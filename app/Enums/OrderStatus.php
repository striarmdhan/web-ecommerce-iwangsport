<?php

namespace App\Enums;

enum OrderStatus: string
{
    case Pending = 'pending';
    case ShippingConfirmed = 'shipping_confirmed';
    case WaitingVerification = 'waiting_verification';
    case Verified = 'verified';
    case Rejected = 'rejected';
    case Processing = 'processing';
    case Shipped = 'shipped';
    case Completed = 'completed';
    case Cancelled = 'cancelled';

    public function label(): string
    {
        return match ($this) {
            self::Pending => 'Menunggu Konfirmasi Ongkir',
            self::ShippingConfirmed => 'Siap Dibayar',
            self::WaitingVerification => 'Menunggu Verifikasi',
            self::Verified => 'Diverifikasi',
            self::Rejected => 'Ditolak',
            self::Processing => 'Diproses',
            self::Shipped => 'Dikirim',
            self::Completed => 'Selesai',
            self::Cancelled => 'Dibatalkan',
        };
    }

    public function badgeColor(): string
    {
        return match ($this) {
            self::Pending => 'bg-yellow-100 text-yellow-800',
            self::ShippingConfirmed => 'bg-orange-100 text-orange-800',
            self::WaitingVerification => 'bg-blue-100 text-blue-800',
            self::Verified => 'bg-green-100 text-green-800',
            self::Rejected => 'bg-red-100 text-red-800',
            self::Processing => 'bg-indigo-100 text-indigo-800',
            self::Shipped => 'bg-purple-100 text-purple-800',
            self::Completed => 'bg-emerald-100 text-emerald-800',
            self::Cancelled => 'bg-gray-100 text-gray-800',
        };
    }
}
