@extends('admin::layouts.master')

@section('title', 'Add New Share')

@section('vendor-style')
    <!-- vendor css files -->
    <link rel="stylesheet" href="{{ asset('admin/vendors/css/pickers/pickadate/pickadate.css') }}">
@endsection

@section('content')

    @include('admin::pages.alert')
    <!-- // Basic multiple Column Form section start -->
    <section id="multiple-column-form">
        <div class="row match-height">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Add New</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <form
                                method="POST"
                                action="{{route('adminShare.store')}}"
                                enctype="multipart/form-data"
                                class="form"
                            >
                                @csrf
                                <div class="form-body">
                                    <div class="row">

                                        <div class="col-md-6 col-12">
                                            <div class="form-label-group">
                                                <input
                                                    type="text"
                                                    id="uid-column"
                                                    class="form-control"
                                                    placeholder="Enter UID"
                                                    name="uid"
                                                    value="{{old('uid')}}"
                                                >
                                                <label for="uid-column">UID:</label>
                                            </div>
                                        </div>

                                        <div class="col-md-6 col-12">
                                            <div class="form-label-group">
                                                <input
                                                    type="text"
                                                    id="title-column"
                                                    class="form-control"
                                                    placeholder="Enter Title"
                                                    name="title"
                                                    value="{{old('title')}}"
                                                    required
                                                >
                                                <label for="title-column">Title:</label>
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <div class="form-label-group">
                                                <input
                                                    type="file"
                                                    id="image-column"
                                                    class="form-control"
                                                    placeholder="Upload Image"
                                                    name="image"
                                                    required
                                                >
                                                <label for="image-column">Image:</label>
                                            </div>
                                        </div>

                                        <div class="col-md-6 col-12">
                                            <div class="form-label-group">
                                                <input
                                                    type="text"
                                                    id="artist-column"
                                                    class="form-control"
                                                    placeholder="Enter Artist"
                                                    name="artist"
                                                    value="{{old('artist')}}"
                                                >
                                                <label for="artist-column">Artist:</label>
                                            </div>
                                        </div>

                                        <div class="col-md-6 col-12">
                                            <div class="form-label-group">
                                                <input
                                                    type="text"
                                                    id="created-column"
                                                    class="form-control"
                                                    placeholder="Enter Date of Art Created"
                                                    name="created"
                                                    value="{{old('created')}}"
                                                >
                                                <label for="created-column">Date of Art Created:</label>
                                            </div>
                                        </div>

                                        <div class="col-md-6 col-12">
                                            <div class="form-label-group">
                                                <input
                                                    type="text"
                                                    id="classification"
                                                    class="form-control"
                                                    placeholder="Enter Classification"
                                                    name="classification"
                                                    value="{{old('classification')}}"
                                                >
                                                <label for="classification">Classification:</label>
                                            </div>
                                        </div>

                                        <div class="col-md-6 col-12">
                                            <div class="form-label-group">
                                                <input
                                                    type="text"
                                                    id="dimension-column"
                                                    class="form-control"
                                                    placeholder="Enter Dimension"
                                                    name="dimension"
                                                    value="{{old('dimension')}}"
                                                >
                                                <label for="dimension-column">Dimension:</label>
                                            </div>
                                        </div>

                                        <div class="col-md-6 col-12">
                                            <div class="form-label-group">
                                                <input
                                                    type="text"
                                                    id="creditline-column"
                                                    class="form-control"
                                                    placeholder="Enter Creditline"
                                                    name="creditline"
                                                    value="{{old('creditline')}}"
                                                >
                                                <label for="creditline-column">Creditline:</label>
                                            </div>
                                        </div>

                                        <div class="col-md-6 col-12">
                                            <div class="form-label-group">
                                                <select id="category-column" name="category_id"
                                                        class="form-control">
                                                    <option value="" selected>No Category</option>
                                                    @foreach($categories as $category)
                                                        <option
                                                            value="{{$category['id']}}">{{$category['name']}}</option>
                                                    @endforeach
                                                </select>

                                                <label for="category-column">Category</label>
                                            </div>
                                        </div>


                                        <div class="col-12">
                                            <button type="submit" class="btn btn-primary mr-1 mb-1">Submit</button>
                                            <button type="reset" class="btn btn-outline-warning mr-1 mb-1">Reset
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- // Basic Floating Label Form section end -->
@endsection

@section('vendor-script')
    <!-- vendor files -->
    <script src="{{ asset('admin/vendors/js/pickers/pickadate/picker.js') }}"></script>
    <script src="{{ asset('admin/vendors/js/pickers/pickadate/picker.date.js') }}"></script>
    <script src="{{ asset('admin/vendors/js/pickers/pickadate/picker.time.js') }}"></script>
    <script src="{{ asset('admin/vendors/js/pickers/pickadate/legacy.js') }}"></script>
@endsection
@section('page-script')
    <!-- Page js files -->
    <script src="{{ asset('admin/js/scripts/pickers/dateTime/pick-a-datetime.js') }}"></script>

    <script type="text/javascript">

        $(document).ready(function () {
            $('.datepicker').pickadate({

                selectMonths: true,
                selectYears: 80,
                format: 'yyyy-mm-dd',

            });

        });

    </script>

@endsection
