@extends ('layouts.client.main')
@section('content')
    @include('components.client.alert')
    <div class="container">
        {{-- <a href="{{ route('home.index')}}">Trang chủ</a> / <a href="{{ route('blog.index')}}">Tin tức</a> --}}
        @include('breadcrumbs::bootstrap4')
        <div class="d-flex my-2" id="category-list">
            <div class="title">
                <a href="{{ route('blog.index') }}" class="nav-link category-link">
                    <h6>Tất cả</h6>
                </a>
            </div>
            @foreach ($categories as $category)
                <div class="ms-3 title">
                    <a href="{{ route('blog.by.category', ['slug' => $category->slug]) }}"
                        class="nav-link category-link text-decoration-none text-dark-custom">
                        <h6>{{ $category->name }}</h6>
                    </a>
                </div>
            @endforeach
        </div>
        <!-- /section title -->
        <div class="row mb-3">
            <div class="col-md-6 ps-0 col-12 ">
                <h3 class="title">Bài viết nổi bật</h3>
                <div id="postCarousel" class="carousel slide mt-3" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        @foreach ($posts as $post)
                            <div class="carousel-item active">
                                <a href="{{ route('blog.show', $post->id) }}">
                                    <img width="100%" class="card"
                                        src="{{ $post->image ? asset('images/' . $post->image) : asset('images/no_images.jpg') }}"
                                        alt="">
                                </a>
                                <div class="">
                                    <div class="btn btn-danger btn-sm">
                                        {{ $post->category->name }}
                                    </div>
                                    <a href="{{ route('blog.show', $post->id) }}">
                                        <h6 class="title title-post">{{ $post->title }}</h6>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#postCarousel"
                        data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#postCarousel"
                        data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            </div>
            <div class="col-6 ps-0 d-none d-md-block">
                <h3 class="title">Bài viết mới nhất</h3>
                @if ($postnews->count() > 0)
                    @foreach ($postnews as $postnew)
                        <div class="row mt-3">
                            <div class="col-4 p-0">
                                <a href="{{ route('blog.show', $postnew->id) }}">
                                    <img width="100%" class="card"
                                        src="{{ $postnew->image ? asset('images/' . $postnew->image) : asset('images/no_images.jpg') }}"
                                        alt="">
                                </a>
                            </div>
                            <div class="col-8">
                                <div class="btn btn-danger btn-sm">
                                    {{ $postnew->category->name }}
                                </div>
                                <a href="{{ route('blog.show', $postnew->id) }}">
                                    <h6 class="title title-post">{{ $postnew->title }}</h6>
                                </a>
                                <div class="author d-flex align-items-center">
                                    <div class="name">
                                        <div class="d-flex">
                                            <span>{{ $postnew->created_at->format('d/m/Y') }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <p class="text-center mt-3">Không có bài viết nào phù hợp với loại bài viết này.</p>
                @endif
            </div>
        </div>
        {{-- tất cả bài viết  --}}
        <div class="row mt-3">
            <div class="col-12">
                <div class="row g-3 w-100">
                    @if ($posts->count() > 0)
                        @foreach ($posts as $post)
                            <div class="col-xl-4 col-md-6 col-sm-6 col-6">
                                <div class="blog">
                                    <div class="img">
                                        <a href="{{ route('blog.show', $post->id) }}">
                                            <img width="100%" class="card"
                                                src="{{ $post->image ? asset('images/' . $post->image) : asset('images/no_images.jpg') }}"
                                                alt="">
                                        </a>
                                    </div>
                                    <div class="blog-info">
                                        <div class="btn btn-danger btn-sm">
                                            {{ $post->category->name }}
                                        </div>
                                        <a href="{{ route('blog.show', $post->id) }}">
                                            <h6 class="title title-post">{{ $post->title }}</h6>
                                        </a>
                                        <div class="author d-flex align-items-center">
                                            <div class="name">
                                                <div class="d-flex">
                                                    <span>{{ $post->created_at->format('d/m/Y') }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <p class="text-center mt-3">Không có bài viết nào phù hợp với loại bài viết này.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
