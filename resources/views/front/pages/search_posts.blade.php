@extends('front.layout.pages-layout')

@section('pageTitle', isset($pageTitle) ? $pageTitle : 'Document title')

@section('meta_tags')

    {!! SEO::generate() !!}

@endsection

@section('content')

    {{-- Search --}}
    <div class="d-flex align-items-center mb-3">

        {{-- title --}}
        <h4 class="title-color">
            Search for:
        </h4>

        <span class="ml-2">{{ $query }}</span>

    </div>

    {{-- Search result returns --}}
    <div class="row">

        <div class="col-lg-8  mb-5 mb-lg-0">

            <div class="col-12  mb-5 mb-lg-0">

                @forelse ( $posts as $index => $post )


                    <article class="row mb-5">
                        <div class="col-md-4 mb-4 mb-md-0">
                            <div class="post-img-box">
                            <img src="/images/posts/resized/resized_{{ $post->featured_image }}" class="img-fluid rounded-lg" alt="post-thumb">
                            </div>
                        </div>
                        <div class="col-md-8">
                            <h5>
                            <a class="post-title" href="{{ route('read_post',$post->slug) }}">
                                {{ $post->title }}
                            </a>
                            </h5>
                            <ul class="list-inline post-meta mb-2">
                            <li class="list-inline-item">
                                <i class="ti-user mr-1"></i><a href="{{ route('author_posts',$post->author->username) }}">{{ $post->author->name }}</a>
                            </li>
                            <li class="list-inline-item">
                                <i class="ti-calendar mr-1"></i>{{ date_formatter($post->created_at) }}
                            </li>
                            <li class="list-inline-item">
                                Category : <a href="{{ route('category_posts',$post->post_category->slug) }}" class="ml-1">{{ $post->post_category->name }} </a>
                            </li>
                            <li class="list-inline-item">
                                <i class="ti-timer mr-1"></i>{{ readDuration($post->title, $post->content) }} @choice('min|mins', readDuration($post->title, $post->content))
                            </li>
                            </ul>
                            <p>
                            {!! Str::ucfirst(words($post->content,28)) !!}
                            </p>
                            <a href="{{ route('read_post',$post->slug) }}" class="btn btn-outline-primary">Read more...</a>
                        </div>
                    </article>

                    @if ( ($index + 1) % 3 == 0 )

                        {{-- @if( rand(1, 10) > 7 ) --}}
                        <div class="mb-3 pb-4" style="background: yellow; mar">
                            @include(get_random_ad_view(array('block_with_two','block_with_three')))
                        </div>

                    @endif

                @empty

                    {{-- no search results --}}
                    <p><span class="text-danger">No posts found for your search</span></p>

                @endforelse

            </div>

            {{-- pagination --}}
            <div class="pagination-block">
                {{ $posts->appends(request()->input())->links('custom_pagination') }}
            </div>

        </div>

        {{-- side bar  --}}
        <aside class="col-lg-4">

            <!-- Search -->
            <x-sidebar-search></x-sidebar-search>

            <!-- categories -->
            <x-sidebar-categories></x-sidebar-categories>

            <!-- tags -->
            <x-sidebar-tags></x-sidebar-tags>

            <!-- latest post widget -->
            <div class="widget">

                {{-- title --}}
                <h5 class="widget-title">
                    <span>Latest Article</span>
                </h5>

                <!-- post-item -->
                @foreach ( sidebar_latest_posts() as $gindex => $item )

                    {{-- widget --}}
                    <ul class="list-unstyled widget-list">

                        <li class="media widget-post align-items-center">

                            {{-- image --}}
                            <a href="{{ route('read_post',$item->slug) }}">
                                <img loading="lazy" class="mr-3" src="/images/posts/resized/thumb_{{ $item->featured_image }}">
                            </a>

                            <div class="media-body">

                                <h6 class="mb-0">
                                    <a href="{{ route('read_post',$item->slug) }}">{{ $item->title }}</a>
                                </h6>

                                <small>{{ date_formatter($item->created_at) }}</small>

                            </div>

                        </li>

                    </ul>

                    @if ( ($gindex + 1) % 2 == 0 )

                        <div class="mb-3 pb-4" style="">
                            @include(get_random_ad_view(array('sidebar_banner','block_with_two')))
                        </div>

                    @endif

                @endforeach

            </div>

        </aside>

    </div>

@endsection
