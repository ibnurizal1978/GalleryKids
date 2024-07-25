@extends('admin::layouts.master')

@section('title', 'Exhibition')

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
                      <h4 class="card-title">Exhibitions</h4>
                  </div>
                  <div class="card-content">
                      <div class="card-body card-dashboard"> 
                          <div class="table-responsive">
                              <table class="table zero-configuration">
                                  <thead>
                                      <tr>
                                          <th>Title</th>
                                          <th>URL</th>
                                          <th>Content Start Date</th>
                                          <th>Content Expiry Date</th>
                                          <th>Status</th>
                                          <th>Members Only</th>
                                          <th>Age Group</th>
                                          <th>Category</th>
                                          <th>Action</th>
                                      </tr>
                                  </thead>
                                  <tbody>
                                    @foreach($exhibitions as $exhibition)
                                      <tr>
                                          <td>{{$exhibition->title}}</td>
                                          <td>{{$exhibition->url}}</td>
                                          <td>{{$exhibition->content_start_date}}</td>
                                          <td>{{$exhibition->content_expiry_date}}</td>
                                          <td>
                                            <a href="{{route('exhibition.change.status',$exhibition->id)}}">
                                              <div @if($exhibition->status == 'Disable') class="chip chip-danger" @else class="chip chip-success" @endif >
                                                <div class="chip-body">
                                                  <div class="chip-text">{{$exhibition->status}}</div>
                                                </div>
                                              </div>
                                            </a>
                                          </td>
                                          <td>{{$exhibition->members_only}}</td>
                                          <td>
                                            @foreach($exhibition->age_groups as $age_group)
                                              {{$age_group->age_group}}<br>
                                            @endforeach
                                          </td>
                                          <td>{{$exhibition->category->name}}</td>
                                          <td class="product-action">
                                              <a href="{{route('exhibition.edit',$exhibition->id)}}"><span class="action-edit"><i class="feather icon-edit"></i></span></a>
                                          </td>
                                      </tr>
                                    @endforeach
                                  </tbody>
                                  <tfoot>
                                      <tr>
                                          <th>Title</th>
                                          <th>URL</th>
                                          <th>Content Start Date</th>
                                          <th>Content Expiry Date</th>
                                          <th>Status</th>
                                          <th>Members Only</th>
                                          <th>Age Group</th>
                                          <th>Category</th>
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
