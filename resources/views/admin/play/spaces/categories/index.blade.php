@extends('admin::layouts.master')

@section('title', 'Spaces Categories')

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
            <h4 class="card-title">Play Categories
              <a href="{{route('admin.play.spaces.categories.add')}}" class="btn btn-sm btn-success">Add New</a>
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
                    <th>Serial</th>
                    <th>Status</th>
                    <th>Actions</th>
                  </tr>
                  </thead>
                  <tbody>
                  @foreach($data as $category)
                    <tr>
                      <td>{{$category->id}}</td>
                      <td>{{$category->name}}</td>
                      <td>{{$category->serial}}</td>
                      <td>{{$category->status}}</td>
                      <td class="product-action" style="display: flex; align-items: center;">
                        <a
                          href="{{route('admin.play.spaces.categories.edit' ,$category->id)}}"
                          style="margin-right: 10px;"
                        >
                          <span
                            class="action-edit"
                          ><i class="feather icon-edit"></i></span>
                        </a>

                        <form
                          method="POST"
                          action="{{route('admin.play.spaces.categories.delete', $category->id)}}"
                          onsubmit="return confirm('Do you really want to delete category?')"
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
