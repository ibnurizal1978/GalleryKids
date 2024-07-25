@extends('admin::layouts.master')

@section('title', 'Event')

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
                  <h4 class="card-title">Edit Event</h4>
              </div>
              <div class="card-content">
                  <div class="card-body">
                      <form method="POST" action="{{route('event.update',$event->id)}}" enctype="multipart/form-data" class="form">
                        @csrf
                          <div class="form-body">
                              <div class="row">
                                  <div class="col-md-6 col-12">
                                      <div class="form-label-group">
                                          <input type="text" id="title-column" class="form-control" value="{{$event->title}}" name="title" required="">
                                          <label for="title-column">Title</label>
                                      </div>
                                  </div> 

                                    <div class="col-md-6 col-12">
                                      <div class="form-label-group">
                                         <label for="type-column">Type</label>
                                          <select id="type-column" name="type" class="form-control" required="">
                                            <option @if($event->type == 'Digital') selected="" @endif value="Digital">Digital</option>
                                            <option @if($event->type == 'Physical') selected="" @endif value="Physical">Physical</option>
                                          </select> 
                                      </div>
                                  </div>   

                                  <div class="col-md-6 col-12">
                                      <div class="form-label-group">
                                          <input type="text" id="event-date-column" class="form-control datepicker" value="{{$event->date}}" name="date">
                                          <label for="event-date-column">Event Date</label>
                                      </div>
                                  </div>    

                                  <div class="col-md-6 col-12">
                                    <fieldset class="form-group">
                                        <div class="custom-file">
                                            <input type="file" name="thumbnail" class="custom-file-input" id="thumbnail" accept="image/*">
                                            <label class="custom-file-label" for="thumbnail">Thumbnail</label>
                                        </div>
                                    </fieldset>
                                  </div>

                                   <div class="col-md-6 col-12">
                                      <div class="form-label-group">
                                          <input type="text" id="location-column" class="form-control" value="{{$event->location}}" name="location" required="">
                                          <label for="location-column">Location</label>
                                      </div>
                                  </div> 
 
                                  <div class="col-md-6 col-12">
                                    <fieldset class="form-group">
                                        <textarea name="synopsis" required="" class="form-control" id="basicTextarea" rows="3" placeholder="Synopsis">{{$event->synopsis}}</textarea>
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