<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AdminResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        if($this->getRoleNames()->first()!='Admin'){
            return [
                'id'=>$this->id,
                'name'=>$this->name,
                'email'=>$this->email,
                'phone'=>$this->phone,
                'username'=>$this->username,
                'image'=>$this->image,
                'status'=>$this->status,
                'role_name'=>$this->getRoleNames()->first(),
            ];
        }
        
    }
}
