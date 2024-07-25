@extends('admin::layouts.master')

@section('title', 'Avatars')

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
                      <h4 class="card-title"></h4>
                  </div>
                  <div class="card-content">
                      <div class="card-body card-dashboard"> 
                          <div class="table-responsive">
                              <table class="table zero-configuration">
                                  <thead>
                                      <tr>
                                          <th>Image</th>
                                          <th>Status</th>
                                          <th>Action</th>
                                      </tr>
                                  </thead>
                                  <tbody>
                                    @foreach($avatars as $avatar)
                                      <tr>
                                          <td><img src="{{asset($avatar->image)}}" style="height: 150px;width: 150px;"></td>
                                          <td>
                                            <a href="{{route('avatar.change.status',$avatar->id)}}">
                                              <div @if($avatar->status == 'Disable') class="chip chip-danger" @else class="chip chip-success" @endif >
                                                <div class="chip-body">
                                                  <div class="chip-text">{{$avatar->status}}</div>
                                                </div>
                                              </div>
                                            </a>
                                          </td>
                                          <td class="product-action">
                                              <a href="{{route('avatar.edit',$avatar->id)}}"><span class="action-edit"><i class="feather icon-edit"></i></span></a>
                                          </td>
                                      </tr>
                                    @endforeach
                                  </tbody>
                                  <tfoot>
                                      <tr>
                                          <th>Image</th>
                                          <th>Status</th>
                                          <th>Action</th>
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
