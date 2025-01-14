@extends('layouts.master')

@section('style')
  <style type="text/css">
    .emolist {
      display: none;
      height: 23px;
      margin-top: 10px;
    }

    .emolist li {
      list-style: none;
      list-style: none;
      float: right;
      margin: 0px 3px;
      font-size: 26px;
    }

    .emolist li:hover {
      transform: rotate(360deg);
      transition: 0.6s;
    }

    span.msg {
      font-size: 16px;
      display: block;
      text-align: center;
      color: #0ba0d8;
    }

    .centernav {
      top: 70px;
      position: fixed;
      left: 0;
      right: 0;
      z-index: 999;
    }

    .mtop125 {
      margin-top: 80px;
    }

    .listnone {
      list-style: none;
    }

    .catitem4 {
      cursor: initial !important;
    }

    .vbottom {
      display: block;
      clear: both;
      margin-left: 20px !important;
      padding-top: 40px !important;
    }

    .vbottom a {
      color: #000;
      border-bottom: 1px solid;
    }

    /* added 27 juli 2021 by Rizal for display a slick arrow color */
    /*.slick-prev:before,*/
    /*.slick-next:before {*/
    /*  font-family: 'slick';*/
    /*  font-size: 30px !important;*/
    /*  line-height: 1;*/
    /*  opacity: .75;*/
    /*  color: #9D9Dc2 !important;*/
    /*  -webkit-font-smoothing: antialiased;*/
    /*  -moz-osx-font-smoothing: grayscale;*/
    /*}*/

    /*.slick-prev {*/
    /*  left: -35px !important;*/
    /*}*/

    .para-blk {
      padding: 70px 50px 30px 50px;
    }
  </style>

  <link rel="stylesheet" href="{{asset('/slick/slick.css')}}">
  <link rel="stylesheet" href="{{asset('/slick/slick-theme.css')}}">
  <link rel="stylesheet" href="{{asset('/front/css/kcae.css')}}">
@endsection

