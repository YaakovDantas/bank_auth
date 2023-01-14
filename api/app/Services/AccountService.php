<?php

namespace App\Services;

use App\Enums\TransactionStatusEnum;
use App\Exceptions\BusinessException;
use App\Repositories\TransactionRepository;
use App\Repositories\UserRepository;
use App\Services\TransactionLogic\TransactionFactory;

class AccountService extends BaseService
{
    protected $transactionRepository;
    protected $userRepository;

    public function __construct(
        UserRepository $userRepository,
        TransactionRepository $transactionRepository
    ) {
        $this->NotFoundMessage = "Account not found!";
        $this->userRepository = $userRepository;        
        $this->transactionRepository = $transactionRepository;
    }

    public function processTransaction($user_id, $transaction_data)
    {
        $account = $this->userRepository->find($user_id, 'account')->account;

        if (!$account) {
            throw new BusinessException('Invalid account information.', 400);
        }

        $transaction_logic = TransactionFactory::generate($transaction_data->type, $transaction_data);
        $transaction = $transaction_logic->process($account);

        return $transaction;
    }

    public function history($user_id)
    {
        $account = $this->userRepository->find($user_id, 'account.transactions')->account;

        if (!$account) {
            throw new BusinessException('Invalid account information.', 400);
        }

        return $this->transactionRepository->getAllWhere([
            ['account_id', $account->id],
            ['status', "!=", TransactionStatusEnum::PENDING]
        ]);
    }

    public function balance($user_id)
    {
        $account = $this->userRepository->find($user_id, 'account')->account;

        if (!$account) {
            throw new BusinessException('Invalid account information.', 400);
        }

        return [ "balance" => $account->balance ];
    }
}
