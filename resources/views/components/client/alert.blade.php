@if (Session::has('error'))
<div id="errorAlert" class="alert alert-danger position-fixed top-0 end-0 mt-3 me-3" style="z-index: 9999;">
    {{ Session::get('error') }}
</div>
@endif
@if (Session::has('success'))
<div id="successAlert" class="alert alert-success position-fixed top-0 end-0 mt-3 me-3" style="z-index: 9999;">
    {{ Session::get('success') }}
</div>
@endif
<script>
    // Tự động đóng thông báo sau 5 giây
    setTimeout(function() {
        var errorAlert = document.getElementById('errorAlert');
        var successAlert = document.getElementById('successAlert');
        if (errorAlert) {
            errorAlert.style.display = 'none';
        }
        if (successAlert) {
            successAlert.style.display = 'none';
        }
    }, 2000);
</script>
