@extends('admin::layouts.master')

@section('title', 'Play')

@section('content')

@include('admin::pages.alert')
<!-- // Basic multiple Column Form section start -->
<section id="multiple-column-form">
  <div class="row match-height">
      <div class="col-12">
          <div class="card">
              <div class="card-header">
                  <h4 class="card-title">Create Play</h4>
              </div>
              <div class="card-content">
                  <div class="card-body">
                      <form method="POST" action="{{route('play.store')}}" enctype="multipart/form-data" class="form">
                        @csrf
                          <div class="form-body">
                              <div class="row">
                                  <div class="col-md-6 col-12">
                                      <div class="form-label-group">
                                          <input type="text" id="title-column" class="form-control" placeholder="Enter Title" name="title" required="">
                                          <label for="title-column">Title</label>
                                      </div>
                                  </div>
                                  <div class="col-md-6 col-12">
                                      <div class="form-label-group">
                                          <input type="url" id="url-column" class="form-control" placeholder="Enter Url" name="url" required="">
                                          <label for="url-column">Url</label>
                                      </div>
                                  </div>
                                  
                                  <div class="col-md-6 col-12">
                                      <div class="form-label-group">
                                         <label for="targeted_age_group-column">Age Groups</label>
                                         <h5>Age Groups:</h5>
                                          @foreach($age_groups as $age_group)
                                          <input type="checkbox" name="age_groups[]" checked="" value="{{$age_group->id}}"> {{$age_group->age_group}} <br>
                                          @endforeach 
                                      </div>
                                  </div>

                                  <div class="col-md-6 col-12">
                                    <fieldset class="form-group">
                                        <label for="thumbnails">Thumbnail</label>
                                        <div class="custom-file">
                                            <input type="file" name="thumbnail" required="" class="custom-file-input" id="thumbnail">
                                            <label class="custom-file-label" for="thumbnail">Choose file</label>
                                        </div>
                                    </fieldset>
                                  </div>
 
                                  <div class="col-12">
                                    <fieldset class="form-group">
                                        <textarea name="synopsis" required="" class="form-control" id="basicTextarea" rows="3" placeholder="Synopsis"></textarea>
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