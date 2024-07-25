@extends('admin::layouts.master')

@section('title', 'Add Space')
<link rel="stylesheet" href="{{ asset('admin/vendors/css/pickers/pickadate/pickadate.css') }}">
@section('content')

  @include('admin::pages.alert')
  <!-- // Basic multiple Column Form section start -->
  <section id="multiple-column-form">
    <div class="row match-height">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <h4 class="card-title">Add Space - Play</h4>
          </div>
          <div class="card-content">
            <div class="card-body">
              <form
                method="POST"
                action="{{route('admin.play.spaces.add')}}"
                enctype="multipart/form-data"
                class="form"
              >
                @csrf
                <div class="form-body">
                    <div class="row">
                        <div class="col-md-6 col-12">
                            <div class="form-label-group">
                                <input type="text" id="title-column" class="form-control" placeholder="Enter Title" name="title" required="" value="{{ old('title') }}">
                                <label for="title-column">Title</label>
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-label-group">
                                <input type="url" id="url-column" class="form-control" placeholder="Enter Url" name="url" required="" value="{{ old('url') }}">
                                <label for="url-column">Url</label>
                            </div>
                        </div>
                        
                        <!--<div class="col-md-6 col-12">
                            <div class="form-label-group">
                                <label for="targeted_age_group-column">Age Groups</label>
                                <h5>Age Groups:</h5>
                                @foreach($age_groups as $age_group)
                                <input type="checkbox" name="age_groups[]" checked="" value="{{$age_group->id}}"> {{$age_group->age_group}} <br>
                                @endforeach 
                            </div>
                        </div>-->
                        
                        <div class="col-md-6 col-12">
                            <div class="form-label-group">
                                <label for="categories-column">Categories</label>
                                <select id="categories-column" name="category_id" class="form-control" required="">
                                    
                                  @foreach($categories as $category)
                                  <option value="{{$category->id}}" {{ old('category_id')==$category->id ? 'selected' : '' }}>{{$category->name}}</option>
                                  @endforeach
                                </select> 
                            </div>
                        </div>

                          <!--<div class="col-md-6 col-12">
                          <div class="custom-control custom-switch">
                            <label>Members Only</label>
                            <input type="checkbox" name="members_only" class="custom-control-input" id="members_only" value="Yes">
                            <label class="custom-control-label" for="members_only">
                              <span class="switch-text-left">Yes</span>
                              <span class="switch-text-right">No</span>
                            </label>
                          </div>
                        </div>-->

                        <div class="col-md-6 col-12">
                          <fieldset class="form-group">
                              <label for="thumbnails">Thumbnails</label>
                              <div class="custom-file">
                                  <input type="file" name="thumbnails" multiple="" class="custom-file-input" id="thumbnails">
                                  <label class="custom-file-label" for="thumbnails">Choose file</label>
                              </div>
                          </fieldset>
                        </div>

                        <div class="col-12">
                          <fieldset class="form-group">
                              <textarea name="synopsis" required="" class="form-control" id="basicTextarea" rows="3" placeholder="Synopsis">{{ old('synopsis') }}</textarea>
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