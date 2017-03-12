<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Nahid\Talk\Facades\Talk;
use Auth;
use View;

class MessageController extends Controller
{
    protected $authUser;
    public function __construct()
    {
        $this->middleware('auth');
        Talk::setAuthUserId(Auth::user()->id);

        View::composer('partials.peoplelist', function($view) {
            $threads = Talk::threads();
            $view->with(compact('threads'));
        });
    }
     /*
    @ Chat Logs/History with another user - by Team Aliens
    */
    public function chatHistory($id)
    {
        $conversations = Talk::getMessagesByUserId($id);
        $user = '';
        $messages = [];
        if(!$conversations) {
            $user = User::find($id);
        } else {
            $user = $conversations->withUser;
            $messages = $conversations->messages;
        }

        return view('messages.conversations', compact('messages', 'user'));
    }
     /*
    @ To Send a Message without Refreshing - by Team Aliens
    */
    public function ajaxSendMessage(Request $request)
    {
        if ($request->ajax()) {
            $rules = [
                'message-data'=>'required',
                '_id'=>'required'
            ];

            $this->validate($request, $rules);

            $body = $request->input('message-data');
            $userId = $request->input('_id');

            if ($message = Talk::sendMessageByUserId($userId, $body)) {
                $html = view('ajax.newMessageHtml', compact('message'))->render();
                return response()->json(['status'=>'success', 'html'=>$html], 200);
            }
        }
    }
    /*
    @ To Delete a Message without Refreshing - by Team Aliens
    */

    public function ajaxDeleteMessage(Request $request, $id)
    {
        if ($request->ajax()) {
            if(Talk::deleteMessage($id)) {
                return response()->json(['status'=>'success'], 200);
            }

            return response()->json(['status'=>'errors', 'msg'=>'something went wrong'], 401);
        }
    }
    public function seenMessage(Request $request, $id)
    {
        if ($request->ajax()) {
            if(Talk::makeSeen($id)) {
                return response()->json(['status'=>'success'], 200);
            }

            return response()->json(['status'=>'errors', 'msg'=>'something went wrong'], 401);
        }
    }

     /*
    @ Random Test - by Team Aliens
    */
    public function tests()
    {
        dd(Talk::channel());
    }
}
