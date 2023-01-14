<?php

namespace App\Services\TransactionLogic;

use App\Entities\Transaction;
use App\Enums\TransactionStatusEnum;
use App\Enums\TransactionTypeEnum;

class DeclinedStrategy implements TransactionInterface
{
    protected $data;

    public function __construct($transaction)
    {
        $this->data = $transaction;
    }

    public function process($transaction): Transaction
    {
        $transaction->type = TransactionTypeEnum::DEPOSIT;
        $transaction->status = TransactionStatusEnum::DECLINED;
        $transaction->save();

        unset($transaction['account']);
        return $transaction;
    }
}