@section('content')

  @include('layouts.navbar')

  <main style="background-image:url('{{asset('front/img/ktop.png')}}')" class="mtop125">
    <div class="contwrap kap" style="background-image:url('{{asset('front/img/kbottom.png')}}')">
      <div id="play-content-kap1" class="mt125">
        <div class="container">
          <div class="row">
            <div class=" col-md-12 col-sm-12 page-content ">

              <div class="title-container">
                {!! optional($pageContent)->title !!}
              </div>

              <div class="latest-jobs-section ">

                <div class="col-md-12 kapple-para">
                  {!! optional($pageContent)->description !!}
                </div>

                @if ($slides)
                  <div class="row">

                    <div class="hero_slider_title">
                      {!! optional($pageContent)->hero_slider_title !!}
                    </div>

                    <div id="hero-slider" class="col-xs-12">
                      @foreach($slides as $slide)
                        <div class="hero-slide">
                          <div class="inner">
                            <a href="javascript:void(0)" class="open_popup slide-{{$slide->id}}"
                               data-slide="{{$slide->id}}">
                              @if ($slide->video)
                                <iframe height="200" src="{{$slide->video}}" frameborder="0"
                                        allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture"
                                        allowfullscreen></iframe>
                              @else
                                <img src="{{$slide->image}}" alt="{{$slide->name}}">
                              @endif
                            </a>
                          </div>
                        </div>
                      @endforeach
                    </div>

                    <div id="hero-popups">
                      @foreach($slides as $slide)
                        <div class="modal fontcss itempop1 slide-{{$slide->id}}" role="dialog">
                          <div class="preloader"></div>
                          <div class="modal-dialog modal-lg modal-dialog-centered">
                            <!-- Modal content-->
                            <div class="modal-content">
                              <a class="cancel mtcancel"><img src="{{asset('front/img/close.png')}}"/></a>
                              <div class="modal-body para-blk">
                                @if ($slide->video)
                                  <iframe
                                    height="500"
                                    width="100%"
                                    src="{{$slide->video}}"
                                    frameborder="0"
                                    allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture"
                                    allowfullscreen
                                  ></iframe>
                                @else
                                  <img src="{{$slide->image}}" alt="{{$slide->name}}" style="width:  100%">
                                @endif
                              </div>
                            </div>
                          </div>
                        </div>
                      @endforeach
                    </div>
                  </div>
                @endif

                <div class="clearfix"></div>

                @if($spaces)
                  <div id="spaces-section">
                    @foreach($spaces as $category)
                      @if($category && $category->spaces->count())
                        <div class="space_cat">
                          <h2>{{$category->name}}</h2>
                        </div>

                        <div class="spaces_list">
                          @foreach($category->spaces as $space)
                            <div class="col-md-4 ">
                              <div class="catitem b1">
                                <a href="javascript:void(0)"
                                   class="open_space_popup @if(!$space->slides->count()) no_slides @endif">
                                  <img src="{{asset($space->image)}}"/>

                                  <h4>{{$space->name}}</h4>
                                  <p>{{$space->description}}</p>
                                </a>

                                @if($space->slides->count())
                                  <div class="modal fontcss itempop1" role="dialog">
                                    <div class="preloader"></div>
                                    <div class="modal-dialog modal-lg modal-dialog-centered">
                                      <!-- Modal content-->
                                      <div class="modal-content">
                                        <a class="cancel mtcancel">
                                          <img src="{{asset('front/img/close.png')}}"/>
                                        </a>
                                        <div class="modal-body para-blk">

                                          <div id="space-slider-{{$space->id}}" class="space-sliders">
                                            @foreach($space->slides as $slide)
                                              <div class="space-slide">
                                                <img src="{{$slide->image}}" alt="{{$slide->name}}"/>
                                                {{-- <div class="space_slide_nav"></div>--}}
                                                <h4>{{$slide->name}}</h4>
                                                <p>{{$slide->description}}</p>
                                              </div>
                                            @endforeach
                                          </div>

                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                @endif

                                {{-- <h5>--}}
                                {{-- @if (!$space->created_at->addDays(30)->isPast())--}}
                                {{-- New--}}
                                {{-- @endif--}}
                                {{-- </h5>--}}

                                <div class="sharebtn">
                                  <a href="javascript:void(0);" class="shbtn">Share</a>
                                  <a class="heartShow-{{$space->id}}" style=""></a>
                                  @if(Auth::check() && $space->reactions->contains('user_id', Auth::user()->id))
                                    <a href="javascript:void(0);">
                                      <img src="{{asset('front/img/Icons/liked.svg')}}">
                                    </a>
                                  @else
                                    <a href="javascript:void(0);" data-type="space" data-id="{{$space->id}}"
                                       class="heart dd">
                                      <img src="{{asset('front/img/Icons/like.svg')}}">
                                    </a>
                                    <ul id="emolist-space-{{$space->id}}" class="emolist">
                                      <li val="&#128561;">&#128561;</li>
                                      <li val="&#128546;">&#128546;</li>
                                      <li val="&#129322;">&#129322;</li>
                                      <li val="&#128526;">&#128526;</li>
                                    </ul>
                                    <span class="msg"></span>
                                  @endif
                                  <ul class="shlist">
                                    <li>
                                      <a href="javascript:void(0);" class="share"
                                         data-clipboard-text="{{url()->current()}}">
                                        <i class="fa fa-share-alt"></i>
                                      </a>
                                    </li>

                                    <li>
                                      <a href="https://api.whatsapp.com/send?text={{url()->current()}}" class="whatsapp"
                                         target="_blank" rel="noreferrer noopener">
                                        <img src="{{asset('front/img/wa.png')}}" l>
                                      </a>
                                    </li>

                                    <li>
                                      <a href="https://www.facebook.com/sharer.php?u={{url()->current()}}"
                                         class="facebook" target="_blank" rel="noreferrer noopener">
                                        <i class="fa fa-facebook" aria-hidden="true"></i>
                                      </a>
                                    </li>

                                  </ul>

                                </div>
                              </div>
                            </div>
                          @endforeach
                        </div>
                      @endif
                    @endforeach
                  </div>
                @endif
              </div>

            </div>
          </div>
        </div>
      </div>

      <div id="play-content2-kap">
        <div class="container">
          <div class="row">
            <div class=" col-md-12 col-sm-12 page-content ">

              <div class="col-md-12 kapple-para2" id="mid-section">
                {!! optional($pageContent)->{'mid-section'} !!}
              </div>

              <div class="kapple-section-visit">
                {!! optional($pageContent)->{'last-section-top'} !!}

                <div class="col-xs-12">
                  <div class="visitbox mb-15px">
                    {!! optional($pageContent)->{'last-section-box1'} !!}
                  </div>
                </div>

                <div class="col-xs-12">
                  <div class="visitbox mb-15px">
                    {!! optional($pageContent)->{'last-section-box2'} !!}
                  </div>
                </div>

                <div class="col-xs-12 ">
                  <div class="visitbox">
                    {!! optional($pageContent)->{'last-section-box3'} !!}
                  </div>
                </div>
                <br/>
                <div class="vbottom">
                  {!! optional($pageContent)->{'last-section-bottom'} !!}
                </div>

              </div>

            </div>
          </div>
        </div>
      </div>
      <div class="bottomheightk"></div>
    </div>

  </main>
