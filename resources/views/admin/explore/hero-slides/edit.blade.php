@extends('admin::layouts.master')

@section('title', 'Edit Slide')

@section('content')

  @include('admin::pages.alert')
  <!-- // Basic multiple Column Form section start -->
  <section id="multiple-column-form">
    <div class="row match-height">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <h4 class="card-title">Edit Slide</h4>
          </div>
          <div class="card-content">
            <div class="card-body">
              <form
                method="POST"
                action="{{route('admin.kcae.hero-slides.update', $slide)}}"
                enctype="multipart/form-data"
                class="form"
              >
                @csrf
                @method('PUT')
                <div class="form-body">
                  <div class="row">

                    <div class="col-md-6 col-12">
                      <div class="form-group">
                        <label for="name-column">Name</label>
                        <input
                          type="text"
                          id="name-column"
                          class="form-control"
                          placeholder="Enter Name"
                          name="name"
                          value="{{old('name') ?? $slide->name}}"
                          required
                          autofocus
                        >
                      </div>
                    </div>

                    <div class="col-md-6 col-12">
                      <fieldset class="form-group">
                        <label for="image">Image</label>
                        <div class="custom-file">
                          <input
                            type="file"
                            name="image"
                            class="custom-file-input"
                            id="image"
                            accept="image/png, image/jpeg"
                          >
                          <label class="custom-file-label" for="image">Choose file</label>
                        </div>
                      </fieldset>
                    </div>

                    <div class="col-md-6 col-12">
                      <div class="form-group">
                        <label for="name-column">Video</label>
                        <input
                          type="text"
                          id="name-column"
                          class="form-control"
                          placeholder="Video Embed URL"
                          name="video"
                          value="{{old('video') ?? $slide->video}}"
                        >
                      </div>
                    </div>

                    <div class="col-12">
                      <button type="submit" class="btn btn-primary mr-1 mb-1">Update</button>
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