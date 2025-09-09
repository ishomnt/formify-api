<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ResponseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'date' => $this->date,
            'user' => new UserResource($this->whenLoaded('user')),
            'answers' => $this->whenLoaded('answers', function() {
                return $this->answers->mapWithKeys(function($answer) {
                    return [
                        $answer->question->name => $answer->value
                    ];
                });
            }),
        ];
    }
}
