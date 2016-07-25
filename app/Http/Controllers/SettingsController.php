<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Setting;
use App\Banner;
use App\WesalSettings;

use Laracasts\Flash\Flash;
class SettingsController extends Controller
{

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit_mail()
    {
        $setting = Setting::find(1);
        $data = json_decode($setting->options);
        return view('backend.settings.email', compact('setting', 'data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update_mail(Request $request)
    {
        $setting = Setting::find(1);
        $setting->options = '{"driver":"'.$request->driver.'","host":"'.$request->host.'","port":"'.$request->port.'","user_name":"'.$request->user_name.'","password":"'.$request->password.'","address":"'.$request->address.'","name":"'.$request->name.'","encryption":"'.$request->encryption.'"}';
        $setting->save();

        Flash::success(trans('backend.updated_successfully'));
        return back();
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit_social_media()
    {
        $setting = Setting::find(2);
        $data = json_decode($setting->options);
        return view('backend.settings.social_media', compact('setting', 'data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update_social_media(Request $request)
    {
        $setting = Setting::find(2);
        $setting->options = '{"facebook":"'.$request->facebook.'","twitter":"'.$request->twitter.'"}';
        $setting->save();

        Flash::success(trans('backend.updated_successfully'));
        return back();
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit_app_links()
    {
        $setting = Setting::find(3);
        $data = json_decode($setting->options);
        return view('backend.settings.app', compact('setting', 'data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update_app_links(Request $request)
    {
        $setting = Setting::find(3);
        $setting->options = '{"apple":"'.$request->apple.'","google":"'.$request->google.'"}';
        $setting->save();

        Flash::success(trans('backend.updated_successfully'));
        return back();
    }


}
