<!-- resources/views/payment/vnpay_form.blade.php -->
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thanh toán VNPay</title>
</head>
<body>
    <form action="{{ route('vnpay_payment') }}" method="POST">
        @csrf
        <input type="hidden" name="total_amount" value="{{ $totalAmount }}">
        <input type="hidden" name="order_info" value="Thanh toán đơn hàng">
        <button type="submit">Thanh toán với VNPay</button>
    </form>
</body>
</html>