<?php

namespace App\Modules\Website\app\Http\Resources\Faq;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FaqResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
       return [
           "id" => $this->id ?? null,
           "question" => $this->question ?? null,
           "answer" => $this->answer ?? null
       ];
    }
}
