@extends ('layouts.admin.main')

@section('content')
    @include('components.admin.alert')

    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card my-4 ">
                    <div class="card-header p-0 position-relative mt-n4 mx-3 ">
                        <div
                            class="bg-gradient-dark shadow-danger border-radius-lg pt-4 pb-3 d-flex align-items-center justify-content-between">
                            <h5 class="text-white text-capitalize ps-3">{{ $title }}</h5>
                            <a href="{{ route('post.index') }}"><button type="button"
                                    class="btn btn-primary text-capitalize me-4">
                                    Danh sách
                                </button>
                            </a>
                        </div>
                    </div>


                    <div class="row px-5">
                        <div class="row ">
                            <h1>{{ $post->title }}
                            </h1>
                        </div>
                        <div class="row gx-4 mt-2 m-0 ">
                            <div class="col-auto">
                                <div class="avatar avatar-xl position-relative">
                                    <img src="{{ $post->author->image ? asset('images/' . $post->author->image) : asset('images/no_images.jpg') }}"
                                        alt="profile_image" class="w-100 border-radius-lg shadow-sm">
                                </div>
                            </div>
                            <div class="col-auto my-auto">
                                <div class="h-100">
                                    <h5 class="mb-1">
                                        {{ $post->author->name }}
                                    </h5>
                                    <p class="mb-0 font-weight-normal text-sm">
                                        vào ngày {{ $post->created_at->format('d/m/Y') }}
                                    </p>
                                </div>
                            </div>
                            <hr class="mb-2">
                        </div>
                        <div class="row container text-dark">
                            <p>{!! $post->content !!}</p>
                            <div>
                                <div class="row mb-3">
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
