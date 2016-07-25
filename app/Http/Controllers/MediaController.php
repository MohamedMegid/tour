<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use App\Media;
use App\Gallery;
use Laracasts\Flash\Flash;
use Intervention\Image\Facades\Image;

use Lang;

class MediaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function browse_images()
    {
        $images = Media::where('type', '=', '1')->orderBy('created_at', 'Desc')->paginate(32);
        return view('backend.media.iframe.upload.index', compact('images'));
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function browse_gallery_images()
    {
        $images = Media::where('type', '=', '1')->orderBy('created_at', 'Desc')->paginate(32);
        return view('backend.media.iframe.upload.index-gallery', compact('images'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function upload_image()
    {
        return view('backend.media.iframe.upload.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store_image(Request $request)
    {
        $file = Input::file('image');
        $rules = array(
           'image' => 'required|mimes:png,gif,jpeg,jpg|max:1000'
       );
       $validator = \Validator::make(array('image'=> $file), $rules);
       if($validator->fails()){
         $errors = $validator->errors()->all();
         return redirect()->back()->withErrors($errors);
       }
       if($validator->passes()){
            $destinationPath = 'uploads';
            $filename = $file->getClientOriginalName();
            $mime_type = $file->getMimeType();
            $extension = $file->getClientOriginalExtension();
            $random_name = str_random(14).'.'.$extension;
            $upload_success = $file->move($destinationPath, $random_name );

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

       }
        Flash::success(trans('backend.image_uploaded_successfully'));
        $Currentlanguage = Lang::getLocale();
        return redirect(''.$Currentlanguage.'/media/browse/images');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function upload_gallery_image()
    {
        return view('backend.media.iframe.upload.create-gallery');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store_image_gallery(Request $request)
    {
        $file = Input::file('image');
        $rules = array(
           'image' => 'required|mimes:png,gif,jpeg,jpg|max:1000'
       );
       $validator = \Validator::make(array('image'=> $file), $rules);
       if($validator->fails()){
         $errors = $validator->errors()->all();
         return redirect()->back()->withErrors($errors);
       }
       if($validator->passes()){
            $destinationPath = 'uploads';
            $filename = $file->getClientOriginalName();
            $mime_type = $file->getMimeType();
            $extension = $file->getClientOriginalExtension();
            $random_name = str_random(14).'.'.$extension;
            $upload_success = $file->move($destinationPath, $random_name );

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

       }
        Flash::success(trans('backend.image_uploaded_successfully'));
        $Currentlanguage = Lang::getLocale();
        return redirect(''.$Currentlanguage.'/media/browse/gallery');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function store_to_gallery($media_id, $content_type, $content_id, $category_id, $is_main, $image_order)
    {
        $image = new Gallery; 
        $image->media_id = $media_id;
        $image->content_type = $content_type;
        $image->content_id = $content_id;
        $image->category_id = $category_id;
        $image->is_main = $is_main;
        $image->image_order = $image_order;
        $image->save();
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete_from_gallery($content_type, $content_id, $category_id, $is_main)
    {
        $images = Gallery::where('content_type', '=', $content_type)
                        ->where('content_id', '=', $content_id)
                        ->where('category_id', '=', $category_id)
                        ->where('is_main', '=', $is_main)
                        ->get();
        if($images){
            foreach ($images as $image) {
                $image->delete(); 
            }
        }
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function select_from_gallery($content_type, $content_id, $category_id, $is_main)
    {
        $images = Gallery::where('content_type', '=', $content_type)
                        ->where('content_id', '=', $content_id)
                        ->where('category_id', '=', $category_id)
                        ->where('is_main', '=', $is_main)
                        ->get();
        return $images;
    }



}
