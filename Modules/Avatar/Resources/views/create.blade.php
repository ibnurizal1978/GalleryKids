@extends('admin::layouts.master')

@section('title', 'Avatar')

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
                  <h4 class="card-title">Avatar</h4>
              </div>
              <div class="card-content">
                  <div class="card-body">
                      <form method="POST" action="{{route('avatar.store')}}" enctype="multipart/form-data" class="form">
                        @csrf
                          <div class="form-body">
                              <div class="row">
                                  
                                  <div class="col-md-6 col-12">
                                    <fieldset class="form-group">
                                        <label for="image">Image</label>
                                        <div class="custom-file">
                                            <input type="file" name="image" required="" class="custom-file-input" id="image">
                                            <label class="custom-file-label" for="image">Choose file</label>
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
