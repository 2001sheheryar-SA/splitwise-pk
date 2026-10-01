<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TeamResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'company_id' => $this->company_id,
            'created_by' => $this->created_by,
            'name' => $this->name,
            'description' => $this->description,
            'channels_count' => $this->whenCounted('channels'),
            'channels' => ChannelResource::collection($this->whenLoaded('channels')),
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at->format('Y-m-d H:i:s'),
        ];
    }
}
