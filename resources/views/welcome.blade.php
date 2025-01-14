@extends('layouts.master')

@section('style')
  <style type="text/css">

    .emolist {
      display: none;
      height: 23px;
      /*        position: absolute;*/
      right: 25px;
      margin-top: 2px;
    }

    .emolist li {
      $ campaigns
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

    .shareImog {
      position: inherit;
    }

    .modal-body .sharebtn {
      display: none;
    }

    .upCase {
      text-transform: uppercase;
    }

    /*  .happen p{
          padding-right: 40px !important;
      }*/
    .slidrwrap {
      width: 100%;
    }

    .mitem .whatsapp img {
      margin-top: -7px !important;
    }

    .mitem .shlist i.fa.fa-share-alt {
      margin-top: 0px;
    }

    .mitem .shlist i.fa.fa-facebook {
      margin-top: 4px;
    }

    .modalcontent {
      display: none;
    }

    #itempop .modalcontent {
      display: block;
    }

    #itempop .boxconent {
      display: none;
    }

    .boxconent h4, .modalcontent h4 {
      margin-top: 10px;
      margin: 4px 0px;
      font-style: italic;
    }

    .boxconent p {
      text-align: left !important;
      margin-top: 0px !important;
      font-style: initial;
      font-family: sans-serif;
      font-size: 14px;
      padding: 0px 15px;
      margin-bottom: 0px;
      line-height: 20px;
    }

    .modalcontent p {
      text-align: left !important;
      margin-top: 0px !important;
      font-style: initial;
      font-family: sans-serif;
      font-size: 14px;
      padding: 0px 15px;
      margin-bottom: 0px;
      line-height: 20px;
    }

    #itempop .para-blk > div > img {
      margin-top: 0px !important;
      width: 100% !important;
    }

    h4 b {
      line-height: 15px;
    }

    #itempop .hditem {
      margin-top: 15px;
    }

    .boxconent p {
      text-align: left !important;
      margin-top: 5px;
    }

    .boxconent {
      text-align: left;
    }

    .tab2sec .hditem {
      margin-top: 13px;
    }
  </style>

@endsection

@section('alert')

  @include('layouts.alert')

@endsection

