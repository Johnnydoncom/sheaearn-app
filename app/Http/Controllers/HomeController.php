<?php

namespace App\Http\Controllers;

use App\Models\Entry;
use App\Models\Product;
use Artesaos\SEOTools\Facades\SEOTools;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class HomeController extends Controller
{
    public function index(){

        // Store all entries in cache for 1 hour (3600 seconds)
        $entries = Cache::remember('entries', 3600, function() {
            return Entry::latest()->whereSticky(false)->get();
        });

        // Store all entries in cache for 1 hour (3600 seconds)
        $sticky_entry = Cache::remember('sticky_entries', 3600, function() {
            return Entry::latest()->whereSticky(true)->first();
        });

        $upgradeBundle = Product::whereSpecial(true)->first();

        return view('welcome', [
           'entries' => $entries,
            'sticky_entry' => $sticky_entry,
            'upgradeBundle' => $upgradeBundle
        ]);
    }

    public function privacy()
    {
        SEOTools::setTitle('Privacy Policy');
//        SEOTools::setDescription($entry->excerpt);
        return view('privacy-policy');
    }
}
