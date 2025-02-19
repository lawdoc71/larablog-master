@extends('back.layout.pages-layout')

@section('pageTitle', isset($pageTitle) ? $pageTitle : 'Page Title Here')

@section('content')

    <div class="page-header">
        <div class="row">

            <div class="col-md-6 col-sm-12">

                <div class="title">
                    <h4>Pages</h4>
                </div>

                <nav aria-label="breadcrumb" role="navigation">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.dashboard') }}">Home</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            List
                        </li>
                    </ol>
                </nav>

            </div>

            <div class="col-md-6 col-sm-12 text-right">
                <a href="{{ route('admin.add_page') }}" class="btn btn-primary">
                    <i class="icon-copy bi bi-plus-circle"></i> Add page
                </a>
            </div>

        </div>
    </div>

    @livewire('admin.pages')

@endsection

@push('scripts')
    <script>

        $('table tbody#sortable_pages').sortable({
            cursor:"move",
            update: function(event, ui){
                $(this).children().each(function(index){
                   if( $(this).attr("data-ordering") != (index+1) ){
                     $(this).attr("data-ordering",(index+1)).addClass("updated");
                   }
                });
                var positions = [];
                $(".updated").each(function(){
                   positions.push([$(this).attr("data-index"),$(this).attr("data-ordering")]);
                });
                Livewire.dispatch("updatePagesOrdering",[positions]);
            }
        });

        window.addEventListener("deletePage", function(event){
            var id = event.detail.id;
            $().konfirma({
                title:'Are you sure?',
                html:'You want to delete this page.',
                cancelButtonText:'Cancel',
                confirmButtonText:'Yes, Delete',
                fontSize:'.87rem',
                done: function(){
                    Livewire.dispatch('deletePageAction',[id]);
                }
            });
        });

    </script>
@endpush
