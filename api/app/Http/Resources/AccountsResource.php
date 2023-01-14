<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class AccountsResource extends JsonResource
{
    public function toArray($request)
    {
        $date_time = Carbon::create($this['created_at'])->format('Y-m-d H:i:s');

        $array = [
            'id' => $this['id'],
            'amount' => $this['amount'],
            'description' => $this['description'],
            'type' => $this['type'],
            'status' => $this['status'],
            'date_time' => $date_time,
        ];

        return $array;
    }
}
