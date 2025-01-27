@extends('layouts.master')

@section('style')

  <style>

    .centernav {
      top: 70px;
      position: fixed;
      left: 0;
      right: 0;
      z-index: 9;
    }

    #pass-modal1 .modal-body {
      background: url('{{asset('front/img/zigzagbg1.png')}}');
      background-repeat: repeat;
      background-size: 50% auto;
    }

    #pass-modal1 p.subline {
      color: #000;
      font-size: 14px;
      width: 100%;
    }

    #pass-modal1 h2.formhding {
      color: #000;
      font-size: 18px;
    }

    #pass-modal1 h3.formhding {
      color: #000;
      font-size: 16px;
    }

    #pass-modal1 .form-control {
      min-width: 100% !important;
      margin-bottom: 30px;
    }

    #pass-modal1 .form-group {
      display: block;
    }

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
      margin-top: -2px !important;
    }

    .mitem .sharebtn {
      margin-top: 45px;
    }

    /*.mitem>div>img {
        margin-top: -42px;
    }*/

    .sharebtn a:nth-child(2) {
      margin-right: 10px;
    }

    .mitem .shlist {
      margin-top: -40px;
    }

    .mr10 {
      margin-right: 10px;
    }

    a.iframecont {
      overflow: hidden;
    }

    .linkeda {
      display: block;
      width: 100%;
      margin-top: -37px;
      overflow: hidden;
      border-top-left-radius: 6px;
      border-top-right-radius: 6px;
    }

    .linkeda img {
      display: block;
      width: 100%;
    }

    .mitem a.trashbtn {
      margin-top: 21px;
    }

    @media (min-width: 768px) {
      .myfevsec > div {
        min-height: 400px;
      }
    }
  </style>
@endsection

@section('alert')

  @include('layouts.alert')

@endsection


@section('content')


  @include('layouts.navbar')


  <main class="prbg">
    <div class="mt125 pr-content">
      <div class="container">
        <div class="row">

          <div class="mysubmission col-md-12 col-sm-12 mt80">


            <div class="toggleProfile">

              <label class="switch">
                <input type="checkbox" id="togglePR">
                <span class="slider round"></span>

              </label>
              <label>Current: Child Profile</label>
              <span>Click on the switch to change profile</span>
            </div>
            <div class="col-md-6">

              @if($user->image)
                <img id="profile_image" src="{{asset($user->image)}}" class="primg"/>
              @else
                <img id="profile_image" src="{{asset('front/img/defaultpr.png')}}" class="primg"/>
              @endif

              <button class="btn btn-primary" id="avatar" type="button">Select Avatar</button>


            </div>

            <div class="col-md-6 prcont">
              <h3>{{$user->first_name}} {{$user->last_name}}</h3>
            <!--                        <p>Level {{$startLabel}} | {{$amout}} Points</p>-->
              <ul>
                <li>
                  <img src="{{asset('front/img/pricon1.png')}}"/>
                  <p>No. of Reactions</p>
                  <b>{{$user->reactions->count()}}</b>
                </li>
                <li>
                  <img src="{{asset('front/img/pricon2.png')}}"/>
                  <p>No. of Questions Posted</p>
                  <b>{{$user->questions->count()}}</b>
                </li>
                <li>
                  <img src="{{asset('front/img/pricon3.png')}}"/>
                  <p>No. of Submissions (Shares)</p>
                  <b>{{$shares->count()}}</b>
                </li>
                <li>
                  <img src="{{asset('front/img/pricon4.png')}}"/>
                  <p>No. of Login/Visit</p>
                  <b>{{Auth::user()['visit']}}</b>
                </li>
              </ul>
            </div>


          </div>


          <div class="mysubmission col-md-12 col-sm-12 ">
            <div class="title-lines">
              <h3 class="mt0">MY BADGES</h3>
            </div>

            <div class="col-md-12 col-sm-12 badgeswon">
              <div class="col-md-4 col-sm-4 col-xs-4">
                <img src="{{asset('front/img/500_Badges_1.png')}}"/>
                <!--                            <h6>A Consistent Contributer</h6>-->
              </div>

            <!--                        <div class="col-md-4">
                                                    <img src="{{asset('front/img/badge2.png')}}"/>
                                                    <h6>The Most Active User!</h6>
                                                </div>

                                                <div class="col-md-4">
                                                    <img src="{{asset('front/img/badge3.png')}}"/>
                                                    <h6>Most Popular Post of the week</h6>
                                                </div>-->
            </div>

          </div>
        <!--
                                <div class="mysubmission col-md-12 col-sm-12 ">
                                    <div class="title-lines">
                                        <h3 class="mt0">MY CHALLENGES</h3>
                                    </div>

                                    <div class="col-md-12 col-sm-12 mychallenges">
                                        @foreach($challenges as $challenge)
          <?php
          $userId = Auth::user()['id'];
          $id = $challenge['id'];
          $userChalange = Modules\Challenges\Entities\UserChallenge::whereUserId( $userId )->whereChallangeId( $id )->first();
          ?>
            <div class="form-group col-md-12 selectbox widthfull">
