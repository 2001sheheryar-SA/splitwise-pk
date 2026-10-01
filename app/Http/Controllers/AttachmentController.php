<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\UploadImageRequest;
use App\Http\Resources\AttachmentResource;
use App\Models\Message;
use App\Services\AttachmentService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Response;

class AttachmentController extends Controller
{
    public function __construct(private readonly AttachmentService $attachmentService)
    {
    }

    /**
     * POST /api/messages/{message}/attachments
     *
     * Uploads an image and attaches it to an existing message.
     */
    public function store(UploadImageRequest $request, Message $message): JsonResponse
    {
        Gate::authorize('update', $message);

        $attachment = $this->attachmentService->store($message, $request->file('image'));

        return Response::success(
            'Image uploaded successfully.',
            new AttachmentResource($attachment),
            201
        );
    }
}
