<?php

namespace App\Enums;

enum PaymentMethod: string
{
    case Qris = 'qris';
    case Transfer = 'transfer';

    public function label(): string
    {
        return match ($this) {
            self::Qris => 'QRIS',
            self::Transfer => 'Transfer Bank',
        };
    }
}
