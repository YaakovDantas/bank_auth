<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray($request)
    {
        $array = [
            'id' => $this['id'],
            'name' => $this['name'],
            'balance' => $this->when($this['is_adm'] == 0, function () {
                return $this['account']['balance'];
            }),
            'is_adm' => $this->when(request()->getRequestUri() == '/api/auth/user', function () {
                return $this['is_adm'];
            })
        ];

        return $array;
    }
}