@endsection

@section('script')
  <script src="{{asset('front/plugins/clipboard.min.js')}}"></script>
  <script src="{{asset('slick/slick.min.js')}}"></script>
  <script type="text/javascript">
    $(document).ready(function () {

      // Hero Slider

      $('#hero-slider').slick({
        dots: true,
        infinite: true,
        slidesToShow: 3,
        slidesToScroll: 3,
        arrows: true,
        prevArrow: '<span class="fas fa-chevron-left slick-nav-left"></span>',
        nextArrow: '<span class="fas fa-chevron-right slick-nav-right"></span>',
        responsive: [{
          breakpoint: 1024,
          settings: {
            slidesToShow: 2,
            slidesToScroll: 2,
          }
        },
          {
            breakpoint: 767,
            settings: {
              slidesToShow: 1,
              slidesToScroll: 1,
            }
          }
        ]
      });

      // Popups
      $(".open_popup").click(function () {
        var slideId = $(this).data('slide');

        $(".itempop1.slide-" + slideId).modal({
          backdrop: false
        });
      });

      $(".open_space_popup").click(function () {
        $(this).next(".itempop1").modal({
          backdrop: false
        });
        // space sliders
        $(this).next(".itempop1").find('.space-sliders').not('.slick-initialized').slick({
          dots: true,
          infinite: true,
          slidesToShow: 1,
          slidesToScroll: 1,
          arrows: true,
          prevArrow: '<span class="fas fa-chevron-left slick-nav-left"></span>',
          nextArrow: '<span class="fas fa-chevron-right slick-nav-right"></span>',
          // appendDots: $('.space_slide_nav')
        });

        $(this).next(".itempop1").find('.space-sliders').slick('setPosition');
        $(this).next(".itempop1").find('.space-sliders').slick('slickGoTo', 0, true);

        var _self = this;
        setTimeout(function () {
          $(_self).next(".itempop1").find('.space-sliders').slick('setPosition');
        }, 500);
      });

      $(".mtcancel").click(function () {
        $(".itempop1").modal('hide');
        $(this)
          .next(".modal-body")
          .find('iframe')
          .attr(
            'src',
            $(this)
              .next(".modal-body")
              .find('iframe')
              .attr('src')
          );
      });

      // share buttons
      $('.shbtn').click(function () {
        $(this).siblings(".shlist").slideToggle();
        $(".emolist").hide();
      });

      // heart icon
      $('.heart').click(function () {
        $(".shlist").hide();
        var session = "{{Auth::check()}}";
        var ele = $(this);
        if (session == '') {
          $("#firstloginmodal").modal("show");
        } else {
          $("#emolist-" + ele.attr("data-type") + "-" + ele.attr("data-id")).slideToggle();
        }
      });

      // copy into clipboard
      var clipboard = new ClipboardJS('.share');
      clipboard.on('success', function (e) {
        alert("Link Copied to clipboard");
      });
      clipboard.on('error', function (e) {
        console.log(e);
      });

      // Send favourites to server
      $(".emolist li").click(function () {

        var parent = $(this).parents("ul");
        var val = $(this).attr("val");
        var formData = new FormData();
        var csrf = "{{csrf_token()}}";
        formData.append('_token', csrf);
        formData.append('reaction', val);
        formData.append('reaction_type', parent.prev(".heart").attr('data-type'));
        formData.append('reaction_id', parent.prev(".heart").attr('data-id'));
        var reaction_id = parent.prev(".heart").attr('data-id');
        $.ajax({
          url: "{{route('reaction.add')}}",
          method: 'POST',
          contentType: false,
          processData: false,
          data: formData,
          success: function (res) {
            if (res.status == 'success') {
              parent.next(".msg").html("Your reaction is " + val).show();
              parent.slideToggle();
              parent.prev(".heart").hide();
              $(".heartShow-" + reaction_id + "").append('<img src="{{url("front/img/Icons/liked.svg")}}" style="height: -16px !important" />');
            } else {

            }
          },
          error: function () {
            console.log('error reacting');
          }
        });
      });

    });
  </script>
@endsection
