@extends('admin::layouts.master')

@section('title', 'Teachers')

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
                      <h4 class="card-title">{{isset($user) ? $user->first_name.' '.$user->last_name : ''}} Teacher List</h4>
                  </div>
                  <div class="card-content">
                      <div class="card-body card-dashboard"> 
                          <div class="table-responsive">
                              <table class="table zero-configuration">
                                  <thead>
                                      <tr>
                                          <th>Name</th>
                                          <th>Email</th>
                                          <th>Username</th>
                                          <th>YOB</th>
                                          <th>Students</th>
                                          <th>Excel</th>
                                          <th>School</th>
                                          <th>Level</th>
                                          <th>Class</th>
                                          <th>Team</th>
                                          <th>Status</th>  
                                      </tr>
                                  </thead>
                                  <tbody>
                                    @foreach($users as $user)
                                      <tr>
                                          <td>{{$user->first_name}} {{$user->last_name}}</td>
                                          <td>{{$user->email}}</td>
                                          <td>{{$user->username}}</td>
                                          <td>{{$user->year_of_birth}}</td>
                                          <td><a href="{{route('user.children',$user->id)}}">{{$user->children->count()}}</a></td>
                                          <td><a href="{{asset($user->import->file)}}" target="_blank">Download</a></td>
                                          <td>{{$user->school}}</td>
                                          <td>{{$user->level}}</td>
                                          <td>{{$user->class}}</td>
                                          <td>{{$user->team}}</td>
                                          <td>
                                            <a href="{{route('user.change.status',$user->id)}}">
                                              <div @if($user->status == 'Disable') class="chip chip-danger" @else class="chip chip-success" @endif >
                                                <div class="chip-body">
                                                  <div class="chip-text">{{$user->status}}</div>
                                                </div>
                                              </div>
                                            </a>
                                          </td>  
                                      </tr>
                                    @endforeach
                                  </tbody>
                                  <tfoot>
                                      <tr>
                                          <th>Name</th>
                                          <th>Email</th>
                                          <th>Username</th>
                                          <th>YOB</th>
                                          <th>Students</th>
                                          <th>Excel</th>
                                          <th>School</th>
                                          <th>Level</th>
                                          <th>Class</th>
                                          <th>Team</th>
                                          <th>Status</th> 
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
