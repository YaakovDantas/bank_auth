<?php

namespace App\Services\TransactionLogic;

use App\Entities\Transaction;
use App\Enums\TransactionStatusEnum;

class ApprovedStrategy implements TransactionInterface
{
    protected $data;

    public function __construct($transaction)
    {
        $this->data = $transaction;
    }

    public function process($transaction): Transaction
    {
        $transaction->account->balance += $transaction->amount;
        $transaction->account->save();

        $transaction->status = TransactionStatusEnum::APPROVED;
        $transaction->save();

        unset($transaction['account']);
        return $transaction;
    }
}
