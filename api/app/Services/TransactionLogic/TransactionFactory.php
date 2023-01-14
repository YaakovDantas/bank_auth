<?php

namespace App\Services\TransactionLogic;

use App\Exceptions\BusinessException;
use App\Enums\TransactionTypeEnum;

class TransactionFactory
{
    public static function generate($type, $transacion): TransactionInterface
    {
        switch($type) {
            case TransactionTypeEnum::DRAFT :
                return new DraftStrategy($transacion);
            case TransactionTypeEnum::DECLINED :
                return new DeclinedStrategy($transacion);
            case TransactionTypeEnum::DEPOSIT :
                return new CreateStrategy($transacion);
            case TransactionTypeEnum::APPROVED :
                return new ApprovedStrategy($transacion);
            default:
                throw new BusinessException('Invalid transaction type', 400);
        }
    }
}
