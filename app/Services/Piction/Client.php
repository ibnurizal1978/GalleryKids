<?php


namespace App\Services\Piction;


use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class Client
{
    const SURL_TOKEN_CACHE_KEY = 'piction_api_surl_token';
    const DATE_FORMAT = 'd-M-Y';

    public function getArtworkImagesByDateRange( $from, $to )
    {
        $from   = Carbon::parse( $from )->format( static::DATE_FORMAT );
        $to     = Carbon::parse( $to )->format( static::DATE_FORMAT );
        $search = "HIER_CATEGORY:%22National%20Collections%20Artworks%20%22%20AND%20META:%22KIDS_GALLERY.PUBLISH_TO_KIDS_CLUB,YES%22%20AND%20METADATA_UPDATED_BETWEEN:%22{$from},{$to}%22";

        return $this->getArtworkImages( $search );
    }

    public function getArtworkImages( $search = null )
    {
        $token = $this->getToken();

        if ( ! $token ) {
            return false;
        }

        if ( ! $search ) {
            $search = 'HIER_CATEGORY:%22National%20Collections%20Artworks%20%22%20AND%20META:%22KIDS_GALLERY.PUBLISH_TO_KIDS_CLUB,YES%22';
        }
        $endpoint = 'r/st/IQ/surl/' . $token . '/OUTPUT_STYLE/COMPACT/RETURN/DIRECT/INCLUDE_DERIVS/2345/URL_PREFIX/https:$PICTIONSLASH$$PICTIONSLASH$'.$this->getHost() . '$PICTIONSLASH$piction$PICTIONSLASH$/SHOW_FULLTAG/TRUE/DISABLE_ATTRIBS/category,date_created/METATAG_VIEW/GROUP/METATAGS/ARTWORK%20DATA,KIDS_GALLERY/search/' . $search;
        $url      = $this->getUrl( $endpoint );

        if ( ! $url ) {
            return false;
        }

        $response = Http::get( $url );

        if ( $response->successful() && $data = $response->body() ) {
            $data = is_string( $data ) ? json_decode( $data ) : $data;

            return $data;
        }

        return false;
    }

    public function getToken()
    {
        if ( $token = Cache::get( static::SURL_TOKEN_CACHE_KEY ) ) {
            return $token;
        }

        $token = $this->getTokenWithoutCaching();

        if ( $token ) {
            Cache::set(
                static::SURL_TOKEN_CACHE_KEY,
                $token,
                now()->addMinutes( config( 'piction.cache_lifetime.surl_token' ) )
            );
        }

        return $token;
    }

    public function getTokenWithoutCaching()
    {
        $username = config( 'piction.api.username' );
        $password = config( 'piction.api.password' );

        if ( ! $username || ! $password ) {
            return false;
        }

        $endpoint = '/r/st/Piction_login/USERNAME/' . $username . '/PASSWORD/' . $password . '/JSON/T';
        $url      = $this->getUrl( $endpoint );

        if ( ! $url ) {
            return false;
        }

        $response = Http::get( $url );

        if ( $response->successful() && $data = $response->body() ) {
            $data = is_string( $data ) ? json_decode( $data ) : $data;

            if ( $data->SURL ) {
                return $data->SURL;
            }
        }

        return false;
    }


    public function getUrl( $endpoint )
    {
        $host = $this->getHost();

        if ( ! $host ) {
            return false;
        }

        return sprintf(
            'https://%s/%s',
            trim( $host, '/' ),
            trim( $endpoint, '/' )
        );
    }

    public function getHost()
    {
        $host = config( 'piction.api.host' );

        if ( ! $host ) {
            return false;
        }

        // Remove starting http:// or https:// from the host
        return preg_replace( '/^http(s)?:\/\//i', '', $host );
    }
}
