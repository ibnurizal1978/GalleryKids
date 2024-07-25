@extends('admin::layouts.master')

@section('title', 'Spaces')

@section('vendor-style')
  {{-- vendor css files --}}
  <link rel="stylesheet" href="{{ asset('admin/vendors/css/tables/datatable/datatables.min.css') }}">
@endsection

@section('content')
  @include('admin::pages.alert')
  <!-- Zero configuration table -->
  <section id="basic-datatable">
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <h4 class="card-title">Spaces
              <a href="{{route('admin.kcae.spaces.add')}}" class="btn btn-sm btn-success">Add New</a>
            </h4>
          </div>
          <div class="card-content">
            <div class="card-body card-dashboard">

              <div class="table-responsive">
                <table class="table zero-configuration">
                  <thead>
                  <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Image</th>
                    <th>Description</th>
                    <th>Category</th>
                    <th>Actions</th>
                  </tr>
                  </thead>
                  <tbody>
                  @foreach($spaces as $space)
                    <tr>
                      <td>{{$space['id']}}</td>
                      <td>{{$space['name']}}</td>
                      <td><img src="{{$space['image']}}" alt="{{$space['name']}}" style="max-width: 100px;"></td>
                      <td>{{$space['description']}}</td>
                      <td>{{optional($space['category'])->name}}</td>
                      <td class="product-action" style="display: flex; align-items: center;">
                        <a
                          href="{{route('admin.kcae.spaces.edit' ,$space->id)}}"
                          style="margin-right: 10px;"
                        >
                          <span
                            class="action-edit"
                          ><i class="feather icon-edit"></i></span>
                        </a>

                        <form
                          method="POST"
                          action="{{route('admin.kcae.spaces.delete', $space->id)}}"
                          onsubmit="return confirm('Do you really want to delete space? This is irreversible action.')"
                        >
                          @csrf
                          @method('DELETE')
                          <button type="submit" class="btn btn-flat-danger"><i class="feather icon-trash-2"></i>
                          </button>
                        </form>
                      </td>
                    </tr>
                  @endforeach
                  </tbody>
                  <tfoot>
                  <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Image</th>
                    <th>Description</th>
                    <th>Category</th>
                    <th>Actions</th>
                  </tr>
                  </tfoot>
                </table>
              </div>

            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!--/ Zero configuration table -->
@endsection
@section('vendor-script')
  {{-- vendor files --}}
  <script src="{{ asset('admin/vendors/js/tables/datatable/pdfmake.min.js') }}"></script>
  <script src="{{ asset('admin/vendors/js/tables/datatable/vfs_fonts.js') }}"></script>
  <script src="{{ asset('admin/vendors/js/tables/datatable/datatables.min.js') }}"></script>
  <script src="{{ asset('admin/vendors/js/tables/datatable/datatables.buttons.min.js') }}"></script>
  <script src="{{ asset('admin/vendors/js/tables/datatable/buttons.html5.min.js') }}"></script>
  <script src="{{ asset('admin/vendors/js/tables/datatable/buttons.print.min.js') }}"></script>
  <script src="{{ asset('admin/vendors/js/tables/datatable/buttons.bootstrap.min.js') }}"></script>
  <script src="{{ asset('admin/vendors/js/tables/datatable/datatables.bootstrap4.min.js') }}"></script>
@endsection
@section('page-script')
  {{-- Page js files --}}
  <script src="{{ asset('admin/js/scripts/datatables/datatable.js') }}"></script>
@endsection
