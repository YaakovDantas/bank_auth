<?php

namespace App\Enums;

abstract class TransactionStatusEnum
{
    const PENDING = 'PENDING';
    const APPROVED = 'APPROVED';
    const DECLINED = 'DECLINED';
}
