@extends('admin::layouts.master')

@section('title', 'Discovers')

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
                      <h4 class="card-title">Discovers List</h4>
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
                                    @foreach($discovers as $discover)
                                      <tr>
                                          <td>{{$discover->title}}</td>
                                          <td>{{$discover->url}}</td>
                                          <td>{{$discover->content_start_date}}</td>
                                          <td>{{$discover->content_expiry_date}}</td>
                                          <td>
                                            <a href="{{route('discover.change.status',$discover->id)}}">
                                              <div @if($discover->status == 'Disable') class="chip chip-danger" @else class="chip chip-success" @endif >
                                                <div class="chip-body">
                                                  <div class="chip-text">{{$discover->status}}</div>
                                                </div>
                                              </div>
                                            </a>
                                          </td>
                                          <td>{{$discover->members_only}}</td>
                                          <td>  
                                            @foreach($discover->age_groups as $age_group)
                                              {{$age_group->age_group}}<br>
                                            @endforeach
                                          </td>  
                                          <td>{{$discover->category->name}}</td>
                                          <td class="product-action">
                                              <a href="{{route('discover.edit',$discover->id)}}"><span class="action-edit"><i class="feather icon-edit"></i></span></a>
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
