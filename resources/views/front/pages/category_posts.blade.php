@extends('front.layout.pages-layout')

@section('pageTitle', isset($pageTitle) ? $pageTitle : 'Document title')

@section('meta_tags')
    {!! SEO::generate() !!}
@endsection

@section('content')

    {{-- page title --}}
    <div class="w-full mb-3">
        <h3 class="title-color">{{ $pageTitle }}</h3>
    </div>

    @if ($posts->count())

        {{-- not sure what this is  --}}
        @php
            $displayed = false;
        @endphp

        <div class="row">

            @foreach ( $posts as $index => $post )

                <div class="col-sm-6 col-md-4 col-lg-3 mb-2">

                    <article class="mb-2">

                        {{-- image --}}
                        <div class="mb-2">
                            <img src="/images/posts/resized/resized_{{ $post->featured_image }}" alt="" class="img-fluid rounded-lg">
                        </div>

                        {{-- post title w/ route --}}
                        <h5>
                            <a class="post-title" href="{{ route('read_post',$post->slug) }}">
                                {{ $post->title }}
                            </a>
                        </h5>

                        {{-- date & author --}}
                        <ul class="list-inline post-meta mb-2">

                            {{-- Date --}}
                            <li class="list-inline-item">Date :
                                {{ date_formatter($post->created_at) }}
                            </li>

                            {{-- Author --}}
                            <li class="list-inline-item">Author :
                                <a href="{{ route('author_posts',$post->author->username) }}" class="ml-1">{{ $post->author->name }} </a>
                            </li>

                        </ul>

                    </article>

                </div>

                @if ( !$displayed && $index  == 3 )

                    {{-- @if( rand(1, 10) > 8 ) --}}
                    <div class="col-12 mb-3 pb-4" style="">
                        @include(get_random_ad_view(array('full_banner1','block_with_four','responsive')))
                    </div>

                    @php
                        $displayed = true;
                    @endphp

                @endif

            @endforeach

        </div>

    @else

        {{-- not posts in category --}}
        <p><span class="text-danger">No posts found in this category</span></p>

    @endif

    {{-- pagination --}}
    <div class="pagination-block">
        {{ $posts->appends(request()->input())->links('custom_pagination') }}
    </div>

@endsection
