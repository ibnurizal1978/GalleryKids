@extends('admin::layouts.master')

@section('title', 'Plays')

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
                      <h4 class="card-title">Play List</h4>
                  </div>
                  <div class="card-content">
                      <div class="card-body card-dashboard"> 
                          <div class="table-responsive">
                              <table class="table zero-configuration">
                                  <thead>
                                      <tr>
                                          <th>Title</th>
                                          <th>URL</th>
                                          <th>Synopsis</th>
                                          <th>Thumbnail</th>
                                          <th>Age Group</th>
                                          <th>Status</th> 
                                          <th>Action</th>
                                      </tr>
                                  </thead>
                                  <tbody>
                                    @foreach($plays as $play)
                                      <tr>
                                          <td>{{$play->title}}</td>
                                          <td>{{$play->url}}</td>
                                          <td>{{$play->synopsis}}</td> 
                                          <td><img src="{{asset($play->thumbnail)}}" style="height: 200px;width: 200px;"></td>
                                          <td>  
                                            @foreach($play->age_groups as $age_group)
                                              {{$age_group->age_group}}<br>
                                            @endforeach
                                          </td> 
                                          <td>
                                            <a href="{{route('play.change.status',$play->id)}}">
                                              <div @if($play->status == 'Disable') class="chip chip-danger" @else class="chip chip-success" @endif >
                                                <div class="chip-body">
                                                  <div class="chip-text">{{$play->status}}</div>
                                                </div>
                                              </div>
                                            </a>
                                          </td> 
                                          <td class="product-action">
                                              <a href="{{route('play.edit',$play->id)}}"><span class="action-edit"><i class="feather icon-edit"></i></span></a>
                                          </td>
                                      </tr>
                                    @endforeach
                                  </tbody>
                                  <tfoot>
                                      <tr>
                                          <th>Title</th>
                                          <th>URL</th>
                                          <th>Synopsis</th>
                                          <th>Thumbnail</th>
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
