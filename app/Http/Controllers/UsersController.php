<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\AddUserRequest;
use App\Http\Requests\UpdateUserRequest;

use Illuminate\Http\Request;

use App\User;
use App\Role;
use App\UserRole;
use Laracasts\Flash\Flash;
use Route;
use Auth;
use Input;
use Lang;
use App\Media;


class UsersController extends Controller {

	public function __construct()
	{
   		//
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$users = User::paginate(10);
		return view('backend.users.index',compact('users', 'page_title'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$roles = Role::where('id', '!=', '1')->where('id', '!=', '2')->get(); //developing it soon 
		return view('backend.users.create', compact('roles'));	
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(AddUserRequest $request)
	{
		$user = new User;
		$user->name = $request->name;
		$user->email = $request->email;
		$user->phone = $request->phone;
		$user->password = bcrypt($request->password);
		$user->active = $request->status;
        $user->confirmed = 1;
		$user->created_by = Auth::user()->id;
        $user->updated_by = Auth::user()->id;
        $user->main_image_id = $request->main_image_id;
        $user->save();

        // User role
        $user_role = new UserRole;
        $user_role->user_id = $user->id;
        $user_role->role_id = $request->role;
        $user_role->save();
        // End User role
		
		Flash::success(trans('backend.saved_successfully'));
        $Currentlanguage = Lang::getLocale();
        if($request->back){
            return back();
        }
        return redirect(''.$Currentlanguage.'/admin/users');

	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$user = User::find($id);
		$roles = Role::where('id', '!=', '1')->where('id', '!=', '2')->get(); //developing it soon 
		$media = Media::where('id', '=', $user->main_image_id)->first();
		return view('backend.users.edit', compact('user', 'media', 'roles'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update(UpdateUserRequest $request, $id)
	{
		$user = User::find($id);
		$user->name = $request->name;
		$user->email = $request->email;
		if(!empty($request->password)) {
			$user->password = bcrypt($request->password);
		}
		$user->phone = $request->phone;
		$user->active = $request->status;
        $user->confirmed = 1;
        $user->updated_by = Auth::user()->id;
        $user->main_image_id = $request->main_image_id;
		$user->save();

        // User role
        $user_role = UserRole::where('user_id', '=', $user->id)->first();
        $user_role->role_id = $request->role;
        $user_role->save();
        // End User role

        Flash::success(trans('backend.updated_successfully'));
        $Currentlanguage = Lang::getLocale();
        if($request->back){
            return back();
        }
        return redirect(''.$Currentlanguage.'/admin/users');
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
	    $user = User::find($id);
	    $user->delete();

        Flash::success(trans('backend.deleted_successfully'));
        $Currentlanguage = Lang::getLocale();

        return redirect(''.$Currentlanguage.'/admin/users');
    }
    /**
     * Get single status.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function single_status($status, $id)
    {
        $user = User::find($id);
        $user->active = $status;
        $user->save();

        Flash::success(trans('backend.saved_successfully'));
        $Currentlanguage = Lang::getLocale();
        return redirect(''.$Currentlanguage.'/admin/users');
    }
     /**
     * confirm bulk delete and return resources to use it in model.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function bulk_destroy_confirm(Request $request)
    {
        $users = User::whereIn('id', $request->ids)->get();
        return $users;
    }
     /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function bulk_destroy(Request $request)
    {
        $users = User::find($request->ids);

        foreach ($users as $user) {
           $user->delete();
        }
        Flash::success(trans('backend.deleted_successfully'));
        $Currentlanguage = Lang::getLocale();
        return redirect(''.$Currentlanguage.'/admin/users');
    }
    /**
     * Bulk Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function bulk_status(Request $request, $status)
    {
        $users = User::find($request->ids);
        if(!empty($users)){
            foreach ($users as $user) {
                $user->active = $status;
                $user->save();
            }
            Flash::success(trans('backend.saved_successfully'));
            $Currentlanguage = Lang::getLocale();
            return redirect(''.$Currentlanguage.'/admin/users');
        }
        else
        {
            Flash::warning(trans('backend.nothing_selected'), 'alert-class');           
            return back();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit_profile($id)
    {
        $user = User::find($id);
        $roles = Role::where('id', '!=', '1')->where('id', '!=', '2')->get(); //developing it soon 
        $media = Media::where('id', '=', $user->main_image_id)->first();
        return view('backend.users.profile.edit', compact('user', 'media', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update_profile(UpdateUserRequest $request, $id)
    {
        $user = User::find($id);
        $user->name = $request->name;
        $user->email = $request->email;
        if(!empty($request->password)) {
            $user->password = bcrypt($request->password);
        }
        $user->phone = $request->phone;
        //$user->active = $request->status;
        $user->updated_by = Auth::user()->id;
        $user->main_image_id = $request->main_image_id;
        $user->save();

        Flash::success(trans('backend.updated_successfully'));
        $Currentlanguage = Lang::getLocale();
        if($request->back){
            return back();
        }
        return redirect(''.$Currentlanguage.'/admin');
    }

}
