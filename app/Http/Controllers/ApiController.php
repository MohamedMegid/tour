<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Response;
use Lang;

use App\Language;
use App\Section;
use App\Site;
use App\Visit;

use App\Comment;
use App\Contact;
use App\Gmap;
use App\ContactInfo;
use App\ContactUsPhone;
use App\Complains;
use App\ComplainSection;
use App\ComplainSectionTrans;
use App\Review;
use App\Favourite;
use App\News;
use App\NewsTrans;
use App\Media;
use App\Banners;
use App\BannersTrans;
use App\PhotoAlbum;
use App\PhotoAlbumTrans;
use App\VideoAlbum;
use App\VideoAlbum_trans;
use App\ImpLinks;
use App\ImpLinksTrans;
use App\Pages;
use App\PagesTrans;
use App\MapTracks;
use App\Setting;
use App\Area;
use App\AreaTrans;
use App\City;
use App\CityTrans;
use App\Events;
use App\EventsTrans;
use App\GmapEvent;
use Intervention\Image\Facades\Image;

class ApiController extends Controller
{
    /**
     * Authorize Request.
     *
     * @return Response
     */
    public function api_auth($request)
    {
        $Auth = 'INNO_core_2016_p1';
        $get_auth = $request->get('auth'); 
        if(!$get_auth || $get_auth && $get_auth != $Auth){
            $result = array('status' => '0', 'response' => trans('backend.not_authorized'));
        }else{
            $result = '';
        }
        return $result;
    }
    /**
     * Pager.
     *
     * @return Response
     */
    public function pager($request, $collection)
    { 
        $paginate = $request->get('paginate');
        if($paginate && is_numeric($paginate)){
            $pager = $collection->paginate($paginate);
        }else{
            $pager = $collection->get();
        }
        return $pager;
    }
    /**
     * Pager.
     *
     * @return Response
     */
    public function order($request, $collection, $allowed)
    { 
        $orderby = $request->get('orderby');
        $sort = $request->get('sort');
        if(!empty($orderby) && !empty($sort)){
            // check for allowed fields
            foreach ($allowed as $field) {
                if($orderby == $field){
                    $order = $collection->orderBy($orderby, $sort);
                    return $order;
                }
            }
        }
    }

    /**
     * Display a listing of Avaiable languages.
     *
     * @return Response
     */
    public function languages(Request $request)
    {
        $result = $this->api_auth($request);
        if(!$result){
            $languages = Language::get();
            if($languages->count()){
                $result = $languages; 
            }else{
                $result = array('status' => '2', 'response' => trans('backend.no_results'));
            }             
        }
        return Response::json($result);
    }

