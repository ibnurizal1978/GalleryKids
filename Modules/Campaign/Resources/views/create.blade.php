@extends('admin::layouts.master')

@section('title', 'Campaign')

@section('vendor-style')
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
                  <h4 class="card-title">Create Campaign</h4>
              </div>
              <div class="card-content">
                  <div class="card-body">
                      <form method="POST" action="{{route('campaign.store')}}" enctype="multipart/form-data" class="form">
                        @csrf
                          <div class="form-body">
                              <div class="row">
                                  <div class="col-md-6 col-12">
                                      <div class="form-label-group">
                                          <input type="text" id="content-start-date-column" required="" class="form-control datepicker" placeholder="Campaign Start Date" name="start_date" value="{{old('start_date')}}">
                                          <label for="content-start-date-column">Campaign Start Date</label>
                                      </div>
                                  </div>
                                   <div class="col-md-6 col-12">
                                      <div class="form-label-group">
                                          <input type="text" id="content-expiry-date-column" required="" class="form-control datepicker" placeholder="Campaign Expiry Date" name="end_date" value="{{old('end_date')}}">
                                          <label for="content-expiry-date-column">Campaign Expiry Date</label>
                                      </div>
                                  </div>
                                  <div class="col-md-6 col-12">
                                    <fieldset class="form-group">
                                        <label for="thumbnails">Thumbnails</label>
                                        <div class="custom-file">
                                            <input type="file" name="thumbnail" required=""class="custom-file-input" id="thumbnails">
                                            <label class="custom-file-label" for="thumbnails">Choose file</label>
                                        </div>
                                    </fieldset>
                                  </div>
                                  <div class="col-md-6 col-12">
                                      <div class="form-label-group">
                                          <input type="text" id="name-column" required="" class="form-control" placeholder="Enter Title" name="title" required="">
                                          <label for="name-column">Title</label>
                                      </div>
                                  </div>
                                  <div class="col-md-6 col-12">
                                      <div class="form-label-group">
                                          <textarea type="text" id="name-column" required="" class="form-control" placeholder="Enter Description" name="description" required=""></textarea>
                                          <label for="name-column">Description</label>
                                      </div>
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