<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;


use App\Review;
use Lang;
use Laracasts\Flash\Flash;

class ReviewController extends Controller
{
    public function index(){
        // Varibales
        $content_type = '';
        $created_at = '';
        $last_update = ''; 
        $orderby = '';
        $sort = '';
        $published = '';

        $list = Review::select();
        if(!empty($_GET['type'])){
            $content_type = $_GET['type'];
            $list->where('content_type', '=', $content_type);     
        }
        if(!empty($_GET['created_at'])){
            $created_at = $_GET['created_at'];
            $list->where('created_at', '>=', ''.$created_at.' 00:00:00')->where('created_at', '<=', ''.$created_at.' 23:59:59');           
        }
        if(!empty($_GET['last_update'])){
            $last_update = $_GET['last_update'];
            $list->where('updated_at', '>=', ''.$last_update.' 00:00:00')->where('updated_at', '<=', ''.$last_update.' 23:59:59');           
        }
        if(!empty($_GET['orderby']) && !empty($_GET['sort'])){
            $orderby = $_GET['orderby'];
            $sort = $_GET['sort'];
            $list->orderBy($orderby, $sort);           
        }
        
        $reviews = $list->paginate(10);

        // add to pagination other fields
        $reviews->appends(['content_type' => $content_type, 'created_at' => $created_at,
         'last_update' => $last_update, 'orderby' => $orderby, 'sort' => $sort]);
        

        return view('backend.reviews.index', compact('reviews'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $id = $request->id;

        $review = Review::find($id);
        $review->delete();

        Flash::success(trans('backend.deleted_successfully'));
        $Currentlanguage = Lang::getLocale();

        return redirect(''.$Currentlanguage.'/admin/reviews');
    }

    /**
     * confirm bulk delete and return resources to use it in model.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function bulk_destroy_confirm(Request $request)
    {
        $reviews = Review::find($request->ids);
        return $reviews;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function bulk_destroy(Request $request)
    {
        $reviews = Review::find($request->ids);
        foreach ($reviews as $review) {
            $review->delete();
        }
        
        Flash::success(trans('backend.deleted_successfully'));
        $Currentlanguage = Lang::getLocale();
        return redirect(''.$Currentlanguage.'/admin/reviews');
    }
}
