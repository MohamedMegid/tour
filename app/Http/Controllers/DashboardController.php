<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Contact;
use App\Visit;
use App\Site;
use App\News;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {   
    	$contacts = Contact::where('reply_status', '=', '2')->orderBy('created_at', 'DESC')->take(4)->get();
    	//sites visits
    	$sites_total_visits = Visit::where('content_type', '=', '1')->sum('total_visits');
    	$sites_web_visits = Visit::where('content_type', '=', '1')->sum('web_visits');
    	$sites_android_visits = Visit::where('content_type', '=', '1')->sum('android_visits');
    	$sites_ios_visits = Visit::where('content_type', '=', '1')->sum('ios_visits');
    	//news visits
    	$news_total_visits = Visit::where('content_type', '=', '2')->sum('total_visits');
    	$news_web_visits = Visit::where('content_type', '=', '2')->sum('web_visits');
    	$news_android_visits = Visit::where('content_type', '=', '2')->sum('android_visits');
    	$news_ios_visits = Visit::where('content_type', '=', '2')->sum('ios_visits');
    	//counter 
    	$tourism_services = Site::where('site_type', '=', '1')->count();
    	$tourism_sites = Site::where('site_type', '=', '2')->count();
    	$news = News::count();

        return view('backend.dashboard.index',
        			compact(
        			'contacts',
        			'sites_total_visits',
        			'sites_web_visits',
        			'sites_android_visits',
        			'sites_ios_visits',
        			'news_total_visits',
        			'news_web_visits',
        			'news_android_visits',
        			'news_ios_visits',
        			'tourism_services',
        			'tourism_sites',
        			'news'
        			));
    }

}
