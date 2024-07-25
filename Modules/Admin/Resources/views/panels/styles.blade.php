        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat:300,400,500,600">
        <link rel="stylesheet" href="{{ asset('admin/vendors/css/vendors.min.css') }}">
        <link rel="stylesheet" href="{{ asset('admin/vendors/css/ui/prism.min.css') }}">
        {{-- Vendor Styles --}}
        @yield('vendor-style')
        {{-- Theme Styles --}}
        <link rel="stylesheet" href="{{ asset('admin/css/bootstrap.css') }}">
        <link rel="stylesheet" href="{{ asset('admin/css/bootstrap-extended.css') }}">
        <link rel="stylesheet" href="{{ asset('admin/css/colors.css') }}">
        <link rel="stylesheet" href="{{ asset('admin/css/components.css') }}">
        <link rel="stylesheet" href="{{ asset('admin/css/themes/dark-layout.css') }}">
        <link rel="stylesheet" href="{{ asset('admin/css/themes/semi-dark-layout.css') }}">

        <link rel="stylesheet" href="{{ asset('admin/css/core/menu/menu-types/horizontal-menu.css') }}">
        <link rel="stylesheet" href="{{ asset('admin/css/core/menu/menu-types/vertical-menu.css') }}">
        <link rel="stylesheet" href="{{ asset('admin/css/core/colors/palette-gradient.css') }}">
        {{-- Page Styles --}}
        @yield('page-style')
{{-- Laravel Style --}}
        <link rel="stylesheet" href="{{ asset('admin/css/custom-laravel.css') }}">

        <link rel="stylesheet" href="{{ asset('admin/css/custom-rtl.css') }}">