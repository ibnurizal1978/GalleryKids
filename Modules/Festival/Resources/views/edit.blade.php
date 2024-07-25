@extends('admin::layouts.master')

@section('title', 'Festival')

@section('vendor-style')
        <!-- vendor css files -->
        <link rel="stylesheet" href="{{ asset('admin/vendors/css/pickers/pickadate/pickadate.css') }}">
@endsection

@section('content')

@include('admin::pages.alert')
<!-- // Basic multiple Column Form section start -->
<section id="multiple-column-form">
  <div class="row match-height">
      <div class="col-12">
          <div class="card">
              <div class="card-header">
                  <h4 class="card-title">Edit Exibition</h4>
              </div>
              <div class="card-content">
                  <div class="card-body">
                      <form method="POST" action="{{route('festival.update',$festival->id)}}" enctype="multipart/form-data" class="form">
                        @csrf
                          <div class="form-body">
                              <div class="row">
                                  <div class="col-md-6 col-12">
                                      <div class="form-label-group">
                                          <input type="text" id="title-column" class="form-control" value="{{$festival->title}}" name="title" required="">
                                          <label for="title-column">Title</label>
                                      </div>
                                  </div>
                                  <div class="col-md-6 col-12">
                                      <div class="form-label-group">
                                          <input type="url" id="url-column" class="form-control" value="{{$festival->url}}" name="url" required="">
                                          <label for="url-column">Url</label>
                                      </div>
                                  </div>
                                  <div class="col-md-6 col-12">
                                      <div class="form-label-group">
                                          <input type="text" id="content-start-date-column" class="form-control datepicker"  name="content_start_date" value="{{$festival->content_start_date}}">
                                          <label for="content-start-date-column">Content Start Date</label>
                                      </div>
                                  </div>
                                   <div class="col-md-6 col-12">
                                      <div class="form-label-group">
                                          <input type="text" id="content-expiry-date-column" class="form-control datepicker" name="content_expiry_date" value="{{$festival->content_expiry_date}}">
                                          <label for="content-expiry-date-column">Content Expiry Date</label>
                                      </div>
                                  </div>
                                 
                                  <div class="col-md-6 col-12">
                                      <div class="form-label-group">
                                         <label for="targeted_age_group-column">Targeted Age Group</label>
                                          <select id="targeted_age_group-column" name="targeted_age_group" class="form-control" required="">
                                            <option @if($festival->targeted_age_group == 'Younger than 10') selected="" @endif value="Younger than 10">Younger than 10</option>
                                            <option @if($festival->targeted_age_group == '10 to 15') selected="" @endif value="10 to 15">10 to 15</option>
                                            <option @if($festival->targeted_age_group == 'Older than 15') selected="" @endif value="Older than 15">Older than 15</option>
                                          </select> 
                                      </div>
                                  </div>
                                  <div class="col-md-6 col-12">
                                      <div class="form-label-group">
                                         <label for="categories-column">Categories</label>
                                          <select id="categories-column" name="category_id" class="form-control" required="">
                                           @foreach($categories as $category)
                                           <option @if($category->id == $festival->category_id) @endif value="{{$category->id}}">{{$category->name}}</option>
                                           @endforeach
                                          </select> 
                                      </div>
                                  </div>

                                   <div class="col-md-6 col-12">
                                    <div class="custom-control custom-switch">
                                      <label>Members Only</label>
                                      <input type="checkbox" @if($festival->members_only == 'Yes') checked @endif name="members_only" class="custom-control-input" id="members_only" value="Yes">
                                      <label class="custom-control-label" for="members_only">
                                        <span class="switch-text-left">Yes</span>
                                        <span class="switch-text-right">No</span>
                                      </label>
                                    </div>
                                  </div>

                                  <div class="col-md-6 col-12">
                                    <fieldset class="form-group">
                                        <label for="thumbnails">Thumbnails</label>
                                        <div class="custom-file">
                                            <input type="file" name="thumbnails[]" multiple="" class="custom-file-input" id="thumbnails">
                                            <label class="custom-file-label" for="thumbnails">Choose file</label>
                                        </div>
                                    </fieldset>
                                  </div>
 
                                  <div class="col-12">
                                    <fieldset class="form-group">
                                        <textarea name="synopsis" required="" class="form-control" id="basicTextarea" rows="3" placeholder="Synopsis">{{$festival->synopsis}}</textarea>
                                    </fieldset>
                                  </div> 

                              <div class="col-12">
                                      <button type="submit" class="btn btn-primary mr-1 mb-1">Submit</button>
                                      <button type="reset" class="btn btn-outline-warning mr-1 mb-1">Reset</button>
                                  </div>
                              </div>
                          </div>
                      </form>
                  </div>
              </div>
          </div>
      </div>
  </div>
</section>
<!-- // Basic Floating Label Form section end -->
@endsection

@section('vendor-script')
        <!-- vendor files -->
        <script src="{{ asset('admin/vendors/js/pickers/pickadate/picker.js') }}"></script>
        <script src="{{ asset('admin/vendors/js/pickers/pickadate/picker.date.js') }}"></script>
        <script src="{{ asset('admin/vendors/js/pickers/pickadate/picker.time.js') }}"></script>
        <script src="{{ asset('admin/vendors/js/pickers/pickadate/legacy.js') }}"></script>
@endsection
@section('page-script')
        <!-- Page js files -->
        <script src="{{ asset('admin/js/scripts/pickers/dateTime/pick-a-datetime.js') }}"></script>

        <script type="text/javascript">
     
           $(document).ready(function(){
              $('.datepicker').pickadate({

                  selectMonths: true,
                  selectYears: 80, 
                  format: 'yyyy-mm-dd',

              });
 
          });

        </script>

@endsection