<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\ChatResource;
use App\Http\Traits\WebSocketTrait;
use App\Http\Resources\MessageResource;
use Illuminate\Http\Request;
use App\Models\Chat;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class MessagesController extends Controller
{
    use WebSocketTrait;
    protected $model;
    public function __construct(Chat $model)
    {
        $this->model = $model;
    }
    public function send(Request $request) {
        $v = Validator::make(request()->all() , [
            'body' => 'required',
            'receiver_id'  => 'required'
        ]);
        if($v->fails()) {
            return response()->json([
                'status' => false, 
                "error" => $v->errors()
            ]);
        }
        $to_user = User::find($request->receiver_id);
        if(!$to_user) {
            return response()->json([
                'status' => false, 
                'error' => 'user not found'
            ]);
        }
        $save = $this->model->create([
            'sender_id' => auth()->guard('api') -> user() ->id,
            'receiver_id' => $request->receiver_id,
            'body' => $request->body
        ]);
        if($save) {
            $this->sendWSMessage($to_user->channel, auth()->guard('api') -> user() ->channel,
            new MessageResource($save));
            return response() -> json([
                'status' => true, 
                'messages' => new ChatResource($save)
            ]);
        }
    }
    public function messages($id) {
        // dd(Auth::guard('api')->user()->id);
        $to_user = User::find($id);
        if(!$to_user) {
            return response() -> json(["status" => false, "error" => "error_user"]);
        }
        $messages = $this->model->where('sender_id', Auth::guard('api')->user()->id)
                                ->where('receiver_id', $to_user->id)
                                ->orWhere('sender_id', $to_user->id)
                                ->where('receiver_id', Auth::guard('api')->user()->id)
                                ->get();
        return response() ->json([
            'status' => "success",
            "messages"   => ChatResource::collection($messages)
        ]);
    }
    public function chats(){
        return response()->json([
          "status" => "success",
        //   "messages" =>  Chat::all(),
        "messages" => ChatResource::collection(Chat::all()),
        ]);
    }
}
