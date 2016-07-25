<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\CommentRequest;
use App\Http\Controllers\Controller;

use App\Comment;
use Lang;
use Laracasts\Flash\Flash;


class CommentsController extends Controller
{

    public function index(){
        // Varibales
        $comment = '';
        $type = '';
        $created_at = '';
        $last_update = ''; 
        $orderby = '';
        $sort = '';
        $published = '';

        $list_comments = Comment::where('lang', '=', Lang::getLocale())->select();

        if(!empty($_GET['comment'])){
            $comment = $_GET['comment'];
            $list_comments->where('comment', 'like', '%'.$comment.'%');     
        }
        if(!empty($_GET['type'])){
            $type = $_GET['type'];
            $list_comments->where('content_type', '=', $type);     
        }
        if(!empty($_GET['created_at'])){
            $created_at = $_GET['created_at'];
            $list_comments->where('created_at', '>=', ''.$created_at.' 00:00:00')->where('created_at', '<=', ''.$created_at.' 23:59:59');           
        }
        if(!empty($_GET['last_update'])){
            $last_update = $_GET['last_update'];
            $list_comments->where('updated_at', '>=', ''.$last_update.' 00:00:00')->where('updated_at', '<=', ''.$last_update.' 23:59:59');           
        }
        if(!empty($_GET['published'])){
            $published = $_GET['published'];
            $list_comments->where('published', '=', $published);           
        }
        if(!empty($_GET['orderby']) && !empty($_GET['sort'])){
            $orderby = $_GET['orderby'];
            $sort = $_GET['sort'];
            $list_comments->orderBy($orderby, $sort);           
        }
        
        $comments = $list_comments->paginate(10);

        // add to pagination other fields
        $comments->appends(['type' => $type, 'created_at' => $created_at,
         'last_update' => $last_update, 'orderby' => $orderby, 'sort' => $sort, 'published' => $published]);
        

        return view('backend.comments.index', compact('comments'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $comment = Comment::find($id);
        return view('backend.comments.edit', compact('comment'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CommentRequest $request, $id)
    {
        $comment = Comment::find($id);
        $comment->comment = $request->comment;
        if($request->published){
            $comment->published = '1';
        }else{
            $comment->published = '2';
        }
        $comment->save();

        Flash::success(trans('backend.updated_successfully'));
        $Currentlanguage = Lang::getLocale();
        if($request->back){
            return back();
        }
        return redirect(''.$Currentlanguage.'/admin/comments');
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
        $type = $request->type;

        $comment = Comment::find($id);
        $comment->delete();

        Flash::success(trans('backend.deleted_successfully'));
        $Currentlanguage = Lang::getLocale();

        return redirect(''.$Currentlanguage.'/admin/comments');
    }
    /**
     * Get single status.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function single_status($status, $id)
    {
        $comment = Comment::find($id);
        $comment->published = $status;
        $comment->save();

        Flash::success(trans('backend.saved_successfully'));
        $Currentlanguage = Lang::getLocale();
        return redirect(''.$Currentlanguage.'/admin/comments');
    }
     /**
     * confirm bulk delete and return resources to use it in model.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function bulk_destroy_confirm(Request $request)
    {
        $comments = Comment::find($request->ids);
        return $comments;
    }
     /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function bulk_destroy(Request $request)
    {
        $comments = Comment::find($request->ids);

        foreach ($comments as $comment) {
            $comment->delete();
        }
        
        Flash::success(trans('backend.deleted_successfully'));
        $Currentlanguage = Lang::getLocale();
        return redirect(''.$Currentlanguage.'/admin/comments');
    }
    
    /**
     * Bulk Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function bulk_status(Request $request, $status)
    {
        $comments = Comment::find($request->ids);
        if(!empty($comments)){
            foreach ($comments as $comment) {
                $comment->published = $status;
                $comment->save();
            }
            Flash::success(trans('backend.saved_successfully'));
            $Currentlanguage = Lang::getLocale();
            return redirect(''.$Currentlanguage.'/admin/comments');
        }
        else
        {
            Flash::warning(trans('backend.nothing_selected'), 'alert-class');           
            return back();
        }
    }

}
