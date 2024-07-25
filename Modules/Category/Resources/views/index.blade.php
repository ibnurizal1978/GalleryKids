@extends('admin::layouts.master')

@section('title', 'Category')

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
                      <h4 class="card-title">Categories</h4>
                  </div>
                  <div class="card-content">
                      <div class="card-body card-dashboard"> 
                          <div class="table-responsive">
                              <table class="table zero-configuration">
                                  <thead>
                                      <tr>
                                          <th>Id</th>
                                          <th>Name</th>
                                          <th>Type</th> 
                                          <th>Status</th> 
                                          <th>Action</th> 
                                      </tr>
                                  </thead>
                                  <tbody>
                                  	@foreach($categories as $category)
                                      <tr>
                                          <td>{{$category['id']}}</td>	
                                          <td>{{$category['name']}}</td>
                                          <td>{{$category['type']}}</td> 
                                          <td>
                                            <!-- added 11-12-20 -->    
                                            @if($category['type'] == 'pictionShare')
                                            <a href="{{route('category.change.status',$category->id)}}">
                                              <div @if($category->status) class="chip chip-success" @else class="chip chip-danger" @endif >
                                                <div class="chip-body">
                                                  <div class="chip-text">{{$category->status ? 'enabled' : 'disabled'}}</div>
                                                </div>
                                              </div>
                                              @endif
                                            </a>
                                            <!-- End -->
                                          </td>
                                          <td class="product-action">
                                              <a href="{{route('category.edit',$category->id)}}"><span class="action-edit"><i class="feather icon-edit"></i></span></a>
                                          </td>
                                      </tr>
                                    @endforeach   
                                  </tbody>
                                  <tfoot>
                                      <tr>
                                          <th>Id</th>
                                          <th>Name</th>
                                          <th>Type</th> 
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
