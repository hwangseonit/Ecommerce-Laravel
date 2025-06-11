<?php

if (!function_exists('translateOrderStatus')) {
    function translateOrderStatus($status)
    {
        $statuses = [
            'pending' => 'Chờ xử lý',
            'processing' => 'Đang xử lý',
            'completed' => 'Hoàn thành',
            'cancelled' => 'Đã hủy',
        ];

        return $statuses[$status] ?? $status;
    }
}
