<?php

namespace App\Services;

use App\Models\Message;
use App\Models\MessageAttachment;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AttachmentService
{
    public function store(Message $message, UploadedFile $file): MessageAttachment
    {
        $filename = Str::uuid()->toString().'.'.$file->getClientOriginalExtension();
        $name=($message->channel_id!=0) ? 'channel'.$message->channel_id: 'user'.$message->user_id;
        $path = $file->storeAs('attachments/'.$name, $filename, 'public');

        return MessageAttachment::create([
            'message_id' => $message->id,
            'file_path' => $path,
            'file_name' => $file->getClientOriginalName(),
            'mime_type' => $file->getClientMimeType(),
            'file_size' => $file->getSize()/1024, //in Kbytes
        ]);
    }

    public static function delete(MessageAttachment $attachment): void
    {
        Storage::disk('public')->delete($attachment->file_path);
        $attachment->delete();
    }
}
