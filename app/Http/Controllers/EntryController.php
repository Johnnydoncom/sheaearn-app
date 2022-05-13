<?php

namespace App\Http\Controllers;

use App\Models\Entry;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
//use Jorenvh\Share\Share;

class EntryController extends Controller
{
    public function index(){
        // Store all entries in cache for 1 hour (3600 seconds)
        $entries = Entry::latest()->whereSticky(false)->get();

        // Store all entries in cache for 1 hour (3600 seconds)
        $sticky_entries = Entry::latest()->whereSticky(true)->latest()->limit(3)->get();

        return view('blog.home', [
            'entries' => $entries,
            'sticky_entries' => $sticky_entries
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

            $products = Product::inRandomOrder()->limit(6)->get();

        return view('blog.show', [
            'entry' => $entry,
            'shareUrls' => $shareUrls,
            'products' => $products
        ]);
    }
}
