@extends('admin::layouts.master')

@section('title', 'Share')

@section('vendor-style')
    
<link rel="stylesheet" href="{{ asset('tagsinput/bootstrap-tagsinput.css') }}"> 
<style>
  .addedval {
    margin-top: -22PX;
}
.bootstrap-tagsinput .tag {
    margin-right: 2px;
    color: white;
}
.label-info {
    background-color: #5BC0DE;
}
.label {
    display: inline;
    padding: .2em .6em .3em;
    font-size: 75%;
    font-weight: 700;
    line-height: 1;
    color: #fff;
    text-align: center;
    white-space: nowrap;
    vertical-align: baseline;
    border-radius: .25em;
}
.bootstrap-tagsinput .tag [data-role="remove"] {
    margin-left: 8px;
    cursor: pointer;
}
</style>
@endsection

@section('content')

@include('admin::pages.alert')
<!-- // Basic multiple Column Form section start -->
<section id="multiple-column-form">
  <div class="row match-height">
      <div class="col-12">
          <div class="card">
              <div class="card-header">
                  <h4 class="card-title">Create Share</h4>
              </div>
              <div class="card-content">
                  <div class="card-body">
                      <form method="POST" action="{{route('share.store')}}" enctype="multipart/form-data" class="form">
                        @csrf
                          <div class="form-body">
                              <div class="row">
                                  <div class="col-md-6 col-12">
                                      <div class="form-label-group">
                                          <input type="text" id="name-column" class="form-control" placeholder="Enter Name" name="name" required="">
                                          <label for="name-column">Name</label>
                                      </div>
                                  </div>
<!--                                  <div class="col-md-6 col-12 bs-example">
                                      <div class="form-label-group">
                                          <input type="text" id="hashtags-column" data-role="tagsinput" class="form-control" placeholder="Enter Hashtags seperated by , " name="hashtags" required="">
                                          <label for="hashtags-column">Hashtags (Seperated By ' , ')</label>
                                      </div>
                                      <div class="addedval"> </div>
                                  </div> -->
<div class="col-md-6 col-12">
                                      <div class="form-label-group">
                                          <input type="text"   class="form-control" maxlength="2"  name="age" required="">
                                          <label>Age</label>
                                      </div>
                                  </div> 
<!--                                  <div class="col-md-6 col-12">
                                      <div class="form-label-group">
                                          <input type="text"  class="form-control"  name="Inspired_by" required="">
                                          <label>Inspire by</label>
                                      </div>
                                  </div> -->
                                  <div class="col-md-6 col-12">
                                    <fieldset class="form-group">
                                        <label for="thumbnails">Thumbnails</label>
                                        <div class="custom-file">
                                            <input type="file" name="thumbnails[]" required="" multiple="" class="custom-file-input" id="thumbnails">
                                            <label class="custom-file-label" for="thumbnails">Choose file</label>
                                        </div>
                                    </fieldset>
                                  </div>
 
                                  <div class="col-12">
                                    <fieldset class="form-group">
                                        <textarea maxlength="50" name="description" required="" class="form-control" id="basicTextarea" rows="3" placeholder="Description"></textarea>
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