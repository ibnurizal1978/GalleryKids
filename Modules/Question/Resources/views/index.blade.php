@extends('admin::layouts.master')

@section('title', 'Question')

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
                      <h4 class="card-title">Question List</h4>
                  </div>
                  <div class="card-content">
                      <div class="card-body card-dashboard"> 
                          <div class="table-responsive">
                              <table class="table zero-configuration">
                                  <thead>
                                      <tr>
                                         
                                          <th>Question</th> 
                                           <th>Featured</th> 
                                          <th>File</th>
                                          <th>Status</th>
                                          <th>Creator</th> 
                                      </tr>
                                  </thead>
                                  <tbody>
                                    @foreach($questions as $question)
                                      <tr>
                                          
                                          <td>{!! $question->question !!}</td>
                                          <td>
                                            <a href="{{route('question.change.featured',$question->id)}}">
                                              <div @if($question->featured == 'Disable') class="chip chip-danger" @else class="chip chip-success" @endif >
                                                <div class="chip-body">
                                                  <div class="chip-text">Featured</div>
                                                </div>
                                              </div>
                                            </a>
                                          </td>
                                          <td>
                                           
                                            <img src="{{asset($question->file)}}" style="height: 150px;width: 150px;">
                                            
                                          </td>
                                           <td>
                                            <a href="{{route('question.change.status',$question->id)}}">
                                              <div @if($question->status == 'Disable') class="chip chip-danger" @else class="chip chip-success" @endif >
                                                <div class="chip-body">
                                                  <div class="chip-text">{{$question->status}}</div>
                                                </div>
                                              </div>
                                            </a>
                                          </td>
                                          <td>{{$question->creator}} @if(isset($question->user)) ( <strong> {{$question->user->first_name}} {{$question->user->last_name}} </strong> ) @endif</td>  
                                      </tr>
                                    @endforeach
                                  </tbody>
                                  <tfoot>
                                      <tr>
                                          <th>Question</th> 
                                          <th>File</th>
                                          <th>Status</th>
                                          <th>Creator</th> 
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
