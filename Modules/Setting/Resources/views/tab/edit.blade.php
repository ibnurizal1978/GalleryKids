@extends('admin::layouts.master')

@section('title', 'Tab')

@section('content')

@include('admin::pages.alert')
<!-- // Basic multiple Column Form section start -->
<section id="multiple-column-form">
  <div class="row match-height">
      <div class="col-12">
          <div class="card">
              <div class="card-header">
                  <h4 class="card-title"> Edit {{$tab->name}} Tab</h4>
              </div>
              <div class="card-content">
                  <div class="card-body">
                      <form method="POST" action="{{route('setting.tab.update',$tab->id)}}" class="form">
                        @csrf
                          <div class="form-body">
                              <div class="row">
 
                                   <div class="col-md-4 col-12">
                                      <div class="form-label-group">
                                          <input type="text" id="name-column" class="form-control" name="name" value="{{$tab->name}}" required="" readonly="">
                                          <label for="name-column">Name</label>
                                      </div>
                                  </div>

                                   <div class="col-md-4 col-12">
                                      <div class="form-label-group">
                                          <input type="text" id="slug-column" class="form-control" name="slug" value="{{$tab->slug}}" required="">
                                          <label for="slug-column">Slug</label>
                                      </div>
                                  </div>
                                  
                                   <div class="col-md-4 col-12">
                                      <div class="form-label-group">
                                          <input type="text" id="display_name-column" class="form-control" name="display_name" value="{{$tab->display_name}}" required="">
                                          <label for="display_name-column">Display Name</label>
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

 