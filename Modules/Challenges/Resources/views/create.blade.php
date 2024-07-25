@extends('admin::layouts.master')

@section('title', 'Category')

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
                  <h4 class="card-title">Create Challenges</h4>
              </div>
              <div class="card-content">
                  <div class="card-body">
                      <form method="POST" action="{{route('challenges.store')}}" enctype="multipart/form-data" class="form">
                        @csrf
                          <div class="form-body">
                              <div class="row">
                                  
                                  <div class="col-md-6 col-12">
                                      <div class="form-label-group">
                                          <input type="text" id="name-column" class="form-control" placeholder="Enter Name" name="name" required="">
                                          <label for="name-column">Name</label>
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

<script src="{{ asset('admin/vendors/js/tables/datatable/buttons.bootstrap.min.js') }}"></script>
<script src="{{ asset('tagsinput/bootstrap-tagsinput.js') }}"></script>
        
@endsection
@section('page-script')

@endsection