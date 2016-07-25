<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Http\Requests\ContactsRequest;
use App\Http\Requests\ContactReplyRequest;

use App\Contact;
use App\ContactReply;
use App\Block;
use App\Http\Controllers\DB;

use Laracasts\Flash\Flash;

use Mail;
use Input;
use Auth;
use Lang;
use App\Setting;
use Config;


use App\Gmap;
use App\ContactInfo;
use App\ContactUsPhone;

use App\Http\Requests\ContactInfoRequest;
use App\Http\Requests\GmapRequest;

class ContactsController extends Controller
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
        $query = Contact::select();
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
        $contacts = $query->where('reply_status', '=', '2')->orderBy('created_at', 'DESC')->paginate(10);
        return view('backend.contacts.index', compact('contacts'));
    }
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index_replied()
    {
        $query = Contact::select();
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
        $contacts = $query->where('reply_status', '=', '1')->orderBy('created_at', 'DESC')->paginate(10);
        return view('backend.contacts.index', compact('contacts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function reply($id)
    {
        $message = Contact::where('id', '=', $id)->first();
        return view('backend.contacts.reply', compact('message'));
    }

    /**
     * reply the contact message
     *
     */
    public function store_reply(ContactReplyRequest $request, $id)
    {     

        $data = json_decode(Setting::find(1)->options);
        $contact = Contact::find($id);
        $this->mail_setting();
        try {
            Mail::send('emails.message', ['request' => $request], function ($msg) use($contact, $data) {
                $msg->from($data->address, $data->name);
                $msg->to($contact->mail);
                $msg->subject('Re:'.$contact->subject);
            });
        } catch (\Exception $e) {
            Flash::error(trans('backend.error_sent'));
            return back();
        }

        $contact_reply = new ContactReply;
        $contact_reply->message_id = $id;
        $contact_reply->reply_message = $request->reply_message;
        //$contact_reply->created_by = Auth::user()->id;
        $contact_reply->save();

        $contact->reply_status = '1';
        $contact->save();

        Flash::success(trans('backend.replied_successfully'));
        $Currentlanguage = Lang::getLocale();
        return redirect(''.$Currentlanguage.'/admin/contacts');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('frontend.contact.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(ContactsRequest $request)
    {
        $contact = new Contact;
        $contact->name = $request->name;
        $contact->phone = $request->phone;
        $contact->mail = $request->email;
        if (Auth::id()) {
            $contact->user_id = Auth::user()->id;
        }
        $contact->subject = $request->subject;
        $contact->message = $request->message;
        $contact->save();

        Flash::success("Thank you $request->name for your message");
       // $Currentlanguage = Lang::getLocale();
        return redirect('/contact');
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
       $message = Contact::find($id);
       return view('backend.contacts.show', compact('message'));
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroyconfirm($id)
    {
        $message = Contact::find($id);
        return view('backend.contacts.confirmdelete', compact('message'));
    }

    /**
     * confirm bulk delete and return resources to use it in model.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function bulk_destroy_confirm(Request $request)
    {
        $items = Contact::whereIn('id', $request->ids)->get();
        return $items;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        Contact::find($request->id)->delete();
        Flash::success(trans('backend.deleted_successfully'));
        $Currentlanguage = Lang::getLocale();

        return redirect(''.$Currentlanguage.'/admin/contacts');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function bulk_destroy(Request $request)
    {
        $items = Contact::find($request->ids);
        foreach ($items as $item) {
            $item->delete();
        }

        Flash::success(trans('backend.deleted_successfully'));
        $Currentlanguage = Lang::getLocale();
        return redirect(''.$Currentlanguage.'/admin/contacts');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit()
    {
        $gmap = Gmap::first();        
        return view('backend.contacts.gmap-edit', compact('gmap'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(GmapRequest $request)
    {
        $gmap = Gmap::first();
        $gmap->address = $request->input('address');
        $gmap->latitude = $request->input('latitude');
        $gmap->longitude = $request->input('longitude');
        $gmap->update();
        Flash::success(trans('backend.updated_successfully'));
        $Currentlanguage = Lang::getLocale();
        return redirect(''.$Currentlanguage.'/admin/contacts-gmap');
    }

        /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit_contact_info()
    {
        $contact = ContactInfo::first();
        $contact_id = $contact['attributes']['id'];
        $phones = ContactUsPhone::where('contact_id', '=', $contact_id)->get();
        
        return view('backend.contacts.contact_info_edit', compact('contact', 'phones'));        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update_contact_info(ContactInfoRequest $request)
    {
        $contact = ContactInfo::first();
        $contact->title = $request->title;
        $contact->mail = $request->input('mail');
        $count = $request->input('counter');
        $contact->update();
        $contact_id = $contact['attributes']['id'];
        $phones = ContactUsPhone::where('contact_id', '=', $contact_id)->get();
        ContactUsPhone::where('contact_id', '=', $contact_id)->delete();
        $contact_info = ContactInfo::first(['id']);
        $last_contact_id = $contact_info['attributes']['id'];
        for ($i=1; $i <= $count; $i++) {
            $contact_phone = new ContactUsPhone; 
            $input_name = "phone" . $i;
            $contact_phone->phone = $request->input($input_name);
            $contact_phone->contact_id = $last_contact_id;
            $contact_phone->counter = $i;
            if (!empty($request->input($input_name))){
                $contact_phone->save();
            }
        }
        Flash::success(trans('backend.updated_successfully'));
        $Currentlanguage = Lang::getLocale();
        return redirect(''.$Currentlanguage.'/admin/contacts-info');
    }
}
