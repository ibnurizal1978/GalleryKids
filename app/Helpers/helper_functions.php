<?php

if ( ! function_exists( 'get_publicly_accessible_disk' ) ) {
    function get_publicly_accessible_disk()
    {
        $currentDisk = config( 'filesystems.default' );

        if ( 'local' === $currentDisk || 'public' === $currentDisk ) {
            return 'public_uploads';
        }

        return $currentDisk;
    }
}

if ( ! function_exists( 'show_missing_profile_info_window' ) ) {
    function show_missing_profile_info_window()
    {
        $user = \Illuminate\Support\Facades\Auth::user();
        if ( ! $user ) {
            return false;
        }

        $memberson = resolve( \App\Repositories\MembersonRepository::class );

        return 'Gallery Explorer' === optional( optional( $user )->data )->membership_type &&
               'GPE' === optional( optional( $user )->data )->benefit_code &&
               $memberson->hasMissingInfo();
    }
}
