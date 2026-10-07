<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\UploadImageRequest;
use App\Http\Resources\AttachmentResource;
use App\Models\Attachment;
use App\Models\Message;
use App\Models\Settlements;
use App\Services\AttachmentService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Response;

class AttachmentController extends Controller
{
    public function __construct(private readonly AttachmentService $attachmentService)
    {
    }

    
    public function store(UploadImageRequest $request, Settlements $settlement): JsonResponse
    {
       

        $attachment = $this->attachmentService->storeScreenshot($settlement, $request->file('image'));

        return Response::success(
            'Image uploaded successfully.',
            new AttachmentResource($attachment),
            201
        );
    }


    public function download(Attachment $attachment): JsonResponse
    {

        $path=$this->attachmentService->downloadScreenshotToStorage($attachment);

        return Response::success(
            "Image Downloaded in  $path successfully.",
            200
        );
    }
}
