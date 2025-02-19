@extends('front.layout.pages-layout')

@section('pageTitle', isset($pageTitle) ? $pageTitle : 'Document title')

@section('meta_tags')
    {!! SEO::generate() !!}
@endsection

@section('content')

    <!-- Author Profile -->
    <section class="section-sm border-bottom pb-3 pt-3">

        <div class="container">

            <!-- Author Profile -->
            <div class="author-card">

                {{-- author picture --}}
                <img src="{{ $author->picture }}" alt="Author's Profile Photo">

                {{-- author name --}}
                <h3 class="mt-3 title-color">
                    {{ $author->name }}
                </h3>

                {{-- username  --}}
                <p>{{ $author->username }}</p>

                {{-- bio --}}
                <p>{{ $author->bio }}</p>

                {{-- author social links --}}
                @if( $author->social_links )

                    <!-- Social Links -->
                    <div class="social-links mt-3">

                        @if ( $author->social_links->facebook_url )
                            <a href="{{ $author->social_links->facebook_url }}" target="_blank" title="Facebook"><i class="ti-facebook"></i></a>
                        @endif

                        @if ( $author->social_links->instagram_url )
                            <a href="{{ $author->social_links->instagram_url }}" target="_blank" title="Instagram"><i class="ti-instagram"></i></a>
                        @endif

                        @if ( $author->social_links->youtube_url )
                            <a href="{{ $author->social_links->youtube_url }}" target="_blank" title="YouTube"><i class="ti-youtube"></i></a>
                        @endif

                        @if ( $author->social_links->linkedin_url )
                            <a href="{{ $author->social_links->linkedin_url }}" target="_blank" title="LinkedIn"><i class="ti-linkedin"></i></a>
                        @endif

                        @if ( $author->social_links->github_url )
                            <a href="{{ $author->social_links->github_url }}" target="_blank" title="GitHub"><i class="ti-github"></i></a>
                        @endif

                        @if ( $author->social_links->twitter_url )
                            <a href="{{ $author->social_links->twitter_url }}" target="_blank" title="Twitter"><i class="ti-twitter"></i></a>
                        @endif

                    </div>

                @endif

            </div>

        </div>

    </section>

    {{-- posts & banner --}}
    <section class="section-sm mt-0 pt-4">

        <div class="container">

            {{-- banner & posts --}}
            <div class="row">

                {{-- full_banner  --}}
                <div class="col-12">
                    <div class="col-12 mb-3 pb-4" style="">
                        @include(get_random_ad_view(array('full_banner','responsive')))
                    </div>
                </div>

                {{-- posts --}}
                @forelse ( $posts as $post )

                    <div class="col-sm-6 col-md-4 col-lg-3 mb-2">

                        {{-- Article --}}
                        <article class="mb-2">

                            {{-- post image --}}
                            <div class="mb-2">
                                <img src="/images/posts/resized/resized_{{ $post->featured_image }}" alt="" class="img-fluid rounded-lg">
                            </div>

                            {{-- post title --}}
                            <h5>
                                <a class="post-title" href="{{ route('read_post',$post->slug) }}">{{ $post->title }}</a>
                            </h5>

                            <ul class="list-inline post-meta mb-2">

                                <li class="list-inline-item">
                                    Date : {{ date_formatter($post->created_at) }}
                                </li>

                                <li class="list-inline-item">Category :
                                    <a href="{{ route('category_posts',$post->post_category->slug) }}" class="ml-1">{{ $post->post_category->name }} </a>
                                </li>

                            </ul>

                        </article>


                    </div>

                @empty
                    {{-- if empty  --}}
                    <div class="col-12">
                        <span class="text-danger text-center">
                            No posts found for this author!
                        </span>
                    </div>

                @endforelse

            </div>

            {{-- pagination --}}
            <div class="pagination-block">
                {{ $posts->appends(request()->input())->links('custom_pagination') }}
            </div>

        </div>

    </section>

@endsection
