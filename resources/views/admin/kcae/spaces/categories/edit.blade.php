@extends('admin::layouts.master')

@section('title', 'Edit Category')

@section('content')

  @include('admin::pages.alert')
  <!-- // Basic multiple Column Form section start -->
  <section id="multiple-column-form">
    <div class="row match-height">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <h4 class="card-title">Edit Category</h4>
          </div>
          <div class="card-content">
            <div class="card-body">
              <form
                method="POST"
                action="{{route('admin.kcae.spaces.categories.edit', $category->id)}}"
                enctype="multipart/form-data"
                class="form"
              >
                @csrf
                @method('PUT')
                <div class="form-body">
                  <div class="row">

                    <div class="col-md-6 col-12">
                      <div class="form-label-group">
                        <input
                          type="text"
                          id="name-column"
                          class="form-control"
                          placeholder="Enter Name"
                          name="name"
                          value="{{old('name') ?? $category->name}}"
                          required
                          autofocus
                        >
                        <label for="name-column">Name</label>
                      </div>
                    </div>

                    <div class="col-md-6 col-12">
                      <div class="form-label-group">
                        <input
                          type="number"
                          id="serial-column"
                          class="form-control"
                          placeholder="Serial Number"
                          name="serial"
                          value="{{old('serial') ?? $category->serial}}"
                          required
                          min="0"
                          step="10"
                        >
                        <label for="serial-column">Serial</label>
                      </div>
                    </div>

                    <div class="col-md-6 col-12">
                      <div class="form-label-group">
                        <label for="status-column">Status</label>
                        <select id="status-column" name="status" class="form-control" required>
                          <option
                            value="enabled"
                            @if ('enabled' === $category->status) selected @endif
                          >Enabled</option>
                          <option
                            value="disabled"
                            @if ('disabled' === $category->status) selected @endif
                          >Disabled</option>
                        </select>
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
