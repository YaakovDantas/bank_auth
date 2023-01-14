<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Transaction extends Model
{
    protected $table = 'transactions';

    protected $fillable = [
        'amount',
        'type',
        'description',
        'account_id',
        'status',
        'check_path',
        'created_at'
    ];

    protected $hidden = ['updated_at'];
    protected $appends = ['url'];

    public function account() {
        return $this->belongsTo(Account::class);
    }

    public function getUrlAttribute() {
        return env('FILE_URL') . Storage::url($this->check_path);
    }
}
