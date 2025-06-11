<script>
document.addEventListener('DOMContentLoaded', (event) => {
    // Chọn tất cả checkbox
    document.getElementById('select-all').addEventListener('click', function() {
        const checkboxes = document.querySelectorAll('.product-checkbox');
        checkboxes.forEach((checkbox) => {
            checkbox.checked = this.checked;
        });
    });

    // Xóa các sản phẩm đã chọn
    document.getElementById('delete-selected').addEventListener('click', function() {
        const selectedProducts = [];
        document.querySelectorAll('.product-checkbox:checked').forEach((checkbox) => {
            selectedProducts.push(checkbox.value);
        });

        if (selectedProducts.length > 0) {
            if (confirm('Bạn có chắc chắn muốn xóa các sản phẩm đã chọn?')) {
                fetch('{{ route('products.bulkDelete') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ ids: selectedProducts })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        location.reload();
                    } else {
                        alert('Có lỗi xảy ra, vui lòng thử lại.');
                    }
                })
                .catch((error) => {
                    console.error('Error:', error);
                });
            }
        } else {
            alert('Vui lòng chọn ít nhất một sản phẩm để xóa.');
        }
    });
});
</script>