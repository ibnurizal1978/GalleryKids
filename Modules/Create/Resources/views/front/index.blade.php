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
      background: #fbf7ec;
      top: 70px;
      position: fixed;
      left: 0;
      right: 0;
      z-index: 999;
    }
  </style>
@endsection

@section('content')

  @include('layouts.navbar')

  <main @if(isset($data['category_id'])) style="background-image:url({{asset('front/img/c1bg.png')}})"
        @else style="background-image:url({{asset('front/img/c1bg.png')}})" @endif class="mt125">

    <div class="contwrap" style="background-image:url('{{asset('front/img/c1bottom.png')}}')"
         @if(isset($data['category_id'])) id="sepratecreate" @endif>
      @foreach($creates as $create_category)
        <div class="create-content1">
          <div class="container">
            <div class="row">
              <div class=" col-md-12 col-sm-12 page-content ">

                <div class="title-lines">
                  <h3 class="mt0">{{$create_category->first()->category->name}}</h3>
                </div>
                <div class="latest-jobs-section ">
                  @foreach($create_category as $create)
                    @php $thumbnail = $create->thumbnails->shuffle()->first(); @endphp
                    <div class="col-md-4 ">
                      <?php
                      $str = $create['url'];
                      $l = ( explode( ".", $str ) );
                      $last = end( $l );
                      $var = '';
                      if ( preg_match( '%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $str, $match ) ) {
                        $var = 'true';
                      } else {
                        $var = 'false';
                      }
                      ?>

                      <div class="catitem b1">
                        @if($var == 'false')
                          <a href="{{$create['url']}}" target="_blank" rel="noreferrer noopener"> <img
                              src="{{asset($thumbnail->image)}}"/></a>
                        @else
                          <a href="javascript:void(0)" class="iframecont">
                            <iframe height="200" src="{{$create['url']}}" frameborder="0"
                                    allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture"
                                    allowfullscreen></iframe>
                          </a>
                          <div class="modal fontcss itempop1" role="dialog" id="modal{{$create['id']}}">
                            <div class="preloader"></div>
                            <div class="modal-dialog modal-lg modal-dialog-centered">
                              <!-- Modal content-->
                              <div class="modal-content">
                                <a class="cancel mtcancel"><img src="{{asset('front/img/close.png')}}"/></a>
                                <div class="modal-body para-blk">
                                  <iframe height="500" width="100%" src="{{$create['url']}}" frameborder="0"
                                          allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture"
                                          allowfullscreen></iframe>

                                </div>
                              </div>
                            </div>
                          </div>
                        @endif
                        <h5> 
                          @if (!$create->created_at->addDays(30)->isPast())
                            New
						              @else
							              &nbsp;
                          @endif
                        </h5>

                        @if($var == 'false')
                        <a style="text-decoration: none; color:#000" href="{{$create['url']}}" target="_blank" rel="noreferrer noopener">
                        @else
                          <a style="text-decoration: none; color:#000" href="#" data-toggle="modal" data-target="#modal{{$create['id']}}">
                        @endif
                        <h4>{{$create->title}}</h4>
                        <p>{!!$create->synopsis!!}</p>
                        </a>
                        <div class="sharebtn">
                          <a href="javascript:void(0);" class="shbtn">Share</a>
                          <a class="heartShow-{{$create->id}}" style="">

                          </a>
                          @if(Auth::check() && $create->reactions->contains('user_id' , Auth::user()->id))
                            <a href="javascript:void(0);"><img src="{{asset('front/img/Icons/liked.svg')}}"></a>
                          @else
                            <a href="javascript:void(0);" data-type="create" data-id="{{$create->id}}" class="heart dd"><img
                                src="{{asset('front/img/Icons/like.svg')}}"></a>
                            <ul id="emolist-create-{{$create->id}}" class="emolist">
                              <li val="&#128561;">&#128561;</li>
                              <li val="&#128546;">&#128546;</li>
                              <li val="&#129322;">&#129322;</li>
                              <li val="&#128526;">&#128526;</li>
                            </ul>
                            <span class="msg"></span>
                          @endif
                          <ul class="shlist">
                            <li>
                              <a href="javascript:void(0);" class="share" data-clipboard-text="{{$create->url}}"><i
                                  class="fa fa-share-alt"></i></a>
                            </li>

                            <li>
                              <a href="https://api.whatsapp.com/send?text={{$create->url}}" class="whatsapp"
                                 target="_blank" rel="noreferrer noopener"><img src="{{asset('front/img/wa.png')}}"></a>
                            </li>


                            <li>
                              <a href="https://www.facebook.com/sharer.php?u={{$create->url}}" class="facebook"
                                 target="_blank" rel="noreferrer noopener"><i class="fa fa-facebook"
                                                                              aria-hidden="true"></i></a></li>

                          </ul>

                        </div>
                      </div>
                      </a>
                    </div>


                  @endforeach

                  @if(!isset($data['category_id']))
                    <div class="col-md-12">
                      @php $url = url()->current()."?category_id=$create->category_id"; @endphp
                      <a class="vmore crview" href="{{$url}}">View More</a>
                    </div>
                  @endif


                </div>

              </div>


            </div>

          </div>
        </div>
      @endforeach

      <div id="create-content3">
        <div class="contwrap3">
          <div class="container">
            <div class="row">
              <div class=" col-md-12 col-sm-12 page-content ">
                @if($events != '[]')
                  <div class="title-lines">
                    <h3 class="mt0">FEATURED UPCOMING EVENTS</h3>
                  </div>
                  <div class="latest-jobs-section ">
                    @endif

                    <div class="accordion" id="accordionExample">

                      @foreach($events as $event)
                        <div class="acco1">
                          <div class="acchding">
                            <h2 class="mb-0">
                              <button class="btn btn-link collapsed" type="button" data-toggle="collapse"
                                      data-target="#collapse{{$event->id}}" aria-expanded="false"
                                      aria-controls="collapseOne">
                                {{Carbon\Carbon::parse($event->date)->format('d F, Y')}}
                                <i class="fa fa-plus"></i>
                                <i class="fa fa-minus"></i>
                              </button>
                            </h2>
                          </div>

                          <div id="collapse{{$event->id}}" class="collapse acccont" aria-labelledby="headingOne"
                               data-parent="#accordionExample" aria-expanded="false" style="height: 0px;">
                            <div class="card-body accbox">
                              <div class="col-md-4">
                                <img src="{{asset($event->thumbnail)}}">
                              </div>
                              <div class="col-md-8">
                                <!--                                                <h6>EXHIBITION</h6>-->
                                <h2>{{$event->title}}</h2>
                                <div class="dt">{{Carbon\Carbon::parse($event->date)->format('d F, Y')}}</div>
                                <p>{{$event->synopsis}}</p>
                                <!--                                                <a href="#">Read More</a>-->
                              </div>
                            </div>
                          </div>
                        </div>
                      @endforeach


                    </div>


                    <!--                            <div class="col-md-12">
                                                    <a class="vmore crview" href="#">View More</a>
                                                </div>-->

                    <div class="bottomheight"></div>
                  </div>

              </div>


            </div>

          </div>
        </div>
      </div>
    </div>

  </main>
@endsection

@section('script')

  <script src="{{asset('front/plugins/clipboard.min.js')}}"></script>

  <script>

    var getUrlParameter = function getUrlParameter(sParam) {
      var sPageURL = window.location.search.substring(1),
        sURLVariables = sPageURL.split('&'),
        sParameterName,
        i;
      for (i = 0; i < sURLVariables.length; i++) {
        sParameterName = sURLVariables[i].split('=');
        if (sParameterName[0] === sParam) {
          return sParameterName[1] === undefined ? true : decodeURIComponent(sParameterName[1]);
        }
      }
    };
    $(document).ready(function () {
      var catid = getUrlParameter('category_id');
      if (!catid) {
        $(".latest-jobs-section .col-md-4:nth-of-type(1n+4)").css('display', 'none')
      }
    })

    var clipboard = new ClipboardJS('.share');
    clipboard.on('success', function (e) {
      alert("Link Copied to clipboard");
    });
    clipboard.on('error', function (e) {
      console.log(e);
    });
    $(".iframecont").click(function () {
      $(this).next(".itempop1").modal({
        backdrop: false
      });
    })
    $(".mtcancel").click(function () {
      $(".itempop1").modal('hide')
      $(this).next(".modal-body").find('iframe').attr('src', $(this).next(".modal-body").find('iframe').attr('src'));
    })


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
    $('.shbtn').click(function () {
      // var session = "{{Auth::check()}}";
      // var ele = $(this);
      // if (session == '')
      // {
      //     $("#firstloginmodal").modal("show");
      // }
      // else
      // {
      $(this).siblings(".shlist").slideToggle();
      $(".emolist").hide();
      // }
    });
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
    })

  </script>

@endsection
