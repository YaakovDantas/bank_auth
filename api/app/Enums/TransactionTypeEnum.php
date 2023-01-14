<?php

namespace App\Enums;

abstract class TransactionTypeEnum
{
    const DRAFT = 'DRAFT';
    const DEPOSIT = 'DEPOSIT';
    const CREATE = 'CREATE';
    const DECLINED = 'DECLINED';
    const APPROVED = 'APPROVED';
}
