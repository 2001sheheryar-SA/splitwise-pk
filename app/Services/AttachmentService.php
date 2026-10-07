<?php

namespace App\Services;

use App\Models\Attachment;
use App\Models\Message;
use App\Models\MessageAttachment;
use App\Models\Settlements;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use MongoDB\BSON\ObjectId;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;


class AttachmentService
{
    public function storeScreenshot(Settlements $settlement, UploadedFile $file): Attachment
    {
            $bucket = DB::connection('mongodb')
            ->getMongoDB()
            ->selectGridFSBucket(); // default chunk size: 255 KB

        $stream = fopen($file->getRealPath(), 'rb');

        try {
            $fileId = $bucket->uploadFromStream(
                $file->hashName(),
                $stream,
                ['metadata' => [
                    'settlement_id' => (string) $settlement->id,
                    'mime_type'     => $file->getMimeType(),
                ]]
            );
        } finally {
            fclose($stream);
        }

        return Attachment::create([
            'settlement_id' => (string) $settlement->id,
            'file_id'       => (string) $fileId,
            'filename'      => $file->getClientOriginalName(),
            'mime_type'     => $file->getMimeType(),
            'size'          => $file->getSize(),
        ]);
    }


    public function downloadScreenshotToStorage(Attachment $attachmentId): string
{
    // 1. Fetch the Attachment model to get the GridFS file_id
    $attachment = Attachment::findOrFail($attachmentId->id);

    // 2. Open the GridFS stream from MongoDB
    $bucket = DB::connection('mongodb')
        ->getMongoDB()
        ->selectGridFSBucket();

    $stream = $bucket->openDownloadStream(new ObjectId($attachment->file_id));

    // 3. Define the local storage destination path (e.g., storage/app/public/42.png)
    $extension = pathinfo($attachment->filename, PATHINFO_EXTENSION) ?: 'png';
    $filename = "{$attachment->id}.{$extension}";
    $destinationPath = storage_path("app/public/attachments/{$filename}");

    // 4. Save the stream to the public storage directory
    $targetStream = fopen($destinationPath, 'wb');

    try {
        stream_copy_to_stream($stream, $targetStream);
    } finally {
        fclose($stream);
        fclose($targetStream);
    }
   

    return $destinationPath;
}

    
}
