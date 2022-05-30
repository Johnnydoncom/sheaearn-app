<?php

namespace App\Http\Controllers;

use App\Models\Ads;
use App\Models\Entry;
use Artesaos\SEOTools\Facades\SEOTools;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class AdsController extends Controller
{
    public function index(Request $request){
        $entries = Ads::whereDate('created_at', '<', Carbon::tomorrow());

        if($request->s){
            $entries->where('title','like','%'.$request->get('s').'%')->orWhere('description','like','%'.$request->get('s').'%')->get();
        }

        SEOTools::setTitle('Sponsored Ads');
        // SEOTools::setDescription($category->description);
        SEOTools::opengraph()->addProperty('type', 'articles');

        $latestPosts = Entry::latest()->limit(4)->get();

        return view('ads.home', [
            'ads' => $entries->paginate(),
            'latestPosts' => $latestPosts
        ]);
    }

    public function show($slug){

    }
}
