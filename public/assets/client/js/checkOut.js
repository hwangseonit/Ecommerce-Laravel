$(document).ready(function () {
    // Lấy tỉnh thành
    $.getJSON('https://esgoo.net/api-tinhthanh/1/0.htm', function (data_tinh) {
        if (data_tinh.error == 0) {
            $.each(data_tinh.data, function (key_tinh, val_tinh) {
                $("#city").append('<option value="' + val_tinh.id + '">' + val_tinh.full_name + '</option>');
            });

            $("#city").change(function (e) {
                var idtinh = $(this).val();
                // Lấy quận huyện
                $.getJSON('https://esgoo.net/api-tinhthanh/2/' + idtinh + '.htm', function (data_quan) {
                    if (data_quan.error == 0) {
                        $("#district").html('<option value="0">Quận Huyện</option>');
                        $("#ward").html('<option value="0">Phường Xã</option>');
                        $.each(data_quan.data, function (key_quan, val_quan) {
                            $("#district").append('<option value="' + val_quan.id + '">' + val_quan.full_name + '</option>');
                        });

                        // Lấy phường xã  
                        $("#district").change(function (e) {
                            var idquan = $(this).val();
                            $.getJSON('https://esgoo.net/api-tinhthanh/3/' + idquan + '.htm', function (data_phuong) {
                                if (data_phuong.error == 0) {
                                    $("#ward").html('<option value="0">Phường Xã</option>');
                                    $.each(data_phuong.data, function (key_phuong, val_phuong) {
                                        $("#ward").append('<option value="' + val_phuong.id + '">' + val_phuong.full_name + '</option>');
                                    });
                                }
                            });
                        });

                    }
                });
            });

        }
    });
});

document.addEventListener('DOMContentLoaded', function () {
    let voucherApplied = false; // Biến để kiểm tra xem voucher đã được áp dụng hay chưa

    document.getElementById('applyVoucherButton').addEventListener('click', function () {
        if (voucherApplied) {
            const voucherMessage = document.getElementById('voucherMessage');
            if (voucherMessage) {
                voucherMessage.innerText = 'Mã voucher đã được áp dụng';
                voucherMessage.classList.remove('d-none');
            }
            return;
        }

        let voucherCode = document.getElementById('voucher').value;
        let totalAmount = parseInt(document.getElementById('totalAmountInput').value);

        if (voucherCode.trim() === '') {
            const voucherMessage = document.getElementById('voucherMessage');
            if (voucherMessage) {
                voucherMessage.innerText = 'Vui lòng nhập mã voucher';
                voucherMessage.classList.remove('d-none');
            }
            return;
        }

        fetch(`/apply-voucher?voucher=${voucherCode}&total_amount=${totalAmount}`)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    let discount = data.discount;
                    let newTotalAmount = totalAmount - discount;
                    document.getElementById('totalAmount').innerText = newTotalAmount.toLocaleString('vi-VN', {
                        style: 'currency',
                        currency: 'VND'
                    });
                    document.getElementById('totalAmountInput').value = newTotalAmount;
                    document.getElementById('voucherDiscount').innerText = `-${numberFormat(discount)}`;
                    document.getElementById('voucherSection').classList.remove('d-none');
                    document.getElementById('voucherMessage').classList.add('d-none');
                    document.getElementById('discountAmountInput').value = discount;
                    voucherApplied = true; // Đánh dấu voucher đã được áp dụng
                } else {
                    document.getElementById('voucherSection').classList.add('d-none');
                    const voucherMessage = document.getElementById('voucherMessage');
                    if (voucherMessage) {
                        voucherMessage.innerText = data.message;
                        voucherMessage.classList.remove('d-none');
                    }
                    document.getElementById('discountAmountInput').value = 0;
                }
            })
            .catch(error => {
                console.error('Error:', error);
                document.getElementById('voucherSection').classList.add('d-none');
                const voucherMessage = document.getElementById('voucherMessage');
                if (voucherMessage) {
                    voucherMessage.innerText = 'Mã voucher không hợp lệ';
                    voucherMessage.classList.remove('d-none');
                }
                document.getElementById('discountAmountInput').value = 0;
            });
    });

    function numberFormat(number) {
        return new Intl.NumberFormat('vi-VN', {
            minimumFractionDigits: 0
        }).format(number) + '₫';
    }

    document.getElementById('placeOrderButton').addEventListener('click', function (event) {
        let isValid = true;
        const Fields = ['fullName', 'phone', 'city', 'district', 'ward', 'address'];

        Fields.forEach(function (fieldId) {
            const field = document.getElementById(fieldId);
            if (!field.value.trim()) {
                isValid = false;
                field.classList.add('is-invalid');
                const nextElement = field.nextElementSibling;
                if (nextElement) {
                    nextElement.innerText = 'Không được để trống';
                    nextElement.style.display = 'block';
                }
            } else {
                field.classList.remove('is-invalid');
                const nextElement = field.nextElementSibling;
                if (nextElement) {
                    nextElement.innerText = '';
                    nextElement.style.display = 'none';
                }
            }
        });

        if (!isValid) {
            event.preventDefault();
        } else {
            let selectedPaymentMethod = document.querySelector('input[name="order_type"]:checked').value;
            let checkoutForm = document.getElementById('checkoutForm');
            if (selectedPaymentMethod === 'VNPay') {
                checkoutForm.action = "{{ route('vnpay_payment') }}";
            }
            if (selectedPaymentMethod === 'Cod') {
                checkoutForm.action = "{{ route('cod_payment') }}";
            }
            checkoutForm.submit();
        }
    });
});