@section('content')
  <div id="header2">
    <div class="header-banner">
      <!-- <img src="img/Landing_Nav.jpg" class="bannerimg"/> -->
      <ul class="hdrlist">
        <li class="hr1">
          <a href="{{url($tabs[0]['slug'])}}">
            <img src="{{asset('front/img/gifs/1.png')}}">
            <img src="{{asset('front/img/gifs/1gif.gif')}}">
          </a>
        </li>
        <li class="hr2">
          <a href="{{url($tabs[1]['slug'])}}">
            <img src="{{asset('front/img/gifs/2.png')}}">
            <img src="{{asset('front/img/gifs/2gif.gif')}}">
          </a>
        </li>
        <li class="hr3">
          <a href="{{route('keppelCentre')}}
            ">
            <img src="{{asset('front/img/gifs/3.png')}}">
            <img src="{{asset('front/img/gifs/3gif.gif')}}">
          </a>
        </li>
      </ul>
      <ul class="hdrlist mt95minus">
        <li class="hr4">
          <!--<a href="{{url($tabs[4]['slug'])}}">-->
          <a href="{{route('/festivals/new')}}">
            <img src="{{asset('front/img/gifs/4.png')}}">
            <img src="{{asset('front/img/gifs/4gif.gif')}}">
          </a>
        </li>
        <li class="hr5">
          <!--<a href="{{url($tabs[3]['slug'])}}">-->
          <a href="{{route('/explore/new')}}">
            <img src="{{asset('front/img/gifs/5.png')}}">
            <img src="{{asset('front/img/gifs/5gif.gif')}}">
          </a>
        </li>
        <li class="hr6">
          <!--<a href="{{url($tabs[2]['slug'])}}">-->
          <a href="{{route('/play/new')}}">
            <img src="{{asset('front/img/gifs/6.png')}}">
            <img src="{{asset('front/img/gifs/6gif.gif')}}">
          </a>
        </li>
      </ul>
    </div>
  </div>
  @include('layouts.navbar')
  <div id="page-content">
    <div class="container">
      <div class="row">
        <div class=" col-md-12 col-sm-12 page-content ">
          <div class="title-lines">
            <h3 class="mt0 upCase">{{$tabs[0]['display_name']}}</h3>
          </div>
          <div class="latest-jobs-section ">
            @foreach($creates as $create)

              <div class="col-md-4 ">
                <div class="catitem b1">
                  @php $thumbnail = $create->thumbnails->shuffle()->first(); @endphp
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
                  @if($var == 'false')
                    <a href="{{$create['url']}}" target="_blank" rel="noreferrer noopener"> <img
                        src="{{asset($thumbnail->image)}}"/></a>
                  @else
                    <a href="javascript:void(0)" class="iframecont">
                      <iframe height="200" width="100%" src="{{$create['url']}}" frameborder="0"
                              allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture"
                              allowfullscreen></iframe>

                    </a>
                    <div class="modal fontcss itempop1" role="dialog">

                      <div class="preloader"></div>
                      <div class="modal-dialog modal-lg modal-dialog-centered">
                        <!-- Modal content-->
                        <div class="modal-content">
                          <a class="cancel mtcancel"><img
                              src="{{asset('front/img/close.png')}}"/></a>
                          <div class="modal-body para-blk">
                            <iframe height="500" width="100%" src="{{$create['url']}}"
                                    frameborder="0"
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
                    @endif
                  </h5>

                  <h4>{{$create->title}}</h4>
                  <p>{!!$create->synopsis!!}</p>
                  <div class="sharebtn">
                    <a href="javascript:void(0);" class="shbtn">Share</a>
                  <!--                                <a data-clipboard-text="{{$create->url}}">Share</a>-->
                    <a class="heartShow-{{$create->id}}-create" style="">

                    </a>
                    @if(Auth::check() && $create->reactions->contains('user_id' , Auth::user()->id))
                      <a href="javascript:void(0);"><img
                          src="{{asset('front/img/Icons/liked.svg')}}"></a>
                    @else
                      <a href="javascript:void(0);" data-type="create" data-id="{{$create->id}}"
                         class="heart dd"><img src="{{asset('front/img/Icons/like.svg')}}"></a>
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
                        <a href="javascript:void(0);" class="share"
                           data-clipboard-text="{{$create->url}}"><i
                            class="fa fa-share-alt"></i></a>
                      </li>
                      <li><a href="https://api.whatsapp.com/send?text={{$create->url}}"
                             class="whatsapp" target="_blank" rel="noreferrer noopener"><img
                            src="{{asset('front/img/wa.png')}}"></a></li>
                      <li><a href="https://www.facebook.com/sharer.php?u={{$create->url}}"
                             class="facebook" target="_blank" rel="noreferrer noopener"><i
                            class="fa fa-facebook" aria-hidden="true"></i></a></li>


                    </ul>


                  </div>
                </div>
              </div>
            @endforeach
            <div class="col-md-12">
              <a class="vmore crview" href="{{url($tabs[0]['slug'])}}">View More</a>
            </div>
          </div>
        </div> <!-- end .page-content -->
      </div>
    </div>
  </div>

  <div id="page-content1">
    <div class="container">
      <div class="row">
        <div class=" col-md-12 col-sm-12 page-content ">

          <div class="title-lines">
            <h3 class="mt0">{{$tabs[1]['display_name']}}</h3>
          </div>

          <ul class="tabshare">
            <li class="active t1">KIDS' GALLERY</li>
            <li class="t2">GALLERY'S PICKS</li>
          </ul>

			<!--------------  15-10-2021 I comment this coz got problem error 500 --------->
			<!--------------  22-10-2021 I add if data is empty --------->
          <div class="latest-jobs-section tab1sec masonry">
            @if(is_null($my_shares))
				echo '';
			@else
			@foreach($my_shares as $m_share)
              @php $thumbnail = $m_share->thumbnails->shuffle()->first(); @endphp
              <a>
                <div class="mitem">
                  <div class=" ">
                    <img src="{{asset($thumbnail['image'])}}"/>
                    <div class="hditem">
                      <h4>{{ $m_share->name}}</h4>
                      <?php
                      //$dateOfBirth = $m_share['user']['year_of_birth']; /* ==== 15-10-2021 I comment this coz got problem error 500 */
                      //$years = \Carbon\Carbon::parse( '' . $m_share['user']['year_of_birth'] . '-01-01' )->age; /* ==== 15-10-2021 I comment this coz got problem error 500 */
                      ?>
                      <p>
                        @if($m_share['age'])
                          {{$m_share['age']}} Years Old<br/>
                        @else
                          {{$years}} Years Old<br/>
                        @endif
                      </p>
                    <!-- <div class="sharebtn">
                                        <a href="javascript:void(0);"  class="shbtn">Share</a>
                                        <a class="heartShow-{{$m_share->id}}-share" style="">

                                        </a>
                                        @if(Auth::check() && $m_share->reactions->contains('user_id' , Auth::user()->id))
                      <a href="javascript:void(0);"><img src="{{asset('front/img/Icons/liked.svg')}}"></a>
                                        @else
                      <a href="javascript:void(0);" data-type="share" data-id="{{$m_share->id}}" class="heart dd"><img src="{{asset('front/img/Icons/like.svg')}}"></a>
                                        <ul id="emolist-share-{{$m_share->id}}" class="emolist shareImog">
                                            <li val="&#128561;">&#128561;</li>
                                            <li val="&#128546;">&#128546;</li>
                                            <li val="&#129322;">&#129322;</li>
                                            <li val="&#128526;">&#128526;</li>
                                        </ul>
                                        <span class="msg"></span>
                                        @endif
                      <ul class="shlist">
                          <li>
                              <a href="javascript:void(0);" class="share" onclick='getMessage({{$m_share->id}}, "share")' data-clipboard-text="{{route('showShare',$m_share['id'])}}"><i class="fa fa-share-alt"></i></a>
                                            </li>
                                            <li> <a href="https://api.whatsapp.com/send?text={{route('showShare',$m_share['id'])}}" onclick='getMessage({{$m_share->id}}, "share")' class="whatsapp" target="_blank"><img src="{{asset('front/img/wa.png')}}"></a></li>
                                            <li><a href="https://www.facebook.com/sharer.php?u={{route('showShare',$m_share['id'])}}" onclick='getMessage({{$m_share->id}}, "share")' class="facebook" target="_blank"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>


                                        </ul>
                                    </div> -->
                    </div>
                  </div>
                </div>
              </a>
            @endforeach
			@endif

          </div><!--------------  END OF 15-10-2021 I comment this coz got problem error 500 --------->
		  <!--------------  END OF 22-10-2021 I add if data is empty --------->
		  
		  
		  
		  
		  


          <div class="latest-jobs-section tab2sec masonry">


            @foreach($admin_shares as $a_share)
              <div class="mitem">
                <div class=" ">
                  <img src="{{$a_share['image']}}"/>
                  <div class="hditem">

                    <div class="boxconent">

                      <p> {{$a_share['ARTIST']}}</p>
                      <p><i>{{$a_share['TITLE']}}</i></p>
                      <p>{{$a_share['DATE_OF_ART_CREATED']}}</p>
                    </div>
                    <div class="modalcontent">

                      <p> {{$a_share['ARTIST']}}</p>
                      <p><i>{{$a_share['TITLE']}}</i></p>
                      <p>{{$a_share['DATE_OF_ART_CREATED']}}</p>

                      {{--                                            <p>{{$a_share['CLASSIFICATION']}}</p>--}}
                      <p>{{$a_share['medium']}}, {{$a_share['dimension']}}</p>
                      <p> {{$a_share['CREDITLINE']}}</p>

                    </div>


                  <!--  <div class="sharebtn">
                                    <a href="javascript:void(0);"  class="shbtn">Share</a>
                                    <a class="heartShow-{{$a_share['id']}}-share" style="">

                                    </a>

                                    @if(Auth::check() && $a_share->reactions->contains('user_id' , Auth::user()->id))
                    <a href="javascript:void(0);"><img src="{{asset('front/img/Icons/liked.svg')}}"></a>
                                    @else

                    <a href="javascript:void(0);" data-type="admin_share" data-id="{{$a_share->id}}" class="heart dd"><img src="{{asset('front/img/Icons/like.svg')}}"></a>
                                    <ul id="emolist-admin_share-{{$a_share->id}}" class="emolist">
                                        <li val="&#128561;">&#128561;</li>
                                        <li val="&#128546;">&#128546;</li>
                                        <li val="&#129322;">&#129322;</li>
                                        <li val="&#128526;">&#128526;</li>
                                    </ul>
                                    <span class="msg"></span>
                                    @endif
                    <ul class="shlist">
                        <li>
                            <a href="javascript:void(0);" class="share" data-clipboard-text="{{route('showShare',$a_share['id'])}}" onclick='getMessage({{$a_share->id}}, "a_share")'><i class="fa fa-share-alt"></i></a>
                                        </li>
                                        <li> <a href="https://api.whatsapp.com/send?text=http://165.22.209.85/blog/share/{{$a_share['id']}}" onclick='getMessage({{$a_share->id}}, "a_share")' class="whatsapp" target="_blank"><img src="{{asset('front/img/wa.png')}}"></a></li>
                                        <li><a href="https://www.facebook.com/sharer.php?u=http://165.22.209.85/blog/share/{{$a_share['id']}}" onclick='getMessage({{$a_share->id}}, "a_share")' class="facebook" target="_blank"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>


                                    </ul>
                                </div> -->
                  </div>
                </div>
              </div>
            @endforeach


          </div>


          <div class="col-md-12">
            <a class="vmore shview" href="{{url($tabs[1]['slug'])}}">View More</a>
          </div>

        </div> <!-- end .page-content -->


      </div>
    </div>
  </div>
  <div id="page-content2">
    <div class="container">
      <div class="row">
        <div class=" col-md-12 col-sm-12 page-content explore">
          <div class="title-lines">
            <h3 class="mt0"><span>{{$tabs[3]['display_name']}}</span></h3>
          </div>
          <div class="latest-jobs-section ">
            @foreach($discovers as $discover)
              @php $thumbnail = $discover->thumbnails->shuffle()->first(); @endphp

              <div class="col-md-4 ">
                <div class="catitem3 b1">
                  <?php
                  $str = $discover['url'];
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
                    <a href="{{$discover['url']}}" target="_blank" rel="noreferrer noopener"> <img
                        src="{{asset($thumbnail->image)}}"/></a>
                  @else
                    <a href="javascript:void(0)" class="iframecont">
                      <iframe height="200" width="100%" src="{{$discover['url']}}" frameborder="0"
                              allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture"
                              allowfullscreen></iframe>
                    </a>
                    <div class="modal fontcss itempop1" role="dialog">
                      <div class="preloader"></div>
                      <div class="modal-dialog modal-lg modal-dialog-centered">
                        <!-- Modal content-->
                        <div class="modal-content">
                          <a class="cancel mtcancel"><img
                              src="{{asset('front/img/close.png')}}"/></a>
                          <div class="modal-body para-blk">
                            <iframe height="500" width="100%" src="{{$discover['url']}}"
                                    frameborder="0"
                                    allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture"
                                    allowfullscreen></iframe>

                          </div>
                        </div>
                      </div>
                    </div>
                  @endif
                  <h5>
                    @if (!$discover->created_at->addDays(30)->isPast())
                      New
                    @endif
                  </h5>
                  {{--                                    <h6>Awesome art posters:</h6>--}}
                  <h4>{{$discover->title}}</h4>
                  <p>{{$discover->synopsis}}</p>
                  <div class="sharebtn">
                    <a href="javascript:void(0);" class="shbtn">Share</a>
                    <a class="heartShow-{{$discover->id}}-discover" style=""></a>
                    @if(Auth::check() && $discover->reactions->contains('user_id' , Auth::user()->id))

                      <a href="javascript:void(0);"><img
                          src="{{asset('front/img/Icons/liked.svg')}}"></a>
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
                      <li><a href="https://api.whatsapp.com/send?text={{$discover->url}}"
                             class="whatsapp" target="_blank" rel="noreferrer noopener"><img
                            src="{{asset('front/img/wa.png')}}"></a></li>
                      <li><a href="https://www.facebook.com/sharer.php?u={{$discover->url}}"
                             class="facebook" target="_blank" rel="noreferrer noopener"><i
                            class="fa fa-facebook" aria-hidden="true"></i></a></li>
                    </ul>
                  </div>
                </div>
              </div>
            @endforeach


            <div class="col-md-12">
              <a class="vmore expview" href="{{url($tabs[3]['slug'])}}">View More</a>
            </div>


          </div>

        </div> <!-- end .page-content -->


      </div>
    </div>
  </div>
  <div id="page-content3">
    <div class="container">
      <div class="row">
        <div class=" col-md-12 col-sm-12 page-content play">
          <div class="title-lines">
            <h3 class="mt0"><span>{{$tabs[2]['display_name']}}<span></h3>
          </div>
          <div class="latest-jobs-section ">
            @foreach($plays as $play)
              <div class="col-md-4 ">
                <div class="catitem4 b1">
                  <?php
                  $str = $play['url'];
                  $l = ( explode( ".", $str ) );
                  $last = end( $l );
                  ?>
                  <a href="{{$play['url']}}" target="_blank" rel="noreferrer noopener"> <img
                      src="{{asset($play->thumbnail)}}"/></a>


                  <h5>
                    @if (!$play->created_at->addDays(30)->isPast())
                      New
                    @endif
                  </h5>
                  {{--                                    <h6>Awesome art posters:</h6>--}}
                  <h4>{{$play->title}}</h4>
                  <p>{{$play->synopsis}}</p>
                  <div class="sharebtn">
                    <a href="javascript:void(0);" class="shbtn">Share</a>
                    <a class="heartShow-{{$play->id}}-play" style="">

                    </a>
                    @if(Auth::check() && $play->reactions->contains('user_id' , Auth::user()->id))
                      <a href="javascript:void(0);"><img
                          src="{{asset('front/img/Icons/liked.svg')}}"></a>
                    @else
                      <a href="javascript:void(0);" data-type="play" data-id="{{$play->id}}"
                         class="heart dd"><img src="{{asset('front/img/Icons/like.svg')}}"></a>
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
                        <a href="javascript:void(0);" class="share"
                           data-clipboard-text="{{$play->url}}"><i class="fa fa-share-alt"></i></a>
                      </li>
                      <li><a href="https://api.whatsapp.com/send?text={{$play->url}}"
                             class="whatsapp" target="_blank" rel="noreferrer noopener"><img
                            src="{{asset('front/img/wa.png')}}"></a></li>
                      <li><a href="https://www.facebook.com/sharer.php?u={{$play->url}}"
                             class="facebook" target="_blank" rel="noreferrer noopener"><i
                            class="fa fa-facebook" aria-hidden="true"></i></a></li>


                    </ul>
                  </div>
                </div>
              </div>
            @endforeach

            <div class="col-md-12">
              <a class="vmore plview" href="{{url($tabs[2]['slug'])}}">View More</a>
            </div>
          </div>
        </div>
        <!-- end .page-content -->
      </div>
    </div> <!-- end .container -->
  </div> <!-- end #page-content -->
  <div id="page-content4">
    <div class="container">
      <div class="row">
        <div class=" col-md-12 col-sm-12 page-content ">

          <div class="title-lines">
            <h3 class="mt0">FESTIVALS & EXHIBITIONS</h3>
          </div>
          <div class="success-stories-section ">

            @foreach($exhibitions as $exhibition)
              <div class="col-md-4 ">
                <div class="catitem4 b1">
                  @php $thumbnail = $exhibition->thumbnails->shuffle()->first(); @endphp
                  <?php
                  $str = $exhibition['url'];
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
                    <a href="{{$exhibition['url']}}" target="_blank" rel="noreferrer noopener"> <img
                        src="{{asset($thumbnail->image)}}"/></a>
                  @else
                    <a href="javascript:void(0)" class="iframecont">
                      <iframe height="200" width="100%" src="{{$exhibition['url']}}"
                              frameborder="0"
                              allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture"
                              allowfullscreen></iframe>
                    </a>
                    <div class="modal fontcss itempop1" role="dialog">
                      <div class="preloader"></div>
                      <div class="modal-dialog modal-lg modal-dialog-centered">
                        <!-- Modal content-->
                        <div class="modal-content"><a class="cancel mtcancel"><img
                              src="{{asset('front/img/close.png')}}"/></a>
                          <div class="modal-body para-blk">
                            <iframe height="500" width="100%" src="{{$exhibition['url']}}"
                                    frameborder="0"
                                    allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture"
                                    allowfullscreen></iframe>

                          </div>
                        </div>
                      </div>
                    </div>
                  @endif
                  <h5>
                    @if (!$discover->created_at->addDays(30)->isPast())
                      New
                    @endif
                  </h5>
                  {{--                                    <h6>Awesome art posters:</h6>--}}
                  <h4>{{$exhibition->title}}</h4>
                  <p>{{$exhibition->synopsis}}</p>
                  <div class="sharebtn">
                    <a href="javascript:void(0);" class="shbtn">Share</a>
                    <a class="heartShow-{{$exhibition->id}}-exhibition" style="">

                    </a>
                    @if(Auth::check() && $exhibition->reactions->contains('user_id' , Auth::user()->id))
                      <a href="javascript:void(0);"><img
                          src="{{asset('front/img/Icons/liked.svg')}}"></a>
                    @else
                      <a href="javascript:void(0);" data-type="exhibition"
                         data-id="{{$exhibition->id}}" class="heart dd"><img
                          src="{{asset('front/img/Icons/like.svg')}}"></a>
                      <ul id="emolist-exhibition-{{$exhibition->id}}" class="emolist">
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
                           data-clipboard-text="{{$exhibition->url}}"><i
                            class="fa fa-share-alt"></i></a>
                      </li>
                      <li><a href="https://api.whatsapp.com/send?text={{$exhibition->url}}"
                             class="whatsapp" target="_blank" rel="noreferrer noopener"><img
                            src="{{asset('front/img/wa.png')}}"></a></li>
                      <li><a href="https://www.facebook.com/sharer.php?u={{$exhibition->url}}"
                             class="facebook" target="_blank" rel="noreferrer noopener"><i
                            class="fa fa-facebook" aria-hidden="true"></i></a></li>


                    </ul>
                  </div>
                </div>
              </div>
            @endforeach


            <div class="col-md-12">
              <a class="vmore exbview" href="{{url($tabs[4]['slug'])}}">View More</a>
            </div>


          </div>

        </div> <!-- end .page-content -->


      </div>

    </div>
  </div>

  <div id="page-content5">
    <div class="container">
      <div class="row">
        <div class=" col-md-12 col-sm-12 page-content ">

          <div class="title-lines">
            <h3 class="mt0">WHAT'S HAPPENING AT THE GALLERY?</h3>
          </div>
          <div class="latest-jobs-section happen">


            <div class="flexslider">
              <ul class="slides">
                @foreach($campaigns as $campaigns)
                  <li>
                    <!--  <div class="row"> -->
                  <!--    <div class="col-md-6">
                                       <img src="{{asset($campaigns['image'])}}"/>
                                   </div>
                                   <div class="col-md-6">

                                       <div class="wrapbx">

                                       <h2>{{$campaigns['title']}}</h2>
                                       <div class="dt">{{$campaigns['start_date']}} - {{$campaigns['end_date']}} </div>
                                       <p>{{$campaigns['description']}}</p>
                                   </div>
                                   </div>
                               </div> -->
                    <table class="slidrwrap">
                      <tr>
                        <td><img src="{{asset($campaigns['image'])}}"/></td>
                        <td>
                          <h2>{{$campaigns['title']}}</h2>
                          <div class="dt">{{$campaigns['start_date']}}
                            - {{$campaigns['end_date']}} </div>
                          <p>{{$campaigns['description']}}</p>
                        </td>
                      </tr>
                    </table>
                  </li>
                @endforeach

              </ul>
            </div>


          </div>

        </div> <!-- end .page-content -->


      </div>

    </div>
  </div>

  <div id="itempop" class="modal fontcss" role="dialog">
    <div class="preloader"></div>
    <div class="modal-dialog modal-lg modal-dialog-centered">
      <!-- Modal content-->
      <div class="modal-content">
        <a class="cancel mtcancel"><img src="{{asset('front/img/close.png')}}"/></a>
        <div class="modal-body para-blk">

        </div>
      </div>
    </div>
  </div>
  <div class="modal emocheck" role="dialog">
    <div class="preloader"></div>
    <div class="modal-dialog modal-sm modal-dialog-centered">
      <!-- Modal content-->
      <div class="modal-content-new modal-content">
        <a class="okcancelbtn cancel"><img src="{{ asset('front/img/close.png') }}"></a>
        <div class="modal-body">
          <h6>Did you know?</h6>
          <p>By clicking onto the heart shape and selecting a reaction, you are adding the artwork into your
            Favourites that can be found in My Profile page.</p>
          <div>
            <input type="checkbox" name="dontshow" id="dontshow">
            <label for="dontshow">Do not show this again.</label>
          </div>
          <button class="okbtn">I'm aware now!</button>
        </div>
      </div>
    </div>
  </div>
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
    $(".iframecont").click(function () {
      $(this).next(".itempop1").modal({
        backdrop: false
      });
    })
    $(".mtcancel").click(function () {
      $(".itempop1").modal('hide')
      $(this).next(".modal-body").find('iframe').attr('src', $(this).next(".modal-body").find('iframe').attr('src'));
    })
    $(".masonry .mitem>div>img,.masonry .mitem h4").click(function () {
      $("#itempop .modal-body").empty();
      $("#itempop .modal-body").append($(this).parents('.mitem').html())
      $("#itempop").modal("show");
      $(".okcancelbtn").click(function () {
        $(".emocheck").modal("hide");
      })
    })
    $(".okbtn").click(function () {
      if ($("#dontshow").prop("checked") === true) {
        localStorage.setItem("dontshow", true);
      }
      $(".emocheck").modal("hide");
    })

    $('.heart').click(function (event) {
      //  event.stopPropagation();
      var session = "{{Auth::check()}}";
      var ele = $(this);
      if (session == '') {
        $("#firstloginmodal").modal("show");
      } else {

        if (localStorage.getItem("dontshow")) {

        } else {
          $(".emocheck").modal("show");
        }


        $("#emolist-" + ele.attr("data-type") + "-" + ele.attr("data-id")).slideToggle();
        $(".shlist").hide();

      }

    });
    $('.shbtn').click(function (event) {
      // event.stopPropagation();
      var session = "{{Auth::check()}}";
      var ele = $(this);
      // if (session == '')
      // {
      // $("#firstloginmodal").modal("show");
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
      var reaction_type = parent.prev(".heart").attr('data-type');
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
            $(".heartShow-" + reaction_id + "-" + reaction_type + "").append('<img src="{{url("front/img/Icons/liked.svg")}}" style="height: -16px !important" />');
          } else {

          }
        },
        error: function () {
          console.log('error reacting');
        }
      });
    })

    $(document).ready(function () {
      $('.flexslider').flexslider({
        animation: "slide",
        animationLoop: true,
        pauseOnHover: true,
        touch: true,
        directionNav: true,
        controlNav: false,
        prevText: '&#xf053;',
        nextText: '&#xf054;',
      });
      $(".login").on('click', function () {
        $("#login-modal1").modal("show");
      })
      $(".forgtlink").on('click', function () {
        $(".modal").modal("hide");
        $("#forgot-modal").modal("show");
      })

      $(".cancel").click(function () {
        $(".modal").modal("hide");
      });
      $(".t1").click(function () {
        $(".tab1sec").show();
        $(".tab2sec").hide();
        $(this).addClass("active").siblings().removeClass("active");
      })
      $(".t2").click(function () {
        $(".tab2sec").show();
        $(".tab1sec").hide();
        $(this).addClass("active").siblings().removeClass("active");
      })
    })
  </script>
@endsection

