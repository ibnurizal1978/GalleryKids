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

    #uploadSource img {
      height: 80px;
      margin-top: -47px;
    }

    .centernav {
      background: #fbf7ec;
      top: 70px;
      position: fixed;
      left: 0;
      right: 0;
      z-index: 9;
    }

    main .create-content1:first-child {
      margin-top: 125px;
    }

    .imgheartShow {
      width: 23px;
      margin: 0px 15px;
      height: 37px;
    }

    a.iframecontexplore {
    display: block;
    width: 100%;
    margin-top: -1px;
    height: 200px;
    cursor: pointer;
    }

  .resetTopMargin{
	  margin-top:-100px;
  }
  
  .latest-jobs-section {
    display: flex;
    flex-wrap: wrap;
    flex-direction: row;
    justify-content: flex-start;
    align-items: center;
}

a.iframecont {
    display: block;
    width: 100%;
    margin-top: -1px;
    height: 201px;
}
.iframecont>iframe {
    pointer-events: none;
    width: calc(100% + 5px);
}
  </style>

@endsection

@section('content')

  @include('layouts.navbar')

  <main style="background-image:url({{asset('front/img/ex1bg.png')}})">
    <div class="contwrap exp" style="background-image:url('{{asset('front/img/exbottom1.png')}}')">
    @foreach($contents as $content)
    @if(strlen($content->title) > 13 && strlen($content->description) > 10)
      <div class="row">
        <div class=" col-md-12 col-sm-12 page-content">
          
            @if(strlen($content->title) < 10)
              <div class="maint title-lines" style="display:none">
            @else
              <div class="maint title-lines resetTopMargin" style="margin-top:-50px">
            @endif
            {!! html_entity_decode($content->title) !!}
            {!! html_entity_decode($content->description) !!}
            </div>
        </div>
      </div>
      @endif



      @foreach($categories as $discover_category)
        <div class="explore-content1">
          <div class="exleft1">
            <div class="container">
              <div class="row">
                <div class=" col-md-12 col-sm-12 page-content explore-page1">

                  <div class="title-lines">
                    <h3 class="mt0">{{$discover_category->name}}</h3>
                  </div>
                  <div class="latest-jobs-section">
                    @foreach($discover_category->datas as $discover)
                   

                     
                      <div class="col-md-4 ">
                        <div class="catitem4 b1" style="cursor:auto">
                          <?php
                          $str = $discover->url;
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
                            <a href="{{$discover->url}}" target="_blank"
                               rel="noreferrer noopener"> <img
                                src="{{asset($discover->thumbnail->image)}}"/></a>
                          @else
                          <div class="modal fontcss itempop1" role="dialog" id="modal{{$discover->id}}">
                              <div class="preloader"></div>
                              <div class="modal-dialog modal-lg modal-dialog-centered">
                                <!-- Modal content-->
                                <div class="modal-content">
                                  <a class="cancel mtcancel"><img
                                      src="{{asset('front/img/close.png')}}"/></a>
                                  <div class="modal-body para-blk">
                                    <iframe height="500" width="100%"
                                            src="{{$discover->url}}"
                                            frameborder="0"
                                            allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture"
                                            allowfullscreen></iframe>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <a href="#" data-toggle="modal" data-target="#modal{{$discover->id}}" class="iframecont">
                              <iframe height="200" width="100%" src="{{$discover->url}}"
                                      frameborder="0"
                                      allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture"
                                      allowfullscreen></iframe>
                            </a>
                            

                          @endif
                          <?php
                          $fdate = date("Y-m-d");
                          $tdate = date('Y-m-d', strtotime($discover->created_at));
                          $datetime1 = new DateTime($fdate);
                          $datetime2 = new DateTime($tdate);
                          $interval = $datetime1->diff($datetime2);
                          $days = $interval->format('%a');//now do whatever you like with $days
                          if($days<30) { echo '<h5>NEW</h5>'; }else{ echo '<h5>&nbsp;</h5>'; }
                          ?>
                          @if($var == 'false')
                            <a style="text-decoration: none; color:#000" href="{{$discover->url}}" target="_blank" rel="noreferrer noopener">
                          @else
                            <a style="text-decoration: none; color:#000" href="#" data-toggle="modal" data-target="#modal{{$discover->id}}">
                          @endif
                          <h4>{{$discover->title}}</h4>
                          <p>{{$discover->synopsis}}</p>
                          </a>
                          <div class="sharebtn">

                            <a href="javascript:void(0);" class="shbtn">Share</a>
                            <a class="heartShow-{{$discover->id}}" style="">

                            </a>
                            <?php //@if(Auth::check() && $reactions->contains('user_id' , Auth::user()->id)) ?>
                            @if(Auth::check()==true && !empty(optional($discover->reactions)->reactionable_id))
                                <a href="javascript:void(0);"><img src="{{asset('front/img/Icons/liked.svg')}}"></a>
                                
                              @else
                                <a href="javascript:void(0);" data-type="discover"
                                  data-id="{{$discover->id}}" class="heart dd"><img
                                    src="{{asset('front/img/Icons/like.svg')}}"></a>
                                <ul id="emolist-discover-{{$discover->id}}" class="emolist">
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
                                   data-clipboard-text="{{$discover->url}}"><i
                                    class="fa fa-share-alt"></i></a>
                              </li>
                              <li>
                                <a href="https://api.whatsapp.com/send?text={{$discover->url}}"
                                   class="whatsapp" target="_blank"
                                   rel="noreferrer noopener"><img
                                    src="{{asset('front/img/wa.png')}}"></a></li>

                              <li>
                                <a href="https://www.facebook.com/sharer.php?u={{$discover->url}}"
                                   class="facebook" target="_blank"
                                   rel="noreferrer noopener"><i class="fa fa-facebook"
                                                                aria-hidden="true"></i></a>
                              </li>


                            </ul>

                          </div>
                          </a>
                        </div>
                      </div>
                    @endforeach


                    <?php /*@if(!isset($data->category_id))
                      <div class="col-md-12">
                        @php $url = url()->current()."?category_id=$discover->category_id"; @endphp
                        <a class="vmore crExpl" href="{{$url}}">View More</a>
                      </div>
                    @endif*/ ?>


                  </div>
                  <a class="vmore crview" href="detail/{{$discover_category->id}}">View More</a>

                </div>


              </div>

            </div>
          </div>
        </div>
        @if($discover_category->name == 'QUESTIONS ON ART')
          @if(Auth::check()==0)
          <a  class='btn btn-postQues poupoCall'>Submit A Question</a>
          @else
          <a href="{{ route('discover.question.create') }}" class='btn btn-postQues'>Submit A Question</a>
          @endif
        @endif

    @endforeach
    @endforeach


    <!-- <a href="{{route('discover.question.create')}}" class="btn btn-postQues">Post question</a> -->
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
        //$(".latest-jobs-section .col-md-4:nth-of-type(1n+4)").css('display', 'none')
        $(".latest-jobs-section .col-md-4:nth-of-type(1n+4)")
      }


      /*var session = "{{Auth::check()}}";
      if (session == '') {
        $("main .explore-content1:nth-child(2)").append("<a  class='btn btn-postQues poupoCall'>Submit A Question</a>")
      } else {
        $("main .explore-content1:nth-child(2)").append("<a href='{{route('discover.question.create')}}' class='btn btn-postQues'>Submit A Question</a>")
      }*/

      $(document).on('click', '.poupoCall', function () {
        $(".step3").show();
        $("#login-modal1").modal("show");
      })
    


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
    $(".uploadinput").change(function () {
      $("#uploadSource").empty();
      const file = $(this)[0].files[0];
      const reader = new FileReader();
      reader.addEventListener("load", function () {
        // convert image file to base64 string
        $("#uploadSource").append("<img src='" + reader.result + "'/>")
      }, false);
      if (file) {
        reader.readAsDataURL(file);
      }
    })

    $('.shbtn').click(function () {

      // var session = "{{Auth::check()}}";
      // var ele = $(this);
      // if (session == '')
      // {
      //      $("#firstloginmodal").modal("show");
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
      console.log($(".heartShow-" + reaction_id + ""));
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
            //  $(".heartShow-" + reaction_id + "").append('');
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

