@isset($pageConfigs)
    {!! Helper::updatePageConfig($pageConfigs) !!}
@endisset

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-textdirection="{{ env('MIX_CONTENT_DIRECTION') === 'rtl' ? 'rtl' : 'ltr' }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width,initial-scale=1.0">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('title') - Gallery Kids CMS</title>
        <link rel="shortcut icon" type="image/x-icon" href="images/logo/favicon.ico">

        {{-- Include core + vendor Styles --}}
        @include('admin::panels/styles')

    </head>

    @extends((( $configData["mainLayoutType"] === 'horizontal') ? 'admin::layouts/horizontalLayoutMaster' : 'admin::layouts.verticalLayoutMaster' ))
