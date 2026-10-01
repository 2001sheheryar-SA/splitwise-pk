<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\MessageRequest;

use App\Http\Resources\MessageResource;
use App\Models\Channel;
use App\Models\Message;
use App\Models\User;
use App\Services\MessageService;
use App\Services\ViewQuery;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Response;

class MessageController extends Controller
{
    public function __construct(private readonly MessageService $messageService)
    {
    }

    /**
     * GET /api/channels/{channel}/messages
     */
    public function index(Channel $channel): JsonResponse
    {
        Gate::authorize('view', $channel);


         $limit = request()->integer('limit', 10);

        $messages = $channel->messages()
            ->with(['user', 'attachments'])
            ->latest()
            ->paginate($limit);

         $message =  $messages->total() === 0 ? 'No Message found.' : 'Messages fetched successfully.';    

        return Response::success(
            $message,
            MessageResource::collection($messages)->resolve(),
            200,
            [
                'current_page' => $messages->currentPage(),
                'last_page' => $messages->lastPage(),
                'per_page' => $messages->perPage(),
                'total' => $messages->total(),
            ]
        );
    }


    public function dmindex(User $user): JsonResponse
    {
       
        $company=$user->company;
        $authuserid=request()->user()->id;
        Gate::authorize('view', $company);

        $limit = request()->integer('limit', 10);
        $messages = Message::
                    with('attachments')->where('sender_id', $authuserid)
                    ->where('user_id', $user->id)->orwhere(function ($query) use ($authuserid, $user) {
                // Corrected orWhere part: Messages sent from auth user to target user
                $query->where('sender_id', $authuserid)
                    ->where('user_id', $user->id);})
                    ->orwhere(function ($query) use ($authuserid, $user) {
                // Corrected orWhere part: Messages recieve from target user to auth user
                $query->where('sender_id',$user->id)
                    ->where('user_id', $authuserid);})
                    ->paginate($limit);
           

         $message =  $messages->total() === 0 ? 'No Message found.' : 'Messages fetched successfully.';    

        return Response::success(
            $message,
            MessageResource::collection($messages)->resolve(),
            200,
            [
                'current_page' => $messages->currentPage(),
                'last_page' => $messages->lastPage(),
                'per_page' => $messages->perPage(),
                'total' => $messages->total(),
            ]
        );
    }

    /**
     * POST /api/channels/{channel}/messages
     */
    public function store(MessageRequest $request, Channel $channel): JsonResponse
    {
        Gate::authorize('sendmessage', $channel);
        $message = $this->messageService->send($channel, $request->user(), $request->validated('message'));

        return Response::success(
            'Message sent successfully.',
              new MessageResource($message),
            201
        );
    }

    public function dmmessage(MessageRequest $request, User $user){
        

        $company=$user->company;
        Gate::authorize('view', $company);
        $message = $this->messageService->senddm($user, $request->user(), $request->validated('message'));

        return Response::success(
            'Message sent successfully.',
              new MessageResource($message),
            201
        );
    }
    

    /**
     * GET /api/messages/{message}
     */
    public function show(Message $message): JsonResponse
    {
        Gate::authorize('view', $message);

        return Response::success(
            'Message fetched successfully.',
            new MessageResource($message->load(['user', 'attachments']))
        );
    }

    /**
     * PUT /api/messages/{message}
     */
    public function update(MessageRequest $request, Message $message): JsonResponse
    {
       Gate::authorize('update', $message);

        $message = $this->messageService->update($message, $request->validated('message'));

        return Response::success('Message updated successfully.', new MessageResource($message->load('user')));
    }

    /**
     * DELETE /api/messages/{message}
     */
    public function destroy(Message $message): JsonResponse
    {
        Gate::authorize('delete', $message);

        $this->messageService->delete($message);

        return Response::success('Message deleted successfully.');
    }
}
