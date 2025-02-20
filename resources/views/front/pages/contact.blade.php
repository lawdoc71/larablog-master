@extends('front.layout.pages-layout')

@section('pageTitle', isset($pageTitle) ? $pageTitle : 'Document title')

@section('meta_tags')
    {!! SEO::generate() !!}
@endsection

@section('content')

    <div class="row">

        {{-- header with social links --}}
        <div class="col-12">

            <div class="mb-5 d-flex align-items-center">

                {{-- title --}}
                <h3 class="title-color">Contact Us</h3>

                {{-- social links - contact page --}}
                <ul class="list-inline social-icons ml-auto mr-3 d-none d-sm-block">

                    {{-- facebook --}}
                    {{-- @if ( site_social_links()->facebook_url ) --}}
                        <li class="list-inline-item">
                            <a target="_blank" href="{{ site_social_links()->facebook_url }}">
                                <i class="ti-facebook"></i>
                            </a>
                        </li>
                    {{-- @endif --}}

                    {{-- twitter or X --}}
                    {{-- {{-- @if ( site_social_links()->twitter_url ) --}}
                        <li class="list-inline-item">
                            <a target="_blank" href="{{  site_social_links()->twitter_url }}">
                                <i class="ti-twitter-alt"></i>
                            </a>
                        </li>
                    {{-- @endif --}}

                    {{-- linkedin --}}
                    @if ( site_social_links()->linkedin_url )
                        <li class="list-inline-item">
                            <a target="_blank" href="{{ site_social_links()->linkedin_url }}">
                                <i class="ti-linkedin"></i>
                            </a>
                        </li>
                    @endif

                    {{-- instagram --}}
                    @if ( site_social_links()->instagram_url )
                        <li class="list-inline-item">
                            <a target="_blank" href="{{ site_social_links()->instagram_url }}">
                                <i class="ti-instagram"></i>
                            </a>
                        </li>
                    @endif

                </ul>

            </div>

        </div>

        {{-- contact header --}}
        <div class="col-md-6">

            {{-- contact text --}}
            <div class="content mb-5">

                <h4>We love to hear from you!</h4>

                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Velit massa vitae felis augue. In venenatis scelerisque accumsan egestas mattis. Massa feugiat in sem pellentesque.</p>

                <h4 class="mt-5">Alternatively, send us an email</h4>

                <p>
                    <i class="ti-email mr-2 text-primary"></i>
                    <a href="mailto:michael@butlerlegaltech.com">info@butlertransport.com</a>
                </p>

            </div>

        </div>

        {{-- contact form --}}
        <div class="col-md-6">

            {{-- contact form  --}}
            <form method="POST" action="{{ route('send_email') }}">

                @csrf

                {{-- alert  --}}
                <x-form-alerts></x-form-alerts>

                {{-- name --}}
                <div class="form-group">

                    {{-- name --}}
                    <label for="name">
                        <b class="title-color">Your Name</b> (Required):
                    </label>

                    <input type="text" name="name" id="name" class="form-control" placeholder="eg: William Woods" value="{{ old('name') }}">

                    {{-- errors --}}
                    @error('name')
                        <span class="text-danger ml-1">{{ $message }}</span>
                    @enderror

                </div>

                {{-- email --}}
                <div class="form-group">

                    <label for="email">
                        <b class="title-color">Your Email Address</b> (Required):
                    </label>

                    <input type="text" name="email" id="email" class="form-control"  placeholder="eg: williamwoods@example.com" value="{{ old('email') }}">

                    @error('email')
                        <span class="text-danger ml-1">{{ $message }}</span>
                    @enderror

                </div>

                {{-- subject --}}
                <div class="form-group">

                    <label for="subject">
                        <b class="title-color">Reason For Contact</b>:
                    </label>

                    <input type="text" name="subject" id="subject" class="form-control" placeholder="eg: Advertising" value="{{ old('subject') }}">

                    @error('subject')
                        <span class="text-danger ml-1">{{ $message }}</span>
                    @enderror

                </div>

                {{-- message --}}
                <div class="form-group">

                    <label for="message">
                        <b class="title-color">Your Message Here</b>:
                    </label>

                    <textarea name="message" id="message" class="form-control">{{ old('message') }}</textarea>


                    @error('message')
                        <span class="text-danger ml-1">{{ $message }}</span>
                    @enderror

                </div>

                {{-- Submit button --}}
                <button type="submit" class="btn btn-primary">Submit</button>

            </form>

        </div>

    </div>

@endsection
