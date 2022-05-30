<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Country;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $country = Country::where('name', 'nigeria')->first();
        $states = $country->states()->get()->map(function($city){
            return [
                'value' => $city->id,
                'label' => ucfirst($city->name)
            ];
        });
        return view('admin.settings.general',[
            'settings' => setting()->all(),
            'states' => $states
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function product()
    {
        $country = Country::where('name', 'nigeria')->first();
        $states = $country->states()->get();
        return view('admin.settings.shop',[
            'settings' => setting()->all(),
            'states' => $states
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function earnings()
    {
        $country = Country::where('name', 'nigeria')->first();
        $states = $country->states()->get()->map(function($city){
            return [
                'value' => $city->id,
                'label' => ucfirst($city->name)
            ];
        });
        return view('admin.settings.earnings',[
            'settings' => setting()->all(),
            'states' => $states
        ]);
    }

    public function update(Request $request){
        $request->validate([
            'logoUpload' => 'nullable | image',
            'site_name' => 'nullable'
        ]);

        $settingArray = [];
        foreach($request->except('_method', '_token') as $key => $value){
            $settingArray[$key] = $value;
        }


        if($request->hasFile('logoUpload')) {
            $imagePath = $request->file('logoUpload');
            $imageName = $imagePath->getClientOriginalName();
            $settingArray['site_logo'] = $request->file('logoUpload')->storeAs('/', $imageName, 'public');

        }else{
            unset($settingArray['site_logo']);
        }

        if($request->hasFile('lightLogoUpload')) {
            $imagePath = $request->file('lightLogoUpload');
            $imageName = $imagePath->getClientOriginalName();
            $settingArray['site_logo_white'] = $request->file('lightLogoUpload')->storeAs('/', $imageName, 'public');

        }else{
            unset($settingArray['site_logo_white']);
        }

        \Setting::set($settingArray);
        \Setting::save();

        return redirect()->back()->withSuccess('Settings Updated');
    }
}
