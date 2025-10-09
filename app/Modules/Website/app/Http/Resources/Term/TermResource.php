<?php

namespace App\Modules\Website\app\Http\Resources\Term;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TermResource extends JsonResource
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
           "description" => $this->description ?? null
       ];
    }
}
