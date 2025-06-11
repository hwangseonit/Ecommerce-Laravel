@extends('layouts.client.main')
@section('content')
<div class="container my-4">
    <h3 class="title mb-1">Danh sách yêu thích</h3>
    <ul class="list-group">
        @foreach($favorites as $favorite)
        <li class="list-group-item d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center">
                <img src="{{ asset('images/' . $favorite->product->image_url) }}" class="img-thumbnail" alt="{{ $favorite->product->name }}" style="width: 100px; height: 100px;">
                <div class="ms-3">
                    <h5>{{ $favorite->product->name }}</h5>
                </div>
            </div>
            <button class="btn btn-danger remove-favorite" data-id="{{ $favorite->product_id }}">Xóa</button>
        </li>
        @endforeach
    </ul>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var removeButtons = document.querySelectorAll('.remove-favorite');

        removeButtons.forEach(function(button) {
            button.addEventListener('click', function() {
                var productId = this.getAttribute('data-id');
                var self = this;

                fetch(`/favorites/${productId}`, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert(data.success);
                        self.closest('li').remove();
                    } else {
                        alert(data.error);
                    }
                });
            });
        });
    });
</script>
@endsection
