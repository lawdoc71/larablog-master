@extends('back.layout.pages-layout')

@section('pageTitle', isset($pageTitle) ? $pageTitle : 'Page Title Here')

@section('content')

    @livewire('admin.slides')

@endsection

@push('scripts')
    <script>
        
        var modal = $('#slide_modal');

        window.addEventListener('showSlideModalForm', function(e){
            modal.modal('show');
        });

        window.addEventListener('hideSlideModalForm', function(e){
            modal.modal('hide');
        });

        $('table tbody#sortable_slides').sortable({
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
                Livewire.dispatch("updateSlidesOrdering",[positions]);
            }
        });

        window.addEventListener("deleteSlide", function(event){
            var id = event.detail.id;
            $().konfirma({
                title:'Are you sure?',
                html:'You want to delete this slide.',
                cancelButtonText:'Cancel',
                confirmButtonText:'Yes, Delete',
                fontSize:'.87rem',
                done: function(){
                    Livewire.dispatch('deleteSlideAction',[id]);
                }
            });
        });

    </script>
@endpush
