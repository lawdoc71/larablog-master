@extends('front.layout.pages-layout')

@section('pageTitle', isset($pageTitle) ? $pageTitle : 'Document title')

@section('meta_tags')

    {!! SEO::generate() !!}

@endsection

@section('content')

   <div>

        {{-- page title --}}
        <h2 class="mb-4 title-color">
            {{ $page->title }}
        </h2>

        {{-- article content --}}
        {!! $page->content !!}

   </div>

@endsection
