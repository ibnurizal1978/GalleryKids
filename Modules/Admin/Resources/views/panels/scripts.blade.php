        {{-- Vendor Scripts --}}
        <script src="{{ asset('admin/vendors/js/vendors.min.js') }}"></script>
        <script src="{{ asset('admin/vendors/js/ui/prism.min.js') }}"></script>
        @yield('vendor-script')
        {{-- Theme Scripts --}}
        <script src="{{ asset('admin/js/core/app-menu.js') }}"></script>
        <script src="{{ asset('admin/js/core/app.js') }}"></script>
        <script src="{{ asset('admin/js/scripts/components.js') }}"></script>
@if($configData['blankPage'] == false)
        <script src="{{ asset('admin/js/scripts/customizer.js') }}"></script>
        <script src="{{ asset('admin/js/scripts/footer.js') }}"></script>
@endif
        {{-- page script --}}
        @yield('page-script')
        {{-- page script --}}
