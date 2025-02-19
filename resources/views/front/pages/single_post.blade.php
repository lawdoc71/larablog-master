@extends('front.layout.pages-layout')

@section('pageTitle', isset($pageTitle) ? $pageTitle : 'Document title')

@section('meta_tags')

    {!! SEO::generate() !!}

@endsection

@section('content')

    <div class="row">

        {{-- main content --}}
        <div class="col-lg-8  mb-5 mb-lg-0">

            {{-- article meta --}}
            <article class="row mb-4">

                {{-- post meta --}}
                <div class="col-lg-12 mb-2">

                    {{-- post title --}}
                    <h2 class="mb-3">
                        {{ $post->title }}
                    </h2>

                    {{-- post content --}}
                    <ul class="list-inline post-meta">

                        {{-- username --}}
                        <li class="list-inline-item">

                            <i class="ti-user mr-2"></i>

                            <a href="{{ route('author_posts',$post->author->username) }}">
                                {{ $post->author->name }}
                            </a>

                        </li>

                        {{-- created at --}}
                        <li class="list-inline-item">

                            Date : {{ date_formatter($post->created_at) }}

                        </li>

                        {{-- Category --}}
                        <li class="list-inline-item">

                            Category :

                            <a href="{{ route('category_posts',$post->post_category->slug) }}" class="ml-1">
                                {{ $post->post_category->name }}
                            </a>

                        </li>

                        {{-- content --}}
                        <li class="list-inline-item">

                            <i class="ti-timer mr-1"></i>

                            {{ readDuration($post->title,$post->content) }} @choice('min|mins',readDuration($post->title,$post->content))

                        </li>

                    </ul>

                </div>

                {{-- image fluid --}}
                <div class="col-12 mb-3">

                    <img src="/images/posts/{{ $post->featured_image }}" alt="" class="img-fluid rounded-lg">

                </div>

                <!-- social SHARE BUTTONS -->
                <div class="share-buttons">

                    <span class="title-color">Share: </span>

                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(route('read_post',$post->slug)) }}" target="_blank" class="btn-facebook">
                        <i class="ti-facebook"></i>
                    </a>

                    <a href="https://twitter.com/intent/tweet?url={{ urlencode(route('read_post',$post->slug)) }}&amp;text={{ urlencode($post->title) }}" target="_blank" class="btn-twitter">
                        <i class="ti-twitter-alt"></i>
                    </a>

                    <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode(route('read_post',$post->slug)) }}" target="_blank" class="btn-linkedin">
                        <i class="ti-linkedin"></i>
                    </a>

                    {{-- <a href="https://www.pinterest.com/pin/create/button?url={{ urlencode(route('read_post',$post->slug)) }}&description={{ urlencode($post->title) }}" target="_blank" class="btn-pinterest">
                        <i class="ti-pinterest"></i>
                    </a> --}}

                    <a href="mailto:?subject={{ urlencode('Check out this post: '.$post->title) }}&amp;body={{ urlencode('I found this interesting post: '.route('read_post',$post->slug)) }}" target="_blank" class="btn-email">
                        <i class="ti-email"></i>
                    </a>

                </div>

                <!-- post content -->
                <div class="col-lg-12">

                    <div class="content">

                        <p>{!! $post->content !!}</p>

                    </div>

                </div>

            </article>

            {{-- image banner --}}
            <div class="mb-3 pb-4" style="">

                @include(get_random_ad_view(array('responsive','full_banner')))

            </div>

            {{-- pagination --}}
            <div class="prev-next-posts mt-3 mb-3">

                <div class="row justify-content-between p-4">

                    {{-- Previous --}}
                    <div class="col-md-6 mb-2">

                        @if ( $prevPost )

                            {{-- Previous --}}
                            <div>

                                <h6>« Previous</h6>

                                <a href="{{ route('read_post',$prevPost->slug) }}">{{ $prevPost->title }}</a>

                            </div>

                        @endif

                    </div>

                    {{-- next --}}
                    <div class="col-md-6 mb-2 text-md-right">

                        @if ( $nextPost )

                            {{-- next --}}
                            <div>

                                <h6>Next »</h6>

                                <a href="{{ route('read_post',$nextPost->slug) }}">
                                    {{ $nextPost->title }}
                                </a>

                            </div>

                        @endif

                    </div>

                </div>

            </div>

            {{-- Related Posts --}}
            @if ( $relatedPosts )

                {{-- Related Posts --}}
                <section>

                    <h4>Related Posts</h4>

                    <hr>

                    @foreach ( $relatedPosts as $vindex => $related )


                        <article class="row mb-5 mt-4">

                            <div class="col-md-4 mb-4 mb-md-0">

                                <div class="post-img-box">
                                    <img src="/images/posts/resized/resized_{{ $related->featured_image }}" class="img-fluid rounded-lg" alt="post-thumb">
                                </div>

                            </div>

                            <div class="col-md-8">

                                <h4>
                                    <a class="post-title" href="{{ route('read_post',$related->slug) }}">
                                        {{ $related->title }}
                                    </a>
                                </h4>

                                <ul class="list-inline post-meta mb-2">

                                    <li class="list-inline-item">
                                        <i class="ti-user mr-1"></i>
                                        <a href="{{ route('author_posts',$related->author->username) }}">{{ $related->author->name }}</a>
                                    </li>

                                    <li class="list-inline-item">
                                        <i class="ti-calendar mr-1"></i>{{ date_formatter($related->created_at) }}
                                    </li>

                                    <li class="list-inline-item">

                                        Category :
                                        <a href="{{ route('category_posts',$related->post_category->slug) }}" class="ml-1">{{ $related->post_category->name }} </a>
                                    </li>

                                    <li class="list-inline-item">
                                        <i class="ti-timer mr-1"></i>
                                        {{ readDuration($related->title,$related->content) }} @choice('min|mins',readDuration($related->title,$related->content))
                                    </li>

                                </ul>

                                <p>
                                    {!! Str::ucfirst(words($related->content,28)) !!}
                                </p>

                                <a href="{{ route('read_post',$related->slug) }}" class="btn btn-outline-primary">Read more...</a>

                            </div>

                        </article>

                        @if ( ($vindex + 1) % 2 == 0 )

                            {{-- @if( rand(1, 10) > 7 ) --}}
                            <div class="mb-3 pb-4" style="">

                                @include(get_random_ad_view(array('block_with_four','block_with_three')))

                            </div>

                        @endif

                    @endforeach

                </section>

            @endif

            {{-- comments removed - maybe add different package --}}
            <section class="comments">

                {{-- disqus --}}
                {{-- <div id="disqus_thread"></div> --}}

                {{-- needs work --}}
                <script>
                    /**
                    *  RECOMMENDED CONFIGURATION VARIABLES: EDIT AND UNCOMMENT THE SECTION BELOW TO INSERT DYNAMIC VALUES FROM YOUR PLATFORM OR CMS.
                    *  LEARN WHY DEFINING THESE VARIABLES IS IMPORTANT: https://disqus.com/admin/universalcode/#configuration-variables    */

                    // var disqus_config = function () {
                    // this.page.url = "{{ route('read_post',$post->id) }}";  // Replace PAGE_URL with your page's canonical URL variable
                    // this.page.identifier = "PID_"+"{{ $post->id }}"; // Replace PAGE_IDENTIFIER with your page's unique identifier variable
                    // };

                    // (function() { // DON'T EDIT BELOW THIS LINE
                    // var d = document, s = d.createElement('script');
                    // s.src = 'https://larablogapp.disqus.com/embed.js';
                    // s.setAttribute('data-timestamp', +new Date());
                    // (d.head || d.body).appendChild(s);
                    // })();

                </script>

                {{-- enable JavaScript --}}
                {{-- <noscript>Please enable JavaScript to view the <a href="https://disqus.com/?ref_noscript">comments powered by Disqus.</a></noscript> --}}

            </section>

        </div>

        {{-- side bar --}}
        <aside class="col-lg-4">

            <!-- Search -->
            <x-sidebar-search></x-sidebar-search>

            <!-- categories -->
            <x-sidebar-categories></x-sidebar-categories>

            <!-- tags -->
            <x-sidebar-tags></x-sidebar-tags>

            <!-- latest post -->
            <div class="widget">

                {{-- Latest Article --}}
                <h5 class="widget-title">
                    <span>Latest Article</span>
                </h5>

                <!-- post-item -->
                @foreach ( sidebar_latest_posts(5, $post->id) as $xindex => $item )

                    <ul class="list-unstyled widget-list">

                        <li class="media widget-post align-items-center">

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

                    @if ( ($xindex + 1) % 2 == 0 )

                        <div class="mb-3 pb-4" style="">

                            @include(get_random_ad_view(array('sidebar_banner','block_with_two')))

                        </div>

                    @endif

                @endforeach

            </div>

        </aside>

    </div>

@endsection

@push('scripts')

    <script>
        $(document).on('click','.share-buttons > a', function(e){
            e.preventDefault();
            window.open($(this).attr('href'),'','height=450,width=450,top='+($(window).height()/2-275)+', left='+($(window).width()/2-225)+', toolbar=0, location=0, menubar=0, directories=0, scrollbars=0');
            return false;
        });
    </script>

@endpush
