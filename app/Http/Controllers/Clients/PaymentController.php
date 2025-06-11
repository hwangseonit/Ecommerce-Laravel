<?php

namespace App\Http\Controllers\Clients;

use App\Http\Controllers\Controller;
use App\Mail\OrderInvoiceMail;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Voucher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class PaymentController extends Controller
{
    // public function processOrder(Request $request)
    // {
    //     // Validate the input
    //     $request->validate([
    //         'fullName' => 'required|string|max:255',
    //         'city' => 'required|string|max:255',
    //         'district' => 'required|string|max:255',
    //         'ward' => 'required|string|max:255',
    //         'address' => 'required|string|max:255',
    //         'phone' => 'required|string|max:10',
    //         'note' => 'nullable|string',
    //         'paymentMethod' => 'required|string',
    //     ]);
    //     $paymentMethod = $request->input('paymentMethod');
    //     if ($paymentMethod === 'VNPay') {
    //         // Chuyển hướng tới trang thanh toán của VNPay
    //         return redirect()->route('vnpay_payment', [
    //             'amount' => $request->input('totalAmount'),
    //             'orderInfo' => 'Thanh toán đơn hàng'
    //         ]);
    //     } else if ($paymentMethod === 'Cod') {
    //         // Tạo đơn hàng cho thanh toán COD
    //         return $this->createOrder($request, 'Cod');
    //     }

    //     return back()->with('error', 'Phương thức thanh toán không hợp lệ.');
    // }
    public function processOrder(Request $request)
{
    //  dd($request->input('total_amount'));
    // Validate the input
    $request->validate([
        'fullName' => 'required|string|max:255',
        'city' => 'required|string|max:255',
        'district' => 'required|string|max:255',
        'ward' => 'required|string|max:255',
        'address' => 'required|string|max:255',
        'phone' => 'required|string|max:10',
        'note' => 'nullable|string',
        'paymentMethod' => 'required|string',
    ]);

    $paymentMethod = $request->input('paymentMethod');
    if ($paymentMethod === 'VNPay') {
        // Gửi yêu cầu POST đến route vnpay_payment
        return view('payment.vnpay_form', ['totalAmount' => $request->input('total_amount')]);
    } else if ($paymentMethod === 'Cod') {
        // Tạo đơn hàng cho thanh toán COD
        return $this->createOrder($request, 'Cod');
    }

    return back()->with('error', 'Phương thức thanh toán không hợp lệ.');
}

    // public function vnpay_payment()
    // {
    //     error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);
    //     date_default_timezone_set('Asia/Ho_Chi_Minh');

    //     $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
    //     $vnp_Returnurl = "https://6db0-125-235-236-116.ngrok-free.app ";
    //     $vnp_TmnCode = "N5W6AA0O"; //Mã website tại VNPAY 
    //     $vnp_HashSecret = "LMFQ08Y3JOATOR2QECTGA7DTOZC76RRS"; //Chuỗi bí mật

    //     $vnp_TxnRef = date("YmdHis"); //Mã đơn hàng. Trong thực tế Merchant cần insert đơn hàng vào DB và gửi mã này sang VNPAY

    //     $vnp_OrderInfo = 'Thanh toán đơn hàng';
    //     $vnp_OrderType = 'Thanh toán vnpay';
    //     $vnp_Amount = $_POST['total_amount'] * 100;
    //     $vnp_Locale = 'VN';
    //     $vnp_BankCode = 'NCB';
    //     $vnp_IpAddr = $_SERVER['REMOTE_ADDR'];
    //     $inputData = array(
    //         "vnp_Version" => "2.1.0",
    //         "vnp_TmnCode" => $vnp_TmnCode,
    //         "vnp_Amount" => $vnp_Amount,
    //         "vnp_Command" => "pay",
    //         "vnp_CreateDate" => date('YmdHis'),
    //         "vnp_CurrCode" => "VND",
    //         "vnp_IpAddr" => $vnp_IpAddr,
    //         "vnp_Locale" => $vnp_Locale,
    //         "vnp_OrderInfo" => $vnp_OrderInfo,
    //         "vnp_OrderType" => $vnp_OrderType,
    //         "vnp_ReturnUrl" => $vnp_Returnurl,
    //         "vnp_TxnRef" => $vnp_TxnRef
    //     );

    //     if (isset($vnp_BankCode) && $vnp_BankCode != "") {
    //         $inputData['vnp_BankCode'] = $vnp_BankCode;
    //     }
    //     ksort($inputData);
    //     $query = "";
    //     $i = 0;
    //     $hashdata = "";
    //     foreach ($inputData as $key => $value) {
    //         if ($i == 1) {
    //             $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
    //         } else {
    //             $hashdata .= urlencode($key) . "=" . urlencode($value);
    //             $i = 1;
    //         }
    //         $query .= urlencode($key) . "=" . urlencode($value) . '&';
    //     }

    //     $vnp_Url = $vnp_Url . "?" . $query;
    //     if (isset($vnp_HashSecret)) {
    //         $vnpSecureHash =   hash_hmac('sha512', $hashdata, $vnp_HashSecret); //  
    //         $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
    //     }
    //     $returnData = array(
    //         'code' => '00', 'message' => 'success', 'data' => $vnp_Url
    //     );
    //     return redirect($vnp_Url);
    // }

    public function vnpay_payment(Request $request)
{
    error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);
    date_default_timezone_set('Asia/Ho_Chi_Minh');

    $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
    $vnp_Returnurl = "https://6db0-125-235-236-116.ngrok-free.app"; // Đảm bảo URL trả về đúng
    $vnp_TmnCode = "N5W6AA0O"; // Mã website tại VNPAY 
    $vnp_HashSecret = "LMFQ08Y3JOATOR2QECTGA7DTOZC76RRS"; // Chuỗi bí mật

    $vnp_TxnRef = date("YmdHis"); // Mã đơn hàng. Trong thực tế Merchant cần insert đơn hàng vào DB và gửi mã này sang VNPAY

    $vnp_OrderInfo = 'Thanh toán đơn hàng';
    $vnp_OrderType = 'Thanh toán vnpay';
    $vnp_Amount = $request->input('total_amount') * 100;
    $vnp_Locale = 'VN';
    $vnp_BankCode = 'NCB';
    $vnp_IpAddr = $request->ip();
    
    $inputData = array(
        "vnp_Version" => "2.1.0",
        "vnp_TmnCode" => $vnp_TmnCode,
        "vnp_Amount" => $vnp_Amount,
        "vnp_Command" => "pay",
        "vnp_CreateDate" => date('YmdHis'),
        "vnp_CurrCode" => "VND",
        "vnp_IpAddr" => $vnp_IpAddr,
        "vnp_Locale" => $vnp_Locale,
        "vnp_OrderInfo" => $vnp_OrderInfo,
        "vnp_OrderType" => $vnp_OrderType,
        "vnp_ReturnUrl" => $vnp_Returnurl,
        "vnp_TxnRef" => $vnp_TxnRef
    );

    if (!empty($vnp_BankCode)) {
        $inputData['vnp_BankCode'] = $vnp_BankCode;
    }

    ksort($inputData);
    $query = "";
    $hashdata = "";
    foreach ($inputData as $key => $value) {
        $hashdata .= urlencode($key) . "=" . urlencode($value) . '&';
        $query .= urlencode($key) . "=" . urlencode($value) . '&';
    }

    $vnp_Url .= "?" . $query;
    if (isset($vnp_HashSecret)) {
        $vnpSecureHash = hash_hmac('sha512', rtrim($hashdata, '&'), $vnp_HashSecret);
        $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
    }

    return redirect($vnp_Url);
}


    private function createOrder(Request $request, $paymentMethod, $transactionId = null, $status = 'pending')
    {
        // Lấy giỏ hàng của người dùng
        $cart = Cart::where('user_id',  auth()->id())->where('status', 'active')->first();

        // Kiểm tra nếu giỏ hàng không tồn tại
        if (!$cart) {
            return redirect()->back()->with('error', 'Giỏ hàng không tồn tại hoặc đã hết hạn.');
        }

        // Tạo mã đơn hàng duy nhất
        $orderCode = date('YmdHis') . strtoupper(uniqid());

        // Kiểm tra và cập nhật voucher nếu có
        if ($request->voucher) {
            $voucher = Voucher::where('code', $request->voucher)->first();

            if (!$voucher) {
                return redirect()->back()->with('error', 'Mã voucher không hợp lệ.');
            }

            if ($voucher->used >= $voucher->quantity) {
                return redirect()->back()->with('error', 'Voucher này đã hết lượt sử dụng.');
            }

            // Cập nhật số lần sử dụng của voucher
            $voucher->increment('used');
        }

        // Tạo đơn hàng
        $order = Order::create([
            'user_id' => auth()->id(),
            'order_code' => $orderCode,
            'full_name' => $request->fullName,
            'phone' => $request->phone,
            'city' => $request->city,
            'district' => $request->district,
            'ward' => $request->ward,
            'address' => $request->address,
            'note' => $request->note,
            'total_amount' => $cart->items->sum(function ($item) {
                return $item->price * $item->quantity;
            }),
            'discount_amount' => $request->discount_amount ?? 0,
            'final_amount' => $cart->items->sum(function ($item) {
                return $item->price * $item->quantity;
            }) - ($request->discount_amount ?? 0),
            'voucher_code' => $request->voucher,
            'payment_method' => $paymentMethod,
            'transaction_id' => $transactionId,
            'status' => $status,
        ]);

        // Tạo các chi tiết đơn hàng
        foreach ($cart->items as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item->product_id,
                'variant_id' => $item->variant_id,
                'product_name' => $item->product->name,
                'quantity' => $item->quantity,
                'price' => $item->price,
                'total_price' => $item->price * $item->quantity,
            ]);

            // Trừ số lượng sản phẩm trong kho
            if ($item->variant_id) {
                // Nếu sản phẩm có biến thể
                $variant = ProductVariant::find($item->variant_id);
                if ($variant) {
                    $variant->decrement('stock', $item->quantity);
                }
            } else {
                // Nếu sản phẩm không có biến thể
                $product = Product::find($item->product_id);
                if ($product) {
                    $product->decrement('store_quantity', $item->quantity);
                }
            }
        }

        // Xóa các mục trong giỏ hàng
        CartItem::where('cart_id', $cart->id)->delete();

        // Xóa giỏ hàng
        $cart->delete();

        return redirect()->route('orderReceived', ['id' => $order->id])->with('success', 'Đặt hàng thành công.');
    }
}
