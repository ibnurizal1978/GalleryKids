@extends('admin::layouts.master')
@section('title', 'Share')
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
                        <h4 class="card-title">Share</h4>
                    </div>
                    <div class="card-header">
                        <a href="{{route('adminShare.sync')}}" class="btn btn-success">Sync</a>
{{--                        <a href="{{route('adminShare.add')}}" class="btn btn-success">Add New</a>--}}
                    </div>
                    <div class="card-content">
                        <div class="card-body card-dashboard">
                            <div class="table-responsive">
                                <table class="table zero-configuration">
                                    <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Category</th>
                                        <th>Image</th>
                                        <th>TITLE</th>
                                        <th>ARTIST</th>
                                        <th>DATE_OF_ART_CREATED</th>
                                        <th>CLASSIFICATION</th>
                                        <th>CREDITLINE</th>
                                        <th>Add Category</th>
                                        <th>Action</th>
{{--                                        <th>Edit</th>--}}
{{--                                        <th>Delete</th>--}}
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($shares as $share)
                                        <tr>
                                            <td>{{isset($share['uid']) ? $share['uid'] : '-'}}</td>
                                            <td>{{isset($share['category']) ? $share['category']['name'] : '-'}}</td>
                                            <td>
                                                @if(isset($share['image']))
                                                    <img src="{{$share['image']}}" height="100" width="100">
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td>{{ isset($share['TITLE']) ? $share['TITLE'] : '-'}}</td>
                                            <td>{{$share['ARTIST']}}</td>
                                            <td>{{$share['DATE_OF_ART_CREATED']}}</td>
                                            <td>{{$share['CLASSIFICATION']}}</td>
                                            <td>{{$share['CREDITLINE']}}</td>
                                            <td>
                                                <a href="{{route('adminShare.show',$share->id)}}">
                                                    <div class="chip chip-success">
                                                        <div class="chip-body">
                                                            <div class="chip-text">Add</div>
                                                        </div>
                                                    </div>
                                                </a>
                                            </td>
                                            <td>
                                                <a href="{{route('adminShare.change.status',$share->id)}}">
                                                    <div @if($share->status == 'Disable') class="chip chip-danger"
                                                         @else class="chip chip-success" @endif >
                                                        <div class="chip-body">
                                                            <div class="chip-text">{{$share->status}}</div>
                                                        </div>
                                                    </div>
                                                </a>
                                            </td>
{{--                                            <td>--}}
{{--                                                <a--}}
{{--                                                    href="{{route('adminShare.edit',$share->id)}}"--}}
{{--                                                    class="btn btn-primary btn-sm"--}}
{{--                                                >Edit</a>--}}
{{--                                            </td>--}}
{{--                                            <td>--}}
{{--                                                <a--}}
{{--                                                    href="{{route('adminShare.delete',$share->id)}}"--}}
{{--                                                    class="btn btn-sm btn-danger"--}}
{{--                                                    onclick="return confirm('Are you want to delete?')"--}}
{{--                                                >Delete--}}
{{--                                                </a>--}}
{{--                                            </td>--}}
                                        </tr>
                                    @endforeach
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <th>Id</th>
                                        <th>Category</th>
                                        <th>Image</th>
                                        <th>TITLE</th>
                                        <th>ARTIST</th>
                                        <th>DATE_OF_ART_CREATED</th>
                                        <th>CLASSIFICATION</th>
                                        <th>CREDITLINE</th>
                                        <th>Add Category</th>
{{--                                        <th>Action</th>--}}
{{--                                        <th>Delete</th>--}}
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
