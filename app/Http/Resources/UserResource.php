<?php
namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;


class UserResource extends JsonResource
{
    public function toArray($request)
    {
        $avatar = 'https://api.dicebear.com/8.x/thumbs/svg?seed=' . $this->id;
        return [
            'id' => $this->id,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'username' => $this->username,
            'username' => $this->username,
            'avatar' => $avatar
        ];
    }
}
