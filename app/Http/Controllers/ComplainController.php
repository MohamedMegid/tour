<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Http\Requests\ComplainSectionRequest;
use App\Http\Requests\ComplainsReplyRequest;

use App\Complains;
use App\ComplainsReply;
use App\ComplainSection;
use App\ComplainSectionTrans;

use Laracasts\Flash\Flash;
use Lang;
use Auth;
use App\Media;
use App\language;
use App\Block;
use App\Http\Controllers\DB;

use Mail;
use Input;
use App\Setting;
use Config;

class ComplainController extends Controller
{
    /**
     * Overide Defualt Mail settings.
     *
     * @return Response
     */
    public function mail_setting()
    {
        // config of mail
        $setting = Setting::find(1);
        $data = json_decode($setting->options);
        Config::set('mail.driver', $data->driver);
        Config::set('mail.host', $data->host);
        Config::set('mail.port', $data->port);
        Config::set('mail.from.address', $data->address);
        Config::set('mail.from.name', $data->name);
        Config::set('mail.encryption', $data->encryption);
        Config::set('mail.username', $data->user_name);
        Config::set('mail.password', $data->password);
        //end config of mail
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {        
        $query = Complains::select();
        if (!empty($_GET['name'])){
            $name = $_GET['name'];
            $query->where('name', 'LIKE', '%' . $name . '%');
        }
        if (!empty($_GET['phone'])){
            $phone = $_GET['phone'];
            $query->where('phone', 'LIKE', '%' . $phone . '%');           
        }
        if (!empty($_GET['mail'])){
            $mail = $_GET['mail'];
            $query->where('mail', 'LIKE', '%' . $mail . '%');           
        }
        if (!empty($_GET['complain_section_id'])){
            $complain_section_id = $_GET['complain_section_id'];
            $query->where('complain_section_id', '=', $complain_section_id);           
        }
        $complains = $query->where('reply_status', '=', '2')->orderBy('created_at', 'DESC')->paginate(10);
        $Currentlanguage = Lang::getLocale();
        $complain_sections = ComplainSectionTrans::where('lang', '=', $Currentlanguage)->get();
        return view('backend.complains.index', compact('complains', 'complain_sections'));
    }
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index_replied()
    {
        $query = Complains::select();
        if (!empty($_GET['name'])){
            $name = $_GET['name'];
            $query->where('name', 'LIKE', '%' . $name . '%');
        }
        if (!empty($_GET['phone'])){
            $phone = $_GET['phone'];
            $query->where('phone', 'LIKE', '%' . $phone . '%');           
        }
        if (!empty($_GET['mail'])){
            $mail = $_GET['mail'];
            $query->where('mail', 'LIKE', '%' . $mail . '%');           
        }
        if (!empty($_GET['complain_section_id'])){
            $complain_section_id = $_GET['complain_section_id'];
            $query->where('complain_section_id', '=', $complain_section_id);           
        }
        $complains = $query->where('reply_status', '=', '1')->orderBy('created_at', 'DESC')->paginate(10);
        $Currentlanguage = Lang::getLocale();
        $complain_sections = ComplainSectionTrans::where('lang', '=', $Currentlanguage)->get();
        return view('backend.complains.index', compact('complains', 'complain_sections'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function reply($id)
    {
        $message = Complains::where('id', '=', $id)->first();
        return view('backend.complains.reply', compact('message'));
    }

    /**
     * reply the contact message
     *
     */
    public function store_reply(ComplainsReplyRequest $request, $id)
    {     

        $data = json_decode(Setting::find(1)->options);
        $complains = Complains::find($id);
        $this->mail_setting();
        try {
            Mail::send('emails.message', ['request' => $request], function ($msg) use($complains, $data) {
                $msg->from($data->address, $data->name);
                $msg->to($complains->mail);
                $msg->subject('Re:'.$complains->subject);
            });
        } catch (\Exception $e) {
            Flash::error("تعذر إرسال رسالة الرد, اذا تكررت المشكلة في أكثر من رسالة قم بمراجعة إعدادات البريد الإلكتروني");
            return back();
        }

        $complain_reply = new ComplainsReply;
        $complain_reply->complains_id = $id;
        $complain_reply->reply_message = $request->reply_message;
        //$contact_reply->created_by = Auth::user()->id;
        $complain_reply->save();

        $complains->reply_status = '1';
        $complains->save();

        Flash::success(trans('backend.sent_successfully'));
        $Currentlanguage = Lang::getLocale();
        return redirect(''.$Currentlanguage.'/admin/complains');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
       $message = Complains::find($id);
       $reply = ComplainsReply::where('complains_id', '=', $id)->first();
       return view('backend.complains.show', compact('message', 'reply'));
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroyconfirm($id)
    {
        $message = Complains::find($id);
        return view('backend.complains.confirmdelete', compact('message'));
    }

    /**
     * confirm bulk delete and return resources to use it in model.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function bulk_destroy_confirm(Request $request)
    {
        $items = Complains::whereIn('id', $request->ids)->get();
        return $items;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function bulkdeleteconfirm()
    {  
       if(!empty($_POST['check_list'])) {
          $messages = Complains::find($_POST['check_list']);
       }
       else
       {
            Flash::warning(trans('backend.nothing_was_choosed'));
            $Currentlanguage = Lang::getLocale();
            return redirect('/admin/complains');
       }
      return view('backend.complains.bulkconfirmdelete', compact('messages'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        Complains::find($request->id)->delete();
        Flash::success(trans('backend.deleted_successfully'));
        $Currentlanguage = Lang::getLocale();

        return redirect(''.$Currentlanguage.'/admin/complains');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function bulk_destroy(Request $request)
    {
        $items = Complains::find($request->ids);
        foreach ($items as $item) {
            $item->delete();
        }

        Flash::success(trans('backend.deleted_successfully'));
        $Currentlanguage = Lang::getLocale();
        return redirect(''.$Currentlanguage.'/admin/complains');
    }
}
