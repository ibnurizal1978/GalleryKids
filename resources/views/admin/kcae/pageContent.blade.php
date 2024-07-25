@extends('admin::layouts.master')

@section('title', 'Page Content')

@section('content')

@include('admin::pages.alert')

<section id="multiple-column-form">
  <div class="row match-height">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <h4 class="card-title">Page Content</h4>
        </div>
        <div class="card-content">
          <div class="card-body">
            <form method="POST" action="{{route('admin.kcae.page-content')}}" enctype="multipart/form-data" class="form" id="kcae-content-form">
              @csrf
              <div class="form-body">
                <div class="row">

                  <!-- Page Title -->
                  <div class="col-sm-12">
                    <div class="form-label-group">
                      <h5>Page Title</h5>
                      <input type="hidden" name="title" />
                      <div id="title-editor">{!! optional($pageContent)->title !!}</div>
                    </div>
                  </div>

                  <!-- Page Description -->
                  <div class="col-sm-12">
                    <div class="form-label-group">
                      <h5>Page Description</h5>
                      <input type="hidden" name="description" />
                      <div id="description-editor">{!! optional($pageContent)->description !!}</div>
                    </div>
                  </div>

                  <!-- Page Description -->
                  <!-- 27 Juli 2021 add by Rizal -->
                  <div class="col-sm-12">
                    <div class="form-label-group">
                      <h5>Hero Slider Title</h5>
                      <input type="hidden" name="hero_slider_title" />
                      <div id="hero_slider_title">{!! optional($pageContent)->hero_slider_title !!}</div>
                      <!--<input type="text" class="form-control" name="slideshow_title" value="{!! optional($pageContent)->hero_slider_title !!}" />-->
                    </div>
                  </div>


                  <!-- Mid Section -->
                  <div class="col-sm-12">
                    <div class="form-label-group">
                      <h5>Mid Section</h5>
                      <input type="hidden" name="mid-section" />
                      <div id="mid-section-editor">{!! optional($pageContent)->{'mid-section'} !!}</div>
                    </div>
                  </div>

                  <!-- Last Section Top -->
                  <div class="col-sm-12">
                    <div class="form-label-group">
                      <h5>Last Section Top</h5>
                      <input type="hidden" name="last-section-top" />
                      <div id="last-section-top-editor">{!! optional($pageContent)->{'last-section-top'} !!}</div>
                    </div>
                  </div>

                  <!-- Last Section Box 1 -->
                  <div class="col-sm-12">
                    <div class="form-label-group">
                      <h5>Last Section Box 1</h5>
                      <input type="hidden" name="last-section-box1" />
                      <div id="last-section-box1-editor">{!! optional($pageContent)->{'last-section-box1'} !!}</div>
                    </div>
                  </div>

                  <!-- Last Section Box 2 -->
                  <div class="col-sm-12">
                    <div class="form-label-group">
                      <h5>Last Section Box 2</h5>
                      <input type="hidden" name="last-section-box2" />
                      <div id="last-section-box2-editor">{!! optional($pageContent)->{'last-section-box2'} !!}</div>
                    </div>
                  </div>

                  <!-- Last Section Box 3 -->
                  <div class="col-sm-12">
                    <div class="form-label-group">
                      <h5>Last Section Box 3</h5>
                      <input type="hidden" name="last-section-box3" />
                      <div id="last-section-box3-editor">{!! optional($pageContent)->{'last-section-box3'} !!}</div>
                    </div>
                  </div>

                  <!-- Last Section Top -->
                  <div class="col-sm-12">
                    <div class="form-label-group">
                      <h5>Last Section Bottom</h5>
                      <input type="hidden" name="last-section-bottom" />
                      <div id="last-section-bottom-editor">{!! optional($pageContent)->{'last-section-bottom'} !!}</div>
                    </div>
                  </div>

                  <!-- Form Footer -->
                  <div class="col-12">
                    <button type="submit" class="btn btn-primary mr-1 mb-1">Submit</button>
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
@endsection

@section('vendor-style')
<link href="{{asset('admin/vendors/css/quill/quill.snow.css')}}" rel="stylesheet">
@endsection

@section('page-script')
<script src="{{asset('admin/vendors/js/quill/quill.min.js')}}"></script>

<script>
  var quillSettings = {
    modules: {
      toolbar: [
        [{
          'header': [1, 2, 3, 4, 5, 6, false]
        }, 'bold', 'italic', 'underline', 'strike'],
        ['blockquote', 'code-block'],
        ['link'],
        [{
          'list': 'ordered'
        }, {
          'list': 'bullet'
        }],
        [{
          'script': 'sub'
        }, {
          'script': 'super'
        }],
        [{
          'indent': '-1'
        }, {
          'indent': '+1'
        }],
        [{
          'color': []
        }, {
          'background': []
        }],
        [{
          'align': []
        }],
        ['clean']
      ]
    },
    theme: 'snow'
  }

  var titleEditor = new Quill('#title-editor', quillSettings);
  var descriptionEditor = new Quill('#description-editor', quillSettings);
  var slideshow_title = new Quill('#hero_slider_title', quillSettings);
  var midSectionEditor = new Quill('#mid-section-editor', quillSettings);
  var lastSectionTop = new Quill('#last-section-top-editor', quillSettings);
  var lastSectionBox1 = new Quill('#last-section-box1-editor', quillSettings);
  var lastSectionBox2 = new Quill('#last-section-box2-editor', quillSettings);
  var lastSectionBox3 = new Quill('#last-section-box3-editor', quillSettings);
  var lastSectionBottom = new Quill('#last-section-bottom-editor', quillSettings);

  var kcaeForm = document.getElementById('kcae-content-form');
  kcaeForm.onsubmit = function() {
    var titleInput = document.querySelector('[name="title"]');
    titleInput.value = document.querySelector('#title-editor .ql-editor').innerHTML;

    var descInput = document.querySelector('[name="description"]');
    descInput.value = document.querySelector('#description-editor .ql-editor').innerHTML;

    var sstInput = document.querySelector('[name="hero_slider_title"]');
    sstInput.value = document.querySelector('#hero_slider_title .ql-editor').innerHTML;

    var midSectionInput = document.querySelector('[name="mid-section"]');
    midSectionInput.value = document.querySelector('#mid-section-editor .ql-editor').innerHTML;

    var lastSectionTopInput = document.querySelector('[name="last-section-top"]');
    lastSectionTopInput.value = document.querySelector('#last-section-top-editor .ql-editor').innerHTML;

    var lastSectionBox1Input = document.querySelector('[name="last-section-box1"]');
    lastSectionBox1Input.value = document.querySelector('#last-section-box1-editor .ql-editor').innerHTML;

    var lastSectionBox2Input = document.querySelector('[name="last-section-box2"]');
    lastSectionBox2Input.value = document.querySelector('#last-section-box2-editor .ql-editor').innerHTML;

    var lastSectionBox3Input = document.querySelector('[name="last-section-box3"]');
    lastSectionBox3Input.value = document.querySelector('#last-section-box3-editor .ql-editor').innerHTML;

    var lastSectionBottom = document.querySelector('[name="last-section-bottom"]');
    lastSectionBottom.value = document.querySelector('#last-section-bottom-editor .ql-editor').innerHTML;
  };
</script>
@endsection
