<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Contact;
use App\Complains;
use Auth;

class CounterController extends Controller
{
    /**
     * Display the specified resource count.
     *
     * @param  int  $id
     * @return Response
     */
     public function NewMessages(){
        $NewMessages = Contact::where('reply_status',  '=', '2')->count();
        return $NewMessages;
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
     public function FourNewMessages(){
        $FourNewMessages = Contact::where('reply_status', '=', '2')->orderBy('created_at','DESC')->take(4)->get();
        return $FourNewMessages;
    }
	/**
     * Display the specified resource count.
     *
     * @param  int  $id
     * @return Response
     */
     public function NewMessagesComplains(){
        $NewMessages = Complains::where('reply_status', '=', '2')->count();
        return $NewMessages;
    }

}
