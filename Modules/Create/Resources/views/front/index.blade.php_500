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

    #page-content5 {
      background-color: transparent;
    }

    .latest-jobs-section > div {
      min-height: 435px;
    }
  </style>

@endsection
@section('content')

  @include('layouts.navbar')

  <main @if(isset($data['category_id'])) style="background-image:url({{asset('front/img/exhbg1.png')}})"
        @else style="background-image:url({{asset('front/img/exhbg1.png')}})" @endif >


    <div class="contwrap exh" style="background-image:url('{{asset('front/img/exhbottom.png')}}')">


      <div class="container" class="mt125">
        <div class="row">
          <div class="maint title-lines">
            <h3 class="mt0">Festivals & Exhibitions</h3>
          </div>

        </div>
      </div>
      <div id="page-content5">
        <div class="container">
          <div class="row">
            <div class=" col-md-12 col-sm-12 page-content ">

              <div class="ex-happen">
                <table class="exhbanner">
                  <tr>
                    <td><img src="{{url($setting['image'])}}"/></td>
                    <td>
                      <div class="">
                        <p>{{$setting['description']}}</p>
                        <a class="btn-exh" href="{{$setting['url']}}" target="_blank" rel="noreferrer noopener">Jump
                          right in</a>
                      </div>
                    </td>
                  </tr>
                </table>


              </div>

            </div> <!-- end .page-content -->


          </div>

        </div>
      </div>


      @foreach($exhibitions as $exhibition_category)
        <div class="exh-content">
          <div class="exhcntwrap">
            <div class="container">
              <div class="row">
                <div class=" col-md-12 col-sm-12 page-content ">
                  <div class="title-lines">
                    <h3 class="mt0">{{$exhibition_category->first()->category->name}}<br/>
                      <div style="text-transform: initial;"></div>
                    </h3>
                  </div>
                  <div class="latest-jobs-section ">

                    @foreach($exhibition_category as $exhibtion)
                      <div class="col-md-4 ">

                        <div class="catitem5 b1">
                          @php $thumbnail = $exhibtion->thumbnails->shuffle()->first(); @endphp
                          <?php
                          $str = $exhibtion['url'];

                          $l = ( explode( ".", $str ) );
                          $last = end( $l );
                          $var = '';
                          if ( preg_match( '%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $str, $match ) ) {
                            $var = 'true';
                          } else {
                            $var = 'false';
                          }
                          ?>
                          @if($var == 'false')
                            <a href="{{$exhibtion['url']}}" target="_blank" rel="noreferrer noopener"> <img
                                src="{{asset($thumbnail->image)}}"/></a>
                          @else
                            <a href="javascript:void(0)" class="iframecont">
                              <iframe height="200" width="100%" src="{{$exhibtion['url']}}" frameborder="0"
                                      allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture"
                                      allowfullscreen></iframe>
                            </a>

                            <div class="modal fontcss itempop1" role="dialog">
                              <div class="preloader"></div>
                              <div class="modal-dialog modal-lg modal-dialog-centered">
                                <!-- Modal content-->
                                <div class="modal-content">
                                  <a class="cancel mtcancel"><img src="{{asset('front/img/close.png')}}"/></a>
                                  <div class="modal-body para-blk">
                                    <iframe height="500" width="100%" src="{{$exhibtion['url']}}" frameborder="0"
                                            allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture"
                                            allowfullscreen></iframe>

                                  </div>
                                </div>
                              </div>
                            </div>


                        @endif
                        <!--                                <a href="{{$exhibtion->url}}" target="_blank" rel="noreferrer noopener">
                                                                            <img src="{{asset($thumbnail->image)}}" />
                                                                        </a>-->
                          <h4>{{$exhibtion->title}}</h4>
                          <p>{{$exhibtion->synopsis}}</p>

                          <div class="sharebtn">
                            <a href="javascript:void(0);" class="shbtn">Share</a>
                            <a class="heartShow-{{$exhibtion->id}}" style="">

                            </a>
                            @if(Auth::check() && $exhibtion->reactions->contains('user_id' , Auth::user()->id))

                              <a href="javascript:void(0);"><img src="{{asset('front/img/Icons/liked.svg')}}"></a>
                            @else
                              <a href="javascript:void(0);" data-type="create" data-id="{{$exhibtion->id}}"
                                 class="heart dd"><img src="{{asset('front/img/Icons/like.svg')}}"></a>
                              <ul id="emolist-create-{{$exhibtion->id}}" class="emolist">
                                <li val="&#128561;">&#128561;</li>
                                <li val="&#128546;">&#128546;</li>
                                <li val="&#129322;">&#129322;</li>
                                <li val="&#128526;">&#128526;</li>
                              </ul>
                              <span class="msg"></span>

                            @endif
                            <ul class="shlist">
                              <li>
                                <a href="javascript:void(0);" class="share" onclick='getMessage({{$exhibtion->id}})'
                                   data-clipboard-text="{{$exhibtion->url}}"><i class="fa fa-share-alt"></i></a>
                              </li>
                              <li>
                                <a href="https://api.whatsapp.com/send?text={{$exhibtion->url}}"
                                   onclick='getMessage({{$exhibtion->id}})' class="whatsapp" target="_blank"
                                   rel="noreferrer noopener"><img src="{{asset('front/img/wa.png')}}"></a>
                              </li>

                              <li>
                                <a href="https://www.facebook.com/sharer.php?u={{$exhibtion->url}}"
                                   onclick='getMessage({{$exhibtion->id}})' class="facebook" target="_blank"
                                   rel="noreferrer noopener"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>

                            </ul>

                          </div>


                        </div>

                      </div>
                    @endforeach

                  <!--                        <div class="col-md-12">
                                                            <a class="vmore exbview" href="#">View More</a>
                                                        </div>-->
                    @if(!isset($data['category_id']))
                      <div class="col-md-12">
                        @php $url = url()->current()."?category_id=$exhibtion->category_id"; @endphp
                        <a class="vmore exbview" href="{{$url}}">View More</a>
                      </div>
                    @endif
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      @endforeach


      <div class="bottomheight"></div>
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


    $('.flexslider11').flexslider({
      animation: "slide",
      animationLoop: true,
      pauseOnHover: true,
      touch: true,
      directionNav: true,
      controlNav: true,
      prevText: '&#xf053;',
      nextText: '&#xf054;',
    });

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
      formData.append('reaction_type', 'exhibition');
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
