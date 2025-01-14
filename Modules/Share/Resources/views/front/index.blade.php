@extends('layouts.master')

@section('style')

  <style type="text/css">

    .emolist {
      display: none;
      height: 23px;
      margin-top: -60px;
    }

    .emolist li {
      list-style: none;
      float: right;
      margin: 0px 3px;
      font-size: 18px;
    }

    .emolist li:hover {
      transform: rotate(360deg);
      transition: 0.6s;
    }

    span.msg {
      font-size: 15px;
      display: block;
      text-align: left;
      color: #0ba0d8;
      margin-top: -29px;
      padding-left: 10px;
    }

    .tab1sec, .tab2sec {
      display: none;
    }

    .tab1sec.active, .tab2sec.active {
      display: block
    }

    .centernav {
      top: 70px;
      position: fixed;
      left: 0;
      right: 0;
      z-index: 9;
    }

    .modal-body .sharebtn {
      display: none;
    }

    .shlist li {
      margin-top: -10px !important;
    }

    .shareSearch .col-md-1 {
      padding: 7px;
    }

    a.whatsapp img {
      margin-top: -2px !important;
    }

    .shlist i.fa.fa-facebook {
      margin-top: 14px;
    }

    .shlist i.fa.fa-share-alt {
      margin-top: 15px;
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
      margin-top: 47px !important;
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


    .grid, .grid1 {
      max-width: 1200px;
      counter-reset: mitem;
      margin-top: 340px;
    }

    /* clearfix */
    .grid:after, .grid1:after {
      content: '';
      display: block;
      clear: both;
    }

    .mitem {
      width: calc(33.33% - 30px);
      margin: 15px;
      height: auto;
      float: left;
    }

    @media (max-width: 769px) {
      .mitem {
        width: calc(50% - 30px);
      }

      .grid, .grid1 {
        margin-top: 0px;
      }
    }
  </style>

@endsection

@section('content')


  @include('layouts.navbar')

  <main style="background-image:url({{asset('front/img/sh1bg.png')}})">
    <div class="contwrap sh" style="background-image:url('{{asset('front/img/shbottom1.png')}}')">
      <div id="create-content1" class="mt125 shbg">
        <p class="share-art">Share your children’s creations with GalleryKids! <br/>Submit artworks by your
          children to <a href="mailto:gallerykids@nationalgallery.sg"> <u>gallerykids@nationalgallery.sg</u>.</a>
        </p>
        <div class="container">
          <div class="row">
            <div class=" col-md-12 col-sm-12 page-content ">

              <form class="shareSearch col-md-12">
                <div class="col-md-4">
                  <i class="fa fa-search"></i>
                  <input type="search" placeholder="Search by title or description"
                         class="form-control searchin" name="search"/>
                  <span id="clearBtn1" class="clearBtn">X</span>
                </div>

                <div class="galwrap">
                  <select class="form-control selectGallery" name="type">
                    <option value="kids">KIDS' GALLERY</option>
                    <option value="gallery">GALLERY'S PICKS</option>
                  </select>
                </div>
                <!--                              08-12-2020  category static to dynamic-->
                <!--                            <div class="col-md-2 catwrap">
                                                <select class="form-control selectCategory" name="category">
                                                    <option value="" selected="">All</option>
                                                    <option value="27">Curator's Pick</option>
                                                </select>
                                            </div>-->
                <div class="col-md-2 catwrap">
                  <select class="form-control selectCategory" name="category">
                    <option value="" selected="">All</option>
                    @foreach($categories as $category)
                      <option value="{{$category['id']}}">{{$category['name']}}</option>
                    @endforeach
                  </select>
                </div>
                <div class="col-md-3">
                  <select class="form-control sortselect" name="sort">
                    <option value="" selected="">Sort by</option>
                    <option value="AtoZ">A to Z</option>
                    <option value="ZtoA">Z to A</option>
                    <option value="Old">Old to New</option>
                    <option value="New">New to Old</option>
                  </select>
                </div>
                <div class="col-md-1">
                  <button type="submit" class="searchsbmit"><i class="fa fa-search"></i></button>

                </div>
              </form>
              <!--   <ul class="tabshare">
                      <li class="active t1">KIDS GALLERY</li>
                      <li class="t2">GALLERY'S PICKS</li>
                  </ul> -->


              <div class="latest-jobs-section tab1sec active grid">
                
				@foreach($my_shares as $m_share)

                  @php $thumbnail = $m_share->thumbnails->shuffle()->first(); @endphp

                  <div class="mitem">
                    <div class=" ">
                      <img src="{{asset($thumbnail->image)}}"/>
                      <div class="hditem">
						
						<h4>{{$m_share->name}}</h4>
                        <?php
                        //$dateOfBirth = $m_share['user']['year_of_birth'];
                        //$years = \Carbon\Carbon::parse( '' . $m_share['user']['year_of_birth'] . '-01-01' )->age;
                        ?>
                        <p>
                          @if($m_share['age'])
                            {{$m_share['age']}} Years Old<br/>
                          @else
                            {{$years}} Years Old<br/>
                          @endif
						  </p>
					
                        
						  
                      <!--  <div class="sharebtn">
                                             <a href="javascript:void(0);"  class="shbtn">Share</a>
                                             <a class="heartShow-{{$m_share->id}}" style="display: none">
                                                 <img src="{{asset('front/img/Icons/liked.svg')}}">
                                             </a>
                                             @if(Auth::check() && $m_share->reactions->contains('user_id' , Auth::user()->id))
                        <a href="javascript:void(0);"><img src="{{asset('front/img/Icons/liked.svg')}}"></a>
                                             @else
                        <a href="javascript:void(0);" data-type="share" data-id="{{$m_share->id}}" class="heart dd"><img src="{{asset('front/img/Icons/like.svg')}}"></a>
                                             <ul id="emolist-share-{{$m_share->id}}" class="emolist">
                                                 <li val="&#128561;">&#128561;</li>
                                                 <li val="&#128546;">&#128546;</li>
                                                 <li val="&#129322;">&#129322;</li>
                                                 <li val="&#128526;">&#128526;</li>
                                             </ul>
                                             <span class="msg"></span>
                                             @endif
                        <ul class="shlist">
                            <li>
                                <a href="javascript:void(0);"  class="share" data-clipboard-text="{{route('showShare',$m_share['id'])}}"><i class="fa fa-share-alt"></i></a>
                                                 </li>

                                                 <li> <a  href="https://api.whatsapp.com/send?text={{route('showShare',$m_share['id'])}}" class="whatsapp" target="_blank"><img src="{{asset('front/img/wa.png')}}"></a></li>


                                                 <li><a  href="https://www.facebook.com/sharer.php?u={{route('showShare',$m_share['id'])}}" class="facebook" target="_blank"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>


                                             </ul>
                                         </div> -->
                      </div>
                    </div>
                  </div>

                @endforeach
              </div>

              <div class="latest-jobs-section tab2sec grid1">
                @foreach($admin_shares as $a_share)

                  <div class="mitem">
                    <div class=" ">
                      <img src="{{$a_share['image']}}"/>
                      <div class="hditem adminPoupop">
                        <div class="boxconent">
                          <p> {{$a_share['ARTIST']}}</p>
                          <p><i> {{$a_share['TITLE']}}</i></p>
                          <p>{{$a_share['DATE_OF_ART_CREATED']}}</p>
                        </div>
                        <div class="modalcontent">
                          <p> {{$a_share['ARTIST']}}</p>
                          <p><i> {{$a_share['TITLE']}}</i></p>
                          <p>{{$a_share['DATE_OF_ART_CREATED']}}</p>

                          {{--                                            <p> {{$a_share['CLASSIFICATION']}}</p>--}}
                          <p>{{$a_share['medium']}}, {{$a_share['dimension']}}</p>
                          <p>{{$a_share['CREDITLINE']}}</p>

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
                                <a href="javascript:void(0);" class="share"  data-clipboard-text="http://165.22.209.85/blog/share/{{$a_share['id']}}"><i class="fa fa-share-alt"></i></a>
                                                 </li>

                                                 <li> <a  href="https://api.whatsapp.com/send?text=http://165.22.209.85/blog/share/{{$a_share['id']}}" class="whatsapp" target="_blank"><img src="{{asset('front/img/wa.png')}}"></a></li>


                                                 <li><a  href="https://www.facebook.com/sharer.php?u=http://165.22.209.85/blog/share/{{$a_share['id']}}" class="facebook" target="_blank"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>




                                             </ul>
                                         </div> -->
                      </div>
                    </div>
                  </div>
                @endforeach
              </div>
            </div>
          </div>
        </div>
        <div class="bottomheight"></div>
      </div>
    </div>
  </main>
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

@endsection

@section('script')


  <script src="{{asset('front/plugins/clipboard.min.js')}}"></script>
  <script src="{{asset('front/js/imagesloaded.pkgd.js')}}"></script>
  <script src="{{asset('front/js/masonry.pkgd.js')}}"></script>
  <script>


    var getUrlParameter = function getUrlParameter(sParam) {
      var sPageURL = window.location.search.substring(1),
        sURLVariables = sPageURL.split('&'),
        sParameterName,
        i;
      for (i = 0; i < sURLVariables.length; i++) {
        sParameterName = sURLVariables[i].split('=');
        if (sParameterName[0] === sParam) {
          if (sParameterName[1].split("+")[0]) {
            sParameterName[1] = sParameterName[1].replaceAll("+", " ");
            return sParameterName[1] === undefined ? true : decodeURIComponent(sParameterName[1]);
          } else {
            return sParameterName[1] === undefined ? true : decodeURIComponent(sParameterName[1]);
          }


        }
      }
    };

    $(document).ready(function () {
// $('.selectCategory').hide();

      if (getUrlParameter('search')) {
        var search = getUrlParameter('search');
        $(".searchin").val(search)
      } else {
        $(".searchin").val("")
      }

      if (getUrlParameter('type')) {
        var type = getUrlParameter('type');
        $(".selectGallery").val(type)

        if (type === 'kids') {
          $(".tab1sec").addClass("active").siblings().removeClass("active");
          $(".catwrap").hide();
          $(".galwrap").addClass("col-md-4");
        } else {
          $(".tab2sec").addClass("active").siblings().removeClass("active");
          $(".catwrap").show();
          $(".galwrap").addClass("col-md-2");
        }
      } else {
        $(".selectGallery").val("kids");
        $(".catwrap").hide();
        $(".galwrap").addClass("col-md-4");
      }

      if (getUrlParameter('sort')) {
        var sort = getUrlParameter('sort');
        $(".sortselect").val(sort)
      } else {
        $(".sortselect").val("")
      }


      if (getUrlParameter('category')) {
        var category = getUrlParameter('category');
        $(".selectCategory").val(category)
      } else {
        $(".selectCategory").val("")
      }


      $('.grid').masonry({
        itemSelector: '.mitem',
        horizontalOrder: true
      });

      $('.grid').imagesLoaded(function () {
        $('.grid').masonry({
          itemSelector: '.mitem',
          horizontalOrder: true
        });
      });


      $('.grid1').masonry({
        itemSelector: '.mitem',
        horizontalOrder: true
      });


      $("#clearBtn1").click(function () {
        $(".searchin").focus();
        $(".searchin").val("");
      })


      $(".mitem>div>img,.mitem h4").click(function () {
        $("#itempop .modal-body").empty();
        $("#itempop .modal-body").append($(this).parents('.mitem').html())
        $(".medium").show();
        $("#itempop").modal("show");
      })
      $(".medium").hide();
      $(".selectGallery").change(function () {
        console.log($(this).val());
        var type = $(this).val();
        // $('.selectCategory').hide();
        if (type == 'gallery') {

          $(".catwrap").show();
          $(".galwrap").addClass("col-md-2");
        } else {

          $(".catwrap").hide();
          $(".galwrap").addClass("col-md-4").removeClass("col-md-2");
        }

        $(".tab1sec").toggleClass('active');
        $(".tab2sec").toggleClass('active');


        $('.grid').masonry({
          itemSelector: '.mitem',
          horizontalOrder: true
        });


        $('.grid1').masonry({
          itemSelector: '.mitem',
          horizontalOrder: true
        });


      })
    })

    var clipboard = new ClipboardJS('.share');
    clipboard.on('success', function (e) {
      alert("Link Copied to clipboard");
    });
    clipboard.on('error', function (e) {
      console.log(e);
    });
    $('.heart').click(function (event) {

      event.stopPropagation();
      var session = "{{Auth::check()}}";
      var ele = $(this);
      if (session == '') {
        $("#firstloginmodal").modal("show");
      } else {
        $("#emolist-" + ele.attr("data-type") + "-" + ele.attr("data-id")).slideToggle();
      }

    });
    // $(".sharebtn").click(function(event){
    //    // event.stopPropagation();
    // })
    $('.shbtn').click(function (event) {

//event.stopPropagation();

// var session = "{{Auth::check()}}";
//         var ele = $(this);
//         if (session == '')
// {
// $("#firstloginmodal").modal("show");
// }
// else
// {
      $(this).siblings(".shlist").slideToggle();
      $(".emolist").hide();
      // }
    });
    $('#poupoCall').click(function () {
      $("#login-modal1").modal("show");
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
            $(".heartShow-" + reaction_id + "").show();
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
