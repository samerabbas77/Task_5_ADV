<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        if($this->assigned_to !=null)
        {
         $assigned =  $this->user->name;
        }else{
            $assigned = null;
        } 
        return [
            'Title'          =>$this->title,
            'description'    => $this->description,
            'priority'       =>$this->priority,
            'Due Date'       => Carbon::parse($this->due_date)->format('d-m-Y H:i'),
            'status'         => $this->status,
            'Assigned To'    => $assigned,
           

        ];
    }
}
