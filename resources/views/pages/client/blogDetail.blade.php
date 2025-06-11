@extends ('layouts.client.main')
@section('content')
    @include('components.client.alert')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10 ">
                <h1 class="p-0">{{ $post->title }}</h1>
                <div class=" gx-4 mt-2 mb-3">
                    <div class="author d-flex align-items-center">
                        <div class="avatar rounded-circle shadow bg-gradient-dark">
                            <img src="{{ $post->author->image ? asset('images/' . $post->author->image) : asset('images/no_images.jpg') }}"
                                alt="logo" class="img-fluid rounded-circle" style="max-width: 50px; height: auto;">
                        </div>
                        <div class="name ps-2">
                            <div class="d-flex flex-column">
                                <h5 class="mb-1">{{ $post->author->name }}</h5>
                                <p class="mb-0 font-weight-normal text-sm">
                                    {{ $post->created_at->format('d/m/Y') }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <hr class="mx-2">
                <div class="row container text-dark">
                    <p>{!! $post->content !!}</p>
                </div>
            </div>
        </div>
    </div>
@endsection
