@extends('admin::layouts.master')

@section('title', 'Setting')

@section('content')

@include('admin::pages.alert')
<!-- // Basic multiple Column Form section start -->
<section id="multiple-column-form">
    <div class="row match-height">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Edit Setting</h4>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <form method="POST" action="{{route('setting.update',$setting->id)}}" enctype="multipart/form-data" class="form">
                            @csrf
                            <div class="form-body">
                                <div class="row">
                                    <div class="col-md-6 col-12">
                                        <div class="form-label-group">
                                            <input type="text" id="name-column" class="form-control" value="{{$setting['url']}}" placeholder="Enter Url" name="url" required="">
                                            <label for="name-column">Url</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                      <div class="form-label-group">
                                          <textarea type="text" id="name-column" class="form-control" placeholder="Enter description" name="description" required="">{{$setting['description']}}</textarea>
                                          <label for="name-column">Description</label>
                                      </div>
                                  </div>
                                    <div class="col-md-12 col-12">
                                        <img src="{{asset($setting->image)}}" style="width: 1220px;">
                                    </div>

                                    <div class="col-md-6 col-12">
                                        <fieldset class="form-group">
                                            <label for="thumbnail">Banner Image</label>
                                            <div class="custom-file">
                                                <input type="file" name="banner" value="{{$setting->image}}" class="custom-file-input" id="thumbnail">
                                                <label class="custom-file-label"  for="thumbnail">Choose file</label>
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

