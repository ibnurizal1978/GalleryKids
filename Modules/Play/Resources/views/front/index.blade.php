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
  </style>

@endsection

@section('content')

  @include('layouts.navbar')

  <main style="background-image:url({{asset('front/img/pl1bg.png')}})">
    <div class="contwrap pl" style="background-image:url('{{asset('front/img/plbottom.png')}}')">

      <div id="play-content" class="mt125">
        <div class="plleft1">
          <div class="plleft2">
            <div class="container">
              <div class="row">
                <div class=" col-md-12 col-sm-12 page-content ">

                  <div class="title-lines">
                    <h3 class="mt0">GAMES</h3>
                  </div>
                  <div class="latest-jobs-section ">
                    @foreach($plays as $play)
                      <div class="col-md-4 ">
                        <div class="catitem4 b1">

                          <a href="{{$play['url']}}" target="_blank"
                             rel="noreferrer noopener"> <img
                              src="{{asset($play->thumbnail)}}"/></a>


                          <h5>
                            @if (!$play->created_at->addDays(30)->isPast())
                              New
                            @else
                              &nbsp;
                            @endif
                          </h5>
                          <h4>{{$play->title}}</h4>
                          <p>{{$play->synopsis}}</p>


                          <div class="sharebtn">
                            <a href="javascript:void(0);" class="shbtn">Share</a>
                            <a class="heartShow-{{$play->id}}" style="">

                            </a>
                            @if(Auth::check() && $play->reactions->contains('user_id' , Auth::user()->id))

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
