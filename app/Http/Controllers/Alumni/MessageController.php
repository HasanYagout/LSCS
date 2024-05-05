<?php

namespace App\Http\Controllers\Alumni;

use App\Http\Controllers\Controller;
use App\Http\Requests\ChatRequest;
use App\Http\Services\ChatService;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class MessageController extends Controller
{
    use ResponseTrait;
    public $chatService;

    public function __construct()
    {
        $this->chatService = new ChatService();
    }

    public function index(){
        $data['title']= __('Message');
        $data['activeMessage'] = 'active';
        $data['users'] = $this->chatService->getChatUserList()->getData()->data;

        return view('alumni.message', $data);
    }

    public function send(ChatRequest $request)
    {
        return  $this->chatService->store($request);
    }

    public function getSingleChat(Request $request)
    {
        $senderId = auth()->id(); 
        $receiverId = $request->receiver_id; 
        
        $data['chats'] = $this->chatService->getSingleUserChat($senderId, $receiverId);
        $response['unseen_user_message'] = collect($this->chatService->unseenUserMessage()->getData()->data);
        $response['total_unseen_message'] = $response['unseen_user_message']->sum('unseen_message_count');
        $response['html'] = View::make('alumni.partials.chat-body', $data)->render();
        return $this->success($response);
    }

}
