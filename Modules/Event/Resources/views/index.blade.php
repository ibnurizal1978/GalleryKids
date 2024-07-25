@extends('admin::layouts.master')

@section('title', 'Events')

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
                      <h4 class="card-title">Event List</h4>
                  </div>
                  <div class="card-content">
                      <div class="card-body card-dashboard"> 
                          <div class="table-responsive">
                              <table class="table zero-configuration">
                                  <thead>
                                      <tr>
                                          <th>Title</th>
                                          <th>Type</th>
                                          <th>Synopsis</th>
                                          <th>Thumbnail</th>
                                          <th>Event Date</th> 
                                          <th>Location</th> 
                                          <th>Status</th> 
                                          <th>Action</th>
                                      </tr>
                                  </thead>
                                  <tbody>
                                    @foreach($events as $event)
                                      <tr>
                                          <td>{{$event->title}}</td>
                                          <td>{{$event->type}}</td>
                                          <td>{{$event->synopsis}}</td> 
                                          <td><img src="{{asset($event->thumbnail)}}" style="height: 200px;width: 200px;"></td>  
                                          <td>{{$event->date}}</td> 
                                          <td>{{$event->location}}</td> 
                                          <td>
                                            <a href="{{route('event.change.status',$event->id)}}">
                                              <div @if($event->status == 'Disable') class="chip chip-danger" @else class="chip chip-success" @endif >
                                                <div class="chip-body">
                                                  <div class="chip-text">{{$event->status}}</div>
                                                </div>
                                              </div>
                                            </a>
                                          </td> 
                                          <td class="product-action">
                                              <a href="{{route('event.edit',$event->id)}}"><span class="action-edit"><i class="feather icon-edit"></i></span></a>
                                          </td>
                                      </tr>
                                    @endforeach
                                  </tbody>
                                  <tfoot>
                                      <tr>
                                          <th>Title</th>
                                          <th>Type</th>
                                          <th>Synopsis</th>
                                          <th>Thumbnail</th>
                                          <th>Event Date</th> 
                                          <th>Location</th> 
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
