@extends('admin::layouts.master')

@section('title', 'Memberson Profiles')

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
                        <h4 class="card-title">Memberson Profiles Data</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body card-dashboard">
                            <div class="table-responsive">
                                <table class="table zero-configuration">
                                    <thead>
                                    <tr>
                                        <th>User ID</th>
                                        <th>First Name</th>
                                        <th>Last Name</th>
                                        <th>Email</th>
                                        <th>IC</th>
                                        <th>Memberson Data</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($profiles as $profile)
                                        <tr>
                                            <td>{{optional($profile->user)->id ?? '--'}}</td>
                                            <td>{{optional($profile->user)->first_name ?? '--'}}</td>
                                            <td>{{optional($profile->user)->last_name ?? '--'}}</td>
                                            <td>{{optional($profile->user)->email ?? '--'}}</td>
                                            <td>{{optional($profile->user)->ic ?? '--'}}</td>
                                            <td>
                                                <button
                                                    type="button"
                                                    class="btn btn-sm btn-primary"
                                                    data-toggle="modal"
                                                    data-target="#profilemodal-{{optional($profile->user)->id ?? rand(10000, 99999999)}}"
                                                >View Data
                                                </button>

                                                <!-- Modal -->
                                                <div class="modal fade"
                                                     id="profilemodal-{{optional($profile->user)->id ?? rand(10000, 99999999)}}"
                                                     tabindex="-1"
                                                     role="dialog"
                                                     aria-labelledby="exampleModalLongTitle"
                                                     aria-hidden="true"
                                                >
                                                    <div class="modal-dialog modal-lg" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5
                                                                    class="modal-title"
                                                                    id="exampleModalLongTitle"
                                                                >
                                                                    {{optional($profile->user)->first_name}} {{optional($profile->user)->last_name}}</h5>
                                                                <button type="button" class="close" data-dismiss="modal"
                                                                        aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <pre style="padding: 15px 20px;"><code>@json(json_decode($profile->data), JSON_PRETTY_PRINT)</code></pre>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <th>User ID</th>
                                        <th>First Name</th>
                                        <th>Last Name</th>
                                        <th>Email</th>
                                        <th>IC</th>
                                        <th>Memberson Data</th>
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
