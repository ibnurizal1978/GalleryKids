@extends('admin::layouts.master')

@section('title', 'Campaign')

@section('vendor-style')
    

@endsection

@section('content')

@include('admin::pages.alert')
<!-- // Basic multiple Column Form section start -->
<section id="multiple-column-form">
  <div class="row match-height">
      <div class="col-12">
          <div class="card">
              <div class="card-header">
                  <h4 class="card-title">Update Campaign</h4>
              </div>
              <div class="card-content">
                  <div class="card-body">
                      <form method="POST" action="{{route('campaign.update',$campaign->id)}}" enctype="multipart/form-data" class="form">
                        @csrf
                          <div class="form-body">
                              <div class="row">
                                  
                                  <div class="col-md-6 col-12">
                                      <div class="form-label-group">
                                          <input type="text" id="content-start-date-column" class="form-control datepicker"  name="start_date" value="{{$campaign['start_date']}}">
                                          <label for="content-start-date-column">Campaign Start Date</label>
                                      </div>
                                  </div>
                                   <div class="col-md-6 col-12">
                                      <div class="form-label-group">
                                          <input type="text" id="content-expiry-date-column" class="form-control datepicker" name="end_date" value="{{$campaign['end_date']}}">
                                          <label for="content-expiry-date-column">Campaign Expiry Date</label>
                                      </div>
                                  </div>
                                  
                                  <div class="col-md-6 col-12">
                                      <div class="form-label-group">
                                          <input type="text" id="name-column" class="form-control" value="{{$campaign['title']}}" name="title" required="">
                                          <label for="name-column">Title</label>
                                      </div>
                                  </div>
                                  <div class="col-md-6 col-12">
                                      <div class="form-label-group">
                                          <textarea type="text" id="name-column" class="form-control" name="description" required="">{{$campaign['description']}}</textarea>
                                          <label for="name-column">Description</label>
                                      </div>
                                  </div>
                                  <div class="col-md-6 col-12">
                                    <fieldset class="form-group">
                                        <label for="thumbnail">Thumbnail</label>
                                        <div class="custom-file">
                                            <input type="file" name="thumbnail" multiple="" class="custom-file-input" id="thumbnail">
                                            <label class="custom-file-label" for="thumbnail">Choose file</label>
                                        </div>
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

<script src="{{ asset('admin/vendors/js/tables/datatable/buttons.bootstrap.min.js') }}"></script>
<script src="{{ asset('tagsinput/bootstrap-tagsinput.js') }}"></script>
        
@endsection
@section('page-script')

@endsection