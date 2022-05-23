<?php

namespace App\Http\Controllers;

use App\Enums\ProductStatus;
use App\Models\Entry;
use App\Models\Product;
use App\Models\Topic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Artesaos\SEOTools\Facades\SEOTools;

class EntryController extends Controller
{
    public function index(Request $request){

        if($request->s){
            $entries = Entry::where('title','like','%'.$request->get('s').'%')->orWhere('description','like','%'.$request->get('s').'%')->get();
        }else{
            // Store all entries in cache for 1 hour (3600 seconds)
            $entries = Entry::latest()->whereSticky(false)->get();
        }

        SEOTools::setTitle('Blog Posts');
        // SEOTools::setDescription($category->description);
        SEOTools::opengraph()->addProperty('type', 'articles');

        // Store all entries in cache for 1 hour (3600 seconds)
        $sticky_entries = Entry::latest()->whereSticky(true)->latest()->limit(3)->get();

        return view('blog.home', [
            'entries' => $entries,
            'sticky_entries' => $sticky_entries
        ]);
    }

    public function category($slug){
        $category = Topic::whereSlug($slug)->firstOrFail();
        $entries = Entry::where('topic_id', '=', $category->id)->wherePublished(true)->paginate();

        SEOTools::setTitle($category->name);
        SEOTools::setDescription($category->description);
        SEOTools::opengraph()->addProperty('type', 'articles');

        $latestPosts = Entry::latest()->limit(4)->get();

        return view('blog.category', [
            'category' => $category,
            'entries' => $entries,
            'latestPosts' => $latestPosts
        ]);
    }

    public function show($slug){
        $entry = Entry::whereSlug($slug)->firstOrFail();

        $shareUrls = \Share::currentPage($entry->title)
            ->facebook()
            ->twitter()
            ->linkedin($entry->excerpt)
            ->whatsapp($entry->title)
            ->reddit()
            ->telegram()
            ->getRawLinks();


        SEOTools::setTitle($entry->title);
        SEOTools::setDescription($entry->excerpt);
        // SEOTools::opengraph()->setUrl('http://current.url.com');
        // SEOTools::setCanonical('https://codecasts.com.br/lesson');
        SEOTools::opengraph()->addProperty('type', 'article');
        SEOTools::twitter()->setSite('@Sheaearn');
        SEOTools::jsonLd()->addImage($entry->getFirstMediaUrl('featured_image', 'standard'));

            // SEOMeta::setTitle($entry->title);
            // SEOMeta::setDescription($entry->excerpt);
        SEOTools::opengraph()->addProperty('article:published_time', $entry->created_at->toW3cString(), 'property');
            // SEOMeta::addMeta('article:section', $entry->topic->name, 'property');
            // SEOMeta::addKeyword(['key1', 'key2', 'key3']);


            $products = Product::whereStatus(ProductStatus::PUBLISHED)->whereSpecial(false)->inRandomOrder()->limit(6)->get();

        return view('blog.show', [
            'entry' => $entry,
            'shareUrls' => $shareUrls,
            'products' => $products
        ]);
    }
}
