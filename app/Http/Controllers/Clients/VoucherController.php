<?php

namespace App\Http\Controllers\Clients;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Voucher;

class VoucherController extends Controller
{
    public function applyVoucher(Request $request)
    {
        $voucherCode = $request->query('voucher');
        $totalAmount = $request->query('total_amount');
        $voucher = Voucher::where('code', $voucherCode)->first();

        if (!$voucher) {
            return response()->json([
                'success' => false,
                'message' => 'Mã voucher không hợp lệ hoặc đã hết hạn',
            ]);
        }

        if (!$voucher->isValid()) {
            if ($voucher->used >= $voucher->quantity) {
                return response()->json([
                    'success' => false,
                    'message' => 'Voucher này đã hết lượt sử dụng',
                ]);
            }
            return response()->json([
                'success' => false,
                'message' => 'Mã voucher không hợp lệ hoặc đã hết hạn',
            ]);
        }

        $discountAmount = $voucher->applyDiscount($totalAmount);
        return response()->json([
            'success' => true,
            'discount' => $discountAmount,
        ]);
    }
}