    /**
     * Display a listing of the App sections.
     *
     * @return Response
     */
    public function sections(Request $request)
    {   
        // First authorize request
        $result = $this->api_auth($request);
        if(!$result){
            // Second validation of required parameters "fields"
            $type = $request->get('type');
            if(!$type){
                $result = array('status' => '2', 'response' => trans('backend.type_required'));
            }else{
                // Third return results
                $list_sections = Section::with('author')->with('image')->where('section_type', '=', $type)->where('published', '=', '1')->leftJoin('sections_trans as trans', 'sections.id', '=', 'trans.section_id')
                 ->select('sections.*', 'trans.lang', 'trans.name', 'trans.description', 'trans.created_at', 'trans.updated_at')->where('trans.lang', '=', Lang::getlocale());
                //Sorting
                $allowed = ['name', 'created_at', 'updated_at'];
                $sections = $this->order($request, $list_sections, $allowed);
                //Pager 
                $sections = $this->pager($request, $list_sections);
                if($sections->count()){
                    // status 1 this return resource
                    $result = $sections;
                }else{
                    $result = array('status' => '3', 'response' => trans('backend.no_results'));
                }
            }
        }
        return Response::json($result);
    }
    /**
     * Display a listing of the App sites.
     *
     * @return Response
     */
    public function sites(Request $request)
    {   
        // First authorize request
        $result = $this->api_auth($request);
        if(!$result){
            // Second validation of required parameters "fields"
            $type = $request->get('type');
            $get_site = $request->get('id'); 
            $get_from = $request->get('from'); 
            $get_user_id = $request->get('user-id'); 
            $get_filter = $request->get('filter');
            $get_section_id =  $request->get('section_id');
            if(empty($type) && empty($get_site) && empty($get_from)){
                $result = array('status' => '2', 'response' => trans('backend.type_or_id_and_from_required'));
            }elseif(empty($get_site) && $get_from || $get_site && empty($get_from)){
                $result = array('status' => '3', 'response' => trans('backend.id_and_from_parameters_required'));
            }else{
                if($get_site && $get_from) {
                    $current_site = Site::with('site_section')
                    ->with('author')->with('image')->with('gallery.media')->with('visits')->where('published', '=', '1')->leftJoin('sites_trans as trans', 'sites.id', '=', 'trans.site_id')
                    ->select('sites.*', 'trans.lang', 'trans.title', 'trans.summary', 'trans.description', 'trans.created_at', 'trans.updated_at')->where('trans.lang', '=', Lang::getlocale())->where('sites.id', '=', $get_site)
                    ->with(['comments' => function ($query)
                    {
                        $query->where('published', '=', '1')
                                ->where('lang', '=', Lang::getlocale())
                                ->where('content_type', '<', '3') // 1 and 2
                                ->with('author');
                    }])
                    ->with('reviews');
                    if($current_site->count()) {
                        //check if registerd user or visitor = null
                        if($get_user_id){
                          $user_id = $get_user_id;
                        }
                        else{
                          $user_id = null;
                        }
                        //end check if registerd user or visitor
                        //start visit
                        $old_visit = Visit::where('content_id', '=', $get_site)->where('content_type', '=', '1')->where('user_id', '=', $user_id)->first();
                        if($old_visit) {
                            $visit = Visit::find($old_visit->id);
                            $visit->content_type = '1';// for sites
                            $visit->content_id = $get_site;
                            $visit->user_id = $user_id;
                            if($get_from == '1'){
                                $visit->web_visits = $old_visit->web_visits +1;
                            }elseif($get_from == '2'){
                                $visit->ios_visits = $old_visit->ios_visits +1;
                            }elseif ($get_from == '3') {
                                $visit->android_visits  = $old_visit->android_visits +1;
                            }
                            $visit->total_visits = $old_visit->total_visits +1;
                            $visit->lang = Lang::getlocale();
                            $visit->save();
                        }else{
                            $visit = New Visit;
                            $visit->content_type = '1';// for sites
                            $visit->content_id = $get_site;
                            $visit->user_id = $user_id;
                            if($get_from == '1'){
                               $visit->web_visits = '1';
                            }elseif($get_from == '2'){
                               $visit->ios_visits = '1';
                            }elseif ($get_from == '3') {
                               $visit->android_visits  = '1';
                            }
                            $visit->total_visits = '1';
                            $visit->lang = Lang::getlocale();
                            $visit->save();
                        }
                        $site = $current_site->first();
                        // end visit
                        $result = $site;
                    }else{
                        $result = array('status' => '4', 'response' => trans('backend.site_not_found'));
                    }
                }else{
                    // Third return results
                    $list_sites = Site::with('site_section')->with('author')->with('image')->with('gallery.media')->with('visits')->with('reviews')
                    ->where('site_type', '=', $type)->where('published', '=', '1')->leftJoin('sites_trans as trans', 'sites.id', '=', 'trans.site_id')
                    ->select('sites.*', 'trans.lang', 'trans.title', 'trans.summary', 'trans.description', 'trans.created_at', 'trans.updated_at')->where('trans.lang', '=', Lang::getlocale());
                    //filter
                    if($get_filter && $get_filter == 'featured'){
                        $list_sites->where('feature_site', '=', '1');
                    }elseif($get_filter && $get_filter == 'important'){
                        $list_sites->where('important_site', '=', '1');
                    }
                    if(!empty($get_section_id)){
                        $list_sites->where('section_id', '=', $get_section_id);
                    }
                    
                    //Sorting
                    $allowed = ['id', 'title', 'created_at', 'updated_at'];
                    $sites = $this->order($request, $list_sites, $allowed);
                    //Pager 
                    $sites = $this->pager($request, $list_sites);
                    if($sites->count()){
                        // status 1 this return resource
                        $result = $sites;
                    }else{
                        $result = array('status' => '5', 'response' => trans('backend.no_results'));
                    }
                    // End Third result
                }
            }
        }
        return Response::json($result);
    }