@if($userChalange)
            <input type="checkbox" name="list1" checked="" class="list1" id="{{$challenge['id']}}" value="{{$challenge['id']}}">
                                            @else
            <input type="checkbox" name="list1"  class="list1" id="{{$challenge['id']}}" value="{{$challenge['id']}}">
                                            @endif
            <label for="{{$challenge['id']}}">{{$challenge['name']}}</label>
                                        </div>
                                        @endforeach
          </div>

      </div>
-->


          <div class="mysubmission col-md-12 col-sm-12 ">
            <div class="title-lines">
              <h3 class="mt0">MY SUBMISSION (SHARE)</h3>
            </div>
            <form>
              <select class="form-control filterright" name="share" Onchange="this.form.submit();">
                <option value="" selected="" disabled="">Filter by</option>
                <option value="AtoZ">A to Z</option>
                <option value="ZtoA">Z to A</option>
                <option value="Old">Old to New</option>
                <option value="New">New to Old</option>
                <option value="like">By Like</option>
              </select>
            </form>

            <div class="latest-jobs-section masonry">

              @foreach($shares as $share)
                <div class="mitem">
                  <div class=" ">
                  <!--   <a href="javascripts:;" class="archive" data-type="share" data-id="{{$share->id}}" title="Archive"><i class="fa fa-trash" aria-hidden="true"></i></a> -->

                    @php $thumbnail = $share->thumbnails->shuffle()->first(); @endphp
                    <img src="{{asset($thumbnail->image)}}"/>
                    <div class="hditem">
                      <h4>{{$share->name}}</h4>


                      <a href="javascript:void(0)" class="trashbtn archive" data-type="share"
                         data-id="{{$share->id}}" title="Archive"><img
                          src="{{asset('front/img/trash.png')}}"></a>

                      <div class="sharebtn">
                        <ul class="shlist">
                          <li>
                            <a href="javascripts:;" class="share"
                               data-clipboard-text="{{$share->url}}"><i
                                class="fa fa-share-alt"></i></a>
                          </li>
                          <li><a href="https://www.facebook.com/sharer.php?u={{$share->url}}"
                                 class="facebook" target="_blank" rel="noopener noreferrer"><i
                                class="fa fa-facebook" aria-hidden="true"></i></a></li>

                          <li><a href="https://api.whatsapp.com/send?text={{$share->url}}"
                                 class="whatsapp" target="_blank" rel="noopener noreferrer"><i
                                class="fa fa-whatsapp" aria-hidden="true"></i></a></li>
                        </ul>

                        <a href="javascript:void(0);" class="shbtn">Share</a>

                        @if(Auth::check() && $share->reactions->contains('user_id' , Auth::user()->id))
                          <a class="heartShow-{{$reaction->id}} mr10">
                            {!! $share->reactions->where('user_id', Auth::user()->id)->first()->reaction !!}
                          </a>
                        @else
                        @endif
                      </div>


                    </div>
                  </div>
                </div>
              @endforeach


            </div>


          </div>

          <div class="myfevroutes col-md-12 col-sm-12 ">
            <div class="title-lines">
              <h3 class="mt0">MY FAVOURITES </h3>
            </div>
            <form>
              <select class="form-control filterright" name="favourite" Onchange="this.form.submit();">
                <option value="" selected="" disabled="">Filter by</option>
                <option value="AtoZ">A to Z</option>
                <option value="ZtoA">Z to A</option>
                <option value="Old">Old to New</option>
                <option value="New">New to Old</option>
              </select>
            </form>

            <div class="latest-jobs-section myfevsec">

              @foreach($reactions as $reaction)
                @if($reaction->reactionable)
                  @php
                    switch ($reaction->reactionable_type) {
                    case 'Modules\Play\Entities\Play':
                      $data_type = 'play';
                      break;
                    case 'Modules\Share\Entities\Share':
                      $data_type = 'share';
                      break;
                    case 'Modules\Discover\Entities\Discover':
                      $data_type = 'discover';
                      break;
                    case 'Modules\Create\Entities\Create':
                      $data_type = 'create';
                      break;
                    case 'Modules\AdminShare\Entities\AdminShare':
                      $data_type = 'admin_share';
                      break;
                    case 'Modules\Exhibition\Entities\Exhibition':
                      $data_type = 'exhibition';
                      break;
                    case \App\Models\KcaeSpace::class:
                      $data_type = 'space';
                      break;
                    default:
                      	$data_type = 'nothing';
                    }
                  @endphp

                  @if($reaction->reactionable->archives_user->count() == 0)
                    <div class="col-md-4 col-sm-6 col-xs-6">
                      <div class="catitem b1">

                        @if($reaction->reactionable_type != 'Modules\Play\Entities\Play' && $reaction->reactionable_type != 'Modules\AdminShare\Entities\AdminShare'  && $reaction->reactionable_type != 'Modules\Share\Entities\Share')
                          @php
                            $thumbnail = \App\Models\KcaeSpace::class === $reaction->reactionable_type
                            ? $reaction->reactionable->image
                            : $reaction->reactionable->thumbnails->shuffle()->first();
                          @endphp

                          <?php
                          $str = $reaction['reactionable']['url'];
                          $l = ( explode( ".", $str ) );
                          $last = end( $l );
                          ?>
                          @if($last == 'pdf')
                            <a href="{{$reaction['reactionable']['url']}}" target="_blank"
                               rel="noopener noreferrer" class="linkeda"> <img
                                src="{{asset($thumbnail->image)}}"/></a>
                          @elseif (\App\Models\KcaeSpace::class === $reaction->reactionable_type)
                            <img src="{{asset($reaction->reactionable->image)}}"/>
                          @else
                            <a href="javascript:void(0)" class="iframecont">
                              <iframe height="200" width="100%"
                                      src="{{$reaction['reactionable']['url']}}"
                                      frameborder="0"
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
                                    <iframe height="500" width="100%"
                                            src="{{$reaction['reactionable']['url']}}"
                                            frameborder="0"
                                            allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture"
                                            allowfullscreen></iframe>
                                  </div>
                                </div>
                              </div>
                            </div>
                          @endif
                        @else

                          @if($data_type == 'play')
                            <img src="{{asset($reaction->reactionable->thumbnail)}}"/>
                          @endif
                          @if($data_type == 'share')
                            @php $thumbnail = $reaction->reactionable->thumbnails->shuffle()->first(); @endphp
                            <img src="{{asset($thumbnail->image)}}"/>
                          @endif
                        @endif
                        <div class="hditem">
                          <h4>{{isset($reaction->reactionable->title) ? $reaction->reactionable->title : $reaction->reactionable->name }}</h4>
                          <p class="fevpara">
                            @if($data_type == 'share')
                              <?php

                              $dateOfBirth = $reaction->reactionable['user']['year_of_birth'];
                              $years = \Carbon\Carbon::parse( '' . $reaction->reactionable['user']['year_of_birth'] . '-01-01' )->age;
                              ?>

                              @if($reaction->reactionable['age'])
                                {{$reaction->reactionable['age']}} Years Old
                              @else
                                {{$years}} Years Old
                              @endif

                            @elseif ('space'===$data_type)
                              {{$reaction->reactionable->description}}
                            @endif
                          </p>

                          <a href="javascript:void(0)" class="trashbtn archive"
                             data-type="{{$data_type}}"
                             data-id="{{$reaction->reactionable_id}}" title="Archive"><img
                              src="{{asset('front/img/trash.png')}}"></a>

                          <div class="sharebtn">
                            <ul class="shlist">
                              <li>
                                <a href="javascripts:;" class="share"
                                   data-clipboard-text="{{$reaction->reactionable->url}}"><i
                                    class="fa fa-share-alt"></i></a>
                              </li>

                              <li>
                                <a href="https://www.facebook.com/sharer.php?u={{$reaction->reactionable->url}}"
                                   class="facebook" target="_blank"
                                   rel="noopener noreferrer"><i class="fa fa-facebook"
                                                                aria-hidden="true"></i></a>
                              </li>
                              <li>
                                <a href="https://api.whatsapp.com/send?text={{$reaction->reactionable->url}}"
                                   class="whatsapp" target="_blank"
                                   rel="noopener noreferrer"><i class="fa fa-whatsapp"
                                                                aria-hidden="true"></i></a>
                              </li>

                            </ul>

                            <a href="javascript:void(0);" class="shbtn">Share</a>
                            <a class="heartShow-{{$reaction->id}} mr10">
                              {!! $reaction->reaction !!}
                            </a>


                          </div>


                        </div>
                      </div>
                    </div>
                  @endif
                @endif
              @endforeach


            </div>


          </div>

          <div class="myarchives col-md-12 col-sm-12 ">
            <div class="title-lines">
              <h3 class="mt0">MY ARCHIVES </h3>
            </div>

            <div class="latest-jobs-section ">


              <div class="accordion" id="accordionExample">

                <div class="acco1">

                  <div class="acchding" id="headingOne">
                    <h2 class="mb-0">
                      <button class="btn btn-link collapsed" type="button" data-toggle="collapse"
                              data-target="#collapse1" aria-expanded="false"
                              aria-controls="collapseOne">
                        MY SUBMISSIONS(SHARES)
                        <i class="fa fa-plus"></i>
                        <i class="fa fa-minus"></i>
                      </button>
                    </h2>
                  </div>

                  <div id="collapse1" class="collapse acccont" aria-labelledby="headingOne"
                       data-parent="#accordionExample" aria-expanded="false" style="height: 0px;">

                    @foreach($archived_shares as $archived_share)
                      @if($archived_share->archivable)
                        @if($archived_share->archivable->user_id == $user->id)
                          @php
                            $share = $archived_share->archivable;
                            $thumbnail = $share->thumbnails->shuffle()->first();
                          @endphp


                          <div class="card-body accbox">
                            <div class="col-md-4">
                              <img src="{{asset($thumbnail->image)}}">
                            </div>
                            <div class="col-md-8">
                              <!--                                            <h6>EXHIBITION</h6>-->
                              <h2>{{$share->name}}</h2>
                              <!--                                            <div class="dt">01 JUN 2020 - 28 MAR 2021 ! ALL DAY</div>-->
                              <p>{!! $share->description !!}</p>
                              <!--                                            <a href="#">Read More</a>-->
                            </div>
                          </div>

                        @endif
                      @endif
                    @endforeach
                  </div>
                </div>


                <div class="acco1">
                  <div class="acchding" id="headingTwo">
                    <h2 class="mb-0">
                      <button class="btn btn-link collapsed" type="button" data-toggle="collapse"
                              data-target="#collapse2" aria-expanded="false"
                              aria-controls="collapseTwo">
                        MY FAVOURITES
                        <i class="fa fa-plus"></i>
                        <i class="fa fa-minus"></i>
                      </button>
                    </h2>
                  </div>

                  <div id="collapse2" class="collapse acccont" aria-labelledby="headingTwo"
                       data-parent="#accordionExample" aria-expanded="false" style="height: 0px;">

                    @foreach($archived_favourite_shares as $archived_favourite_share)
                      @if($archived_favourite_share->archivable)
                        @if($archived_favourite_share->archivable->user_id != $user->id)
                          @php
                            $share = $archived_favourite_share->archivable;
                            $thumbnail = $share->thumbnails->shuffle()->first();
                          @endphp

                          <div class="card-body accbox">
                            <div class="col-md-4">
                              <img src="{{asset($thumbnail->image)}}"/>

                            </div>
                            <div class="col-md-8">
                              <!--                                            <h6>EXHIBITION</h6>-->
                              <p>{{$share->name}}</p>
                              <?php
                              $hashtags = implode( ',', $share->hashtags );

                              $dateOfBirth = $share['user']['year_of_birth'];
                              $years = \Carbon\Carbon::parse( '' . $share['user']['year_of_birth'] . '-01-01' )->age;
                              ?>
                              @if($share['age'])
                                <p>{{$share['age']}} Years Old</p>
                              @else
                                <p>{{$years}} Years Old</p>
                              @endif

                              <p>Inspired by: {{$share['Inspired_by']}}</p>
                              <p>Hashtags: {{$hashtags}}</p>
                              <!--                                            <div class="dt">01 JUN 2020 - 28 MAR 2021 ! ALL DAY</div>-->
                              <p>{!! $share->description !!}</p>
                              <!--                                            <a href="#">Read More</a>-->
                            </div>
                          </div>
                        @endif
                      @endif
                    @endforeach

                    @foreach($archived_favourite_spaces as $archived_favourite_space)
                      @php
                        $space = $archived_favourite_space->archivable;
                        $thumbnail = $space->image;
                      @endphp
                      <div class="card-body accbox">
                        <div class="col-md-4">
                          <img
                            src="{{$thumbnail}}"/>
                        </div>
                        <div class="col-md-8">
                          <h2>{{$space->name}}</h2>
                          <p>{{$space->description}}</p>
                        </div>
                      </div>
                    @endforeach


                    @foreach($archived_favourite_creates as $archived_favourite_create)
                      @php
                        $create = $archived_favourite_create->archivable;
                        $thumbnail = $create->thumbnails->shuffle()->first();
                      @endphp
                      <div class="card-body accbox">
                        <div class="col-md-4">
                          <?php
                          $str = $create['url'];
                          $l = ( explode( ".", $str ) );
                          $last = end( $l );
                          ?>
                          @if($last == 'pdf')
                            <a href="{{$create['url']}}" target="_blank"
                               rel="noopener noreferrer" class="linkeda"> <img
                                src="{{asset($thumbnail->image)}}"/></a>
                          @else
                            <a href="javascript:void(0)" class="iframecont">
                              <iframe height="200" width="100%" src="{{$create['url']}}"
                                      frameborder="0"
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
                                    <iframe height="500" width="100%"
                                            src="{{$create['url']}}" frameborder="0"
                                            allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture"
                                            allowfullscreen></iframe>
                                  </div>
                                </div>
                              </div>
                            </div>
                          @endif
                        </div>
                        <div class="col-md-8">
                          <!--                                            <h6>EXHIBITION</h6>-->
                          <h2>{{$create->title}}</h2>
                          <!--                                            <div class="dt">01 JUN 2020 - 28 MAR 2021 ! ALL DAY</div>-->
                          <p>{!! $create->synopsis !!}</p>
                          <!--                                            <a href="#">Read More</a>-->
                        </div>
                      </div>
                    @endforeach


                    @foreach($archived_favourite_discovers as $archived_favourite_discover)
                      @php
                        $discover = $archived_favourite_discover->archivable;
                        $thumbnail = $discover->thumbnails->shuffle()->first();
                      @endphp
                      <div class="card-body accbox">
                        <div class="col-md-4">
                          <?php
                          $str = $discover['url'];
                          $l = ( explode( ".", $str ) );
                          $last = end( $l );
                          ?>
                          @if($last == 'pdf')
                            <a href="{{$discover['url']}}" target="_blank"
                               rel="noopener noreferrer" class="linkeda"> <img
                                src="{{asset($thumbnail->image)}}"/></a>
                          @else
                            <a href="javascript:void(0)" class="iframecont">
                              <iframe height="200" width="100%" src="{{$discover['url']}}"
                                      frameborder="0"
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
                                    <iframe height="500" width="100%"
                                            src="{{$discover['url']}}"
                                            frameborder="0"
                                            allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture"
                                            allowfullscreen></iframe>
                                  </div>
                                </div>
                              </div>
                            </div>
                          @endif
                        </div>
                        <div class="col-md-8">
                          <!--                                            <h6>EXHIBITION</h6>-->
                          <h2>{{$discover->title}}</h2>
                          <!--                                            <div class="dt">01 JUN 2020 - 28 MAR 2021 ! ALL DAY</div>-->
                          <p>{!! $discover->synopsis !!}</p>
                          <!--                                            <a href="#">Read More</a>-->
                        </div>
                      </div>
                    @endforeach

                    @foreach($archived_favourite_plays as $archived_favourite_play)

                      @php
                        $play = $archived_favourite_play->archivable;
                      @endphp
                      <div class="card-body accbox">
                        <div class="col-md-4">
                          <img src="{{asset($play->thumbnail)}}"/>

                        </div>
                        <div class="col-md-8">
                          <!--                                            <h6>EXHIBITION</h6>-->
                          <h2>{{$play->title}}</h2>
                          <!--                                            <div class="dt">01 JUN 2020 - 28 MAR 2021 ! ALL DAY</div>-->
                          <p>{!! $play->synopsis !!}</p>
                          <!--                                            <a href="#">Read More</a>-->
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

  <style type="text/css">

    .avatars > input {
      display: none;
    }

    .avatars > input + img {
      cursor: pointer;
      border: 2px solid transparent;
    }

    .avatars > input:checked + img {
      border: 2px solid blue;
    }

    .avtr {
      border-radius: 50%;
      margin-bottom: 20px;
    }

  </style>

  <div id="avatar-modal" class="modal" role="dialog">
    <div class="preloader"></div>
    <div class="modal-dialog  modal-dialog-centered">
      <!-- Modal content-->
      <div class="modal-content">
        <a class="cancellogin cancel"><img src="{{asset('front/img/close.png')}}"/></a>
        <div class="modal-body  login-blk">
          <h2 class="formhding mb50">Select Avatar</h2>
          <div class="row">
            @foreach($avatars as $avatar)
              <div class="col-md-4">
                <label class="avatars">
                  <input type="radio" value="{{asset($avatar->image)}}" name="avatar"/>
                  <img src="{{asset($avatar->image)}}" class="avtr">
                </label>
              </div>
            @endforeach
          </div>
          <button class="btn btn-login upload_avatar">Upload</button>
        </div>
      </div>
    </div>
  </div>
  <div id="pass-modal1" class="modal" role="dialog">
    <div class="preloader"></div>
    <div class="modal-dialog modal-dialog-centered">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-body login-blk">
          <a class="cancellogin"><img src="{{asset('front/img/close.png')}}"/></a>
          <h2 class="formhding">Proceed to parent profile</h2>
          {{--                    <h2 class="formhding">This step requires parent's endorsement</h2>--}}
          {{--                    <h3 class="formhding">An One-Time Password sent to your parent's email.</h3>--}}
          {{--                    <p class="subline">Please enter OTP code to proceed:</p>--}}
          <h5 class="errorMessage"></h5>
          {{--                    <div class="form-group">--}}
          {{--                        <input--}}
          {{--                            type="text"--}}
          {{--                            name="password"--}}
          {{--                            class="form-control forminput"--}}
          {{--                            id="passInput"--}}
          {{--                        />--}}
          {{--                        <b class="error"></b>--}}
          {{--                    </div>--}}
          <button class="btn btn-login PassConfirm">OK</button>
        </div>
      </div>
    </div>
  </div>


  <div id="invalidData" class="modal" role="dialog">
    <div class="preloader"></div>
    <div class="modal-dialog modal-dialog-centered">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-body login-blk">
          <a class="cancellogin"><img src="{{asset('front/img/close.png')}}"/></a>
          <p class="subline" style="color:#e62117">Given Data Invalid</p>
          <h5 class="errorMessage"></h5>

          <button class="btn btn-login PassConfirm">ok</button>
        </div>
      </div>
    </div>
  </div>



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

      if (getUrlParameter('favourite')) {
        var favourite = getUrlParameter('favourite');
        $("select[name='favourite']").val(favourite)
      } else {
        $("select[name='favourite']").val("")
      }

      if (getUrlParameter('share')) {
        var share = getUrlParameter('share');
        $("select[name='share']").val(share)
      } else {
        $("select[name='share']").val("")
      }


      $(".iframecont").click(function () {
        $(this).next(".itempop1").modal({
          backdrop: false
        });
      })


      if (getUrlParameter('search')) {
        var search = getUrlParameter('search');
        $(".searchin").val(search)
      } else {
        $(".searchin").val("")
      }

      if (getUrlParameter('type')) {
        var type = getUrlParameter('type');
        $(".selectGallery").val(type)
      } else {
        $(".selectGallery").val("kids")
      }

      if (getUrlParameter('sort')) {
        var sort = getUrlParameter('sort');
        $(".sortselect").val(sort)
      } else {
        $(".sortselect").val("ASC")
      }

      $("#clearBtn1").click(function () {
        $(".searchin").focus();
        $(".searchin").val("");

      })


      $(".mitem>div>img,.mitem h4").click(function () {
        $("#itempop .modal-body").empty();
        $("#itempop .modal-body").append($(this).parents('.mitem').html())
        $("#itempop").modal("show");
      })


      $(".selectGallery").change(function () {
        console.log($(this).val())
        $(".tab1sec").toggleClass('active');
        $(".tab2sec").toggleClass('active');
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

      var session = "{{Auth::check()}}";
      var ele = $(this);
      if (session == '') {
        $("#firstloginmodal").modal("show");
      } else {
        $(this).siblings(".shlist").toggle();
        $(".emolist").hide();
      }
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

    $(document).ready(function () {


      var stlabel = $(".sliderPr").attr("startLabel");
      var enlabel = $(".sliderPr").attr("endLabel");
      var point = $(".sliderPr").attr("points");

      if (enlabel < 11) {
        var pointPercent = (point * 100) / 50;
        if (point < 50) {
          var reachpoint = 50 - point;
          $(".sliderwrap p").text(reachpoint + " points to go to reach level " + enlabel + "!");
        }
      } else if (stlabel >= 10 && enlabel < 21) {
        var pointPercent = (point * 100) / 75;
        if (point < 75) {
          var reachpoint = 75 - point;
          $(".sliderwrap p").text(reachpoint + " points to go to reach level " + enlabel + "!");
        }
      } else if (stlabel >= 20 && enlabel < 31) {
        var pointPercent = (point * 100) / 100;
        if (point < 100) {
          var reachpoint = 100 - point;
          $(".sliderwrap p").text(reachpoint + " points to go to reach level " + enlabel + "!");
        }
      } else {
        var pointPercent = (point * 100) / 125;
        if (point < 125) {
          var reachpoint = 125 - point;
          $(".sliderwrap p").text(reachpoint + " points to go to reach level " + enlabel + "!");
        }
      }

      $(".lavel1").text("Level " + stlabel);
      $(".lavel2").text("Level " + enlabel);
      $(".sliderFill").css("width", pointPercent + '%');


      $(".list1").change(function () {
        // if($(this).prop("checked") === true){

        // }
        // else{

        // }


        var formData = new FormData();
        formData.append('_token', "{{ csrf_token() }}");
        formData.append('id', $(this).val());
        formData.append('activate', $(this).prop("checked"));

        $.ajax({
          async: true,
          url: "{{route('userChalanges')}}",
          data: formData,
          cache: false,
          processData: false,
          contentType: false,
          type: 'POST',
          success: function (data) {


          },
          error: function (data) {
            $(".errorMessage").append("<b style='color:red;'>" + data.responseJSON.message + "</b>");
            $(".PassConfirm").prop("disabled", false);
            return false;


          }
        });


      })

      function sendOTP() {
        var formData = new FormData();
        var csrf = "{{csrf_token()}}";
        formData.append('_token', csrf);

        $.ajax({
          async: true,
          url: '{{route('profile-otp')}}',
          data: formData,
          cache: false,
          processData: false,
          contentType: false,
          type: 'POST',
          success: function (data) {
            console.log(data);
            // $(".errorMessage").append("<b style='color:green;'>" + data.message + "</b>");
            // window.location.reload(true);
          },
          error: function (data) {
            console.log(data);
            // $(".errorMessage").append("<b style='color:red;'>" + data.responseJSON.message + "</b>");
            // $(".PassConfirm").prop("disabled", false);
            // return false;
          }
        });
      }

      $("#togglePR").change(function () {
        $(".errorMessage").empty();
        $(".forminput").val("")
        // sendOTP();
        if ($(this).prop('checked') === true) {
          $("#pass-modal1").modal({
            backdrop: false
          })
        }
      })

      $("#pass-modal1").find(".cancellogin").click(function () {
        $("#pass-modal1").modal('hide');
        $("#togglePR").prop('checked', false)
      })

      $(".PassConfirm").click(function () {
        $("#passInput").next("b").empty();
        $(".errorMessage").empty();
        var parent = "{{$parent}}";

        $(this).prop("disabled", true);
        var formData = new FormData();
        formData.append('_token', "{{ csrf_token() }}");
        formData.append('id', parent);
        $.ajax({
          async: true,
          {{--url: '{{route("parentLogin")}}',--}}
          url: '{{url()->route('parent-login')}}',
          data: formData,
          cache: false,
          processData: false,
          contentType: false,
          type: 'POST',
          success: function (data) {
            $(".errorMessage").append("<b style='color:green;'>" + data.message + "</b>");
            window.location.reload(true);
            //            $(".SimpleLogin").prop( "disabled", false );

          },
          error: function (data) {
            $(".errorMessage").append("<b style='color:red;'>" + data.responseJSON.message + "</b>");
            $(".PassConfirm").prop("disabled", false);
            return false;
          }
        });


        // if ($("#passInput").val()) {
        //     var pass = $("#passInput").val();
        //     formData.append('password', pass);
        //
        // } else {
        //     $("#passInput").next("b").append("<p>Please Enter Password</p>")
        // }
      })

      $(".unfavourite").click(function () {

        var reaction_id = $(this).attr('data-reaction-id');
        var parent_div = $(this).closest('.col-md-4');
        var formData = new FormData();
        var csrf = "{{csrf_token()}}";
        formData.append('_token', csrf);
        formData.append('reaction_id', reaction_id);


        $.ajax({
          url: "{{route('reaction.delete')}}",
          method: 'POST',
          contentType: false,
          processData: false,
          data: formData,
          success: function (res) {
            if (res.status == 'success') {
              parent_div.remove();
            } else {

            }
          },
          error: function () {
            console.log('error removing reacting');
          }
        });


      });


      $(".prinput").change(function () {

        var formData = new FormData();
        var input = $(this);
        var file = input[0].files[0];
        var csrf = "{{csrf_token()}}";

        formData.append('profile', file);
        formData.append('_token', csrf);

        upload_profile_image(formData);

      });

      function upload_profile_image(formData) {

        $.ajax({
          url: "{{route('user.profile.upload')}}",
          method: 'POST',
          contentType: false,
          processData: false,
          data: formData,
          success: function (res) {
            $("#profile_image").attr('src', res);
          },
          error: function (error) {
            console.log(error);
            $("#invalidData").modal("show");
            console.log('error')
          }
        });

      }

      var clipboard = new ClipboardJS('.share');

      clipboard.on('success', function (e) {
        alert("Link Copied to clipboard");
      });

      clipboard.on('error', function (e) {
        console.log(e);
      });

      $("#avatar").on('click', function () {
        $("#avatar-modal").modal("show");
      });

      $(".upload_avatar").click(function () {

        var avatar = $('input[name="avatar"]:checked').val();

        if (avatar) {

          var formData = new FormData();
          var csrf = "{{csrf_token()}}";
          formData.append('avatar', avatar);
          formData.append('_token', csrf);
          upload_profile_image(formData);
          $("#avatar-modal").modal("hide");

        }


      });

    });


    $(".archive").click(function () {

      var ele = $(this);
      var formData = new FormData();
      var csrf = "{{csrf_token()}}";
      formData.append('_token', csrf);
      formData.append('archive_type', ele.attr('data-type'));
      formData.append('archive_id', ele.attr('data-id'));

      $.ajax({
        url: "{{route('archive.add')}}",
        method: 'POST',
        contentType: false,
        processData: false,
        data: formData,
        success: function (res) {
          window.location.reload(true);
          if (res.status == 'success') {
            ele.parent().remove();
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

