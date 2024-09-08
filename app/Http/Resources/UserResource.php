<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return 
        [
            "Name"   => $this->name,
            "E-Mail" => $this->email,
            "Role"    =>$this->role,
            "Tasks"  => $this->tasks->map(function ($task) {
                return [
                    'Title' => $task->title,
                ];
            })
        ];
    }
}