    /**
     * what this function do.
     *
     * @return Response
     */
   /* public function temp(Request $request)
    {
        $result = $this->api_auth($request);
        if(!$result){
            //start code here
        }
        return Response::json($result);
    }*/

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create_comment(Request $request)
    {
        $auth = $this->api_auth($request);
        if(!$auth){
            $comment = $request->get('comment');
            $type = $request->get('content-type');
            $content_id = $request->get('content-id');
            $user_id = $request->get('user-id');
            if(empty($type) || ($type != 1 && $type != 2)){
                $result = array('status' => '2', 'respond' => trans('backend.comment_type_validation')); 
            }
            elseif(empty($content_id) || !(is_numeric($content_id))){
               $result = array('status' => '3', 'respond' => trans('backend.comment_content_id_validation')); 
            }
            elseif(empty($comment)){
               $result = array('status' => '4', 'respond' => trans('backend.comment_is_required')); 
            }
            else{
                $comment_db = new Comment;
                $comment_db->content_type = $type;
                $comment_db->content_id = $content_id;
                $comment_db->user_id = $user_id;
                $comment_db->comment = $comment;
                $comment_db->published = 2;
                $comment_db->lang = Lang::getlocale();
                $comment_db->save();           
                $result = array('status' => '1', 'respond' => trans('backend.saved_successfully'));
            }
        }
        else{
             $result = array('status' => '0', 'respond' => trans('backend.not_authorized'));
             
        }
        return Response::json($result);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create_review(Request $request)
    {
        $result = $this->api_auth($request);
        if(!$result){
            $review = $request->get('review');
            $content_type = $request->get('content-type');
            $content_id = $request->get('content-id');
            $user_id = $request->get('user-id');
            if(empty($content_type) || ($content_type != 1 && $content_type != 2)){
                $result = array('status' => '2', 'respond' => trans('backend.comment_type_validation')); 
            }
            elseif(empty($content_id) || !(is_numeric($content_id))){
               $result = array('status' => '3', 'respond' => trans('backend.comment_content_id_validation')); 
            }
            elseif(empty($review) || !(is_numeric($review))){
               $result = array('status' => '4', 'respond' => trans('backend.review_is_required')); 
            }
            else{
                $review_db = new Review;
                $review_db->content_type = $content_type;
                $review_db->content_id = $content_id;
                $review_db->review = $review;
                $review_db->user_id = $user_id;
                $review_db->save();           
                $result = array('status' => '1', 'respond' => trans('backend.saved_successfully'));
            }
        }
        else
        {
             $result = array('status' => '0', 'respond' => trans('backend.not_authorized'));
             
        }
        return Response::json($result);
    }

    /**
     * Display a listing of the App sections.
     *
     * @return Response
     */
    public function palbum(Request $request)
    {   
        // First authorize request
        $result = $this->api_auth($request);
        if(!$result){
            $get_album = $request->get('id');
            if(!empty($get_album)){
                $current_album = PhotoAlbum::with('image')->with('gallery.media')->leftJoin('photoablum_trans as trans', 'photoalbum.id', '=', 'trans.tid')
                 ->select('photoalbum.*', 'trans.lang', 'trans.title', 'trans.summary', 'trans.created_at', 'trans.updated_at')->where('trans.lang', '=', Lang::getlocale())->where('photoalbum.id', '=', $get_album);
                    if($current_album->count()) {
                        $album = $current_album->first();
                        $result = $album;
                    }else{
                        $result = array('status' => '2', 'response' => trans('backend.album_not_found'));
                    }
            }else{
                // Third return results
                $list_items = PhotoAlbum::with('image')->with('gallery.media')->leftJoin('photoablum_trans as trans', 'photoalbum.id', '=', 'trans.tid')
                 ->select('photoalbum.*', 'trans.lang', 'trans.title', 'trans.summary', 'trans.created_at', 'trans.updated_at')->where('trans.lang', '=', Lang::getlocale());
                //Sorting
                $allowed = ['id', 'title', 'created_at', 'updated_at'];
                $items = $this->order($request, $list_items, $allowed);
                //Pager 
                $items = $this->pager($request, $list_items);
                if($items->count()){
                    // status 1 this return resource
                    $result = $items;
                }else{
                    $result = array('status' => '3', 'response' => trans('backend.no_results'));
                }
            }
        }
        return Response::json($result);
    }

    /**
     * Display a listing of the App sections.
     *
     * @return Response
     */
    public function valbum(Request $request)
    {   
        // First authorize request
        $result = $this->api_auth($request);
        if(!$result){
            // Third return results
            $list_items = VideoAlbum::leftJoin('videoalbum_trans as trans', 'videoalbum.id', '=', 'trans.tid')
             ->select('videoalbum.*', 'trans.lang', 'trans.title', 'trans.link', 'trans.subject', 'trans.created_at', 'trans.updated_at')->where('trans.lang', '=', Lang::getlocale());
            //Sorting
            $allowed = ['id', 'title', 'created_at', 'updated_at'];
            $items = $this->order($request, $list_items, $allowed);
            //Pager 
            $items = $this->pager($request, $list_items);
            if($items->count()){
                // status 1 this return resource
                $result = $items;
            }else{
                $result = array('status' => '3', 'response' => trans('backend.no_results'));
            }
            
        }
        return Response::json($result);
    }

    /**
     * Display a listing of the App sections.
     *
     * @return Response
     */
    public function news(Request $request)
    {   
        // First authorize request
        $result = $this->api_auth($request);
        if(!$result){
            $get_news = $request->get('id');
            $get_from = $request->get('from');
            $get_user_id = $request->get('user-id');
            $get_filter = $request->get('filter');

            if(empty($get_news) && $get_from || $get_news && empty($get_from)){
                $result = array('status' => '4', 'response' => trans('backend.id_and_from_parameters_required'));
            }elseif($get_news && $get_from) {
                $current_news = News::with('image')->with('visits')->where('published', '=', '1')->leftJoin('news_trans as trans', 'news.id', '=', 'trans.tid')
                 ->select('news.*', 'trans.lang', 'trans.title', 'trans.summary', 'trans.body', 'trans.created_at', 'trans.updated_at')->where('trans.lang', '=', Lang::getlocale())->where('news.id', '=', $get_news);
                    if($current_news->count()) {
                        //check if registerd user or visitor = null
                        if($get_user_id){
                          $user_id = $get_user_id;
                        }
                        else{
                          $user_id = null;
                        }
                        //end check if registerd user or visitor
                        //start visit
                        $old_visit = Visit::where('content_id', '=', $get_news)->where('content_type', '=', '2')->where('user_id', '=', $user_id)->first();
                        if($old_visit) {
                            $visit = Visit::find($old_visit->id);
                            $visit->content_type = '2';// for sites
                            $visit->content_id = $get_news;
                            $visit->user_id = $user_id;
                            if($get_from == '1'){
                                $visit->web_visits = $old_visit->web_visits +1;
                            }elseif($get_from == '2'){
                                $visit->ios_visits = $old_visit->ios_visits +1;
                            }elseif ($get_from == '3') {
                                $visit->android_visits  = $old_visit->android_visits +1;
                            }
                            $visit->total_visits = $old_visit->total_visits +1;
                            $visit->lang = Lang::getlocale();
                            $visit->save();
                        }else{
                            $visit = New Visit;
                            $visit->content_type = '2';// for sites
                            $visit->content_id = $get_news;
                            $visit->user_id = $user_id;
                            if($get_from == '1'){
                               $visit->web_visits = '1';
                            }elseif($get_from == '2'){
                               $visit->ios_visits = '1';
                            }elseif ($get_from == '3') {
                               $visit->android_visits  = '1';
                            }
                            $visit->total_visits = '1';
                            $visit->lang = Lang::getlocale();
                            $visit->save();
                        }
                        $news = $current_news->first();
                        $result = $news;
                    }else{
                        $result = array('status' => '2', 'response' => trans('backend.news_not_found'));
                    }

            }else{
                // Third return results
                $list_news = News::with('image')->with('visits')->where('published', '=', '1')->leftJoin('news_trans as trans', 'news.id', '=', 'trans.tid')
                 ->select('news.*', 'trans.lang', 'trans.title', 'trans.summary', 'trans.body', 'trans.created_at', 'trans.updated_at')->where('trans.lang', '=', Lang::getlocale());
                if($get_filter && $get_filter == 'important'){
                    $list_news->where('important_news', '=', '1');
                }
                //Sorting
                $allowed = ['id', 'title', 'created_at', 'updated_at'];
                $news = $this->order($request, $list_news, $allowed);
                //Pager 
                $news = $this->pager($request, $list_news);
                if($news->count()){
                    // status 1 this return resource
                    $result = $news;
                }else{
                    $result = array('status' => '3', 'response' => trans('backend.no_results'));
                }
            }
            
        }
        return Response::json($result);
    }


    /**
     * Display a listing of the App sections.
     *
     * @return Response
     */
    public function banners(Request $request)
    {   
        // First authorize request
        $result = $this->api_auth($request);
        if(!$result){
            // Third return results
            $list_items = Banners::with('image')->leftJoin('banners_trans as trans', 'banners.id', '=', 'trans.tid')
             ->select('banners.*', 'trans.lang', 'trans.title', 'trans.link', 'trans.created_at', 'trans.updated_at')->where('trans.lang', '=', Lang::getlocale());
            //Sorting
            $allowed = ['id', 'title', 'created_at', 'updated_at'];
            $items = $this->order($request, $list_items, $allowed);
            //Pager 
            $items = $this->pager($request, $list_items);
            if($items->count()){
                // status 1 this return resource
                $result = $items;
            }else{
                $result = array('status' => '3', 'response' => trans('backend.no_results'));
            }
            
        }
        return Response::json($result);
    }
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function banners_web_view(Request $request)
    {
        // First authorize request
        $result = $this->api_auth($request);
        if(!$result){
          $banners = $list_items = Banners::with('image')->leftJoin('banners_trans as trans', 'banners.id', '=', 'trans.tid')
             ->select('banners.*', 'trans.lang', 'trans.title', 'trans.link', 'trans.created_at', 'trans.updated_at')->where('trans.lang', '=', Lang::getlocale())->get();
           return view('api-webview.banner.index', compact('banners'));
        }
        return Response::json($result);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create_contactus(Request $request)
    {
        $result = $this->api_auth($request);
        if(!$result){
            $name = $request->get('name');
            $mail = $request->get('email');
            $mobile = $request->get('mobile');
            $subject = $request->get('subject');
            $message = $request->get('message');
            $user_id = $request->get('user-id');
            if(empty($name)){
                $result = array('status' => '2', 'respond' => 'Name is required'); 
            }
            elseif(empty($mail)){
               $result = array('status' => '3', 'respond' => 'E-mail is required'); 
            }
            elseif(empty($mobile) || !(is_numeric($mobile))){
               $result = array('status' => '4', 'respond' => 'Mobile number is required and must be numeric'); 
            }
            elseif(empty($subject)){
               $result = array('status' => '5', 'respond' => 'Title is required'); 
            }
            elseif(empty($message)){
               $result = array('status' => '6', 'respond' => 'Message is required'); 
            }
            else{
                $contact = new Contact;
                $contact->name = $name;
                $contact->user_id = $user_id;
                $contact->mail = $mail;
                $contact->phone = $mobile;
                $contact->subject = $subject;
                $contact->message = $message;
                $contact->reply_status = 0;
                $contact->save();           
                $result = array('status' => '1', 'respond' => trans('backend.sent_successfully'));
            }
        }
        return Response::json($result);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function contacts_info(Request $request)
    {
        $result = $this->api_auth($request);
        if(!$result){
            $contacts = ContactInfo::with('phones')->first();
            $result = $contacts;
        }
        return Response::json($result);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function contacts_gmap(Request $request)
    {
        $result = $this->api_auth($request);
        if(!$result){
            $gmap = Gmap::first();
            $result = $gmap;
        }
        return Response::json($result);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function complains_sections(Request $request)
    {

        $result = $this->api_auth($request);
        if(!$result){
            $list_sections = ComplainSection::leftJoin('complain_section_trans as trans', 'complain_section.id', '=', 'trans.tid')
             ->select('complain_section.*', 'trans.lang', 'trans.title', 'trans.created_at', 'trans.updated_at')->where('trans.lang', '=', Lang::getlocale());
            //Sorting
            $allowed = ['id', 'title', 'created_at', 'updated_at'];
            $sections = $this->order($request, $list_sections, $allowed);
            //Pager 
            $sections = $this->pager($request, $list_sections);
            if($sections->count()){
                // status 1 this return resource
                $result = $sections;
            }
            else{
                $result = array('status' => '3', 'response' => trans('backend.no_results'));
            }
        }
        return Response::json($result);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function upload_media(Request $request)
    {
        $result = $this->api_auth($request);
        if(!$result){
            $image = $request->get('image');
            $rules = array(
               'image' => 'required|mimes:png,gif,jpeg,jpg|max:2000'
           );
           $validator = \Validator::make(array('image'=> $image), $rules);
           if($validator->fails()){
             $errors = $validator->errors()->all();
             $result = $result = array('status' => '2', 'respond' => $errors[0]);
           }
           if($validator->passes()){
                $destinationPath = 'uploads';
                $filename = $image->getClientOriginalName();
                $mime_type = $image->getMimeType();
                $extension = $image->getClientOriginalExtension();
                $random_name = str_random(14).'.'.$extension;
                $upload_success = $image->move($destinationPath, $random_name );

                // //small
                // $small_dir = 'uploads/small/'.$random_name.'';
                // $small= Image::make($upload_success)->resize(70, 70);
                // $small->save($small_dir);

                //thumbnail
                $thumbnail_dir = 'uploads/thumbinal/'.$random_name.'';
                $thumb = Image::make($upload_success)->resize(214, 198);
                $thumb->save($thumbnail_dir);

                // //meduim
                // $medium_dir = 'uploads/medium/'.$random_name.'';
                // $medium = Image::make($upload_success)->resize(260, 200);
                // $medium->save($medium_dir );

                // //Large
                // $large_dir = 'uploads/large/'.$random_name.'';
                // $large = Image::make($upload_success)->resize(1200, 420);
                // $large->save($large_dir);

                $image = new Media;
                $image->name = $filename;
                $image->mime_type = $mime_type;
                $image->extension = $extension;
                $image->file = 'uploads/'.$random_name.'';
                $image->thumbnail = $thumbnail_dir;
                $image->type = '1';
                $image->save();

                $result = array('status' => '1',
                                'respond' => array('msg' => trans('backend.uploaded_successfully'),
                                                    'media' => array(
                                                                'id' => $image->id,
                                                                'file' => $image->thumbnail,
                                                                'thumbnail' => $image->thumbnail
                                                                )
                                            ));
            }
        }
        return Response::json($result);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function complain(Request $request)
    {
        $result = $this->api_auth($request);
        if(!$result){
            $name = $request->get('name');
            $email = $request->get('email');
            $mobile = $request->get('mobile');
            $complain_section = $request->get('section-id');
            $section = ComplainSection::find($complain_section);
            $message = $request->get('message');
            $photo = $request->get('photo');
            $longitude = $request->get('longitude');
            $latitude = $request->get('latitude');
            if(empty($name)){
                $result = array('status' => '2', 'respond' => 'Name is required'); 
            }
            elseif(empty($email)){
               $result = array('status' => '3', 'respond' => 'E-mail is required'); 
            }
            elseif(empty($mobile) || !(is_numeric($mobile))){
               $result = array('status' => '4', 'respond' => 'Mobile number is required and must be numeric'); 
            }
            elseif(empty($complain_section) || !(is_numeric($complain_section)) || !$section ){
               $result = array('status' => '6', 'respond' => 'Complain section Id is required and must be one of sections_id'); 
            }
            elseif(empty($message)){
               $result = array('status' => '6', 'respond' => 'Message is required'); 
            }
            else{
                $complain = new Complains;
                $complain->name = $name;
                $complain->mail = $email;
                $complain->mobile = $mobile;
                $complain->message = $message;
                $complain->photo = $photo;
                $complain->complain_section_id = $complain_section;
                $complain->longitude = $longitude;
                $complain->latitude = $latitude;
                $complain->save();           
                $result = array('status' => '1', 'respond' => trans('backend.sent_successfully'));
            }
        }
        return Response::json($result);
    }


    // /**
    //  * Show the form for creating a new resource.
    //  *
    //  * @return \Illuminate\Http\Response
    //  */
    // public function create_favourite(Request $request)
    // {
    //     $result = $this->api_auth($request);
    //     if(!$result){
    //         $user_id = $request->get('user_id');
    //         $content_id = $request->get('content_id');
    //         if(empty($user_id)){
    //            $result = array('status' => '2', 'respond' => 'User id is required'); 
    //         }
    //         elseif(empty($content_id) || !(is_numeric($content_id))){
    //            $result = array('status' => '3', 'respond' => 'Content id is required or must be numeric'); 
    //         }
    //         else{
    //             $favourite_db = new Favourite;
    //             $favourite_db->user_id = $user_id;
    //             $favourite_db->content_id = $content_id;
    //             $favourite_db->save();           
    //             $result = array('status' => '1', 'respond' => 'Saved successfully');
    //         }
    //     }
    //     return Response::json($result);
    // }


    // /**
    //  * Display a listing of the resource.
    //  *
    //  * @return \Illuminate\Http\Response
    //  */
    // public function favourites(Request $request)
    // {
    //     $Auth = $this->api_auth($request);
    //     $user_id = $request->get('user_id');
    //     if(!$Auth && empty($user_id)) {
    //         $reviews = Favourite::all();
    //         $result = array('status' => '1', 'respond' => $reviews);
    //     }
    //     elseif (!empty($user_id)){
    //         $reviews = Favourite::where('user_id', '=', $user_id)->get();
    //         $result = array('status' => '2', 'respond' => $reviews);
    //     }
    //     else
    //     {
    //          $result = array('status' => '0', 'respond' => 'Not Authorized');
             
    //     }
    //     return Response::json($result);
    // }

    /**
     * Display a listing of the App sections.
     *
     * @return Response
     */
    public function implinks(Request $request)
    {   
        // First authorize request
        $result = $this->api_auth($request);
        if(!$result){
            // Third return results
            $list_items = ImpLinks::with('image')->leftJoin('implinks_trans as trans', 'implink.id', '=', 'trans.tid')
             ->select('implink.*', 'trans.lang', 'trans.title', 'trans.link', 'trans.created_at', 'trans.updated_at')->where('trans.lang', '=', Lang::getlocale());
            //Sorting
            $allowed = ['id', 'title', 'created_at', 'updated_at'];
            $items = $this->order($request, $list_items, $allowed);
            //Pager 
            $items = $this->pager($request, $list_items);
            if($items->count()){
                // status 1 this return resource
                $result = $items;
            }else{
                $result = array('status' => '3', 'response' => trans('backend.no_results'));
            }
            
        }
        return Response::json($result);
    }

    /**
     * Display a listing of the App sections.
     *
     * @return Response
     */
    public function pages(Request $request)
    {   
        // First authorize request
        $result = $this->api_auth($request);
        if(!$result) {
            $get_page = $request->get('id');
            if(!empty($get_page)){
                $current_page = Pages::where('published', '=', '1')->leftJoin('pages_trans as trans', 'pages.id', '=', 'trans.tid')
                 ->select('pages.*', 'trans.lang', 'trans.title', 'trans.body', 'trans.created_at', 'trans.updated_at')->where('trans.lang', '=', Lang::getlocale())->where('pages.id', '=', $get_page);
                    if($current_page->count()) {
                        $page = $current_page->first();
                        $result = $page;
                    }else{
                        $result = array('status' => '2', 'response' => trans('backend.page_not_found'));
                    }
            }else{
                // Third return results
                $list_items = Pages::where('published', '=', '1')->leftJoin('pages_trans as trans', 'pages.id', '=', 'trans.tid')
                 ->select('pages.*', 'trans.lang', 'trans.title', 'trans.body', 'trans.created_at', 'trans.updated_at')->where('trans.lang', '=', Lang::getlocale());
                //Sorting
                $allowed = ['id', 'title', 'created_at', 'updated_at'];
                $items = $this->order($request, $list_items, $allowed);
                //Pager 
                $items = $this->pager($request, $list_items);
                if($items->count()){
                    // status 1 this return resource
                    $result = $items;
                }else{
                    $result = array('status' => '3', 'response' => trans('backend.no_results'));
                }
            }
        }
        return Response::json($result);
    }
    /**
     * what this function do.
     *
     * @return Response
     */
    public function maptracks(Request $request)
    {
        $result = $this->api_auth($request);
        if(!$result){
            $map = MapTracks::with('image')->find(1);
            if($map){
               $result = $map; 
           }else{
               $result = array('status' => '2', 'response' => trans('backend.map_not_found'));
           }
        }
        return Response::json($result);
    }

    /**
     * what this function do.
     *
     * @return Response
     */
    public function social_media(Request $request)
    {
        $result = $this->api_auth($request);
        if(!$result){
            $setting = Setting::find(2);
            $result = json_decode($setting->options);
        }
        return Response::json($result);
    }

    /**
     * what this function do.
     *
     * @return Response
     */
    public function area(Request $request)
    {
        $result = $this->api_auth($request);
        if(!$result){
            $areas = Area::leftJoin('area_trans as trans', 'area.id', '=', 'trans.tid')
             ->select('area.*', 'trans.*')->where('trans.lang', '=', Lang::getlocale())->get();

            if($areas){
               $result = $areas; 
           }else{
               $result = array('status' => '2', 'response' => trans('backend.no_results'));
           }
        }
        return Response::json($result);
    }

    /**
     * what this function do.
     *
     * @return Response
     */
    public function city(Request $request)
    {
        $result = $this->api_auth($request);
        if(!$result){
            $cities = City::leftJoin('city_trans as trans', 'city.id', '=', 'trans.tid')
             ->select('city.*', 'trans.*')->where('trans.lang', '=', Lang::getlocale())->get();

            if($cities){
               $result = $cities; 
           }else{
               $result = array('status' => '2', 'response' => trans('backend.no_results'));
           }
        }
        return Response::json($result);
    }

    /**
     * what this function do.
     *
     * @return Response
     */
    public function events(Request $request)
    {
        $result = $this->api_auth($request);
        if(!$result){
            $events = Events::leftJoin('events_trans as trans', 'events.id', '=', 'trans.tid')->leftJoin('gmap_event as map', 'events.id', '=', 'map.event_id')
             ->select('events.*', 'trans.*', 'map.*')->where('trans.lang', '=', Lang::getlocale())->get();

            if($events){
               $result = $events; 
           }else{
               $result = array('status' => '2', 'response' => trans('backend.no_results'));
           }
        }
        return Response::json($result);
    }

    /**
     * what this function do.
     *
     * @return Response
     */
    public function single_event(Request $request, $id)
    {
        $result = $this->api_auth($request);
        if(!$result){
            $events = Events::leftJoin('events_trans as trans', 'events.id', '=', 'trans.tid')->leftJoin('gmap_event as map', 'events.id', '=', 'map.event_id')
             ->select('events.*', 'trans.*', 'map.*')->where('trans.lang', '=', Lang::getlocale())->where('events.id', '=', $id)->first();

            if($events){
               $result = $events; 
           }else{
               $result = array('status' => '2', 'response' => trans('backend.no_results'));
           }
        }
        return Response::json($result);
    }
}
