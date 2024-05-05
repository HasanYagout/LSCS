<?php

namespace App\Http\Services;

use App\Events\ChatEvent;
use App\Models\Chat;
use App\Models\FileManager;
use App\Models\User;
use App\Traits\ResponseTrait;
use Exception;
use Illuminate\Support\Facades\DB;

class ChatService
{
    use ResponseTrait;

    public function store($request)
    {
        DB::beginTransaction();
        try {
            $user = auth()->user();
            $chat = new Chat();
            $chat->message = htmlspecialchars($request->message);
            $chat->sender_id = $user->id;
            $chat->tenant_id = getTenantId();
            $chat->receiver_id = $request->receiver_id;
            $chat->save();

            //chat media

            foreach ($request->file ?? [] as $index => $media) {
                if ($request->hasFile('file.' . $index)) {

                    $new_file = new FileManager();
                    $uploaded = $new_file->upload('chat', $media);
                    $chat->media()->create([
                        'file' => $uploaded->id
                    ]);
                }
            }

            DB::commit();

            event(new ChatEvent(['receiver_id' => $request->receiver_id, 'sender_id' => $chat->sender_id]));

            $message = __('Send Successfully');
            return $this->success(['receiver_id' => $request->receiver_id], $message);
        } catch (Exception $e) {
            DB::rollBack();
            $message = getErrorMessage($e, $e->getMessage());
            return $this->error([], $message);
        }
    }

    public function getSingleUserChat($senderId, $receiverId)
    {

        //get data
        $chats = Chat::where(function ($query) use ($senderId, $receiverId) {
            $query->where('sender_id', $senderId)->where('receiver_id', $receiverId);
        })->orWhere(function ($query) use ($senderId, $receiverId) {
            $query->where('receiver_id', $senderId)->where('sender_id', $receiverId);
        })->with('media.file_manager')->orderBy('chats.created_at')->get();

        //make seen
        Chat::where('sender_id', $receiverId)->update(['is_seen' => STATUS_ACTIVE]);

        return $chats;
    }

    public function getChatUserList()
    {
        $users = User::select('users.id', 'users.name', 'users.image', 'users.last_seen')
            ->leftJoin('chats AS c1', function ($join) {
                $join->on('users.id', '=', 'c1.sender_id');
                $join->whereRaw('c1.id = (SELECT MAX(id) FROM chats WHERE sender_id = users.id and receiver_id = '.auth()->id().')');
            })
            ->leftJoin('chats AS c2', function ($join) {
                $join->on('users.id', '=', 'c2.receiver_id');
                $join->whereRaw('c2.id = (SELECT MAX(id) FROM chats WHERE receiver_id = users.id and sender_id = '.auth()->id().')');
            })
            ->selectRaw('CASE
                    WHEN MAX(c1.created_at) >= MAX(c2.created_at) THEN c1.message
                    ELSE c2.message
                END AS last_message')
            ->selectRaw('CASE
                    WHEN MAX(c1.created_at) >= MAX(c2.created_at) THEN MAX(c1.created_at)
                    ELSE MAX(c2.created_at)
                END AS last_message_time')
            ->groupBy('users.id', 'users.name', 'users.image', 'users.last_seen')
            ->where('role','!=', USER_ROLE_SUPER_ADMIN)
            ->where('users.id', '!=', auth()->id())
            ->where('users.status', STATUS_ACTIVE)
            ->where('users.tenant_id', getTenantId())
            ->withCount('unseen_message')
            ->get();

        return $this->success($users);
    }

    public function unseenUserMessage()
    {
        $users = User::where('users.status', STATUS_ACTIVE)->where('users.id', '!=', auth()->id())->leftJoin('chats', ['chats.sender_id' => 'users.id', 'chats.receiver_id' => DB::raw(auth()->id())])
            ->select('users.name', 'users.id', 'users.last_seen', DB::raw('max(chats.created_at) as last_message_time'), 'chats.message as last_message')
            ->withCount('unseen_message')
            ->groupBy('users.id')->get();

        return $this->success($users);
    }
}
