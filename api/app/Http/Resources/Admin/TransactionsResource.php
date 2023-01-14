<?php

namespace App\Http\Resources\Admin;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class TransactionsResource extends JsonResource
{
    public function toArray($request)
    {
        $date_time = Carbon::create($this['created_at'])->format('Y-m-d H:i:s');

        $array = [
            'id' => $this['id'],
            'amount' => $this['amount'],
            'type' => $this['type'],
            'status' => $this['status'],
            'url' => $this['url'],
            'description' => $this['description'],
            'date_time' => $date_time,
        ];

        return $array;
    }
}
