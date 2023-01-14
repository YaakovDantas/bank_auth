<?php

namespace App\Services\TransactionLogic;

use App\Entities\Transaction;
use App\Enums\TransactionTypeEnum;
use Illuminate\Support\Facades\Storage;

class CreateStrategy implements TransactionInterface
{
    protected $data;

    public function __construct($transaction)
    {
        $this->data = $transaction;
    }

    public function process($account): Transaction
    {
        Storage::disk('public')->put($account->user_id, $this->data->check);

        $new_transaction = new Transaction();
        $new_transaction->amount = $this->data->amount;
        $new_transaction->check_path = $account->user_id . '/' . $this->data->check->hashName();
        $new_transaction->type = TransactionTypeEnum::DEPOSIT;
        $new_transaction->account_id = $account->id;
        $new_transaction->save();

        return $new_transaction;
    }
}
