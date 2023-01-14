<?php

namespace App\Services;

use App\Enums\TransactionStatusEnum;
use App\Exceptions\BusinessException;
use App\Repositories\TransactionRepository;
use App\Services\TransactionLogic\TransactionFactory;

class TransactionService extends BaseService
{
    protected $transactionRepository;

    public function __construct(TransactionRepository $transactionRepository) 
    {
        $this->repository = $transactionRepository;
    }

    public function getAllPending()
    {
        return $this->repository->getAllWhere([['status', TransactionStatusEnum::PENDING]]);
    }

    public function update($data)
    {
        $transaction = $this->repository->find($data['transaction_id'], 'account');

        if ($transaction->status !== TransactionStatusEnum::PENDING) {
            throw new BusinessException('This transaction can not be updated again.', 400);
        }

        $transaction_logic = TransactionFactory::generate($data['type'], $transaction);
        $transaction = $transaction_logic->process($transaction);
        
        return $transaction;
    }
}
