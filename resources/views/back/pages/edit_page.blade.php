@extends('back.layout.pages-layout')

@section('pageTitle', isset($pageTitle) ? $pageTitle : 'Page Title Here')

@section('content')

    <div class="page-header">
        <div class="row">
            <div class="col-md-6 col-sm-12">
                <div class="title">
                    <h4>Edit Page</h4>
                </div>
                <nav aria-label="breadcrumb" role="navigation">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.dashboard') }}">Home</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Edit page
                        </li>
                    </ol>
                </nav>
            </div>
            <div class="col-md-6 col-sm-12 text-right">
                <a href="{{ route('admin.pages') }}" class="btn btn-primary">View all pages</a>
            </div>
        </div>
    </div>

    <form action="{{ route('admin.update_page',['page_id'=>$page->id]) }}" method="POST" autocomplete="off" enctype="multipart/form-data" id="updatePageForm">

        @csrf

        <div class="row">
            <div class="col-md-12">
                <div class="card card-box mb-2">
                    <div class="card-body">

                        <div class="form-group">
                            <label for=""><b>Title</b>:</label>
                            <input type="text" class="form-control" name="title" placeholder="Enter post title" value="{{ $page->title }}">
                            <span class="ml-1 text-danger error-text title_error"></span>
                        </div>

                        <div class="form-group">
                            <label for=""><b>Content</b>:</label>
                            <textarea name="content" id="content" cols="30" rows="10" class="ckeditor form-control" placeholder="Enter page content here...">{!! $page->content !!}</textarea>
                            <span class="ml-1 text-danger error-text content_error"></span>
                        </div>

                        <div class="row">
                            <div class="col-md-6 col-sm-12">
                                <label class="weight-600">On header visibility</label>
                                <div class="custom-control custom-checkbox mb-5">
                                    <input type="checkbox" class="custom-control-input" id="customCheck1" name="show_on_header" value="1" {{ $page->show_on_header ? 'checked' : '' }}>
                                    <label class="custom-control-label" for="customCheck1">Show on header</label>
                                </div>
                            </div>

                            <div class="col-md-6 col-sm-12">
                                <label class="weight-600">On footer visibility</label>
                                <div class="custom-control custom-checkbox mb-5">
                                    <input type="checkbox" class="custom-control-input" id="customCheck2" name="show_on_footer" value="1" {{ $page->show_on_footer ? 'checked' : '' }}>
                                    <label class="custom-control-label" for="customCheck2">Show on footer</label>
                                </div>
                            </div>

                        </div>

                        {{-- submit --}}
                        <div class="mt-3">
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                        </div>

                    </div>
                </div>

            </div>

        </div>

    </form>

@endsection

@push('scripts')

    <script src="/ckeditor/ckeditor.js"></script>

    <script>

        //CREATE A POST
        $('#updatePageForm').on('submit', function(e){
            e.preventDefault();
            var form = this;
            var content = CKEDITOR.instances.content.getData();
            var formdata = new FormData(form);
                formdata.append('content',content);

            $.ajax({
                url:$(form).attr('action'),
                method:$(form).attr('method'),
                data:formdata,
                processData:false,
                dataType:'json',
                contentType:false,
                beforeSend:function(){
                    $(form).find('span.error-text').text('');
                },
                success:function(data){
                   if( data.status == 1 ){
                    //   $(form)[0].reset();
                    //   CKEDITOR.instances.content.setData('');
                      $().notifa({
                        vers:2,
                        cssClass:'success',
                        html:data.message,
                        delay:2500
                      });
                   }else{
                    $().notifa({
                        vers:2,
                        cssClass:'error',
                        html:data.message,
                        delay:2500
                    });
                   }
                },
                error:function(data){
                    $.each(data.responseJSON.errors, function(prefix, val){
                        $(form).find('span.'+prefix+'_error').text(val[0]);
                    });
                }
            });


        });
    </script>
    
@endpush
