<style>
  .brand-text mb-0 {
    margin-top: 0px;
  }

  .main-menu-content {
    margin-top: 20px;
  }
</style>
<div
  class="main-menu menu-fixed {{($configData['theme'] === 'light') ? "menu-light" : "menu-dark"}} menu-accordion menu-shadow"
  data-scroll-to-active="true">
  <div class="navbar-header">
    <ul class="nav navbar-nav flex-row">
      <li class="nav-item mr-auto"><a class="navbar-brand" href="">
          <div class="brand-logo"></div>
          <h3 class="brand-text mb-0">Gallery Kids</h3><br>

        </a>
        <p class="brand-text mb-0">Content Management System</p>
      </li>
      <li class="nav-item nav-toggle"><a class="nav-link modern-nav-toggle pr-0" data-toggle="collapse"><i
            class="feather icon-x d-block d-xl-none font-medium-4 primary toggle-icon"></i><i
            class="toggle-icon feather icon-disc font-medium-4 d-none d-xl-block primary collapse-toggle-icon"
            data-ticon="icon-disc"></i></a></li>
    </ul>
  </div>
  <div class="shadow-bottom"></div>
  <div class="main-menu-content">
    <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">

      {{-- Foreach menu item starts --}}

      {{-- @foreach($menuData[0]->menu as $menu)

           @if(isset($menu->navheader))
               <li class="navigation-header">
                   <span>{{ $menu->navheader }}</span>
               </li>
           @else --}}
      {{-- Add Custom Class with nav-item --}}
      {{-- @php
        $custom_classes = "";
        if(isset($menu->classlist)) {
          $custom_classes = $menu->classlist;
        }
        $translation = "";
        if(isset($menu->i18n)){
            $translation = $menu->i18n;
        }
      @endphp --}}
      {{--  <li class="nav-item {{ (request()->is($menu->url)) ? 'active' : '' }} {{ $custom_classes }}">
              <a href="{{ $menu->url }}">
                  <i class="{{ $menu->icon }}"></i>
                  <span class="menu-title" data-i18n="{{ $translation }}">{{ $menu->name }}</span>
                  @if (isset($menu->badge))
                      <?php $badgeClasses = "badge badge-pill badge-primary float-right" ?>
                      <span class="{{ isset($menu->badgeClass) ? $menu->badgeClass.' test' : $badgeClasses.' notTest' }} ">{{$menu->badge}}</span>
                  @endif
              </a>
              @if(isset($menu->submenu))
                  @include('admin::panels/submenu', ['menu' => $menu->submenu])
              @endif
          </li>
      @endif

  @endforeach --}}

      {{-- Added 01-07-2020 --}}

      <li class="nav-item has-sub {{ (request()->is('user')) ? 'active' : '' }}">
        <a href="">
          <i class="feather icon-mail"></i>
          <span class="menu-title" data-i18n="nav.app_email">User</span>
        </a>
        <ul class="menu-content" style="">
          <li class="">
            <a href="{{route('user.index',['type' => 'guardian'])}}">
              <i class="feather icon-circle"></i>
              <span class="menu-title" data-i18n="">Parent/Guardian</span>
            </a>
          </li>
          <li class="">
            <a href="{{route('user.index',['type' => 'teacher'])}}">
              <i class="feather icon-circle"></i>
              <span class="menu-title" data-i18n="">Teachers</span>
            </a>
          </li>
          <li class="">
            <a href="{{route('user.index',['type' => 'student'])}}">
              <i class="feather icon-circle"></i>
              <span class="menu-title" data-i18n="">Childs</span>
            </a>
          </li>
          {{-- Added 17-Mar-2021 --}}
          @if (config('app.delete_user_on_admin'))
            <li class="">
              <a href="{{route('admin.users.search')}}">
                <i class="feather icon-circle"></i>
                <span class="menu-title" data-i18n="">Delete</span>
              </a>
            </li>
          @endif
        </ul>

      </li>

      <li class="nav-item has-sub {{ (request()->is('avatar')) ? 'active' : '' }}">
        <a href="">
          <i class="feather icon-mail"></i>
          <span class="menu-title" data-i18n="nav.app_email">Avatar</span>
        </a>
        <ul class="menu-content" style="">
          <li class="">
            <a href="{{route('avatar.index')}}">
              <i class="feather icon-circle"></i>
              <span class="menu-title" data-i18n="">List</span>
            </a>
          </li>
          <li class="">
            <a href="{{route('avatar.create')}}">
              <i class="feather icon-circle"></i>
              <span class="menu-title" data-i18n="">Create</span>
            </a>
          </li>
        </ul>

      </li>

      <li class="nav-item has-sub {{ (request()->is('category')) ? 'active' : '' }}">
        <a href="">
          <i class="feather icon-mail"></i>
          <span class="menu-title" data-i18n="nav.app_email">Category</span>
        </a>
        <ul class="menu-content" style="">
          <li class="">
            <a href="{{route('category.index')}}">
              <i class="feather icon-circle"></i>
              <span class="menu-title" data-i18n="">List</span>
            </a>
          </li>
          <li class="">
            <a href="{{route('category.create')}}">
              <i class="feather icon-circle"></i>
              <span class="menu-title" data-i18n="">Create</span>
            </a>
          </li>
        </ul>

      </li>
      <li class="nav-item has-sub {{ (request()->is('create')) ? 'active' : '' }}">
        <a href="">
          <i class="feather icon-mail"></i>
          <span class="menu-title" data-i18n="nav.app_email">Create</span>
        </a>
        <ul class="menu-content" style="">
          <li class="">
            <a href="{{route('create.index')}}">
              <i class="feather icon-circle"></i>
              <span class="menu-title" data-i18n="">List</span>
            </a>
          </li>
          <li class="">
            <a href="{{route('create.create')}}">
              <i class="feather icon-circle"></i>
              <span class="menu-title" data-i18n="">Create</span>
            </a>
          </li>
        </ul>

      </li>

      <!--<li class="nav-item has-sub {{ (request()->is('discover')) ? 'active' : '' }}">
        <a href="">
          <i class="feather icon-mail"></i>
          <span class="menu-title" data-i18n="nav.app_email">Explore</span>
        </a>
        <ul class="menu-content" style="">
          <li class="">
            <a href="{{route('discover.index')}}">
              <i class="feather icon-circle"></i>
              <span class="menu-title" data-i18n="">List</span>
            </a>
          </li>
          <li class="">
            <a href="{{route('discover.create')}}">
              <i class="feather icon-circle"></i>
              <span class="menu-title" data-i18n="">Create</span>
            </a>
          </li>
        </ul>

      </li>-->
      
      <!------------- new nov 2021 ------------------->
      <!--explore-->
      <li class="nav-item has-sub {{ (request()->is('admin/explore/*')) ? 'active open' : '' }}">
        <a href="">
          <i class="feather icon-map"></i>
          <span class="menu-title">Explore</span>
        </a>
        <ul class="menu-content" style="">
          <li class="">
            <a href="{{route('admin.explore.page-content')}}">
              <i class="feather icon-circle"></i>
              <span class="menu-title" data-i18n="">Explore Main</span>
            </a>
          </li>
          <li class="">
            <a href="{{route('admin.explore.spaces.categories.index')}}">
              <i class="feather icon-circle"></i>
              <span class="menu-title" data-i18n="">Explore Categories</span>
            </a>
          </li>
          <li class="">
            <a href="{{route('admin.explore.spaces.index')}}">
              <i class="feather icon-circle"></i>
              <span class="menu-title" data-i18n="">Explore Contents</span>
            </a>
          </li>
        </ul>
      </li>
      <!--end explore-->
      <!------------- end new nov 2021 ------------------->

      <li class="nav-item has-sub {{ (request()->is('question')) ? 'active' : '' }}">
        <a href="">
          <i class="feather icon-mail"></i>
          <span class="menu-title" data-i18n="nav.app_email">Question</span>
        </a>
        <ul class="menu-content" style="">
          <li class="">
            <a href="{{route('question.index')}}">
              <i class="feather icon-circle"></i>
              <span class="menu-title" data-i18n="">List</span>
            </a>
          </li>
        </ul>

      </li>

      <li class="nav-item has-sub {{ (request()->is('share')) ? 'active' : '' }}">
        <a href="">
          <i class="feather icon-mail"></i>
          <span class="menu-title" data-i18n="nav.app_email">Share</span>
        </a>
        <ul class="menu-content" style="">
          <li class="">
            <a href="{{route('share.index')}}">
              <i class="feather icon-circle"></i>
              <span class="menu-title" data-i18n="">List</span>
            </a>
          </li>
          <li class="">
            <a href="{{route('share.create')}}">
              <i class="feather icon-circle"></i>
              <span class="menu-title" data-i18n="">Create</span>
            </a>
          </li>
        </ul>

      </li>

      <!--<li class="nav-item has-sub {{ (request()->is('play')) ? 'active' : '' }}">
        <a href="">
          <i class="feather icon-mail"></i>
          <span class="menu-title" data-i18n="nav.app_email">Play</span>
        </a>
        <ul class="menu-content" style="">
          <li class="">
            <a href="{{route('play.index')}}">
              <i class="feather icon-circle"></i>
              <span class="menu-title" data-i18n="">List</span>
            </a>
          </li>
          <li class="">
            <a href="{{route('play.create')}}">
              <i class="feather icon-circle"></i>
              <span class="menu-title" data-i18n="">Create</span>
            </a>
          </li>
        </ul>

      </li>-->

      <!------------- new nov 2021 ------------------->
      <!--play-->
      <li class="nav-item has-sub {{ (request()->is('admin/play/*')) ? 'active open' : '' }}">
        <a href="">
          <i class="feather icon-map"></i>
          <span class="menu-title">Play</span>
        </a>
        <ul class="menu-content" style="">
          <li class="">
            <a href="{{route('admin.play.page-content')}}">
              <i class="feather icon-circle"></i>
              <span class="menu-title" data-i18n="">Play Main</span>
            </a>
          </li>
          <li class="">
            <a href="{{route('admin.play.spaces.categories.index')}}">
              <i class="feather icon-circle"></i>
              <span class="menu-title" data-i18n="">Play Categories</span>
            </a>
          </li>
          <li class="">
            <a href="{{route('admin.play.spaces.index')}}">
              <i class="feather icon-circle"></i>
              <span class="menu-title" data-i18n="">Play Contents</span>
            </a>
          </li>
        </ul>
      </li>
      <!--end play-->
      <!------------- end new nov 2021 ------------------->

      <li class="nav-item has-sub {{ (request()->is('event')) ? 'active' : '' }}">
        <a href="">
          <i class="feather icon-mail"></i>
          <span class="menu-title" data-i18n="nav.app_email">Event</span>
        </a>
        <ul class="menu-content" style="">
          <li class="">
            <a href="{{route('event.index')}}">
              <i class="feather icon-circle"></i>
              <span class="menu-title" data-i18n="">List</span>
            </a>
          </li>
          <li class="">
            <a href="{{route('event.create')}}">
              <i class="feather icon-circle"></i>
              <span class="menu-title" data-i18n="">Create</span>
            </a>
          </li>
        </ul>

      </li>

      <li class="nav-item has-sub {{ (request()->is('setting')) ? 'active' : '' }}">
        <a href="">
          <i class="feather icon-mail"></i>
          <span class="menu-title" data-i18n="nav.app_email">Setting</span>
        </a>
        <ul class="menu-content" style="">
          <li class="">
            <a href="{{route('setting.index')}}">
              <i class="feather icon-circle"></i>
              <span class="menu-title" data-i18n="">List</span>
            </a>
          </li>
          <li class="">
            <a href="{{route('setting.tab.index')}}">
              <i class="feather icon-circle"></i>
              <span class="menu-title" data-i18n="">Tabs</span>
            </a>
          </li>
        </ul>

      </li>

      <!--<li class="nav-item has-sub {{ (request()->is('exhibition')) ? 'active' : '' }}">
        <a href="">
          <i class="feather icon-mail"></i>
          <span class="menu-title" data-i18n="nav.app_email">Exhibition</span>
        </a>
        <ul class="menu-content" style="">
          <li class="">
            <a href="{{route('exhibition.index')}}">
              <i class="feather icon-circle"></i>
              <span class="menu-title" data-i18n="">List</span>
            </a>
          </li>
          <li class="">
            <a href="{{route('exhibition.create')}}">
              <i class="feather icon-circle"></i>
              <span class="menu-title" data-i18n="">Create</span>
            </a>
          </li>
        </ul>
      </li>-->

       <!------------- new nov 2021 ------------------->
      <!--festivals-->
      <li class="nav-item has-sub {{ (request()->is('admin/festivals/*')) ? 'active open' : '' }}">
        <a href="">
          <i class="feather icon-map"></i>
          <span class="menu-title">Festivals</span>
        </a>
        <ul class="menu-content" style="">
          <li class="">
            <a href="{{route('admin.festivals.page-content')}}">
              <i class="feather icon-circle"></i>
              <span class="menu-title" data-i18n="">Festivals Main</span>
            </a>
          </li>
          <li class="">
            <a href="{{route('admin.festivals.spaces.categories.index')}}">
              <i class="feather icon-circle"></i>
              <span class="menu-title" data-i18n="">Festivals Categories</span>
            </a>
          </li>
          <li class="">
            <a href="{{route('admin.festivals.spaces.index')}}">
              <i class="feather icon-circle"></i>
              <span class="menu-title" data-i18n="">Festivals Contents</span>
            </a>
          </li>
        </ul>
      </li>
      <!--end festivals-->
      <!------------------ end new nov 2021 -------------------------->

      <li class="nav-item has-sub {{ (request()->is('admin/kcae/*')) ? 'active open' : '' }}">
        <a href="">
          <i class="feather icon-map"></i>
          <span class="menu-title">KCAE</span>
        </a>
        <ul class="menu-content" style="">
          <li class="">
            <a href="{{route('admin.kcae.page-content')}}">
              <i class="feather icon-circle"></i>
              <span class="menu-title" data-i18n="">Page Content</span>
            </a>
          </li>
          <li class="">
            <a href="{{route('admin.kcae.hero-slides.index')}}">
              <i class="feather icon-circle"></i>
              <span class="menu-title" data-i18n="">Hero Slider</span>
            </a>
          </li>
          <li class="">
            <a href="{{route('admin.kcae.spaces.categories.index')}}">
              <i class="feather icon-circle"></i>
              <span class="menu-title" data-i18n="">Spaces Categories</span>
            </a>
          </li>
          <li class="">
            <a href="{{route('admin.kcae.spaces.index')}}">
              <i class="feather icon-circle"></i>
              <span class="menu-title" data-i18n="">Spaces</span>
            </a>
          </li>
          <li class="">
            <a href="{{route('admin.kcae.spaces.slides.index')}}">
              <i class="feather icon-circle"></i>
              <span class="menu-title" data-i18n="">Space Slides</span>
            </a>
          </li>
        </ul>
      </li>

      <li class="nav-item has-sub {{ (request()->is('festival')) ? 'active' : '' }}">
        <a href="">
          <i class="feather icon-mail"></i>
          <span class="menu-title" data-i18n="nav.app_email">Festival</span>
        </a>
        <ul class="menu-content" style="">
          <li class="">
            <a href="{{route('festival.index')}}">
              <i class="feather icon-circle"></i>
              <span class="menu-title" data-i18n="">List</span>
            </a>
          </li>
          <li class="">
            <a href="{{route('festival.create')}}">
              <i class="feather icon-circle"></i>
              <span class="menu-title" data-i18n="">Create</span>
            </a>
          </li>
        </ul>

      </li>

      <li class="nav-item has-sub {{ (request()->is('adminShare')) ? 'active' : '' }}">
        <a href="">
          <i class="feather icon-mail"></i>
          <span class="menu-title" data-i18n="nav.app_email">Piction Share Data</span>
        </a>
        <ul class="menu-content" style="">
          <li class="">
            <a href="{{route('adminShare.index')}}">
              <i class="feather icon-circle"></i>
              <span class="menu-title" data-i18n="">List</span>
            </a>
          </li>
          {{--                    <li class="">--}}
          {{--                        <a href="{{route('adminShare.add')}}">--}}
          {{--                            <i class="feather icon-circle"></i>--}}
          {{--                            <span class="menu-title" data-i18n="">Create</span>--}}
          {{--                        </a>--}}
          {{--                    </li>--}}
        </ul>

      </li>


      <li class="nav-item has-sub {{ (request()->is('challenges')) ? 'active' : '' }}">
        <a href="">
          <i class="feather icon-mail"></i>
          <span class="menu-title" data-i18n="nav.app_email">Challenges</span>
        </a>
        <ul class="menu-content" style="">
          <li class="">
            <a href="{{route('challenges.index')}}">
              <i class="feather icon-circle"></i>
              <span class="menu-title" data-i18n="">List</span>
            </a>
          </li>
          <li class="">
            <a href="{{route('challenges.create')}}">
              <i class="feather icon-circle"></i>
              <span class="menu-title" data-i18n="">Create</span>
            </a>
          </li>
        </ul>

      </li>
      <li class="nav-item has-sub {{ (request()->is('campaign')) ? 'active' : '' }}">
        <a href="">
          <i class="feather icon-mail"></i>
          <span class="menu-title" data-i18n="nav.app_email">Campaign</span>
        </a>
        <ul class="menu-content" style="">
          <li class="">
            <a href="{{route('campaign.index')}}">
              <i class="feather icon-circle"></i>
              <span class="menu-title" data-i18n="">List</span>
            </a>
          </li>
          <li class="">
            <a href="{{route('campaign.create')}}">
              <i class="feather icon-circle"></i>
              <span class="menu-title" data-i18n="">Create</span>
            </a>
          </li>
        </ul>

      </li>

      {{-- Added 01-07-2020 --}}
      @if (config('app.show_memberson_on_admin'))
        <li class="nav-item has-sub {{ (request()->is('admin.memberson-profile.list')) ? 'active' : '' }}">
          <a href="">
            <i class="feather icon-users"></i>
            <span class="menu-title" data-i18n="nav.app_email">Memberson Data</span>
          </a>
          <ul class="menu-content" style="">
            <li class="">
              <a href="{{route('admin.memberson-profile.list')}}">
                <i class="feather icon-circle"></i>
                <span class="menu-title" data-i18n="">List</span>
              </a>
            </li>
          </ul>

        </li>
      @endif

      {{-- Foreach menu item ends --}}
    </ul>
  </div>
</div>
<!-- END: Main Menu-->
