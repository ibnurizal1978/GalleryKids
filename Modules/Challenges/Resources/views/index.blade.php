@extends('admin::layouts.master')

@section('title', 'Challenges')

@section('vendor-style')
        {{-- vendor css files --}}
        <link rel="stylesheet" href="{{ asset('admin/vendors/css/tables/datatable/datatables.min.css') }}">
@endsection

@section('content')
  <!-- Zero configuration table -->
  <section id="basic-datatable">
      <div class="row">
          <div class="col-12">
              <div class="card">
                  <div class="card-header">
                      <h4 class="card-title">Challenges</h4>
                  </div>
                  <div class="card-content">
                      <div class="card-body card-dashboard"> 
                          <div class="table-responsive">
                              <table class="table zero-configuration">
                                  <thead>
                                      <tr>
                                          <th>Id</th>
                                          <th>Name</th>
                                          <th>Status</th> 
                                           <th>Completed by user</th> 
                                          <th>Action</th> 
                                      </tr>
                                  </thead>
                                  <tbody>
                                  	@foreach($challenges as $challenge)
                                      <tr>
                                          <td>{{$challenge['id']}}</td>	
                                          <td>{{$challenge['name']}}</td>
                                         <td>
                                            <a href="{{route('challenges.change.status',$challenge->id)}}">
                                              <div @if($challenge->status == 'Disable') class="chip chip-danger" @else class="chip chip-success" @endif >
                                                <div class="chip-body">
                                                  <div class="chip-text">{{$challenge->status}}</div>
                                                </div>
                                              </div>
                                            </a>
                                          </td>
                                          <td class="product-action">
                                              <a href="{{route('challenges.show',$challenge->id)}}"><span class="action-eye"><i class="feather icon-eye"></i></span></a>
                                          </td>
<!--                                          <td>
                                            <a href="{{route('challenges.change.status',$challenge->id)}}">
                                              <div   class="chip chip-success">
                                                <div class="chip-body">
                                                  <i class="feather icon-eye"></i>
                                                </div>
                                              </div>
                                            </a>
                                          </td>-->
                                          <td class="product-action">
                                              <a href="{{route('challenges.edit',$challenge->id)}}"><span class="action-edit"><i class="feather icon-edit"></i></span></a>
                                          </td>
                                      </tr>
                                    @endforeach   
                                  </tbody>
                                  <tfoot>
                                      <tr>
                                          <th>Id</th>
                                          <th>Name</th>
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
