<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">

  <title>GalleryKids! | National Gallery Singapore</title>
  <link rel="shortcut icon" href="{{asset('front/img/fevicon.png')}}" type="image/x-icon">
  <meta name="description"
        content="GalleryKids! is a website for children by National Gallery Singapore. With the online activities on GalleryKids!, your child will learn about art through playing games, creating art and asking questions.">
  <meta name="keywords"
        content="GalleryKids! , National Gallery , National Gallery Singapore,Playing Games,Art & Craft">
  <meta property="og:image" content="{{asset('front/img/gallerylogo.png')}}">
  <meta property="og:image:type" content="image/png">
  <meta property="og:image:width" content="512">
  <meta property="og:image:height" content="512">
  <meta http-equiv="Content-Security-Policy"
        content="default-src * 'self'; style-src * 'unsafe-inline'; script-src 'self' 'unsafe-inline' https://www.googletagmanager.com https://connect.facebook.net https://www.google-analytics.com  https://s.ytimg.com http://www.youtube.com; img-src * data: 'self'; connect-src * 'self'; object-src 'none'; frame-src *;">
  <link rel="stylesheet" href="{{asset('front/css/bootstrap.min.css')}}">
  <link rel="stylesheet" href="{{asset('front/css/bootstrap.min.css')}}">
  <link rel="stylesheet" href="{{asset('front/css/bootstrap.css')}}">

  <link rel="stylesheet" href="{{asset('front/css/font-awesome.min.css')}}">
  <link rel="stylesheet" href="{{asset('front/css/flexslider.css')}}">
<!--     <link rel="stylesheet" href="{{asset('front/css/style.css')}}">
        -->
  <link rel="stylesheet" href="{{asset('front/css/style.css')}}">
  <link rel="stylesheet" href="{{asset('front/css/responsive.css')}}">
<style>
.tombol {
    background: #40b1d7;
    padding: 15px !important;
    height: 37px !important;
    margin-top: 16px !important;
    line-height: 36px !important;
    color: #fff !important;
    font-family: 'akz',sans-serif !important;
    font-weight: 500 !important;
    font-size: 16px !important;
    padding-top: 0px !important;
    border-radius: 28px !important;
    border-bottom: 0px solid transparent !important;
}

.tombol:hover {
    box-shadow: 1px 1px 4px 2px rgb(64 177 215);
}

.memberbtn {
    display: flex;
    flex-wrap: wrap;
}

.memberbtn button.btn.btn-login {
   padding: 10px 31.5px;
   width: auto;
}
</style>
@yield('style')

@if (app()->environment('production'))
  <!-- Google Tag Manager -->
    <script>(function (w, d, s, l, i) {
        w[l] = w[l] || [];
        w[l].push({
          'gtm.start':
            new Date().getTime(), event: 'gtm.js'
        });
        var f = d.getElementsByTagName(s)[0],
          j = d.createElement(s), dl = l != 'dataLayer' ? '&l=' + l : '';
        j.async = true;
        j.src =
          'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
        f.parentNode.insertBefore(j, f);
      })(window, document, 'script', 'dataLayer', 'GTM-T6FV5T');</script>
    <!-- End Google Tag Manager -->
  @endif
</head>
<body>
@if (app()->environment('production'))
  <!-- Google Tag Manager (noscript) -->
  <noscript>
    <iframe src="https://www.googletagmanager.com/ns.html?id=GTM-T6FV5T" height="0" width="0"
            style="display:none;visibility:hidden"></iframe>
  </noscript>
  <!-- End Google Tag Manager (noscript) -->
