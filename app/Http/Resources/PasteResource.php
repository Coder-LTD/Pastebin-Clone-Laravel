<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PasteResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'slug' => $this->slug,
            'title' => $this->title,
            'content' => $this->content,
            'language' => $this->language,
            'expiry_type' => $this->expiry_type,
            'visibility' => $this->visibility,
            'is_burned' => (bool) ($this->is_burned ?? false),
            'views_count' => (int) ($this->views_count ?? 0),
            'expires_at' => $this->expires_at?->toIso8601String(),
            'created_at' => $this->created_at?->toIso8601String(),
            'updated_at' => $this->updated_at?->toIso8601String(),
            'url' => route('pastes.show', $this->slug),
        ];
    }
}
