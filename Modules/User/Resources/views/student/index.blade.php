@extends('admin::layouts.master')

@section('title', 'Students')

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
                      <h4 class="card-title">{{isset($user) ? $user->first_name.' '.$user->last_name : ''}} Student List</h4>
                  </div>
                  <div class="card-content">
                      <div class="card-body card-dashboard"> 
                          <div class="table-responsive">
                              <table class="table zero-configuration">
                                  <thead>
                                      <tr>
                                          <th>Name</th>
                                          <th>YOB</th>
                                          <th>Total Visit</th>
                                          <th>Last Login</th>
                                          <th>Points</th>
                                          <th>Parents/Teacher</th>
                                          <th>Status</th>  
                                      </tr>
                                  </thead>
                                  <tbody>
                                    @foreach($users as $user)
                                      <tr>
                                          <?php $points  = Modules\Points\Entities\PointManage::whereUserId($user['id'])->get()->sum('points');
                                                       
                                        
                                          
                                          ?>
                                           <td>{{$user->first_name}} {{$user->last_name}}</td>
                                        
                                         
                                          <td>{{$user->year_of_birth}}</td>
                                          <td>{{$user['visit']}}</td>
                                          <td>{{$user['date']}}</td>
                                           <td>{{$points}}</td>
                                          <td><a href="{{route('user.parents',$user->id)}}">{{$user->parents->count()}}</a></td> 
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
                                          <th>Title</th>
                                          <th>URL</th>
                                          <th>Synopsis</th>
                                          <th>Thumbnail</th>
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
