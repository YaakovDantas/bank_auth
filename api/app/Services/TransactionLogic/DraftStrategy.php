<?php

namespace App\Services\TransactionLogic;

use App\Exceptions\BusinessException;
use App\Entities\Transaction;
use App\Enums\TransactionStatusEnum;
use App\Enums\TransactionTypeEnum;

class DraftStrategy implements TransactionInterface
{
    protected $data;

    public function __construct($transaction)
    {
        $this->data = $transaction;
    }

    public function process($account): Transaction
    {
        if (($account->balance < $this->data->amount) || !$this->data->amount) {
            throw new BusinessException('Insufficient balance to complete this transaction.', 400);
        }

        $account->balance -= abs($this->data->amount);
        $account->save();
        
        $new_transaction = new Transaction();
        $new_transaction->amount = abs($this->data->amount);
        $new_transaction->description = $this->data->description;
        $new_transaction->type = TransactionTypeEnum::DRAFT;
        $new_transaction->status = TransactionStatusEnum::APPROVED;
        $new_transaction->account_id = $account->id;
        $new_transaction->save();

        return $new_transaction;
    }
}
