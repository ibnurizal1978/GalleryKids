    <body class="vertical-layout vertical-menu-modern 2-columns {{ $configData['blankPageClass'] }} {{ $configData['bodyClass'] }}  {{($configData['theme'] === 'light') ? '' : $configData['theme'] }}  {{ $configData['navbarType'] }} {{ $configData['sidebarClass'] }} {{ $configData['footerType'] }}" data-menu="vertical-menu-modern" data-col="2-columns"  data-layout="{{ $configData['theme'] }}">
        {{-- Include Sidebar --}}
        @include('admin::panels.sidebar')

        <!-- BEGIN: Content-->
        <div class="app-content content">
            <!-- BEGIN: Header-->
            <div class="content-overlay"></div>
            <div class="header-navbar-shadow"></div>

            {{-- Include Navbar --}}
            @include('admin::panels.navbar')

            @if(!empty($configData['contentLayout']))
                <div class="content-area-wrapper">
                    <div class="{{ $configData['sidebarPositionClass'] }}">
                        <div class="sidebar">
                            {{-- Include Sidebar Content --}}
                            @yield('content-sidebar')
                        </div>
                    </div>
                    <div class="{{ $configData['contentsidebarClass'] }}">
                        <div class="content-wrapper">
                            <div class="content-body">
                                {{-- Include Page Content --}}
                                @yield('content')
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="content-wrapper">
                    {{-- Include Breadcrumb --}}
                    @if($configData['pageHeader'] == true)
                        @include('admin::panels.breadcrumb')
                    @endif

                    <div class="content-body">
                        {{-- Include Page Content --}}
                        @yield('content')
                    </div>
                </div>
            @endif

        </div>
        <!-- End: Content-->

        @if($configData['blankPage'] == false)
           

        @endif

        <div class="sidenav-overlay"></div>
        <div class="drag-target"></div>

        {{-- include footer --}}
        @include('admin::panels/footer')

        {{-- include default scripts --}}
        @include('admin::panels/scripts')

    </body>
</html>
