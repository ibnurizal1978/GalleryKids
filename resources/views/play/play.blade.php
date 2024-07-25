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
      z-index: 9;
    }

    
.title-lines1 {
    position: relative;
    display: block;
    overflow: hidden;
    width: 100%;
    height: auto;
    text-align: center;
}

.title-lines1 h1,
.title-lines1 h2,
.title-lines1 h3,
.title-lines1 h4,
.title-lines1 h5,
.title-lines1 h6 {
        position: relative;
        display: inline-block;
        padding: 0 30px;
        text-transform: initial;
        margin-bottom: 53px;
        margin-top: 22px;
        font-family: 'vegr',sans-serif;
        font-weight: 100;
        color: #000000;
}
.title-lines1 h1:before,
.title-lines1 h2:before,
.title-lines1 h3:before,
.title-lines1 h4:before,
.title-lines1 h5:before,
.title-lines1 h6:before {
    left: 100%;
}

.title-lines1 h1:after,
.title-lines1 h2:after,
.title-lines1 h3:after,
.title-lines1 h4:after,
.title-lines1 h5:after,
.title-lines1 h6:after {
    right: 100%;
}
  </style>

@endsection

@section('content')

  @include('layouts.navbar')

  <main style="background-image:url({{asset('front/img/pl1bg.png')}})">
    <div class="contwrap pl" style="background-image:url('{{asset('front/img/plbottom.png')}}')">

    
    @if(strlen($title) >= 11 && strlen($description) > 10)
      <div class="row">
        <div class=" col-md-12 col-sm-12 page-content">
          
            @if(strlen($title) < 10)
              <div class="title-lines1" style="display:none; margin-top: 100px">
            @else
              <div class="title-lines1" style="margin-top:-50px;">
            @endif
            <div style="margin-top: 100px;">{!! ($title) !!}</div>
            <br/>
            {!! html_entity_decode($description) !!}
            </div>
        </div>
      </div>
      @endif


      <div id="play-content" class="mt125">
        <div class="plleft1">
          <div class="plleft2">
            <div class="container">
              <div class="row">
                <div class=" col-md-12 col-sm-12 page-content ">

                @foreach($categories as $discover_category)
                  <div class="title-lines">
                    <h3 class="mt0">{{$discover_category->name}}</h3>
                  </div>
                  <div class="latest-jobs-section ">
                    @foreach($discover_category->datas as $play)
                      <div class="col-md-4 ">
                        <div class="catitem4 b1" style="cursor:auto">

                          <?php
                          $str = $play->url;
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
                            <a href="{{$play->url}}" target="_blank"
                               rel="noreferrer noopener"> <img
                                src="{{asset($play->thumbnail)}}"/></a>
                          @else
                            <a href="#" data-toggle="modal" data-target="#modal{{$play->id}}" class="iframecont">
                              <iframe height="200" width="100%" src="{{$play->url}}"
                                      frameborder="0"
                                      allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture"
                                      allowfullscreen></iframe>
                            </a>
                            <div class="modal fontcss itempop1" role="dialog" id="modal{{$play->id}}">
                              <div class="preloader"></div>
                              <div class="modal-dialog modal-lg modal-dialog-centered">
                                <!-- Modal content-->
                                <div class="modal-content">
                                  <a class="cancel mtcancel"><img
                                      src="{{asset('front/img/close.png')}}"/></a>
                                  <div class="modal-body para-blk">
                                    <iframe height="500" width="100%"
                                            src="{{$play->url}}"
                                            frameborder="0"
                                            allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture"
                                            allowfullscreen></iframe>

                                  </div>
                                </div>
                              </div>
                            </div>

                          @endif

                          <?php
                          $fdate = date("Y-m-d");
                          $tdate = date('Y-m-d', strtotime($play->created_at));
                          $datetime1 = new DateTime($fdate);
                          $datetime2 = new DateTime($tdate);
                          $interval = $datetime1->diff($datetime2);
                          $days = $interval->format('%a');//now do whatever you like with $days
                          if($days<30) { echo '<h5>NEW</h5>'; }else{ echo '<h5>&nbsp;</h5>'; }
                          ?>
                          @if($var == 'false')
                        <a style="text-decoration: none; color:#000" href="{{$play->url}}" target="_blank" rel="noreferrer noopener">
                        @else
                          <a style="text-decoration: none; color:#000" href="#" data-toggle="modal" data-target="#modal{{$play->id}}">
                        @endif
                          <h4>{{$play->title}}</h4>
                          <p>{{$play->synopsis}}</p>
                          </a>


                          <div class="sharebtn">
                            <a href="javascript:void(0);" class="shbtn">Share</a>
                            <a class="heartShow-{{$play->id}}" style="">

                            </a>
                            <?php //@if(Auth::check() && $play->reactions->contains('user_id' , Auth::user()->id)) ?>
                            @if(Auth::check()==true && !empty(optional($play->reactions)->reactionable_id))
                              <a href="javascript:void(0);"><img
                                  src="{{asset('front/img/Icons/liked.svg')}}"></a>
                            @else
                              <a href="javascript:void(0);" data-type="play"
                                 data-id="{{$play->id}}" class="heart dd"><img
                                  src="{{asset('front/img/Icons/like.svg')}}"></a>
                              <ul id="emolist-play-{{$play->id}}" class="emolist">
                                <li val="&#128561;">&#128561;</li>
                                <li val="&#128546;">&#128546;</li>
                                <li val="&#129322;">&#129322;</li>
                                <li val="&#128526;">&#128526;</li>
                              </ul>
                              <span class="msg"></span>
                            @endif
                            <ul class="shlist">
                              <li>
                                <a href="javascript:void(0);" class="share" value="call"
                                   data-clipboard-text="{{$play->url}}"><i
                                    class="fa fa-share-alt"></i></a>
                              </li>
                              <li>
                                <a href="https://api.whatsapp.com/send?text={{$play->url}}"
                                   class="whatsapp" target="_blank"
                                   rel="noreferrer noopener"><img
                                    src="{{asset('front/img/wa.png')}}"></a>
                              </li>

                              <li>
                                <a href="https://www.facebook.com/sharer.php?u={{$play->url}}"
                                   class="facebook" target="_blank"
                                   rel="noreferrer noopener"><i class="fa fa-facebook"
                                                                aria-hidden="true"></i></a>
                              </li>

                            </ul>

                          </div>


                        </div>
                      </div>
                    @endforeach
                  </div>

                  @endforeach
                </div>
                

              </div>

            </div>
          </div>
        </div>
      </div>
      <div class="bottomheight"></div>
    </div>
  </main>


@endsection

@section('script')

  <script src="{{asset('front/plugins/clipboard.min.js')}}"></script>

  <script>
    var clipboard = new ClipboardJS('.share');

    clipboard.on('success', function (e) {
      alert("Link Copied to clipboard");
    });

    clipboard.on('error', function (e) {
      console.log(e);
    });

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

      // if(session == '')
      // {
      //     $("#firstloginmodal").modal("show");
      // }
      // else
      // {
      $(this).siblings(".shlist").slideToggle();
      $(".emolist").hide();

      // }

    });

    $('.shlist').click(function () {
      $(this).siblings(".shlist").slideToggle();
      $(".shlist").hide();
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