@endif
<div id="main-wrapper">
  <header id="header" class="header-style-1">

    <div class="header-nav-bar hide-in-mob">
      <div class="container" style="min-width:1200px">

        <!-- Logo -->
        <div class="css-table logo">
          <div class="css-table-cell">
            <a href="https://www.nationalgallery.sg" target="_blank" rel="noreferrer noopener">
              <img src="{{asset('front/img/kidslogo2.png')}}" alt="" class="mainlogoimg"
            </a> <!-- end .logo -->
            <a href="{{url('/')}}" class="gallogo"><img
                src="{{asset('front/img/Gallery Kids-LogoNew.png')}}" class="gallogoimg" alt=""></a>
          </div>
        </div>

        <!-- Mobile Menu Toggle -->
        <a href="#" id="mobile-menu-toggle"><span></span></a>

        <!-- Primary Nav -->
        <nav>
          @auth
            <ul class="primary-nav">
              <li class="has-submenu prddli">
                <a href="javascript:void(0);"><span
                    class="tw">Welcome, {{Auth::user()->first_name}} {{Auth::user()->last_name}}</span>

                  <!--                                                    future functionality disabled for now only-->
                <!--  <?php
                if ( Auth::user()->isStudent() ) {
                  $amout  = $submitManage = Modules\Points\Entities\PointManage::whereUserId( Auth::user()['id'] )->orderBy( 'created_at', 'DESC' )->get()->sum( 'points' );
                  $points = $amout;
                  if ( $points <= 500 ) {
                    $current_level = intdiv( $points, 50 );
                    $startLabel    = $current_level;
                    $endLabel      = $current_level + 1;
                    $points        = ( $points - ( $current_level * 50 ) );
                  } elseif ( $points <= 2000 ) {
                    $current_level = 10 + intdiv( ( $points - 500 ), 75 );
                    $startLabel    = $current_level;
                    $endLabel      = $current_level + 1;
                    $points        = ( ( $points - 500 ) - ( $current_level - 10 ) * 75 );
                  } elseif ( $points <= 3000 ) {
                    $current_level = 30 + intdiv( ( $points - 2000 ), 100 );
                    $startLabel    = $current_level;
                    $endLabel      = $current_level + 1;
                    $points        = ( ( $points - 2000 ) - ( $current_level - 30 ) * 100 );
                  } elseif ( $points > 3000 ) {
                    $current_level = 40 + intdiv( ( $points - 3000 ), 125 );
                    $startLabel    = $current_level;
                    $endLabel      = $current_level + 1;
                    $points        = ( ( $points - 3000 ) - ( $current_level - 40 ) * 125 );
                  }
                  $level = 'Level ' . $startLabel . ' |';
                } else {
                  $ids       = [];
                  $user      = Auth::user();
                  $childrens = $user->children;
                  foreach ( $childrens as $children ) {
                    $ids[] = $children['id'];
                  }
                  $amout = Modules\Points\Entities\PointManage::whereIn( 'user_id', $ids )->orderBy( 'created_at', 'DESC' )->get()->sum( 'points' );
                  $level = '';
                }
                ?>-->

                <!--                                                    <div>{{$level}}  {{$amout}} Points</div>-->
                </a>
                <ul>
                  @if (Auth::user()->isAdmin())
                  @else
                    <li><a href="{{route('user.profile')}}">My Profile</a></li>
                @endif
                <!--  <li><a href="{{url($tabs[4]['slug'])}}">{{$tabs[4]['display_name']}}</a></li> -->
                  <li>
                    {{--                                            <form method="POST" id="logout-form" action="{{route('logout')}}">--}}
                    {{--                                                @csrf--}}
                    {{--                                            </form>--}}
                    {{--                                            <a href="#" onclick="event.preventDefault();--}}
                    {{--                                                    document.getElementById('logout-form').submit();">Logout</a>--}}
                    <a href="{{route('sso-logout')}}">Logout</a>
                  </li>
                </ul>
              </li>
              <li>

                <a href="javascript:void(0)" class="findmore">About GalleryKids! Membership</a>
              </li>
            </ul>
          @endauth
          @guest
            <ul class="primary-nav">

              {{--                                <li><a class="btn btn-default btn-block login-btn login1" href="#">Login</a></li>--}}
              <li><a class="btn btn-default btn-block login-btn login2" href="{{ route('sso-login') }}">Login</a>
              </li>
              {{--                                <li><a class="btn btn-default btn-block login-btn register" href="#">Be a member today!</a></li>--}}
              <li>
                <a
                  class="btn btn-default btn-block login-btn register2"
                  href="{{ route('sso-login', ['screen_hint' => 'signup', 'action'=>'signup']) }}"
                >Be a member today!</a>
              </li>
              <!-- <li><a class="btn btn-default btn-block login-btn login" href="#">Login</a></li> -->

              <li>

                <a href="javascript:void(0)" class="findmore">About GalleryKids! Membership</a>

              </li>
              <li><a href="https://web.nationalgallery.sg/pwa/#/journeys-detail?id=1118" class="tombol" style="display:none">Add to Art Journey</a></li>
               <!-- <li><a class="btn btn-default btn-block login-btn registernow" 
href="https://web.nationalgallery.sg/pwa/#/journeys-detail?id=1118">Add to Art
Journey</a></li>-->
            </ul>
          @endguest
        </nav>
      </div> <!-- end .container -->

      <div id="mobile-menu-container" class="container">
        <div class="login-register"></div>
        <div class="menu"></div>
      </div>
    </div> <!-- end .header-nav-bar -->
    <div class="mobile-menu show-in-mob">
      <div class="">
        <!-- Logo -->
        <div class="css-table logo">
          <div class="css-table-cell">
            <a href="javascript:void(0)" class="menuleft"><img
                src="{{asset('front/img/Icons/nav_menu.png')}}"/></a>
            <a href="https://www.nationalgallery.sg" target="_blank" class="logocenter"
               rel="noreferrer noopener">
              <img src="{{asset('front/img/kidslogo2.png')}}" alt="" style="height: 42px;">
            </a>
            <a href="{{url('/')}}" class="menuright"><img
                src="{{asset('front/img/Gallery Kids-LogoNew.png')}}"/></a>
          </div>
          <div id="mobile-menu">
            <a class="closeMenu"><img src="{{asset('front/img/closeWhite.png')}}"/></a>
            <div class="col-xs-12">

              @if(Auth::check())

                <div class="col-xs-4">
                  @if(Auth::user()['image'])
                    <img src="{{asset(Auth::user()['image'])}}" class="userMenuImg"/>
                  @else
                    <img src="{{asset('front/img/defaultpr.png')}}" class="userMenuImg"/>
                  @endif

                </div>
                <div class="col-xs-8">
                  <a href="{{route('user.profile')}}" class="editprMenu">My Profile</a>
                </div>
                <div class="col-xs-12">
                  <h4>Welcome, {{Auth::user()->first_name}} {{Auth::user()->last_name}}</h4>
                <!--                                                    <p>{{$level}}  {{$amout}} Points</p>-->
                </div>
              @else


                <div class="col-xs-12 dfelx">
                <a class="btn btn-default btn-block login-btn registernow" href="https://web.nationalgallery.sg/pwa/#/journeys-detail?id=1118" style="display:none">Add to Art Journey</a>
                  <a
                    class="btn btn-default btn-block login-btn registernow"
                    href="{{ route('sso-login', ['screen_hint' => 'signup', 'action'=>'signup']) }}"
                  >Be a member today!</a>
                  <a class="btn btn-default btn-block login-btn login1"
                     href="{{ route('sso-login') }}">Login</a>
                </div>
              @endif


            </div>
            <?php $tabs = Modules\Setting\Entities\Tab::get(); ?>
            <div class="col-xs-12">
              <ul class="menuist">
                <li class="me1"><a href="{{url($tabs[0]['slug'])}}">CREATE</a></li>
                <li class="me2"><a href="{{url($tabs[1]['slug'])}}">SHARE</a></li>
                <!--<li class="me3"><a href="{{url($tabs[3]['slug'])}}">EXPLORE</a></li>-->
                <li class="me3"><a href="{{ route('/explore/new') }}">EXPLORE</a></li>
                <!--<li class="me4"><a href="{{url($tabs[2]['slug'])}}">PLAY</a></li>-->
                <li class="me4"><a href="{{ route('/play/new') }}">PLAY</a></li>
                <!--<li class="me5"><a href="{{url($tabs[4]['slug'])}}">FESTIVALS & EXHIBITIONS</a></li>-->
                <li class="me5"><a href="{{route('/festivals/new')}}">FESTIVALS & EXHIBITIONS</a></li>
                <li class="me6"><a href="{{route('keppelCentre')}}">KEPPEL CENTRE FOR ART EDUCATION</a>
                </li>
              </ul>
              <!--  <a href="javascript:void(0)" class="findmore">About GalleryKids! Membership</a> -->
            </div>

            @if(Auth::check())
              <a href="{{route('sso-logout')}}" class="logoutlink">Logout</a>
            @endif
          </div>
        </div>
      </div>
    </div>
  </header> <!-- end #header -->
  @if(\Request::route()->getName() != 'user.profile')
  @endif
  @yield('alert')
  @yield('content')
  <footer id="footer">

    <div class="copyright">
      <div class="container">

        <div class="footwrap">
          <ul class="footer-social">
            <li><a href="https://www.facebook.com/nationalgallerysg" target="_blank"
                   rel="noreferrer noopener"><img
                  src="{{asset('front/img/Icons/social-media/facebook.svg')}}"/></a></li>
            <li><a href="https://www.instagram.com/nationalgallerysingapore/" target="_blank"
                   rel="noreferrer noopener"><img src="{{asset('front/img/Icons/social-media/logo.svg')}}"/></a>
            </li>
            <li><a href="https://twitter.com/natgallerysg" target="_blank" rel="noreferrer noopener"><img
                  src="{{asset('front/img/Icons/social-media/twitter.svg')}}"/></a></li>
            <li><a href="https://www.youtube.com/user/nationalgallerysg" target="_blank"
                   rel="noreferrer noopener"><img
                  src="{{asset('front/img/Icons/social-media/youtube.svg')}}"/></a></li>
            <li>
              <a
                href="https://www.tripadvisor.com.sg/Attraction_Review-g294265-d8077179-Reviews-National_Gallery_Singapore-Singapore.html"
                target="_blank" rel="noreferrer noopener"><img
                  src="{{asset('front/img/Icons/social-media/tripadvisor.svg')}}"/></a></li>
          </ul>
        </div>

      </div>
    </div>
    <div class="bootom-footer">
      <div class="col-md-8 col-xs-12">
        <ul>
          <li><a href="javascript:void(0)" data-toggle="modal" data-target="#grownups">FOR GROWN-UPS</a></li>
          <li><a href="javascript:void(0)" data-toggle="modal" data-target="#forsafety">FOR SAFETY</a></li>
          <li><a href="javascript:void(0)" data-toggle="modal" data-target="#termsandcondition">TERMS &
              CONDITIONS</a></li>
          <li><a href="https://www.nationalgallery.sg/privacy-policy" target="_blank"
                 rel="noreferrer noopener">PRIVACY & COOKIES</a></li>
          <li><a href="mailto:gallerykids@nationalgallery.sg" target="_blank" rel="noreferrer noopener">CONTACT
              US</a></li>
        </ul>
      </div>
      <div class="col-md-4 col-xs-12">
        <p>&copy; 2020 ALL RIGHTS RESERVED</p>
      </div>
    </div>
  </footer> <!-- end #footer -->
  <a class="gotoTop" href="javascript:void(0)"><i class="fa fa-arrow-up"></i></a>
</div> <!-- end #main-wrapper -->
<div id="grownups" class="modal fontcss" role="dialog">
  <div class="preloader"></div>
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <!-- Modal content-->
    <div class="modal-content">
      <a class="cancel mtcancel"><img src="{{asset('front/img/close.png')}}"/></a>
      <div class="modal-body para-blk">
        <h3 class="poptitle">For Grown Ups</h3>
        <p>GalleryKids! is a website for children by National Gallery Singapore. With the online activities on
          GalleryKids!, your child will learn about art through playing games, creating art and asking
          questions.</p>

        <p>Some questions can be more difficult than others. Throughout the history of art, artists have been
          inspired by a diversity of topics and subject matter. As such, some images from our collection may
          require a grown-up's guidance for meaningful interpretation and appreciation.</p>

        <p>For example, artists often use the human body to study anatomy. The nude is an important genre in art
          as it celebrates the human body as a symbol of beauty, freedom and strength. When you come across
          nudity in art, take the opportunity to discuss topics such as ideals, symbols and representations
          with your child.
        </p>

      </div>
    </div>
  </div>
</div>
<div id="forsafety" class="modal fontcss" role="dialog">
  <div class="preloader"></div>
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <!-- Modal content-->
    <div class="modal-content">
      <a class="cancel mtcancel"><img src="{{asset('front/img/close.png')}}"/></a>
      <div class="modal-body para-blk">
        <h3 class="poptitle">For Your Safety</h3>
        <p>We are doing our best to keep GalleryKids! a safe space for children and families. That’s why
          we look over every submission before it is published. Unless you agree to share your submissions
          publicly, do not submit:
        <p>
        <ul>
          <li> Images of yourself and your child</li>
          <li> Personal information (such as full name, phone number or home address)</li>
          <li>Any other private images or information.</li>
        </ul>
        <p>Your online safety is of utmost importance. Learn more about our online safety measures: <a
            href="javascript:void(0)" data-toggle="modal" data-target="#termsandcondition">Terms and
            Conditions</a> and the <a href="https://www.nationalgallery.sg/privacy-policy" target="_blank"
                                      rel="noreferrer noopener">Privacy Policy</a>.</p>

      </div>
    </div>
  </div>
</div>
<div id="termsandcondition" class="modal fontcss" role="dialog">
  <div class="preloader"></div>
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <!-- Modal content-->
    <div class="modal-content">
      <a class="cancel mtcancel"><img src="{{asset('front/img/close.png')}}"/></a>
      <div class="modal-body para-blk">
        <h3 class="poptitle">GalleryKids! Submissions ("Submissions") Terms and Conditions</h3>
        <p>The Gallery reserves the right and retains sole discretion over which Submissions it will
          publish. </p>

        <p>Participants agree that all Submissions are original and do not infringe on any third-party copyright
          or intellectual property. Participants are fully liable and responsible for their Submissions and
          for obtaining all necessary third-party permissions before submitting to the Gallery.</p>

        <p>Participants agree to grant the Gallery a non-exclusive, worldwide, perpetual, royalty-free right to
          reproduce, modify, edit, publish and distribute the Submissions digitally or physically and on any
          platforms including but not limited to the GalleryKids! Website.</p>
      </div>


    </div>
  </div>
</div>
<div id="privacypop" class="modal fontcss" role="dialog">
  <div class="preloader"></div>
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <!-- Modal content-->
    <div class="modal-content">
      <a class="cancel mtcancel"><img src="{{asset('front/img/close.png')}}"/></a>
      <div class="modal-body para-blk">
        <h3 class="poptitle">Privacy & Cookies</h3>
        <p>lorem ipsum data lorem ipsum data lorem ipsum data lorem ipsum data lorem ipsum data lorem ipsum data
          lorem ipsum data lorem ipsum data lorem ipsum data lorem ipsum data lorem ipsum data lorem ipsum
          data lorem ipsum data lorem ipsum data lorem ipsum data lorem ipsum data lorem ipsum data lorem
          ipsum data lorem ipsum data </p>

        <p>lorem ipsum data lorem ipsum data lorem ipsum data lorem ipsum data lorem ipsum data lorem ipsum data
          lorem ipsum data lorem ipsum data lorem ipsum data lorem ipsum data lorem ipsum data lorem ipsum
          data lorem ipsum data lorem ipsum data lorem ipsum data lorem ipsum data lorem ipsum data lorem
          ipsum data lorem ipsum data </p>

        <p>lorem ipsum data lorem ipsum data lorem ipsum data lorem ipsum data lorem ipsum data lorem ipsum data
          lorem ipsum data lorem ipsum data lorem ipsum data lorem ipsum data lorem ipsum data lorem ipsum
          data lorem ipsum data lorem ipsum data lorem ipsum data lorem ipsum data lorem ipsum data lorem
          ipsum data lorem ipsum data </p>

        <p>lorem ipsum data lorem ipsum data lorem ipsum data lorem ipsum data lorem ipsum data lorem ipsum data
          lorem ipsum data lorem ipsum data lorem ipsum data lorem ipsum data lorem ipsum data lorem ipsum
          data lorem ipsum data lorem ipsum data lorem ipsum data lorem ipsum data lorem ipsum data lorem
          ipsum data lorem ipsum data </p>

      </div>
    </div>
  </div>
</div>
<div id="contactpop" class="modal fontcss" role="dialog">
  <div class="preloader"></div>
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <!-- Modal content-->
    <div class="modal-content">
      <a class="cancel mtcancel"><img src="{{asset('front/img/close.png')}}"/></a>
      <div class="modal-body para-blk">
        <h3 class="poptitle">Contact Us</h3>
        <p>lorem ipsum data lorem ipsum data lorem ipsum data lorem ipsum data lorem ipsum data lorem ipsum data
          lorem ipsum data lorem ipsum data lorem ipsum data lorem ipsum data lorem ipsum data lorem ipsum
          data lorem ipsum data lorem ipsum data lorem ipsum data lorem ipsum data lorem ipsum data lorem
          ipsum data lorem ipsum data </p>

        <p>lorem ipsum data lorem ipsum data lorem ipsum data lorem ipsum data lorem ipsum data lorem ipsum data
          lorem ipsum data lorem ipsum data lorem ipsum data lorem ipsum data lorem ipsum data lorem ipsum
          data lorem ipsum data lorem ipsum data lorem ipsum data lorem ipsum data lorem ipsum data lorem
          ipsum data lorem ipsum data </p>

        <p>lorem ipsum data lorem ipsum data lorem ipsum data lorem ipsum data lorem ipsum data lorem ipsum data
          lorem ipsum data lorem ipsum data lorem ipsum data lorem ipsum data lorem ipsum data lorem ipsum
          data lorem ipsum data lorem ipsum data lorem ipsum data lorem ipsum data lorem ipsum data lorem
          ipsum data lorem ipsum data </p>

        <p>lorem ipsum data lorem ipsum data lorem ipsum data lorem ipsum data lorem ipsum data lorem ipsum data
          lorem ipsum data lorem ipsum data lorem ipsum data lorem ipsum data lorem ipsum data lorem ipsum
          data lorem ipsum data lorem ipsum data lorem ipsum data lorem ipsum data lorem ipsum data lorem
          ipsum data lorem ipsum data </p>

      </div>
    </div>
  </div>
</div>
<div id="login-modal" class="modal" role="dialog">
  <div class="preloader"></div>
  <div class="modal-dialog  modal-dialog-centered">
    <!-- Modal content-->
    <div class="modal-content">
      <a class="cancel">X</a>
      <div class="modal-body login-blk">
        <img src="{{asset('front/img/kidslogo2.png')}}" alt="">
        <h2>Login</h2>
        <ul>
          <li>Create</li>
          <li>Share</li>
          <li>Play</li>
        </ul>
        <form method="POST" action="{{route('login')}}">
          @csrf
          <input type="text" name="username" value="{{old('username')}}" maxlength="30"
                 placeholder="Enter username"/>
          @error('username')
          <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
          @enderror
          <input type="password" name="password" placeholder="Enter Your Password" autocomplete="off"/>
          @error('password')
          <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
          @enderror

          <a href="javascript:void(0)" class="forgtlink">Forgot Password?</a>
          <a href="javascript:void(0)" class="forget_username">Forgot Username?</a>
          <button type="submit" class="btn btn-login">Login</button>
        </form>

      </div>
    </div>
  </div>
</div>
<div id="termsandcondition1" class="modal fontcss" role="dialog">
  <div class="preloader"></div>
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <!-- Modal content-->
    <div class="modal-content">
      <a class=" termscancel"><img src="{{asset('front/img/close.png')}}"/></a>
      <div class="modal-body para-blk">
        <h3 class="poptitle">GalleryKids! Submissions ("Submissions") Terms and Conditions</h3>
        <p>The Gallery reserves the right and retains sole discretion over which Submissions it will
          publish </p>

        <p>Participants agree that all Submissions are original and do not infringe on any third-party copyright
          or intellectual property. Participants are fully liable and responsible for their Submissions and
          for obtaining all necessary third-party permissions before submitting to the Gallery</p>

        <p>Participants agree to grant the Gallery a non-exclusive, worldwide, perpetual, royalty-free right to
          reproduce, modify, edit, publish and distribute the Submissions digitally or physically and on any
          platforms including but not limited to the GalleryKids! Website.</p>
      </div>


    </div>
  </div>
</div>
<div id="forgot-modal" class="modal" role="dialog">
  <div class="preloader"></div>
  <div class="modal-dialog modal-dialog-centered">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="spinner">
        <div class="bounce1"></div>
        <div class="bounce2"></div>
        <div class="bounce3"></div>
      </div>
      <div class="modal-body login-blk">
        {{--                <a class="cancellogin"><img src="{{asset('front/img/close.png')}}"/></a>--}}
        <h2 class="formhding">Forgot Your Password? </h2>
        <p class="subline">Please enter the registered email address to your GalleryKids! account and
          weÃ¢â‚¬â„¢ll send you instructions to reset your password. </p>

        <div class="form-group">
          <label class="formlabel">Email Address</label>

          <input type="email" name="email" id="forgetEmail" value="" class="form-control forminput"/>
          <p class="forgetEmail error"></p>
        </div>
        <button type="submit" class="btn btn-login forgetPassword">

          <div class="txn">Confirm</div>
        </button>
        </form>
      </div>
    </div>
  </div>
</div>
<div id="mailCheck" class="modal" role="dialog">
  <div class="preloader"></div>
  <div class="modal-dialog modal-dialog-centered">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="spinner">
        <div class="bounce1"></div>
        <div class="bounce2"></div>
        <div class="bounce3"></div>
      </div>
      <div class="modal-body login-blk">
        {{--                <a class="cancellogin"><img src="{{asset('front/img/close.png')}}"/></a>--}}
        <h2 class="formhding">Please check your email</h2>
        <p class="subline">The instructions to reset your password have been sent to you.</p>
        <br/>
        <br/>
        <button type="submit" class="btn btn-login forgetPassword1">
          <div class="txn">Close</div>

        </button>
        </form>
      </div>
    </div>
  </div>
</div>
<div id="register-modal" class="modal" role="dialog">
  <div class="preloader"></div>
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="spinner">
        <div class="bounce1"></div>
        <div class="bounce2"></div>
        <div class="bounce3"></div>
      </div>

      <div class="modal-body login-blk Rstep3">
        {{--                <a class="cancellogin"><img src="{{asset('front/img/close.png')}}"/></a>--}}
        <h2 class="formhding">Registration</h2>
        <p class="subline">On behalf of your family</p>
        <p class="subline black">Step 1: Sign up as a Gallery Explorer</p>

        <div class="form-group col-md-6">
          <label class="formlabel">First Name</label>

          <input type="text" name="firstname" id="firstname" maxlength="30" class="form-control forminput"/>
          <b class="firstname error"></b>
        </div>
        <div class="form-group col-md-6">
          <label class="formlabel">Last Name</label>

          <input type="text" name="lastname" id="lastname" maxlength="30" class="form-control forminput"/>
          <b class="lastname error"></b>
        </div>

        <div class="form-group col-md-12">
          <label class="formlabel">Email Address</label>
          <input type="email" name="email" id="email" class="form-control forminput"/>
          <b class="email error"></b>
        </div>
        <div class="form-group col-md-12">
          <label class="formlabel">Password</label>
          <input type="password" name="password" id="password" class="form-control forminput"
                 autocomplete="off"/>
          <b class="password error"></b>
        </div>

        <div class="form-group col-md-12">
          <label class="formlabel" style="margin-top: -2px;margin-bottom: 30px;">Re-enter Password</label>

          <input type="password" name="repassword" id="repassword" class="form-control forminput"
                 autocomplete="off"/>
          <b class="repassword error"></b>
        </div>

        <div class="form-group col-md-12 selectbox w100pr">
          <input type="checkbox" id="terms" name="terms"/>
          <label>I agree to the <a href="javascript:void(0)" class="termspopcall">Terms & Conditions</a> and
            <a href="https://www.nationalgallery.sg/privacy-policy" target="_blank" class="privacypopcall"
               rel="noreferrer noopener">Privacy Policy</a> of this online activity.</label>
          <b class="terms error"></b>
        </div>
        <div class="form-group col-md-12 selectbox w100pr">
          <input type="checkbox" id="subscribe" name="subscribe"/>
          <label>Subscribe to receive email updates.</label>
        </div>


        <div class="col-md-12">
          <button id="stepOne" class="btn btn-login">
            <div class="txn">Confirm</div>

          </button>
        </div>

      </div>

      <div class="modal-body login-blk Rstep5">
        {{--                <a class="cancellogin"><img src="{{asset('front/img/close.png')}}"/></a>--}}
        <h2 class="formhding">Registration</h2>
        <p class="subline">On behalf of a family</p>
        <p class="subline black">Step 2: Register for Gallerykids!</p>

        <div class="form-group">
          <label class="formlabel">Gender</label>

          <select name="gender" id="gender" class="gender form-control forminput ">
            <option value="">Select</option>
            <option value="M">Male</option>
            <option value="F">Female</option>
          </select>
          <b class="gender error"></b>
        </div>
        <div class="form-group ">
          <label class="formlabel">Mobile</label>

          <input type="text" name="mobile" id="mobile" maxlength="10"
                 class="mobile form-control forminput numvar"/>
          <b class="mobile error"></b>
        </div>

        <div class="form-group">
          <label class="formlabel" style="margin-top: -2px;margin-bottom: 13px;">Country of Residence</label>

          <select name="country" id="country" class="country form-control forminput ">
            <option value="">Select</option>
            <option value="AF">Afghanistan</option>
            <option value="AX">Aland Islands</option>
            <option value="AL">Albania</option>
            <option value="DZ">Algeria</option>
            <option value="AS">American Samoa</option>
            <option value="AD">Andorra</option>
            <option value="AO">Angola</option>
            <option value="AI">Anguilla</option>
            <option value="AQ">Antarctica</option>
            <option value="AG">Antigua and Barbuda</option>
            <option value="AR">Argentina</option>
            <option value="AM">Armenia</option>
            <option value="AW">Aruba</option>
            <option value="AU">Australia</option>
            <option value="AT">Austria</option>
            <option value="AZ">Azerbaijan</option>
            <option value="BS">Bahamas</option>
            <option value="BH">Bahrain</option>
            <option value="BD">Bangladesh</option>
            <option value="BB">Barbados</option>
            <option value="BY">Belarus</option>
            <option value="BE">Belgium</option>
            <option value="BZ">Belize</option>
            <option value="BJ">Benin</option>
            <option value="BM">Bermuda</option>
            <option value="BT">Bhutan</option>
            <option value="BO">Bolivia, Plurinational State of</option>
            <option value="BQ">Bonaire, Sint Eustatius and Saba</option>
            <option value="BA">Bosnia and Herzegovina</option>
            <option value="BW">Botswana</option>
            <option value="BV">Bouvet Island</option>
            <option value="BR">Brazil</option>
            <option value="IO">British Indian Ocean Territory</option>
            <option value="BN">Brunei Darussalam</option>
            <option value="BG">Bulgaria</option>
            <option value="BF">Burkina Faso</option>
            <option value="BI">Burundi</option>
            <option value="KH">Cambodia</option>
            <option value="CM">Cameroon</option>
            <option value="CA">Canada</option>
            <option value="CV">Cape Verde</option>
            <option value="KY">Cayman Islands</option>
            <option value="CF">Central African Republic</option>
            <option value="TD">Chad</option>
            <option value="CL">Chile</option>
            <option value="CN">China</option>
            <option value="CX">Christmas Island</option>
            <option value="CC">Cocos (Keeling) Islands</option>
            <option value="CO">Colombia</option>
            <option value="KM">Comoros</option>
            <option value="CG">Congo</option>
            <option value="CD">Congo, the Democratic Republic of the</option>
            <option value="CK">Cook Islands</option>
            <option value="CR">Costa Rica</option>
            <option value="CI">Cote d'Ivoire</option>
            <option value="HR">Croatia</option>
            <option value="CU">Cuba</option>
            <option value="CW">Curacao</option>
            <option value="CY">Cyprus</option>
            <option value="CZ">Czech Republic</option>
            <option value="DK">Denmark</option>
            <option value="DJ">Djibouti</option>
            <option value="DM">Dominica</option>
            <option value="DO">Dominican Republic</option>
            <option value="EC">Ecuador</option>
            <option value="EG">Egypt</option>
            <option value="SV">El Salvador</option>
            <option value="GQ">Equatorial Guinea</option>
            <option value="ER">Eritrea</option>
            <option value="EE">Estonia</option>
            <option value="ET">Ethiopia</option>
            <option value="FK">Falkland Islands (Malvinas)</option>
            <option value="FO">Faroe Islands</option>
            <option value="FJ">Fiji</option>
            <option value="FI">Finland</option>
            <option value="FR">France</option>
            <option value="GF">French Guiana</option>
            <option value="PF">French Polynesia</option>
            <option value="TF">French Southern Territories</option>
            <option value="GA">Gabon</option>
            <option value="GM">Gambia</option>
            <option value="GE">Georgia</option>
            <option value="DE">Germany</option>
            <option value="GH">Ghana</option>
            <option value="GI">Gibraltar</option>
            <option value="GR">Greece</option>
            <option value="GL">Greenland</option>
            <option value="GD">Grenada</option>
            <option value="GP">Guadeloupe</option>
            <option value="GU">Guam</option>
            <option value="GT">Guatemala</option>
            <option value="GG">Guernsey</option>
            <option value="GN">Guinea</option>
            <option value="GW">Guinea-Bissau</option>
            <option value="GY">Guyana</option>
            <option value="HT">Haiti</option>
            <option value="HM">Heard Island and McDonald Islands</option>
            <option value="VA">Holy See (Vatican City State)</option>
            <option value="HN">Honduras</option>
            <option value="HK">Hong Kong</option>
            <option value="HU">Hungary</option>
            <option value="IS">Iceland</option>
            <option value="IN">India</option>
            <option value="ID">Indonesia</option>
            <option value="IR">Iran, Islamic Republic of</option>
            <option value="IQ">Iraq</option>
            <option value="IE">Ireland</option>
            <option value="IM">Isle of Man</option>
            <option value="IL">Israel</option>
            <option value="IT">Italy</option>
            <option value="JM">Jamaica</option>
            <option value="JP">Japan</option>
            <option value="JE">Jersey</option>
            <option value="JO">Jordan</option>
            <option value="KZ">Kazakhstan</option>
            <option value="KE">Kenya</option>
            <option value="KI">Kiribati</option>
            <option value="KP">Korea, Democratic People's Republic of</option>
            <option value="KR">Korea, Republic of</option>
            <option value="KW">Kuwait</option>
            <option value="KG">Kyrgyzstan</option>
            <option value="LA">Lao People's Democratic Republic</option>
            <option value="LV">Latvia</option>
            <option value="LB">Lebanon</option>
            <option value="LS">Lesotho</option>
            <option value="LR">Liberia</option>
            <option value="LY">Libya</option>
            <option value="LI">Liechtenstein</option>
            <option value="LT">Lithuania</option>
            <option value="LU">Luxembourg</option>
            <option value="MO">Macao</option>
            <option value="MK">Macedonia, the former Yugoslav Republic of</option>
            <option value="MG">Madagascar</option>
            <option value="MW">Malawi</option>
            <option value="MY">Malaysia</option>
            <option value="MV">Maldives</option>
            <option value="ML">Mali</option>
            <option value="MT">Malta</option>
            <option value="MH">Marshall Islands</option>
            <option value="MQ">Martinique</option>
            <option value="MR">Mauritania</option>
            <option value="MU">Mauritius</option>
            <option value="YT">Mayotte</option>
            <option value="MX">Mexico</option>
            <option value="FM">Micronesia, Federated States of</option>
            <option value="MD">Moldova, Republic of</option>
            <option value="MC">Monaco</option>
            <option value="MN">Mongolia</option>
            <option value="ME">Montenegro</option>
            <option value="MS">Montserrat</option>
            <option value="MA">Morocco</option>
            <option value="MZ">Mozambique</option>
            <option value="MM">Myanmar</option>
            <option value="NA">Namibia</option>
            <option value="NR">Nauru</option>
            <option value="NP">Nepal</option>
            <option value="NL">Netherlands</option>
            <option value="NC">New Caledonia</option>
            <option value="NZ">New Zealand</option>
            <option value="NI">Nicaragua</option>
            <option value="NE">Niger</option>
            <option value="NG">Nigeria</option>
            <option value="NU">Niue</option>
            <option value="NF">Norfolk Island</option>
            <option value="MP">Northern Mariana Islands</option>
            <option value="NO">Norway</option>
            <option value="OM">Oman</option>
            <option value="PK">Pakistan</option>
            <option value="PW">Palau</option>
            <option value="PS">Palestinian Territory, Occupied</option>
            <option value="PA">Panama</option>
            <option value="PG">Papua New Guinea</option>
            <option value="PY">Paraguay</option>
            <option value="PE">Peru</option>
            <option value="PH">Philippines</option>
            <option value="PN">Pitcairn</option>
            <option value="PL">Poland</option>
            <option value="PT">Portugal</option>
            <option value="PR">Puerto Rico</option>
            <option value="QA">Qatar</option>
            <option value="RE">Reunion</option>
            <option value="RO">Romania</option>
            <option value="RU">Russian Federation</option>
            <option value="RW">Rwanda</option>
            <option value="BL">Saint Barthelemy</option>
            <option value="SH">Saint Helena, Ascension and Tristan da Cunha</option>
            <option value="KN">Saint Kitts and Nevis</option>
            <option value="LC">Saint Lucia</option>
            <option value="MF">Saint Martin (French part)</option>
            <option value="PM">Saint Pierre and Miquelon</option>
            <option value="VC">Saint Vincent and the Grenadines</option>
            <option value="WS">Samoa</option>
            <option value="SM">San Marino</option>
            <option value="ST">Sao Tome and Principe</option>
            <option value="SA">Saudi Arabia</option>
            <option value="SN">Senegal</option>
            <option value="RS">Serbia</option>
            <option value="SC">Seychelles</option>
            <option value="SL">Sierra Leone</option>
            <option value="SG">Singapore</option>
            <option value="SX">Sint Maarten (Dutch part)</option>
            <option value="SK">Slovakia</option>
            <option value="SI">Slovenia</option>
            <option value="SB">Solomon Islands</option>
            <option value="SO">Somalia</option>
            <option value="ZA">South Africa</option>
            <option value="GS">South Georgia and the South Sandwich Islands</option>
            <option value="SS">South Sudan</option>
            <option value="ES">Spain</option>
            <option value="LK">Sri Lanka</option>
            <option value="SD">Sudan</option>
            <option value="SR">Suriname</option>
            <option value="SJ">Svalbard and Jan Mayen</option>
            <option value="SZ">Swaziland</option>
            <option value="SE">Sweden</option>
            <option value="CH">Switzerland</option>
            <option value="SY">Syrian Arab Republic</option>
            <option value="TW">Taiwan, Province of China</option>
            <option value="TJ">Tajikistan</option>
            <option value="TZ">Tanzania, United Republic of</option>
            <option value="TH">Thailand</option>
            <option value="TL">Timor-Leste</option>
            <option value="TG">Togo</option>
            <option value="TK">Tokelau</option>
            <option value="TO">Tonga</option>
            <option value="TT">Trinidad and Tobago</option>
            <option value="TN">Tunisia</option>
            <option value="TR">Turkey</option>
            <option value="TM">Turkmenistan</option>
            <option value="TC">Turks and Caicos Islands</option>
            <option value="TV">Tuvalu</option>
            <option value="UG">Uganda</option>
            <option value="UA">Ukraine</option>
            <option value="AE">United Arab Emirates</option>
            <option value="GB">United Kingdom</option>
            <option value="US">United States</option>
            <option value="UM">United States Minor Outlying Islands</option>
            <option value="UY">Uruguay</option>
            <option value="UZ">Uzbekistan</option>
            <option value="VU">Vanuatu</option>
            <option value="VE">Venezuela, Bolivarian Republic of</option>
            <option value="VN">Viet Nam</option>
            <option value="VG">Virgin Islands, British</option>
            <option value="VI">Virgin Islands, U.S.</option>
            <option value="WF">Wallis and Futuna</option>
            <option value="EH">Western Sahara</option>
            <option value="YE">Yemen</option>
            <option value="ZM">Zambia</option>
            <option value="ZW">Zimbabwe</option>
          </select>
          <b class="country error"></b>
        </div>

        <div class="form-group">
          <label class="formlabel">Date of Birth</label>

          <div class="dobblk">
            <select name="date" id="date" class="date form-control forminput ddinput">
              <option value="" selected="" disabled="">Day</option>
              <option value="01">01</option>
              <option value="02">02</option>
              <option value="03">03</option>
              <option value="04">04</option>
              <option value="05">05</option>
              <option value="06">06</option>
              <option value="07">07</option>
              <option value="08">08</option>
              <option value="09">09</option>
              <option value="10">10</option>
              <option value="11">11</option>
              <option value="12">12</option>
              <option value="13">13</option>
              <option value="14">14</option>
              <option value="15">15</option>
              <option value="16">16</option>
              <option value="17">17</option>
              <option value="18">18</option>
              <option value="19">19</option>
              <option value="20">20</option>
              <option value="21">21</option>
              <option value="22">22</option>
              <option value="23">23</option>
              <option value="24">24</option>
              <option value="25">25</option>
              <option value="26">26</option>
              <option value="27">27</option>
              <option value="28">28</option>
              <option value="29">29</option>
              <option value="30">30</option>
              <option value="31">31</option>
            </select>
            <b class="date error"></b>

            <select name="month" id="month" class="month form-control forminput moninput">
              <option value="" selected="" disabled="">Month</option>
              <option value="01">January</option>
              <option value="02">February</option>
              <option value="03">March</option>
              <option value="04">April</option>
              <option value="05">May</option>
              <option value="06">June</option>
              <option value="07">July</option>
              <option value="08">August</option>
              <option value="09">September</option>
              <option value="10">October</option>
              <option value="11">November</option>
              <option value="12">December</option>
            </select>
            <b class="month error"></b>

            <select name="year" id="year" class="year form-control forminput yearinputParent">
              <option value="" disabled="" selected="">Year</option>
            </select>
            <b class="year error"></b>
          </div>
        </div>

        <div class="form-group selectbox">
          <input type="checkbox" name="terms" id="terms2" class="step2Terms ml120"/>

          <label class="checklabel5">I agree to the <a href="javascript:void(0)" class="termspopcall">Terms &
              Conditions</a> and <a href="https://www.nationalgallery.sg/privacy-policy" target="_blank"
                                    rel="noreferrer noopener" class="privacypopcall">Privacy Policy</a> of
            this online activity.</label>
          <b class="step2Terms error"></b>
        </div>


        <div class="col-md-12 btnblock">
          <button class="btn btn-back">Back</button>
          <button class="btn btn-login stepTwo">
            <div class="txn">Confirm</div>

          </button>
        </div>

      </div>

      <div class="modal-body login-blk Rstep6">
        {{--                <a class="cancellogin"><img src="{{asset('front/img/close.png')}}"/></a>--}}
        <h2 class="formhding">Registration</h2>
        <p class="subline">On behalf of a family</p>
        <p class="subline black">Step 3: Sign up for children</p>


        <div class="addedchild all">

        </div>


        <div class="addchild ">
          <h3>Add Child<a href="javascript:void(0)" class="addchildbtn"><span class="plus">+</span><span
                class="minus">-</span></a></h3>

          <div class="inneraccord">
            <div class="form-group ">
              <label class="formlabel">First Name</label>

              <input type="text" name="Childfirstname" maxlength="30"
                     class="form-control forminput Childfirstname"/>
              <b class="VChildfirstname error"></b>
            </div>
            <div class="form-group ">
              <label class="formlabel">Last Name</label>

              <input type="text" name="Childlastname" maxlength="30"
                     class="form-control forminput Childlastname"/>
              <b class="VChildlastname error"></b>
            </div>

            <div class="form-group">
              <label class="formlabel">Date of Birth</label>


              <div class="dobblk">
                <select name="Childdate[]" class="Childdate form-control forminput ddinput">
                  <option value="" selected="" disabled="">Day</option>
                  <option value="01">01</option>
                  <option value="02">02</option>
                  <option value="03">03</option>
                  <option value="04">04</option>
                  <option value="05">05</option>
                  <option value="06">06</option>
                  <option value="07">07</option>
                  <option value="08">08</option>
                  <option value="09">09</option>
                  <option value="10">10</option>
                  <option value="11">11</option>
                  <option value="12">12</option>
                  <option value="13">13</option>
                  <option value="14">14</option>
                  <option value="15">15</option>
                  <option value="16">16</option>
                  <option value="17">17</option>
                  <option value="18">18</option>
                  <option value="19">19</option>
                  <option value="20">20</option>
                  <option value="21">21</option>
                  <option value="22">22</option>
                  <option value="23">23</option>
                  <option value="24">24</option>
                  <option value="25">25</option>
                  <option value="26">26</option>
                  <option value="27">27</option>
                  <option value="28">28</option>
                  <option value="29">29</option>
                  <option value="30">30</option>
                  <option value="31">31</option>
                </select>
                <b class="VChildmonth"></b>
                <select name="Childmonth[]" class="Childmonth form-control forminput moninput">
                  <option value="" selected="" disabled="">Month</option>
                  <option value="01">January</option>
                  <option value="02">February</option>
                  <option value="03">March</option>
                  <option value="04">April</option>
                  <option value="05">May</option>
                  <option value="06">June</option>
                  <option value="07">July</option>
                  <option value="08">August</option>
                  <option value="09">September</option>
                  <option value="10">October</option>
                  <option value="11">November</option>
                  <option value="12">December</option>
                </select>
                <b class="VChildyear"></b>
                <select name="Childyear[]" class="Childyear form-control forminput yearinput">
                  <option value="" selected="" disabled="">Year</option>
                </select>
              </div>
              <b class="VChilddate error"></b>
            </div>


            <div class="form-group">
              <button class="btn add-btn">Add</button>
            </div>
          </div>

        </div>
        <p class="errorMessage"></p>


        <div class="col-md-12 btnblock">
          <button class="btn btn-back" style="background: #c3d7c8;">Back</button>
          <button type="submit" id="dataSave" class="btn btn-login">
            <div class="txn">Confirm</div>

          </button>
        </div>

      </div>

      <div class="modal-body login-blk Rstep7">
        <h2 class="welcomehding mb50">WELCOME TO GALLERYKIDS!</h2>
        <p class="subline black">You are now a member of GalleryKids! </p>
        <div class="col-md-12 btnblock">
          <a href="{{url('/')}}" class="btn btn-back startbtn" style="background: #b9171e;">Let's Start
            Exploring</a>
        </div>


      </div>
    </div>
  </div>
</div>
<div id="forgot-username-modal" class="modal" role="dialog">
  <div class="preloader"></div>
  <div class="modal-dialog  modal-dialog-centered">
    <!-- Modal content-->
    <div class="modal-content">
      <a class="cancel">X</a>
      <div class="modal-body login-blk">
        <form method="POST" action="{{route('forget.username')}}">
          @csrf
          <img src="{{asset('front/img/kidslogo2.png')}}" alt="">
          <h2>Enter your email to get username</h2>

          <input type="email" name="email" value="{{old('email')}}" placeholder="Enter email"/>
          @error('email')
          <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
          @enderror
          <button type="submit" class="btn btn-login">Send</button>
        </form>
      </div>
    </div>
  </div>
</div>
<div id="login-modal1" class="modal" role="dialog">
  <div class="preloader"></div>
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="spinner">
        <div class="bounce1"></div>
        <div class="bounce2"></div>
        <div class="bounce3"></div>
      </div>
      <div class="modal-body login-blk step1" style="display: none;">
        <h2 class="formhding mb50">Select your Login type</h2>

        <div class="innerStep1">
          {{--                    <a class="cancellogin"><img src="{{asset('front/img/close.png')}}"/></a>--}}
          <div class="selectbox">
            <input type="radio" value="family" name="logintype" id="familytype"/>
            <label for="familytype">As a family</label>
          </div>
          <div class="selectbox">
            <input type="radio" value="school" name="logintype" id="schooltype"/>
            <label for="schooltype">As a class from school</label>
          </div>
        </div>

        <div class="innerStep2" style="display: none">
          {{--                    <a class="cancellogin"><img src="{{asset('front/img/close.png')}}"/></a>--}}
          <div class="selectbox">
            <input type="radio" value="teacher" name="logintype2" id="teachertype"/>
            <label for="teachertype">As a Teacher</label>
          </div>
          <div class="selectbox">
            <input type="radio" value="student" name="logintype2" id="studenttype"/>
            <label for="studenttype">As a Student</label>
          </div>
        </div>

      </div>

    <!--                    <div class="modal-body login-blk step2" style="display: none">
                                            <a class="cancellogin"><img src="{{asset('front/img/close.png')}}"/></a>
                                            <h2 class="formhding">Login as a Student</h2>
                                            <p class="subline">Please enter your email and password</p>

                                            <div class="form-group">
                                                <label  class="formlabel">Email Address</label>
                                                <input type="email" name="email" class="form-control forminput"/>
                                            </div>
                                            <div class="form-group">
                                                <label  class="formlabel">Password</label>
                                                <input type="password" name="password" class="form-control forminput"/>
                                            </div>

                                            <a href="javascript:void(0)" class="bottomline">Forgot username and password?</a>
                                            <button class="btn btn-login">Confirm</button>

                                        </div>-->


      <div class="modal-body login-blk step3" style="display: none">
        <a class="cancellogin close-popup"><img src="{{asset('front/img/close.png')}}"/></a>
        <h2 class="welcomehding ">Welcome to GalleryKids!</h2>
        <h2 class="welcomheading2">Login as Parent</h2>
        <p class="subline">You will be logging in on behalf of your children.</p>
        {{--                <p class="subline">You will be logging in on behalf of your children. Please enter your email and password. </p>--}}

        {{--                <div class="form-group">--}}
        {{--                    <label class="formlabel">Email Address</label>--}}
        {{--                    <b class="loginEmail error"></b>--}}
        {{--                    <input type="email" name="email" id="loginEmail" class="form-control forminput"/>--}}
        {{--                </div>--}}
        {{--                <div class="form-group">--}}
        {{--                    <label class="formlabel">Password</label>--}}
        {{--                    <b class="loginPass error"></b>--}}
        {{--                    <input type="password" name="password" id="loginPass" class="form-control forminput"--}}
        {{--                           autocomplete="off"/>--}}
        {{--                </div>--}}

        {{--                <a href="javascript:void(0)" class="bottomline forgetCall">Forgot username and password?</a>--}}
        <p class="errorMessage"></p>

        <button class="btn btn-login SimpleSSOLogin">
          <div class="txn">Login</div>

        </button>


      </div>

      <div class="modal-body login-blk step8" style="display: none">
        {{--                <a class="cancellogin"><img src="{{asset('front/img/close.png')}}"/></a>--}}

        <h2 class="welcomehding mb50">Welcome! You're a Gallery Insider</h2>
        <p class="subline black">Register for GalleryKids!</p>


        <div class="form-group selectbox">
          <input type="checkbox" name="terms" id="terms8" class="step2Terms ml120"/>

          <label class="checklabel5">I agree to the <a href="javascript:void(0)" class="termspopcall">Terms &
              Conditions</a> and <a href="https://www.nationalgallery.sg/privacy-policy" target="_blank"
                                    rel="noreferrer noopener" class="privacypopcall">Privacy Policy</a> of
            this online activity.</label>
          <b class="step8Terms error"></b>
        </div>


        <div class="col-md-12 btnblock">
          {{--                    <button class="btn btn-back">Back</button>--}}
          <button class="btn btn-login " id="stepeight">
            <span class="txn">Confirm</span>
          </button>
        </div>

      </div>


      <div class="modal-body login-blk step5" style="display: none">
        {{--                <a class="cancellogin"><img src="{{asset('front/img/close.png')}}"/></a>--}}
        <h2 class="formhding">Welcome! You're a Gallery Explorer!</h2>
        <p class="subline black">Register for Gallerykids!</p>
        <p class="subline">Some additional information is required to be a Parent:</p>


        <div class="form-group">
          <label class="formlabel">Gender</label>

          <select name="gender" id="logingender" class="gender form-control forminput ">
            <option value="">Select</option>
            <option value="M">Male</option>
            <option value="F">Female</option>
          </select>
          <b class="gender error"></b>
        </div>
        <div class="form-group ">
          <label class="formlabel">Mobile</label>

          <input type="text" name="mobile" id="loginmobile" maxlength="10"
                 class="mobile form-control forminput numvar"/>
          <b class="mobile error"></b>
        </div>

        <div class="form-group">
          <label class="formlabel" style="margin-top: -2px;margin-bottom: 13px;">Country of Residence</label>

          <select name="country" id="logincountry" class="country form-control forminput ">
            <option value="">Select</option>
            <option value="AF">Afghanistan</option>
            <option value="AX">Aland Islands</option>
            <option value="AL">Albania</option>
            <option value="DZ">Algeria</option>
            <option value="AS">American Samoa</option>
            <option value="AD">Andorra</option>
            <option value="AO">Angola</option>
            <option value="AI">Anguilla</option>
            <option value="AQ">Antarctica</option>
            <option value="AG">Antigua and Barbuda</option>
            <option value="AR">Argentina</option>
            <option value="AM">Armenia</option>
            <option value="AW">Aruba</option>
            <option value="AU">Australia</option>
            <option value="AT">Austria</option>
            <option value="AZ">Azerbaijan</option>
            <option value="BS">Bahamas</option>
            <option value="BH">Bahrain</option>
            <option value="BD">Bangladesh</option>
            <option value="BB">Barbados</option>
            <option value="BY">Belarus</option>
            <option value="BE">Belgium</option>
            <option value="BZ">Belize</option>
            <option value="BJ">Benin</option>
            <option value="BM">Bermuda</option>
            <option value="BT">Bhutan</option>
            <option value="BO">Bolivia, Plurinational State of</option>
            <option value="BQ">Bonaire, Sint Eustatius and Saba</option>
            <option value="BA">Bosnia and Herzegovina</option>
            <option value="BW">Botswana</option>
            <option value="BV">Bouvet Island</option>
            <option value="BR">Brazil</option>
            <option value="IO">British Indian Ocean Territory</option>
            <option value="BN">Brunei Darussalam</option>
            <option value="BG">Bulgaria</option>
            <option value="BF">Burkina Faso</option>
            <option value="BI">Burundi</option>
            <option value="KH">Cambodia</option>
            <option value="CM">Cameroon</option>
            <option value="CA">Canada</option>
            <option value="CV">Cape Verde</option>
            <option value="KY">Cayman Islands</option>
            <option value="CF">Central African Republic</option>
            <option value="TD">Chad</option>
            <option value="CL">Chile</option>
            <option value="CN">China</option>
            <option value="CX">Christmas Island</option>
            <option value="CC">Cocos (Keeling) Islands</option>
            <option value="CO">Colombia</option>
            <option value="KM">Comoros</option>
            <option value="CG">Congo</option>
            <option value="CD">Congo, the Democratic Republic of the</option>
            <option value="CK">Cook Islands</option>
            <option value="CR">Costa Rica</option>
            <option value="CI">Cote d'Ivoire</option>
            <option value="HR">Croatia</option>
            <option value="CU">Cuba</option>
            <option value="CW">Curacao</option>
            <option value="CY">Cyprus</option>
            <option value="CZ">Czech Republic</option>
            <option value="DK">Denmark</option>
            <option value="DJ">Djibouti</option>
            <option value="DM">Dominica</option>
            <option value="DO">Dominican Republic</option>
            <option value="EC">Ecuador</option>
            <option value="EG">Egypt</option>
            <option value="SV">El Salvador</option>
            <option value="GQ">Equatorial Guinea</option>
            <option value="ER">Eritrea</option>
            <option value="EE">Estonia</option>
            <option value="ET">Ethiopia</option>
            <option value="FK">Falkland Islands (Malvinas)</option>
            <option value="FO">Faroe Islands</option>
            <option value="FJ">Fiji</option>
            <option value="FI">Finland</option>
            <option value="FR">France</option>
            <option value="GF">French Guiana</option>
            <option value="PF">French Polynesia</option>
            <option value="TF">French Southern Territories</option>
            <option value="GA">Gabon</option>
            <option value="GM">Gambia</option>
            <option value="GE">Georgia</option>
            <option value="DE">Germany</option>
            <option value="GH">Ghana</option>
            <option value="GI">Gibraltar</option>
            <option value="GR">Greece</option>
            <option value="GL">Greenland</option>
            <option value="GD">Grenada</option>
            <option value="GP">Guadeloupe</option>
            <option value="GU">Guam</option>
            <option value="GT">Guatemala</option>
            <option value="GG">Guernsey</option>
            <option value="GN">Guinea</option>
            <option value="GW">Guinea-Bissau</option>
            <option value="GY">Guyana</option>
            <option value="HT">Haiti</option>
            <option value="HM">Heard Island and McDonald Islands</option>
            <option value="VA">Holy See (Vatican City State)</option>
            <option value="HN">Honduras</option>
            <option value="HK">Hong Kong</option>
            <option value="HU">Hungary</option>
            <option value="IS">Iceland</option>
            <option value="IN">India</option>
            <option value="ID">Indonesia</option>
            <option value="IR">Iran, Islamic Republic of</option>
            <option value="IQ">Iraq</option>
            <option value="IE">Ireland</option>
            <option value="IM">Isle of Man</option>
            <option value="IL">Israel</option>
            <option value="IT">Italy</option>
            <option value="JM">Jamaica</option>
            <option value="JP">Japan</option>
            <option value="JE">Jersey</option>
            <option value="JO">Jordan</option>
            <option value="KZ">Kazakhstan</option>
            <option value="KE">Kenya</option>
            <option value="KI">Kiribati</option>
            <option value="KP">Korea, Democratic People's Republic of</option>
            <option value="KR">Korea, Republic of</option>
            <option value="KW">Kuwait</option>
            <option value="KG">Kyrgyzstan</option>
            <option value="LA">Lao People's Democratic Republic</option>
            <option value="LV">Latvia</option>
            <option value="LB">Lebanon</option>
            <option value="LS">Lesotho</option>
            <option value="LR">Liberia</option>
            <option value="LY">Libya</option>
            <option value="LI">Liechtenstein</option>
            <option value="LT">Lithuania</option>
            <option value="LU">Luxembourg</option>
            <option value="MO">Macao</option>
            <option value="MK">Macedonia, the former Yugoslav Republic of</option>
            <option value="MG">Madagascar</option>
            <option value="MW">Malawi</option>
            <option value="MY">Malaysia</option>
            <option value="MV">Maldives</option>
            <option value="ML">Mali</option>
            <option value="MT">Malta</option>
            <option value="MH">Marshall Islands</option>
            <option value="MQ">Martinique</option>
            <option value="MR">Mauritania</option>
            <option value="MU">Mauritius</option>
            <option value="YT">Mayotte</option>
            <option value="MX">Mexico</option>
            <option value="FM">Micronesia, Federated States of</option>
            <option value="MD">Moldova, Republic of</option>
            <option value="MC">Monaco</option>
            <option value="MN">Mongolia</option>
            <option value="ME">Montenegro</option>
            <option value="MS">Montserrat</option>
            <option value="MA">Morocco</option>
            <option value="MZ">Mozambique</option>
            <option value="MM">Myanmar</option>
            <option value="NA">Namibia</option>
            <option value="NR">Nauru</option>
            <option value="NP">Nepal</option>
            <option value="NL">Netherlands</option>
            <option value="NC">New Caledonia</option>
            <option value="NZ">New Zealand</option>
            <option value="NI">Nicaragua</option>
            <option value="NE">Niger</option>
            <option value="NG">Nigeria</option>
            <option value="NU">Niue</option>
            <option value="NF">Norfolk Island</option>
            <option value="MP">Northern Mariana Islands</option>
            <option value="NO">Norway</option>
            <option value="OM">Oman</option>
            <option value="PK">Pakistan</option>
            <option value="PW">Palau</option>
            <option value="PS">Palestinian Territory, Occupied</option>
            <option value="PA">Panama</option>
            <option value="PG">Papua New Guinea</option>
            <option value="PY">Paraguay</option>
            <option value="PE">Peru</option>
            <option value="PH">Philippines</option>
            <option value="PN">Pitcairn</option>
            <option value="PL">Poland</option>
            <option value="PT">Portugal</option>
            <option value="PR">Puerto Rico</option>
            <option value="QA">Qatar</option>
            <option value="RE">Reunion</option>
            <option value="RO">Romania</option>
            <option value="RU">Russian Federation</option>
            <option value="RW">Rwanda</option>
            <option value="BL">Saint Barthelemy</option>
            <option value="SH">Saint Helena, Ascension and Tristan da Cunha</option>
            <option value="KN">Saint Kitts and Nevis</option>
            <option value="LC">Saint Lucia</option>
            <option value="MF">Saint Martin (French part)</option>
            <option value="PM">Saint Pierre and Miquelon</option>
            <option value="VC">Saint Vincent and the Grenadines</option>
            <option value="WS">Samoa</option>
            <option value="SM">San Marino</option>
            <option value="ST">Sao Tome and Principe</option>
            <option value="SA">Saudi Arabia</option>
            <option value="SN">Senegal</option>
            <option value="RS">Serbia</option>
            <option value="SC">Seychelles</option>
            <option value="SL">Sierra Leone</option>
            <option value="SG">Singapore</option>
            <option value="SX">Sint Maarten (Dutch part)</option>
            <option value="SK">Slovakia</option>
            <option value="SI">Slovenia</option>
            <option value="SB">Solomon Islands</option>
            <option value="SO">Somalia</option>
            <option value="ZA">South Africa</option>
            <option value="GS">South Georgia and the South Sandwich Islands</option>
            <option value="SS">South Sudan</option>
            <option value="ES">Spain</option>
            <option value="LK">Sri Lanka</option>
            <option value="SD">Sudan</option>
            <option value="SR">Suriname</option>
            <option value="SJ">Svalbard and Jan Mayen</option>
            <option value="SZ">Swaziland</option>
            <option value="SE">Sweden</option>
            <option value="CH">Switzerland</option>
            <option value="SY">Syrian Arab Republic</option>
            <option value="TW">Taiwan, Province of China</option>
            <option value="TJ">Tajikistan</option>
            <option value="TZ">Tanzania, United Republic of</option>
            <option value="TH">Thailand</option>
            <option value="TL">Timor-Leste</option>
            <option value="TG">Togo</option>
            <option value="TK">Tokelau</option>
            <option value="TO">Tonga</option>
            <option value="TT">Trinidad and Tobago</option>
            <option value="TN">Tunisia</option>
            <option value="TR">Turkey</option>
            <option value="TM">Turkmenistan</option>
            <option value="TC">Turks and Caicos Islands</option>
            <option value="TV">Tuvalu</option>
            <option value="UG">Uganda</option>
            <option value="UA">Ukraine</option>
            <option value="AE">United Arab Emirates</option>
            <option value="GB">United Kingdom</option>
            <option value="US">United States</option>
            <option value="UM">United States Minor Outlying Islands</option>
            <option value="UY">Uruguay</option>
            <option value="UZ">Uzbekistan</option>
            <option value="VU">Vanuatu</option>
            <option value="VE">Venezuela, Bolivarian Republic of</option>
            <option value="VN">Viet Nam</option>
            <option value="VG">Virgin Islands, British</option>
            <option value="VI">Virgin Islands, U.S.</option>
            <option value="WF">Wallis and Futuna</option>
            <option value="EH">Western Sahara</option>
            <option value="YE">Yemen</option>
            <option value="ZM">Zambia</option>
            <option value="ZW">Zimbabwe</option>
          </select>
          <b class="country error"></b>
        </div>

        <div class="form-group">
          <label class="formlabel">Date of Birth</label>

          <div class="dobblk">
            <select name="date" id="logindate" class="date form-control forminput ddinput">
              <option value="">Date</option>
              <option value="01">01</option>
              <option value="02">02</option>
              <option value="03">03</option>
              <option value="04">04</option>
              <option value="05">05</option>
              <option value="06">06</option>
              <option value="07">07</option>
              <option value="08">08</option>
              <option value="09">09</option>
              <option value="10">10</option>
              <option value="11">11</option>
              <option value="12">12</option>
              <option value="13">13</option>
              <option value="14">14</option>
              <option value="15">15</option>
              <option value="16">16</option>
              <option value="17">17</option>
              <option value="18">18</option>
              <option value="19">19</option>
              <option value="20">20</option>
              <option value="21">21</option>
              <option value="22">22</option>
              <option value="23">23</option>
              <option value="24">24</option>
              <option value="25">25</option>
              <option value="26">26</option>
              <option value="27">27</option>
              <option value="28">28</option>
              <option value="29">29</option>
              <option value="30">30</option>
              <option value="31">31</option>
            </select>
            <b class="date error"></b>

            <select name="month" id="loginmonth" class="month form-control forminput moninput">
              <option value="" selected="" disabled="">Month</option>
              <option value="01">January</option>
              <option value="02">February</option>
              <option value="03">March</option>
              <option value="04">April</option>
              <option value="05">May</option>
              <option value="06">June</option>
              <option value="07">July</option>
              <option value="08">August</option>
              <option value="09">September</option>
              <option value="10">October</option>
              <option value="11">November</option>
              <option value="12">December</option>
            </select>
            <b class="month error"></b>

            <select name="year" id="loginyear" class=" year form-control forminput yearinputParent">
              <option value="">Year</option>
              {{--                            {!! country_code_html_select_options() !!}--}}
            </select>
            <b class="year error"></b>
          </div>
        </div>

        <div class="form-group selectbox">
          <input type="checkbox" name="terms" id="loginstep2Terms" class="ml120 step2Terms"/>

          <label class="checklabel5">I agree to the <a href="javascript:void(0)" class="termspopcall">Terms &
              Conditions</a> and <a href="https://www.nationalgallery.sg/privacy-policy"
                                    class="privacypopcall">Privacy Policy</a> of this online
            activity.</label>
          <b class="step2Terms error"></b>
        </div>

        <p class="errorMessage"></p>
        <div class="col-md-12 btnblock">
          {{--                    <button class="btn btn-back">Back</button>--}}
          <button class="btn btn-login " id="stepTwo">
            <div class="txn">Confirm</div>

          </button>
        </div>

      </div>

      <div class="modal-body login-blk step6" style="display: none">
        {{--                <a class="cancellogin"><img src="{{asset('front/img/close.png')}}"/></a>--}}
        <h2 class="formhding">Sign up for Children</h2>
        {{--                <p class="subline">On behalf of a family</p>--}}
        {{--                <p class="subline black">Step 3: Sign up for children</p>--}}


        <div class="addedchild all">

        </div>


        <div class="addchild ">
          <h3 class="addchildbtn">Add Child<a href="javascript:void(0)"><span
                class="plus">+</span><span
                class="minus">-</span></a></h3>

          <div class="inneraccord">
            <div class="form-group ">
              <label class="formlabel">First Name</label>

              <input type="text" name="Childfirstname" maxlength="30"
                     class="form-control forminput Childfirstname"/>
              <b class="VChildfirstname error"></b>
            </div>
            <div class="form-group ">
              <label class="formlabel">Last Name</label>

              <input type="text" name="Childlastname" maxlength="30"
                     class="form-control forminput Childlastname"/>
              <b class="VChildlastname error"></b>
            </div>
            <div class="form-group">
              <label class="formlabel">Gender</label>

              <select name="Childgender" class="gender form-control forminput genderinput">
                <option value="">Select</option>
                <option value="M">Male</option>
                <option value="F">Female</option>
              </select>
              <b class="Childgender error"></b>
            </div>

            <div class="form-group">
              <label class="formlabel">Date of Birth</label>


              <div class="dobblk">
                <select name="Childdate[]" class="Childdate form-control forminput ddinput">
                  <option value="" selected="" disabled="">Day</option>
                  <option value="01">01</option>
                  <option value="02">02</option>
                  <option value="03">03</option>
                  <option value="04">04</option>
                  <option value="05">05</option>
                  <option value="06">06</option>
                  <option value="07">07</option>
                  <option value="08">08</option>
                  <option value="09">09</option>
                  <option value="10">10</option>
                  <option value="11">11</option>
                  <option value="12">12</option>
                  <option value="13">13</option>
                  <option value="14">14</option>
                  <option value="15">15</option>
                  <option value="16">16</option>
                  <option value="17">17</option>
                  <option value="18">18</option>
                  <option value="19">19</option>
                  <option value="20">20</option>
                  <option value="21">21</option>
                  <option value="22">22</option>
                  <option value="23">23</option>
                  <option value="24">24</option>
                  <option value="25">25</option>
                  <option value="26">26</option>
                  <option value="27">27</option>
                  <option value="28">28</option>
                  <option value="29">29</option>
                  <option value="30">30</option>
                  <option value="31">31</option>
                </select>
                <b class="VChildmonth"></b>
                <select name="Childmonth[]" class="Childmonth form-control forminput moninput">
                  <option value="" selected="" disabled="">Month</option>
                  <option value="01">January</option>
                  <option value="02">February</option>
                  <option value="03">March</option>
                  <option value="04">April</option>
                  <option value="05">May</option>
                  <option value="06">June</option>
                  <option value="07">July</option>
                  <option value="08">August</option>
                  <option value="09">September</option>
                  <option value="10">October</option>
                  <option value="11">November</option>
                  <option value="12">December</option>
                </select>
                <b class="VChildyear"></b>
                <select name="Childyear[]" class="Childyear form-control forminput yearinput">
                  <option value="" selected="" disabled="">Year</option>
                  {{--                                    {!! country_code_html_select_options() !!}--}}
                </select>
              </div>
              <b class="VChilddate error"></b>
            </div>


            <div class="form-group">
              <button class="btn add-btn add-kid-to-list">Add</button>
            </div>
          </div>

        </div>
        <p class="errorMessage"></p>


        <div class="col-md-12 btnblock">
          <button class="btn btn-back" style="background: #c3d7c8;">Back</button>
          <button
            id="galleryExplorerMembershipUpgrade"
            type="submit"
            class="GalleryExplorerLogin2 btn btn-login"
          >
            <div class="txn">Confirm</div>

          </button>
        </div>

      </div>

      <div class="modal-body login-blk step7" style="display: none">
        {{--                <a class="cancellogin"><img src="{{asset('front/img/close.png')}}"/></a>--}}
        <h2 class="formhding">Sign up for Children</h2>


        <div class="addedchild all">

        </div>


        <div class="addchild ">
          <h3 class="addchildbtn">Add Child<a href="javascript:void(0)"><span
                class="plus">+</span><span
                class="minus">-</span></a></h3>

          <div class="inneraccord">
            <div class="form-group ">
              <label class="formlabel">First Name</label>

              <input type="text" name="Childfirstname" maxlength="30"
                     class="form-control forminput Childfirstname"/>
              <b class="VChildfirstname error"></b>
            </div>
            <div class="form-group ">
              <label class="formlabel">Last Name</label>

              <input type="text" name="Childlastname" maxlength="30"
                     class="form-control forminput Childlastname"/>
              <b class="VChildlastname error"></b>
            </div>

            <div class="form-group">
              <label class="formlabel">Gender</label>

              <select name="VChildgender" class="gender form-control forminput genderinput">
                <option value="">Select</option>
                <option value="M">Male</option>
                <option value="F">Female</option>
              </select>
              <b class="Childgender error"></b>
            </div>

            <div class="form-group">
              <label class="formlabel">Date of Birth</label>


              <div class="dobblk">
                <select name="Childdate[]" class="Childdate form-control forminput ddinput">
                  <option value="" selected="" disabled="">Day</option>
                  <option value="01">01</option>
                  <option value="02">02</option>
                  <option value="03">03</option>
                  <option value="04">04</option>
                  <option value="05">05</option>
                  <option value="06">06</option>
                  <option value="07">07</option>
                  <option value="08">08</option>
                  <option value="09">09</option>
                  <option value="10">10</option>
                  <option value="11">11</option>
                  <option value="12">12</option>
                  <option value="13">13</option>
                  <option value="14">14</option>
                  <option value="15">15</option>
                  <option value="16">16</option>
                  <option value="17">17</option>
                  <option value="18">18</option>
                  <option value="19">19</option>
                  <option value="20">20</option>
                  <option value="21">21</option>
                  <option value="22">22</option>
                  <option value="23">23</option>
                  <option value="24">24</option>
                  <option value="25">25</option>
                  <option value="26">26</option>
                  <option value="27">27</option>
                  <option value="28">28</option>
                  <option value="29">29</option>
                  <option value="30">30</option>
                  <option value="31">31</option>
                </select>
                <b class="VChildmonth"></b>
                <select name="Childmonth[]" class="Childmonth form-control forminput moninput">
                  <option value="" selected="" disabled="">Month</option>
                  <option value="01">January</option>
                  <option value="02">February</option>
                  <option value="03">March</option>
                  <option value="04">April</option>
                  <option value="05">May</option>
                  <option value="06">June</option>
                  <option value="07">July</option>
                  <option value="08">August</option>
                  <option value="09">September</option>
                  <option value="10">October</option>
                  <option value="11">November</option>
                  <option value="12">December</option>
                </select>
                <b class="VChildyear"></b>
                <select name="Childyear[]" class="Childyear form-control forminput yearinput">
                  <option value="" disabled="" selected="">Year</option>
                  {{--                                    {!! country_code_html_select_options() !!}--}}
                </select>
              </div>
              <b class="VChilddate error"></b>
            </div>


            <div class="form-group">
              <button class="btn add-btn add-kid-to-list">Add</button>
            </div>
          </div>

        </div>
        <p class="errorMessage"></p>


        <div class="col-md-12 btnblock">
          <button class="btn btn-back" style="background: #c3d7c8;">Back</button>
          <button type="submit" id="galleryInsiderMembershipUpgrade"
                  class="GalleryExplorerLogin2 btn btn-login">
            <div class="txn">Confirm</div>

          </button>
        </div>

      </div>

      @auth
        <div
          class="modal-body login-blk missing-window"
          style="display: none"
        >
          <h2 class="formhding">Hi! You're a Gallery Parent Explorer!</h2>
          <p class="subline black">Additional Info Required!</p>
          <p class="subline">Some missing information are required to complete your profile:</p>


          <div class="form-group">
            <label class="formlabel">Gender</label>

            <select
              name="gender"
              id="missinggender"
              class="gender form-control forminput"
              required
            >
              <option value="">Select</option>
              <option value="M">Male</option>
              <option value="F">Female</option>
            </select>
            <b class="gender error"></b>
          </div>
          <div class="form-group ">
            <label class="formlabel">Mobile</label>

            <input
              type="text"
              name="mobile"
              id="missingmobile"
              maxlength="10"
              class="mobile form-control forminput numvar"
              required
            />
            <b class="mobile error"></b>
          </div>

          <div class="form-group">
            <label class="formlabel" style="margin-top: -2px;margin-bottom: 13px;">Country of
              Residence</label>

            <select
              name="country"
              id="missingcountry"
              class="country form-control forminput "
            >
              <option value="">Country</option>
              <option value="AF">Afghanistan</option>
              <option value="AX">Aland Islands</option>
              <option value="AL">Albania</option>
              <option value="DZ">Algeria</option>
              <option value="AS">American Samoa</option>
              <option value="AD">Andorra</option>
              <option value="AO">Angola</option>
              <option value="AI">Anguilla</option>
              <option value="AQ">Antarctica</option>
              <option value="AG">Antigua and Barbuda</option>
              <option value="AR">Argentina</option>
              <option value="AM">Armenia</option>
              <option value="AW">Aruba</option>
              <option value="AU">Australia</option>
              <option value="AT">Austria</option>
              <option value="AZ">Azerbaijan</option>
              <option value="BS">Bahamas</option>
              <option value="BH">Bahrain</option>
              <option value="BD">Bangladesh</option>
              <option value="BB">Barbados</option>
              <option value="BY">Belarus</option>
              <option value="BE">Belgium</option>
              <option value="BZ">Belize</option>
              <option value="BJ">Benin</option>
              <option value="BM">Bermuda</option>
              <option value="BT">Bhutan</option>
              <option value="BO">Bolivia, Plurinational State of</option>
              <option value="BQ">Bonaire, Sint Eustatius and Saba</option>
              <option value="BA">Bosnia and Herzegovina</option>
              <option value="BW">Botswana</option>
              <option value="BV">Bouvet Island</option>
              <option value="BR">Brazil</option>
              <option value="IO">British Indian Ocean Territory</option>
              <option value="BN">Brunei Darussalam</option>
              <option value="BG">Bulgaria</option>
              <option value="BF">Burkina Faso</option>
              <option value="BI">Burundi</option>
              <option value="KH">Cambodia</option>
              <option value="CM">Cameroon</option>
              <option value="CA">Canada</option>
              <option value="CV">Cape Verde</option>
              <option value="KY">Cayman Islands</option>
              <option value="CF">Central African Republic</option>
              <option value="TD">Chad</option>
              <option value="CL">Chile</option>
              <option value="CN">China</option>
              <option value="CX">Christmas Island</option>
              <option value="CC">Cocos (Keeling) Islands</option>
              <option value="CO">Colombia</option>
              <option value="KM">Comoros</option>
              <option value="CG">Congo</option>
              <option value="CD">Congo, the Democratic Republic of the</option>
              <option value="CK">Cook Islands</option>
              <option value="CR">Costa Rica</option>
              <option value="CI">Cote d'Ivoire</option>
              <option value="HR">Croatia</option>
              <option value="CU">Cuba</option>
              <option value="CW">Curacao</option>
              <option value="CY">Cyprus</option>
              <option value="CZ">Czech Republic</option>
              <option value="DK">Denmark</option>
              <option value="DJ">Djibouti</option>
              <option value="DM">Dominica</option>
              <option value="DO">Dominican Republic</option>
              <option value="EC">Ecuador</option>
              <option value="EG">Egypt</option>
              <option value="SV">El Salvador</option>
              <option value="GQ">Equatorial Guinea</option>
              <option value="ER">Eritrea</option>
              <option value="EE">Estonia</option>
              <option value="ET">Ethiopia</option>
              <option value="FK">Falkland Islands (Malvinas)</option>
              <option value="FO">Faroe Islands</option>
              <option value="FJ">Fiji</option>
              <option value="FI">Finland</option>
              <option value="FR">France</option>
              <option value="GF">French Guiana</option>
              <option value="PF">French Polynesia</option>
              <option value="TF">French Southern Territories</option>
              <option value="GA">Gabon</option>
              <option value="GM">Gambia</option>
              <option value="GE">Georgia</option>
              <option value="DE">Germany</option>
              <option value="GH">Ghana</option>
              <option value="GI">Gibraltar</option>
              <option value="GR">Greece</option>
              <option value="GL">Greenland</option>
              <option value="GD">Grenada</option>
              <option value="GP">Guadeloupe</option>
              <option value="GU">Guam</option>
              <option value="GT">Guatemala</option>
              <option value="GG">Guernsey</option>
              <option value="GN">Guinea</option>
              <option value="GW">Guinea-Bissau</option>
              <option value="GY">Guyana</option>
              <option value="HT">Haiti</option>
              <option value="HM">Heard Island and McDonald Islands</option>
              <option value="VA">Holy See (Vatican City State)</option>
              <option value="HN">Honduras</option>
              <option value="HK">Hong Kong</option>
              <option value="HU">Hungary</option>
              <option value="IS">Iceland</option>
              <option value="IN">India</option>
              <option value="ID">Indonesia</option>
              <option value="IR">Iran, Islamic Republic of</option>
              <option value="IQ">Iraq</option>
              <option value="IE">Ireland</option>
              <option value="IM">Isle of Man</option>
              <option value="IL">Israel</option>
              <option value="IT">Italy</option>
              <option value="JM">Jamaica</option>
              <option value="JP">Japan</option>
              <option value="JE">Jersey</option>
              <option value="JO">Jordan</option>
              <option value="KZ">Kazakhstan</option>
              <option value="KE">Kenya</option>
              <option value="KI">Kiribati</option>
              <option value="KP">Korea, Democratic People's Republic of</option>
              <option value="KR">Korea, Republic of</option>
              <option value="KW">Kuwait</option>
              <option value="KG">Kyrgyzstan</option>
              <option value="LA">Lao People's Democratic Republic</option>
              <option value="LV">Latvia</option>
              <option value="LB">Lebanon</option>
              <option value="LS">Lesotho</option>
              <option value="LR">Liberia</option>
              <option value="LY">Libya</option>
              <option value="LI">Liechtenstein</option>
              <option value="LT">Lithuania</option>
              <option value="LU">Luxembourg</option>
              <option value="MO">Macao</option>
              <option value="MK">Macedonia, the former Yugoslav Republic of</option>
              <option value="MG">Madagascar</option>
              <option value="MW">Malawi</option>
              <option value="MY">Malaysia</option>
              <option value="MV">Maldives</option>
              <option value="ML">Mali</option>
              <option value="MT">Malta</option>
              <option value="MH">Marshall Islands</option>
              <option value="MQ">Martinique</option>
              <option value="MR">Mauritania</option>
              <option value="MU">Mauritius</option>
              <option value="YT">Mayotte</option>
              <option value="MX">Mexico</option>
              <option value="FM">Micronesia, Federated States of</option>
              <option value="MD">Moldova, Republic of</option>
              <option value="MC">Monaco</option>
              <option value="MN">Mongolia</option>
              <option value="ME">Montenegro</option>
              <option value="MS">Montserrat</option>
              <option value="MA">Morocco</option>
              <option value="MZ">Mozambique</option>
              <option value="MM">Myanmar</option>
              <option value="NA">Namibia</option>
              <option value="NR">Nauru</option>
              <option value="NP">Nepal</option>
              <option value="NL">Netherlands</option>
              <option value="NC">New Caledonia</option>
              <option value="NZ">New Zealand</option>
              <option value="NI">Nicaragua</option>
              <option value="NE">Niger</option>
              <option value="NG">Nigeria</option>
              <option value="NU">Niue</option>
              <option value="NF">Norfolk Island</option>
              <option value="MP">Northern Mariana Islands</option>
              <option value="NO">Norway</option>
              <option value="OM">Oman</option>
              <option value="PK">Pakistan</option>
              <option value="PW">Palau</option>
              <option value="PS">Palestinian Territory, Occupied</option>
              <option value="PA">Panama</option>
              <option value="PG">Papua New Guinea</option>
              <option value="PY">Paraguay</option>
              <option value="PE">Peru</option>
              <option value="PH">Philippines</option>
              <option value="PN">Pitcairn</option>
              <option value="PL">Poland</option>
              <option value="PT">Portugal</option>
              <option value="PR">Puerto Rico</option>
              <option value="QA">Qatar</option>
              <option value="RE">Reunion</option>
              <option value="RO">Romania</option>
              <option value="RU">Russian Federation</option>
              <option value="RW">Rwanda</option>
              <option value="BL">Saint Barthelemy</option>
              <option value="SH">Saint Helena, Ascension and Tristan da Cunha</option>
              <option value="KN">Saint Kitts and Nevis</option>
              <option value="LC">Saint Lucia</option>
              <option value="MF">Saint Martin (French part)</option>
              <option value="PM">Saint Pierre and Miquelon</option>
              <option value="VC">Saint Vincent and the Grenadines</option>
              <option value="WS">Samoa</option>
              <option value="SM">San Marino</option>
              <option value="ST">Sao Tome and Principe</option>
              <option value="SA">Saudi Arabia</option>
              <option value="SN">Senegal</option>
              <option value="RS">Serbia</option>
              <option value="SC">Seychelles</option>
              <option value="SL">Sierra Leone</option>
              <option value="SG">Singapore</option>
              <option value="SX">Sint Maarten (Dutch part)</option>
              <option value="SK">Slovakia</option>
              <option value="SI">Slovenia</option>
              <option value="SB">Solomon Islands</option>
              <option value="SO">Somalia</option>
              <option value="ZA">South Africa</option>
              <option value="GS">South Georgia and the South Sandwich Islands</option>
              <option value="SS">South Sudan</option>
              <option value="ES">Spain</option>
              <option value="LK">Sri Lanka</option>
              <option value="SD">Sudan</option>
              <option value="SR">Suriname</option>
              <option value="SJ">Svalbard and Jan Mayen</option>
              <option value="SZ">Swaziland</option>
              <option value="SE">Sweden</option>
              <option value="CH">Switzerland</option>
              <option value="SY">Syrian Arab Republic</option>
              <option value="TW">Taiwan, Province of China</option>
              <option value="TJ">Tajikistan</option>
              <option value="TZ">Tanzania, United Republic of</option>
              <option value="TH">Thailand</option>
              <option value="TL">Timor-Leste</option>
              <option value="TG">Togo</option>
              <option value="TK">Tokelau</option>
              <option value="TO">Tonga</option>
              <option value="TT">Trinidad and Tobago</option>
              <option value="TN">Tunisia</option>
              <option value="TR">Turkey</option>
              <option value="TM">Turkmenistan</option>
              <option value="TC">Turks and Caicos Islands</option>
              <option value="TV">Tuvalu</option>
              <option value="UG">Uganda</option>
              <option value="UA">Ukraine</option>
              <option value="AE">United Arab Emirates</option>
              <option value="GB">United Kingdom</option>
              <option value="US">United States</option>
              <option value="UM">United States Minor Outlying Islands</option>
              <option value="UY">Uruguay</option>
              <option value="UZ">Uzbekistan</option>
              <option value="VU">Vanuatu</option>
              <option value="VE">Venezuela, Bolivarian Republic of</option>
              <option value="VN">Viet Nam</option>
              <option value="VG">Virgin Islands, British</option>
              <option value="VI">Virgin Islands, U.S.</option>
              <option value="WF">Wallis and Futuna</option>
              <option value="EH">Western Sahara</option>
              <option value="YE">Yemen</option>
              <option value="ZM">Zambia</option>
              <option value="ZW">Zimbabwe</option>
            </select>
            <b class="country error"></b>
          </div>

          <div class="form-group">
            <label class="formlabel">Date of Birth</label>

            <div class="dobblk">
              <select
                name="date"
                id="missingdate"
                class="date form-control forminput ddinput"
                required
              >
                <option value="">Date</option>
                <option value="01">01</option>
                <option value="02">02</option>
                <option value="03">03</option>
                <option value="04">04</option>
                <option value="05">05</option>
                <option value="06">06</option>
                <option value="07">07</option>
                <option value="08">08</option>
                <option value="09">09</option>
                <option value="10">10</option>
                <option value="11">11</option>
                <option value="12">12</option>
                <option value="13">13</option>
                <option value="14">14</option>
                <option value="15">15</option>
                <option value="16">16</option>
                <option value="17">17</option>
                <option value="18">18</option>
                <option value="19">19</option>
                <option value="20">20</option>
                <option value="21">21</option>
                <option value="22">22</option>
                <option value="23">23</option>
                <option value="24">24</option>
                <option value="25">25</option>
                <option value="26">26</option>
                <option value="27">27</option>
                <option value="28">28</option>
                <option value="29">29</option>
                <option value="30">30</option>
                <option value="31">31</option>
              </select>
              <b class="date error"></b>

              <select
                name="month"
                id="missingmonth"
                class="month form-control forminput moninput"
                required
              >
                <option value="" selected="" disabled="">Month</option>
                <option value="01">January</option>
                <option value="02">February</option>
                <option value="03">March</option>
                <option value="04">April</option>
                <option value="05">May</option>
                <option value="06">June</option>
                <option value="07">July</option>
                <option value="08">August</option>
                <option value="09">September</option>
                <option value="10">October</option>
                <option value="11">November</option>
                <option value="12">December</option>
              </select>
              <b class="month error"></b>

              <select
                name="year"
                id="missingyear"
                class=" year form-control forminput yearinputParent"
                required
              >
                <option value="">Year</option>
              </select>
              <b class="year error"></b>
            </div>
          </div>


          <p class="errorMessage"></p>
          <div class="col-md-12 btnblock">
            {{--                    <button class="btn btn-back">Back</button>--}}
            <button class="btn btn-login " id="submitMissingInfo">
              <div class="txn">Confirm</div>

            </button>
          </div>

        </div>
      @endauth

      @guest
        <div class="modal-body login-blk auth0-fails" style="display: none">
          <a class="cancellogin close-popup"><img src="{{asset('front/img/close.png')}}"/></a>
          <h2 class="welcomehding ">Authentication Error</h2>
          <p class="subline">Server authentication error. Please try again.</p>

          <button class="btn btn-login SimpleLogin close-popup">
            <div class="txn close-popup">Ok</div>
          </button>

        </div>

        <div class="modal-body login-blk auth0-core-error" style="display: none">
          <a class="cancellogin close-popup"><img src="{{asset('front/img/close.png')}}"/></a>
          <h2 class="welcomehding ">Authentication Error</h2>
          <p class="subline">Invalid Session. Please try again.</p>

          <button class="btn btn-login SimpleLogin close-popup">
            <div class="txn close-popup">Ok</div>
          </button>

        </div>
      @endguest

    </div>
  </div>
</div>
<div id="findmore-modal" class="modal" role="dialog">
  <div class="preloader"></div>
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <!-- Modal content-->
    <div class="modal-content">
      {{--            <a class="cancellogin cancel"><img src="{{asset('front/img/close.png')}}"/></a>--}}
      <div class="modal-body login-blk ">
        <h2 class="welcomehding ">WELCOME TO GALLERYKIDS!</h2>
        <p class="subline ">Become a member to enjoy these benefits </p>

        {{-- <p>November 2020 launch special: Sign up as a member and redeem either an ice cream or a book on Saturdays and Sundays! Flash your GalleryKids! membership at the redemption point near Keppel Centre for Art Education at the Gallery to redeem your gift.</p>
            <p><i>Redemption is limited to the first 200 visitors on a first come first service basis,  from 10am. </i>
            </p>
             <p><i>Redemption available in November, and while stock last!  </i>
            </p> --}}
        {{-- <h4 class="membersub">Membership Benefits:</h4> --}}
        <ul class="findmorelist">
          <li>Special GalleryKids! Menus with exclusive dishes for members only at selected dining venues.
          </li>
          <li>10% discount for Gallery Children's publications.</li>
          <li>Monthly newsletters featuring new GalleryKids! Programmes.</li>
          <li>Register as a GalleryKids! member and receive a Welcome Badge. Keep a look out for unique badges
            in upcoming months!
          </li>
          <li>Special GalleryKids! programmes.</li>
          <li>First dibs for events and festivals specially created for children.</li>
        </ul>
        @if(!Auth::check())
          <button class="btn btn-login register yellowbg">Be a member today!</button>
        @endif
      </div>
    </div>
  </div>
</div>
<div id="firstloginmodal" class="modal" role="dialog">
  <div class="preloader"></div>
  <div class="modal-dialog modal-dialog-centered">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-body login-blk">
        {{--                <a class="cancellogin cancel"><img src="{{asset('front/img/close.png')}}"></a>--}}
        <h2 class="formhding black">My Favourites</h2>
        <p class="subline black">To add this to your Favourites, log in or sign up as a member today!</p>
        <div class="memberbtn">
          <!--<button class="btn btn-login login1 yellowbg">Login</button>-->
          <button class="btn btn-login register yellowbg">Login</button>&nbsp;
          <button class="btn btn-login register yellowbg">Be a member today!</button>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- Scripts -->
<script src="{{asset('front/js/jquery.min.js')}}"></script>
<script src="{{asset('front/js/jquery.flexslider-min.js')}}"></script>
<script src="{{asset('front/js/bootstrap.min.js')}}"></script>

<!-- <script src="{{asset('front/js/script.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/animejs/2.0.2/anime.min.js"></script> -->
<script type="text/javascript">
  $(document).ready(function () {
    $(".Rstep7").hide();

    $(".menuleft").click(function () {
      $("#mobile-menu").addClass("active")
    })
    $(".closeMenu").click(function () {
      $("#mobile-menu").removeClass("active")
    })

    $(".findmore").click(function () {
      $("#findmore-modal").modal("show");
    })
    $(".cancel").click(function () {
      $(".modal").modal("hide");
    })
    // $(".registernow").click(function () {
    //     $("#findmore-modal").modal("show");
    // })

  })
</script>
@yield('script')
@guest
  <script>
    // Show a popup if Auth0 Authentication failed
    var auth0Failed = {{(int) session('auth0_authentication_error')}};
    if (auth0Failed) {
      $('.auth0-fails').show();

      $("#login-modal1").modal({
        backdrop: false
      });
    }

    // Show a popup if Invalid state error is showing
    var auth0CoreError = {{(int) session('auth0_core_exception')}};
    if (auth0CoreError) {
      $('.auth0-core-error').show();

      $("#login-modal1").modal({
        backdrop: false
      });
    }

    $('.close-popup').click(function () {
      $("#login-modal1").modal('hide');
    });
  </script>
@endguest

@auth
  <script>
    // Show Login Screen
    var loginScreen = '{{optional(auth()->user()->data)->post_login_screen}}';

    var hasMissingInfo = '{{show_missing_profile_info_window()}}';
    var userGender = '{{auth()->user()->gender}}';
    var userMobileNumber = '{{auth()->user()->mobile}}';
    var userCountryCode = '{{auth()->user()->country}}';
    var userBirthDay = '{{str_pad(optional(auth()->user()->dob)->day, 2, '0', STR_PAD_LEFT)}}';
    var userBirthMonth = '{{str_pad(optional(auth()->user()->dob)->month, 2, '0', STR_PAD_LEFT)}}';
    var userBirthYear = '{{optional(auth()->user()->dob)->year}}';

    $(document).ready(function () {

      var startyear = new Date().getFullYear() - 1;
      var endtyear = new Date().getFullYear() - 11;
      for (var i = startyear; i >= endtyear; i--) {
        var opp = "<option value='" + i + "'>" + i + "</option>";
        $(".yearinput").append(opp)
      }

      var startyear1 = new Date().getFullYear() - 21;
      var endtyear1 = startyear1 - 50;
      for (var i = startyear1; i >= endtyear1; i--) {
        var opp = "<option value='" + i + "'>" + i + "</option>";
        $(".yearinputParent").append(opp)
      }

      if (hasMissingInfo) {
        $(".missing-window").show();
        $("#login-modal1").modal({
          backdrop: false
        });

        // Fill data
        if (userGender) {
          $('#missinggender').find('option[value="' + userGender + '"]').prop('selected', 'selected');
        }

        if (userMobileNumber) {
          $('#missingmobile').val(userMobileNumber);
        }

        if (userCountryCode) {
          $('#missingcountry').find('option[value="' + userCountryCode + '"]').prop('selected', 'selected');
        }

        if (userBirthDay) {
          $('#missingdate').find('option[value="' + userBirthDay + '"]').prop('selected', 'selected');
        }

        if (userBirthMonth) {
          $('#missingmonth').find('option[value="' + userBirthMonth + '"]').prop('selected', 'selected');
        }

        if (userBirthYear) {
          $('#missingyear').find('option[value="' + userBirthYear + '"]').prop('selected', 'selected');
        }
      }

      if (loginScreen) {
        if ('GI' === loginScreen) {
          $(".step8").show();
        } else {

          if (userGender) {
            $('#logingender').find('option[value="' + userGender + '"]').prop('selected', 'selected');
          }

          if (userMobileNumber) {
            $('#loginmobile').val(userMobileNumber);
          }

          if (userCountryCode) {
            $('#logincountry').find('option[value="' + userCountryCode + '"]').prop('selected', 'selected');
          }

          if (userBirthDay) {
            $('#logindate').find('option[value="' + userBirthDay + '"]').prop('selected', 'selected');
          }

          if (userBirthMonth) {
            $('#loginmonth').find('option[value="' + userBirthMonth + '"]').prop('selected', 'selected');
          }

          if (userBirthYear) {
            $('#loginyear').find('option[value="' + userBirthYear + '"]').prop('selected', 'selected');
          }

          $(".step5").show();
        }
        // $("#login-modal1").find(".spinner").show();
        $("#login-modal1").modal({
          backdrop: false
        });
      }

      // Let's go to Step two
      $('#stepTwo').click(function () {

        $(".step5 .gender.error").empty();
        $(".step5 .mobile.error").empty();
        $(".step5 .country.error").empty();
        $(".step5 .date.error").empty();
        $(".step5 .month.error").empty();
        $(".step5 .year.error").empty();
        $(".step5 .step2Terms.error").empty();

        if ($('.step5 .gender').val() == "") {
          $(".step5 .gender.error").append("<b style='color:red;'>Select Gender!</b>");
          return false;
        } else if ($('.step5 .mobile').val() == "") {
          $(".step5 .mobile.error").append("<b style='color:red;'>Mobile Number required!</b>");
          return false;
        } else if ($('.step5 .country').val() == "") {
          $(".step5 .country.error").append("<b style='color:red;'>Country required!</b>");
          return false;
        } else if ($('.step5 .date').val() == "") {
          $(".step5 .date.error").append("<b style='color:red;'>Date required!</b>");
          return false;
        } else if ($('.step5 .month').val() == null) {
          $(".step5 .month.error").append("<b style='color:red;'>Month required!</b>");
          return false;
        } else if ($('.step5 .year').val() == "") {
          $(".step5 .year.error").append("<b style='color:red;'>Year required!</b>");
          return false;
        } else if ($('#loginstep2Terms').prop("checked") == false) {
          $(".step5 .step2Terms.error").append("<b style='color:red;'>Please accept terms and conditions!</b>");
          return false;
        } else {
          $(".step6").show();
          $(".step5").hide();
        }

        // if($('#loginstep2Terms').prop("checked") == false){
        //     $(".step2Terms.error").append("<b style='color:red;'>Please accept terms and conditions!</b>");

        // }
        // else{
        // $(this).prop( "disabled", true );
        // $(".step6").show();
        //  $(".step5").hide();
        //     $(this).prop( "disabled", false );
        // }


      });

      $(".termspopcall").click(function () {
        $("#termsandcondition1").modal('show')
      });


      $(".step6 .btn-back").click(function () {
        $(".step5").show();
        $(".step6").hide();
      });


      $(".step7 .btn-back").click(function () {
        $(".step8").show();
        $(".step7").hide();
      });

      $("#stepeight").click(function () {
        $(".step8Terms").empty();
        if ($('#terms8').prop("checked") == true) {
          $(".step7").show();
          $(".step8").hide();
        } else {

          $(".step8Terms").append("<b style='color:red;'>Please accept terms and conditions</b>");
        }

      })

      $(".termspopcall").click(function () {
        $("#termsandcondition1").modal('show')
      })

      $(".termscancel").click(function () {
        $("#termsandcondition1").modal('hide')
      })

      $(".addchildbtn").click(function () {
        $(".addchild").toggleClass("active");
      })


      $(".add-kid-to-list").click(function () {


        var route = $(this).parents(".form-group").parents(".inneraccord");

        var fname = route.find("input[name='Childfirstname']").val();
        var lname = route.find("input[name='Childlastname']").val();
        var gender = route.find(".genderinput").val();
        var date = route.find(".ddinput").val();
        var month = route.find(".moninput").val();
        var year = route.find(".yearinput").val();

        var dt = {
          firstname: fname,
          lastname: lname,
          gender: gender,
          dob: date + "/" + month + "/" + year
        };
        var closeButton = "{{ asset('front/img/close.png') }}";
        console.log(fname, lname, date, month, year, gender)
        if (fname && lname && date && month && year && gender) {
          $(this).parents(".addchild").prev(".addedchild.all").append("<div class='child1' data='" + JSON.stringify(dt) + "'>" +
            "<h3>" + fname + " " + lname + "<a href='javascript:void(0)' class='addchildbtn removebtn'><img src=" + closeButton + "></a></h3>" +
            "</div>")


          route.find("input[name='Childfirstname']").val('');
          route.find("input[name='Childlastname']").val('');
          route.find("input[name='Childgender']").val('');
          route.find(".genderinput").val('');
          route.find(".ddinput").val('');
          route.find(".moninput").val('');
          route.find(".yearinput").val('');
        }
      })

      $('#galleryExplorerMembershipUpgrade').click(function () {
        $(".errorMessage").empty(); // clean all existing error messages

        // Show error if at least on child havn't added
        if ($(".step6").find(".addedchild.all .child1").length == 0) {
          $(".step6").find(".errorMessage").append("<b style='color:red;' >At least One child is required.</b>")
          return false;
        }

        // Disable the submmit button to prevent multiple clicks
        $(this).prop("disabled", true);

        // Show loader to give user a feedback
        $("#login-modal1").find(".spinner").show();

        // Build Form Data
        var formData = new FormData();
        formData.append('_token', "{{ csrf_token() }}");
        formData.append('country', $('#logincountry').val());
        formData.append('mobile', $('#loginmobile').val());
        formData.append('gender', $('#logingender').val());
        formData.append('dob', $('#logindate').val() + "/" + $('#loginmonth').val() + "/" + $('#loginyear').val());

        // Add kids data to the form
        $(".step6").find(".addedchild.all .child1").each(function (index) {
          var childdata = JSON.parse($(this).attr('data'));

          formData.append('kids[' + index + '][firstname]', childdata.firstname);
          formData.append('kids[' + index + '][lastname]', childdata.lastname);
          formData.append('kids[' + index + '][gender]', childdata.gender);
          formData.append('kids[' + index + '][dob]', childdata.dob);

        });

        $.ajax({
          async: true,
          url: '{{url()->route('membersonGEUpgrade')}}',
          data: formData,
          cache: false,
          processData: false,
          contentType: false,
          type: 'POST',
          success: function (data) {
            console.log(data)

            $("#galleryExplorerMembershipUpgrade").prop("disabled", false);
            $("#login-modal1").find(".spinner").hide();
            window.location.reload(true);
          },
          error: function (data) {
            if (data.errors) {
              $(".errorMessage").innerHTML = '<p>Something information is missing. Please try to fill the form again</p>';
            }
            $("#galleryExplorerMembershipUpgrade").prop("disabled", false);
            $("#login-modal1").find(".spinner").hide();
            return false;
          }
        });
      });


      $("#galleryInsiderMembershipUpgrade").click(function () {
        $(".errorMessage").empty();
        if ($(".step7").find(".addedchild.all .child1").length == 0) {
          $(".step7").find(".errorMessage").append("<b style='color:red;' >At least One child is required.</b>")
          return false;
        }


        $(this).prop("disabled", true);
        $("#login-modal1").find(".spinner").show();
        var formData = new FormData();
        formData.append('_token', "{{ csrf_token() }}");

        $(".step7").find(".addedchild.all .child1").each(function (index) {
          var childdata = JSON.parse($(this).attr('data'));

          formData.append('kids[' + index + '][firstname]', childdata.firstname);
          formData.append('kids[' + index + '][lastname]', childdata.lastname);
          formData.append('kids[' + index + '][gender]', childdata.gender);
          formData.append('kids[' + index + '][dob]', childdata.dob);
        });

        console.log(formData)

        $.ajax({
          async: true,
          url: '{{url()->route('memberson-add-kids')}}',
          data: formData,
          cache: false,
          processData: false,
          contentType: false,
          type: 'POST',
          success: function (data) {
            $("#galleryInsiderMembershipUpgrade").prop("disabled", false);
            $("#login-modal1").find(".spinner").hide();
            window.location.replace(removeParam('loggedin', window.location.href));
          },
          error: function (data) {
            $("#galleryInsiderMembershipUpgrade").prop("disabled", false);
            $("#login-modal1").find(".spinner").hide();
            if (data.errors) {
              $(".errorMessage").append("<b style='color:red;'>Something information is missing. Please try to fill the form again</b>");
            }
            return false;
          }
        });

      });

      $(".GalleryExplorerLogin2").click(function () {

        $(".loginEmail").empty();
        $(".loginPass").empty();
        if ($('#loginEmail').val() == "") {
          $(".loginEmail").append("<b style='color:red;'>Email Required!</b>");
          return false;
        }
        if ($('#loginPass').val() == "") {
          $(".loginPass").append("<b style='color:red;'>Password required!</b>");
          return false;
        }

        $(".errorMessage").empty();
        if ($(".step7").find(".addedchild.all .child1").length == 0) {
          $(".step7").find(".errorMessage").append("<b style='color:red;' >At least One child is required.</b>")
          return false;
        }


        $(this).prop("disabled", true);
        $("#login-modal1").find(".spinner").show();
        var formData = new FormData();
        formData.append('_token', "{{ csrf_token() }}");
        formData.append('email', $('#loginEmail').val());
        formData.append('password', $('#loginPass').val());
        // formData.append('country',$('#logincountry').val());
        // formData.append('mobile',$('#loginmobile').val());
        // formData.append('gender',$('#logingender').val());
        // formData.append('date',$('#logindate').val()+"/"+$('#loginmonth').val()+"/"+$('#loginyear').val());


        $(".step7").find(".addedchild.all .child1").each(function (index) {
          var childdata = JSON.parse($(this).attr('data'));

          formData.append('Childs[' + index + '][Childfirstname]', childdata.firstname);
          formData.append('Childs[' + index + '][Childlastname]', childdata.lastname);
          formData.append('Childs[' + index + '][Childdate]', childdata.dob);


        });


        console.log(formData)

        $.ajax({
          async: true,
          url: '{{url("LoginTypeThree")}}',
          data: formData,
          cache: false,
          processData: false,
          contentType: false,
          type: 'POST',
          success: function (data) {
            window.location.reload(true);
            //                        if(data.responseJSON.message == 'success'){
            //                                  window.location.reload(true);
            //                               }
            $(".GalleryExplorerLogin2").prop("disabled", false);
            $("#login-modal1").find(".spinner").hide();

          },
          error: function (data) {
            if (data.responseJSON.message == 'Gallery Explorer') {
              $(".step5").show();
              $(".step6").hide();
            }
            if (data.responseJSON.message == 'NOTCREATED') {
              $(".step7").show();
              $(".step5").hide();
            }
            $(".GalleryExplorerLogin2").prop("disabled", false);
            $("#login-modal1").find(".spinner").hide();
            //                      $(".errorMessage").append("<b style='color:red;'>"+data.responseJSON.message+"</b>");
            return false;
          }
        });

      });

      // Submit Missing Profile Info
      $('#submitMissingInfo').click(function () {
        $(".errorMessage").empty(); // clean all existing error messages

        // Disable the submmit button to prevent multiple clicks
        $(this).prop("disabled", true);

        // Show loader to give user a feedback
        $("#login-modal1").find(".spinner").show();

        // Build Form Data
        var formData = new FormData();
        formData.append('_token', "{{ csrf_token() }}");
        formData.append('country', $('#missingcountry').val());
        formData.append('mobile', $('#missingmobile').val());
        formData.append('gender', $('#missinggender').val());
        formData.append('dob', $('#missingdate').val() + "/" + $('#missingmonth').val() + "/" + $('#missingyear').val());

        $.ajax({
          async: true,
          url: '{{url("update-profile-info")}}',
          data: formData,
          cache: false,
          processData: false,
          contentType: false,
          type: 'POST',
          success: function (data) {
            $(".errorMessage").append("<b style='color:green;'>Profile info updated successfully!</b>");
            $("#login-modal1").find(".spinner").hide();

            setTimeout(function () {
              $("#login-modal1").modal({
                backdrop: false
              }).hide();
              $(".missing-window").hide();
            }, 2000);
          },
          error: function (data) {
            $(".GalleryExplorerLogin2").prop("disabled", false);
            $("#login-modal1").find(".spinner").hide();
            $(".errorMessage").append("<b style='color:red;'>" + data.responseJSON.message + "</b>");
            return false;
          }
        });
      }); // END of Submit Missing Profile Info


      function removeParam(key, sourceURL) {
        var rtn = sourceURL.split("?")[0],
          param,
          params_arr = [],
          queryString = (sourceURL.indexOf("?") !== -1) ? sourceURL.split("?")[1] : "";
        if (queryString !== "") {
          params_arr = queryString.split("&");
          for (var i = params_arr.length - 1; i >= 0; i -= 1) {
            param = params_arr[i].split("=")[0];
            if (param === key) {
              params_arr.splice(i, 1);
            }
          }
          rtn = rtn + "?" + params_arr.join("&");
        }
        return rtn;
      }

      $(document).on("click", "a.removebtn", function () {
        $(this).parents(".child1").remove();
      });

    });
  </script>
@endauth

@guest
  <script>

    function IsEmail(email) {
      var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
      if (!regex.test(email)) {
        return false;
      } else {
        return true;
      }
    }

    var specialKeys = new Array();
    specialKeys.push(8); //Backspace
    $(function () {
      $('.numvar').keyup(function () {
        if (this.value != this.value.replace(/[^0-9\/]/g, '')) {
          this.value = this.value.replace(/[^0-9\/]/g, '');
        }
      });
    });

    $(document).ready(function () {


      var startyear = new Date().getFullYear() - 1;
      var endtyear = new Date().getFullYear() - 11;
      for (var i = startyear; i >= endtyear; i--) {
        var opp = "<option value='" + i + "'>" + i + "</option>";
        $(".yearinput").append(opp)
      }

      var startyear1 = new Date().getFullYear() - 21;
      var endtyear1 = startyear1 - 50;
      for (var i = startyear1; i >= endtyear1; i--) {
        var opp = "<option value='" + i + "'>" + i + "</option>";
        $(".yearinputParent").append(opp)
      }


      $('#stepOne').click(function () {

        $(".firstname").empty();
        $(".lastname").empty();
        $(".email").empty();
        $(".password").empty();
        $(".repassword").empty();
        $(".terms").empty();
        var patt = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[#$@!%&*?])[A-Za-z\d#$@!%&*?]{8,30}$/;
        if ($('#firstname').val() == "") {
          $(".firstname").append("<b style='color:red;'>First name required</b>");
          return false;
        } else if ($('#lastname').val() == "") {
          $(".lastname").append("<b style='color:red;'>Last name required</b>");
          return false;
        }
        var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
        if (!reg.test($('#email').val())) {
          //   alert('Please provide a valid email address');
          $(".email").append("<b style='color:red;'>Please provide a valid email address</b>");
          return false;
        }

          // else if ($('#password').val() == "") {
          //     $(".password").append("<b style='color:red;'>Password required!</b>");
          //     return false;
        // }

        else if (!patt.test($('#password').val())) {

          $(".password").append("<b style='color:red;font-size: 10px;'>Passwords should be 8 characters and include upper- and lower-case letters, a number, and a special character.</b>");
          return false;
        } else if ($('#password').val() !== $('#repassword').val()) {
          $(".repassword").append("<b style='color:red;'>Both passwords do not match</b>");
          return false;
        } else if ($('#terms').prop("checked") == false) {
          $(".terms").append("<b style='color:red;'>Please accept terms and conditions</b>");

        } else {
          $(".Rstep5").show();
          $(".Rstep3").hide();
        }


      });

      $(".step8 .cancellogin,.step8 .btn-back").click(function () {
        $(".step8").hide();
        $(".step3").show();
      })


      $('#stepTwo').click(function () {

        $(".step5 .gender.error").empty();
        $(".step5 .mobile.error").empty();
        $(".step5 .country.error").empty();
        $(".step5 .date.error").empty();
        $(".step5 .month.error").empty();
        $(".step5 .year.error").empty();
        $(".step5 .step2Terms.error").empty();

        if ($('.step5 .gender').val() == "") {
          $(".step5 .gender.error").append("<b style='color:red;'>Select Gender!</b>");
          return false;
        } else if ($('.step5 .mobile').val() == "") {
          $(".step5 .mobile.error").append("<b style='color:red;'>Mobile Number required!</b>");
          return false;
        } else if ($('.step5 .country').val() == "") {
          $(".step5 .country.error").append("<b style='color:red;'>Country required!</b>");
          return false;
        } else if ($('.step5 .date').val() == "") {
          $(".step5 .date.error").append("<b style='color:red;'>Date required!</b>");
          return false;
        } else if ($('.step5 .month').val() == null) {
          $(".step5 .month.error").append("<b style='color:red;'>Month required!</b>");
          return false;
        } else if ($('.step5 .year').val() == "") {
          $(".step5 .year.error").append("<b style='color:red;'>Year required!</b>");
          return false;
        } else if ($('#loginstep2Terms').prop("checked") == false) {
          $(".step5 .step2Terms.error").append("<b style='color:red;'>Please accept terms and conditions!</b>");
          return false;
        } else {
          $(".step6").show();
          $(".step5").hide();
        }

        // if($('#loginstep2Terms').prop("checked") == false){
        //     $(".step2Terms.error").append("<b style='color:red;'>Please accept terms and conditions!</b>");

        // }
        // else{
        // $(this).prop( "disabled", true );
        // $(".step6").show();
        //  $(".step5").hide();
        //     $(this).prop( "disabled", false );
        // }


      });

      $('.stepTwo').click(function () {


        $(".Rstep5 .gender.error").empty();
        $(".Rstep5 .mobile.error").empty();
        $(".Rstep5 .country.error").empty();
        $(".Rstep5 .date.error").empty();
        $(".Rstep5 .month.error").empty();
        $(".Rstep5 .year.error").empty();
        $(".Rstep5 .step2Terms.error").empty();
        console.log($('.Rstep5 .date').val(), $('.Rstep5 .month').val(), $('.Rstep5 .year').val())

        if ($('.Rstep5 .gender').val() == "") {
          $(".Rstep5 .gender").append("<b style='color:red;'>Select Gender!</b>");
          return false;
        } else if ($('.Rstep5 .mobile').val() == "") {
          $(".Rstep5 .mobile.error").append("<b style='color:red;'>Mobile Number required!</b>");
          return false;
        } else if ($('.Rstep5 .country').val() == "") {
          $(".Rstep5 .country.error").append("<b style='color:red;'>Country required!</b>");
          return false;
        } else if ($('.Rstep5 .date').val() == null) {
          $(".Rstep5 .date.error").append("<b style='color:red;'>Date required!</b>");
          return false;
        } else if ($('.Rstep5 .month').val() == null) {
          $(".Rstep5 .month.error").append("<b style='color:red;'>Month required!</b>");
          return false;
        } else if ($('.Rstep5 .year').val() == null) {
          $(".Rstep5 .year.error").append("<b style='color:red;'>Year required!</b>");
          return false;
        } else if ($('.Rstep5 .step2Terms').prop("checked") == false) {
          $(".Rstep5 .step2Terms.error").append("<b style='color:red;'>Please accept terms and conditions!</b>");
          return false;
        } else {
          $(".Rstep6").show();
          $(".Rstep5").hide();
        }

      });

      //        $('#DesignerRegister').attr("disabled", false);
      $("#dataSave").click(function () {


        // $(".Childfirstname").empty();
        // $(".Childlastname").empty();
        // $(".Childdate").empty();
        // $(".Childmonth").empty();
        // $(".Childyear").empty();
        // if ($('.Childfirstname').val() == "") {
        //      $(".VChildfirstname").append("<b style='color:red;'>First Name Required!</b>");
        //      return false;
        //  }
        //  if ($('.Childlastname').val() == "") {
        //      $(".VChildlastname").append("<b style='color:red;'>Last name required!</b>");
        //      return false;
        //  }
        //  if ($('.Childdate').val() == "") {
        //      $(".VChilddate").append("<b style='color:red;'>Date required</b>");
        //      return false;
        //  }
        //  if ($('.Childmonth').val() == "") {
        //      $(".VChildmonth").append("<b style='color:red;'>Month required</b>");
        //      return false;
        //  }
        //  if ($('.Childyear').val() == "") {
        //      $(".VChildyear").append("<b style='color:red;'>Year required!</b>");
        //      return false;
        //  }


        $(".errorMessage").empty();

        if (IsEmail($('#email').val()) == false) {
          $(".Rstep6").find(".errorMessage").append("<b style='color:red;' >Please enter valid email.</b>")
          return false;
        }


        if ($(".Rstep6").find(".addedchild.all .child1").length == 0) {
          $(".Rstep6").find(".errorMessage").append("<b style='color:red;' >At least One child is required.</b>")
          return false;
        }

        $(this).prop("disabled", true);
        $("#register-modal").find(".spinner").show();

        var formData = new FormData();
        formData.append('_token', "{{ csrf_token() }}");
        formData.append('firstname', $('#firstname').val());
        formData.append('subscribe', $('#subscribe').val());
        formData.append('lastname', $('#lastname').val());
        formData.append('email', $('#email').val());
        formData.append('password', $('#password').val());
        formData.append('country', $('#country').val());
        formData.append('mobile', $('#mobile').val());
        formData.append('gender', $('#gender').val());
        formData.append('date', $('#year').val() + "-" + $('#month').val() + "-" + $('#date').val());


        $(".Rstep6").find(".addedchild.all .child1").each(function (index) {
          var childdata = JSON.parse($(this).attr('data'));

          formData.append('ChildData[' + index + '][Childfirstname]', childdata.firstname);
          formData.append('ChildData[' + index + '][Childlastname]', childdata.lastname);
          formData.append('ChildData[' + index + '][Childdate]', childdata.dob);


        });

        // formData.append('imageNew',imageNew);


        $.ajax({
          async: true,
          url: '{{route("newRegister")}}',
          data: formData,
          cache: false,
          processData: false,
          contentType: false,
          type: 'POST',
          success: function (data) {
            //                     $(".Rstep6 .btn-login").click(function () {
            $(".Rstep7").show();
            $(".Rstep6").hide();
            $("#dataSave").prop("disabled", false);
            $("#register-modal").find(".spinner").hide();
            //                });
          },
          error: function (data) {
            console.log(data);
            $(".errorMessage").append("<b style='color:red;'>" + data.responseJSON.message + "</b>");

            $("#dataSave").prop("disabled", false);
            $("#register-modal").find(".spinner").hide();
            // return false;
          }
        });


        //            $('#DesignerRegister').attr("disabled", true);
        // $.ajax({
        //     url: '{{url("/designer/register")}}',
        //     type: 'POST',
        //     data: formData,
        //{
        // "_token": "{{ csrf_token() }}",
        // "firstname": $('#firstname').val(),
        // "lastname": $('#lastname').val(),
        // "email": $('#email').val(),
        // "password": $('#password').val(),
        // "country": $('#country').val(),
        // "mobile": $('#mobile').val(),
        // "gender": $('#gender').val(),
        // "date": $('#date').val(),
        // "month": $('#month').val(),
        // "year": $('#year').val(),
        // "Childfirstname": $('.Childfirstname').val(),
        // "Childlastname": $('.Childlastname').val(),
        // "Childdate": $('.Childdate').val(),
        // "Childmonth": $('.Childmonth').val(),
        // "Childyear": $('.Childyear').val(),

        //                    "imageNew": imageNew,

        // },
        //     success: function (result) {
        //         alert('Your application has been received!\n\
        // Thank you very much for your application! We will check the content and reply as soon as possible.\n\
        //       Please note it could take up to 7 days for our team to review it and get back to you');
        //         window.location.href = '{{url("login")}}';
        //     },
        //     error: function (result) {
        //         $('#loader').addClass('hide');
        //         $('#DesignerRegister').attr("disabled", false);
        //         $(".BackendDesignerValidation").append("<b style='color:red;'>" + result.responseJSON.message + "</b>");
        //  }
        //          });
      });

      $(".SimpleSSOLogin").click(function () {
        $(".errorMessage").empty();
        window.location.href = "{!! route('sso-login') !!}";
      });

      $(".SimpleLogin").click(function () {
        $(".errorMessage").empty();
        $(".loginEmail").empty();
        $(".loginPass").empty();
        if ($('#loginEmail').val() == "") {
          $(".loginEmail").append("<b style='color:red;'>Email Required!</b>");
          return false;
        }
        if ($('#loginPass').val() == "") {
          $(".loginPass").append("<b style='color:red;'>Password required!</b>");
          return false;
        }

        $(this).prop("disabled", true);
        $("#login-modal1").find(".spinner").show();
        var formData = new FormData();
        formData.append('_token', "{{ csrf_token() }}");
        formData.append('email', $('#loginEmail').val());
        formData.append('password', $('#loginPass').val());
        $.ajax({
          async: true,
          url: '{{route("newLogin")}}',
          data: formData,
          cache: false,
          processData: false,
          contentType: false,
          type: 'POST',
          success: function (data) {

            window.location.reload(true);
            $(".SimpleLogin").prop("disabled", false);
            $("#login-modal1").find(".spinner").hide();

          },
          error: function (data) {
            $(".SimpleLogin").prop("disabled", false);
            $("#login-modal1").find(".spinner").hide();
            if (data.responseJSON.message == 'Gallery Explorer') {
              $(".step5").show();
              $(".step3").hide();
            } else if (data.responseJSON.message == 'NOTCREATED') {

              $(".step8").show();
              $(".step3").hide();
            } else {

              $(".errorMessage").append("<b style='color:red;'>" + data.responseJSON.message + "</b>");
              return false;
            }

          }
        });

      });


      $(".GalleryExplorerLogin").click(function () {

        $(".loginEmail").empty();
        $(".loginPass").empty();
        if ($('#loginEmail').val() == "") {
          $(".loginEmail").append("<b style='color:red;'>Email Required!</b>");
          return false;
        }
        if ($('#loginPass').val() == "") {
          $(".loginPass").append("<b style='color:red;'>Password required!</b>");
          return false;
        }


        $(".errorMessage").empty();

        if (IsEmail($('#loginEmail').val()) == false) {
          $(".step6").find(".errorMessage").append("<b style='color:red;' >Please enter valid email.</b>")
          return false;
        }

        if ($(".step6").find(".addedchild.all .child1").length == 0) {
          $(".step6").find(".errorMessage").append("<b style='color:red;' >At least One child is required.</b>")
          return false;
        }

        $(this).prop("disabled", true);
        $("#login-modal1").find(".spinner").show();
        var formData = new FormData();
        formData.append('_token', "{{ csrf_token() }}");
        formData.append('email', $('#loginEmail').val());
        formData.append('password', $('#loginPass').val());
        formData.append('country', $('#logincountry').val());
        formData.append('mobile', $('#loginmobile').val());
        formData.append('gender', $('#logingender').val());
        formData.append('date', $('#logindate').val() + "/" + $('#loginmonth').val() + "/" + $('#loginyear').val());


        $(".step6").find(".addedchild.all .child1").each(function (index) {
          var childdata = JSON.parse($(this).attr('data'));

          formData.append('ChildData[' + index + '][Childfirstname]', childdata.firstname);
          formData.append('ChildData[' + index + '][Childlastname]', childdata.lastname);
          formData.append('ChildData[' + index + '][Childdate]', childdata.dob);


        });


        console.log(formData)

        $.ajax({
          async: true,
          url: '{{url("LoginTypeTwo")}}',
          data: formData,
          cache: false,
          processData: false,
          contentType: false,
          type: 'POST',
          success: function (data) {
            console.log(data)

            if (data.message == 'success') {
              window.location.reload();
              $("#login-modal1").find(".spinner").hide();
            }
            window.location.reload();
            $(".GalleryExplorerLogin").prop("disabled", false);
            $("#login-modal1").find(".spinner").hide();
          },
          error: function (data) {
            if (data.responseJSON.message == 'Gallery Explorer') {
              $(".step5").show();
              $(".step6").hide();
            }
            if (data.responseJSON.message == 'NOTCREATED') {
              $(".step7").show();
              $(".step5").hide();
            }
            $(".GalleryExplorerLogin").prop("disabled", false);
            $("#login-modal1").find(".spinner").hide();
            //                      $(".errorMessage").append("<b style='color:red;'>"+data.responseJSON.message+"</b>");
            return false;
          }
        });

      });

      $(".forgetPassword").click(function () {

        $(".forgetEmail").empty();

        if ($('#forgetEmail').val() == "") {
          $(".forgetEmail").append("<b style='color:red;'>Password required!</b>");
          return false;
        }
        $(this).prop("disabled", true);
        var formData = new FormData();
        formData.append('_token', "{{ csrf_token() }}");
        formData.append('email', $('#forgetEmail').val());

        console.log(formData)

        $.ajax({
          async: true,
          url: '{{url("forgetPassword")}}',
          data: formData,
          cache: false,
          processData: false,
          contentType: false,
          type: 'POST',
          success: function (data) {
            $("#forgot-modal").modal('hide');
            $("#mailCheck").modal('show');
            $(".btn.forgetPassword").prop("disabled", false);
          },
          error: function (data) {

            $(".forgetEmail").append("<b style='color:red;'>" + data.responseJSON.message + "</b>");
            $(".btn.forgetPassword").prop("disabled", false);
            return false;

          }
        });

      });

      $(".forgetPassword1").click(function () {
        $("#mailCheck").modal('hide');
      });

      $(".GalleryExplorerLogin2").click(function () {

        $(".loginEmail").empty();
        $(".loginPass").empty();
        if ($('#loginEmail').val() == "") {
          $(".loginEmail").append("<b style='color:red;'>Email Required!</b>");
          return false;
        }
        if ($('#loginPass').val() == "") {
          $(".loginPass").append("<b style='color:red;'>Password required!</b>");
          return false;
        }

        $(".errorMessage").empty();
        if ($(".step7").find(".addedchild.all .child1").length == 0) {
          $(".step7").find(".errorMessage").append("<b style='color:red;' >At least One child is required.</b>")
          return false;
        }


        $(this).prop("disabled", true);
        $("#login-modal1").find(".spinner").show();
        var formData = new FormData();
        formData.append('_token', "{{ csrf_token() }}");
        formData.append('email', $('#loginEmail').val());
        formData.append('password', $('#loginPass').val());
        // formData.append('country',$('#logincountry').val());
        // formData.append('mobile',$('#loginmobile').val());
        // formData.append('gender',$('#logingender').val());
        // formData.append('date',$('#logindate').val()+"/"+$('#loginmonth').val()+"/"+$('#loginyear').val());


        $(".step7").find(".addedchild.all .child1").each(function (index) {
          var childdata = JSON.parse($(this).attr('data'));

          formData.append('Childs[' + index + '][Childfirstname]', childdata.firstname);
          formData.append('Childs[' + index + '][Childlastname]', childdata.lastname);
          formData.append('Childs[' + index + '][Childdate]', childdata.dob);


        });


        console.log(formData)

        $.ajax({
          async: true,
          url: '{{url("LoginTypeThree")}}',
          data: formData,
          cache: false,
          processData: false,
          contentType: false,
          type: 'POST',
          success: function (data) {
            window.location.reload(true);
            //                        if(data.responseJSON.message == 'success'){
            //                                  window.location.reload(true);
            //                               }
            $(".GalleryExplorerLogin2").prop("disabled", false);
            $("#login-modal1").find(".spinner").hide();

          },
          error: function (data) {
            if (data.responseJSON.message == 'Gallery Explorer') {
              $(".step5").show();
              $(".step6").hide();
            }
            if (data.responseJSON.message == 'NOTCREATED') {
              $(".step7").show();
              $(".step5").hide();
            }
            $(".GalleryExplorerLogin2").prop("disabled", false);
            $("#login-modal1").find(".spinner").hide();
            //                      $(".errorMessage").append("<b style='color:red;'>"+data.responseJSON.message+"</b>");
            return false;
          }
        });

      });


    });
    $(document).ready(function () {


      $("#familytype").change(function () {
        if ($(this).prop('checked') === true) {
          $(".step1").hide();
          $(".step3").show();
        }
      })
      $("#schooltype").change(function () {
        if ($(this).prop('checked') === true) {
          $(".innerStep1").hide();
          $(".innerStep2").show();
        }
      })


      $("#teachertype").change(function () {
        if ($(this).prop('checked') === true) {
          $(".step1").hide();
          $(".step4").show();
        }
      })
      $("#studenttype").change(function () {
        if ($(this).prop('checked') === true) {
          $(".step1").hide();
          $(".step2").show();
        }
      })


      $(".innerStep1 .cancellogin").click(function () {
        $(".modal").modal("hide");
      });

      $("#forgot-modal .cancellogin").click(function () {
        $(".modal").modal("hide");
      });


      $(".innerStep2 .cancellogin").click(function () {
        $(".innerStep1").show();
        $(".innerStep2").hide();

      });

      $(".step3 .cancellogin").click(function () {
        // $(".step1").show();
        // $(".step3").hide();
        $("#login-modal1").find('input').each(function () {
          $(this).val('');
          if ($(this).prop("checked") == true) {
            $(this).prop("checked", false)
          }
        })
        $(".modal").modal("hide");
      });

      $(".step2 .cancellogin").click(function () {
        $(".step1").show();
        $(".step2").hide();
      });

      $(".step4 .cancellogin").click(function () {
        $(".step1").show();
        $(".step4").hide();
      });


      $(".step5 .cancellogin,.step5 .btn-back").click(function () {
        $(".step3").show();
        $(".step5").hide();
      });

      $(".step6 .cancellogin,.step6 .btn-back").click(function () {
        $(".step5").show();
        $(".step6").hide();
      });

      $(".step7 .cancellogin").click(function () {
        $(".step3").show();
        $(".step7").hide();
      });


      // $(".login1").on('click', function () {
      //     $(".modal").modal("hide");
      //     $("#login-modal1").modal({
      //         backdrop: false
      //     });
      // })


      $(document).on("click", "a.removebtn", function () {
        $(this).parents(".child1").remove();
      });

      // register start

      $("#Rfamilytype").change(function () {
        if ($(this).prop('checked') === true) {
          $(".Rstep1").hide();
          $(".Rstep3").show();
        }
      })
      $("#Rschooltype").change(function () {
        if ($(this).prop('checked') === true) {
          $(".RinnerStep1").hide();
          $(".RinnerStep2").show();
        }
      })


      $("#Rteachertype").change(function () {
        if ($(this).prop('checked') === true) {
          $(".Rstep1").hide();
          $(".Rstep4").show();
        }
      })
      $("#Rstudenttype").change(function () {
        if ($(this).prop('checked') === true) {
          $(".Rstep1").hide();
          $(".Rstep2").show();
        }
      })

      $(".RinnerStep1 .cancellogin").click(function () {
        $(".modal").modal("hide");
      });

      $(".RinnerStep2 .cancellogin").click(function () {
        $(".RinnerStep1").show();
        $(".RinnerStep2").hide();

      });

      $(".Rstep3 .cancellogin").click(function () {
        // $(".Rstep1").show();
        // $(".Rstep3").hide();
        $("#register-modal").find('input').each(function () {
          $(this).val('');
          if ($(this).prop("checked") == true) {
            $(this).prop("checked", false)
          }
        })
        $(".modal").modal("hide");
      });

      //                                                    $(".Rstep3 .btn-login").click(function () {
      //                                                        $(".Rstep5").show();
      //                                                        $(".Rstep3").hide();
      //                                                    });
      //                                                    $(".Rstep5 .btn-login").click(function () {
      //                                                        $(".Rstep6").show();
      //                                                        $(".Rstep5").hide();
      //                                                    });
      $(".Rstep5 .btn-back").click(function () {
        $(".Rstep3").show();
        $(".Rstep5").hide();
      });
      $(".Rstep5 .cancellogin").click(function () {
        $(".Rstep3").show();
        $(".Rstep5").hide();
      });


      $(".Rstep6 .btn-back").click(function () {
        $(".Rstep5").show();
        $(".Rstep6").hide();
      });
      $(".Rstep6 .cancellogin").click(function () {
        $(".Rstep5").show();
        $(".Rstep6").hide();
      });


      $(".Rstep2 .cancellogin").click(function () {
        $(".Rstep1").show();
        $(".Rstep2").hide();
      });

      $(".Rstep4 .cancellogin").click(function () {
        $(".Rstep1").show();
        $(".Rstep4").hide();
      });

      $(".register").on('click', function () {
        $(".modal").modal("hide");

        window.location.href = "{!!   route('sso-login', ['screen_hint' => 'signup', 'action'=>'signup']) !!}";

        // $("#register-modal").modal({
        //     backdrop: false
        // });
      })


      //register end


      setInterval(function () {

        if ($("#register-modal").hasClass("in") || $("#forgot-username-modal").hasClass("in")) {

        } else {
          $(".step3").show();
          $("#login-modal1").modal("show");
        }

      }, 600000); // 600000 milliseconds = 10 minutes

    });
  </script>
@endguest
<script type="text/javascript">

  window.onscroll = function () {
    myFunction()
  };

  function myFunction() {
    if ($(document).scrollTop() > 750) {
      $(".centernav").addClass("fixed");
      $(".gotoTop").show();
    } else {
      $(".centernav").removeClass("fixed");
      $(".gotoTop").hide();
    }
  }


  $(document).ready(function () {

    $(".gotoTop").click(function () {
      $("html, body").animate({
        scrollTop: 0
      }, 1000);
    })

    $('.centernav').find('a[href="' + window.location.href + '"]').parents("li").addClass('active');


    $(".login").on('click', function () {
      $("#login-modal1").modal("show");
    })
    $(".forgetCall").on('click', function () {
      $(".modal").modal("hide");
      $("#forgot-modal").modal("show");
    })

    $(".forget_username").on('click', function () {
      $(".modal").modal("hide");
      $("#forgot-username-modal").modal("show");
    })

    $(".cancel").click(function () {
      $(".modal").modal("hide");
    });


    $(".t1").click(function () {
      $(".tab1sec").show();
      $(".tab2sec").hide();
      $(this).addClass("active").siblings().removeClass("active");
    });
    $(".t2").click(function () {
      $(".tab2sec").show();
      $(".tab1sec").hide();
      $(this).addClass("active").siblings().removeClass("active");
    });
  });

  (function ($) {

    "use strict";

    var $body = $('body');
    var $head = $('head');
    var $header = $('#header');
    var transitionSpeed = 300;
    var pageLoaded = setTimeout(addClassWhenLoaded, 1000);
    var marker = 'img/marker.png';


    $(window).load(function () {

      // Add body loaded class for fade transition
      addClassWhenLoaded();
      clearTimeout(pageLoaded);

    });


    function addClassWhenLoaded() {
      if (!$body.hasClass('loaded')) {
        $body.addClass('loaded');
      }


    }


  }(jQuery));
</script>
</body>
</html>
