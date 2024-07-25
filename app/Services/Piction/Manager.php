<?php


namespace App\Services\Piction;


use App\Models\AdminShareDeriv;
use http\Exception\BadMethodCallException;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Modules\AdminShare\Entities\AdminShare;

class Manager
{
    /**
     * @var Client
     */
    protected $client;

    public function __construct( Client $client )
    {
        $this->client = $client;
    }

    public function getAllArtworks()
    {
        $apiResponse = $this->client
            ->getArtworkImages();

        $apiResponse = collect( $apiResponse )
            ->filter( function ( $artwork ) {
                return $artwork && property_exists( $artwork, 'umo_id' );
            } );

        // Add any process later on...

        return $apiResponse;
    }

    public function deleteNonExisting( $artworks )
    {
        $artworkIds = collect( $artworks )->pluck( 'umo_id' )->toArray();

        return AdminShare::whereNotIn( 'uid', $artworkIds )->delete();
    }

    public function syncArtworkToDatabase( $artwork )
    {
        if ( ! class_exists( AdminShare::class ) ) {
            return false;
        }

        $derivs     = collect( $artwork->derivs )
            ->sortByDesc( 'order' );
        $firstDeriv = $derivs->first();

        // create admin share
        $imageName = $this->getShareImage( $firstDeriv );
        $share     = AdminShare::updateOrCreate( [
            'uid' => $artwork->umo_id
        ], [
            'image'               => $imageName,
            'TITLE'               => $artwork->metadata->{'ARTWORK DATA.TITLE'}[0] ?? null,
            'ARTIST'              => $artwork->metadata->{'ARTWORK DATA.ARTIST'}[0]->{'ARTWORK DATA.ARTIST:ARTIST_NAME'} ?? null,
            'DATE_OF_ART_CREATED' => $artwork->metadata->{'ARTWORK DATA.DATE_OF_ART_CREATED'},
            'CLASSIFICATION'      => $artwork->metadata->{'ARTWORK DATA.CLASSIFICATION'},
            'CREDITLINE'          => $artwork->metadata->{'ARTWORK DATA.CREDITLINE'},
            'medium'              => $artwork->metadata->{'ARTWORK DATA.MEDIUM'} ?? null,
            'dimension'           => $this->getDimension( $artwork->metadata ),
            'status'              => 'Enable',
            'data'                => $artwork,
        ] );

        $this->cloneDeriveImage( // Clone image local disk
            $artwork->umo_id,
            $firstDeriv->url,
            $imageName
        );

        return true;
    }

    protected function getDimension( $artworkMetadata )
    {
        $dimensions = optional( $artworkMetadata )->{'ARTWORK DATA.DIMENSIONS DATA'};
        if ( ! $dimensions ) {
            return null;
        }

        $dimensions = collect( $dimensions );
        $dimension  = $dimensions->firstWhere( 'ARTWORK DATA.DIMENSIONS DATA:DIMENSION TYPE', 'Image measure' );

        if ( ! $dimension ) {
            $dimension = $dimensions->first();
        }

        return optional( $dimension )->{'ARTWORK DATA.DIMENSIONS DATA:DIMENSION U_SUMMARY DATA'};
    }

    protected function cloneDeriveImage( $uid, $url, $imageName )
    {
//        $contents = file_get_contents( $url );
        $contents = $this->urlGetContents( $url );
        $path     = AdminShare::IMAGES_UPLOADS_FOLDER . $uid . '/' . $imageName;

        return Storage::disk( get_publicly_accessible_disk() )
                      ->put( $path, $contents );
    }

    public function getDeriveImageName( $deriv )
    {
        $imageName      = $deriv->name;
        $imageParts     = explode( '.', $imageName );
        $imageExtension = array_pop( $imageParts );

        return Str::slug( implode( ' ', $imageParts ) ) . '.' . $imageExtension;
    }

    protected function getShareImage( $deriv )
    {
        $imageName      = $deriv->name;
        $imageParts     = explode( '.', $imageName );
        $imageExtension = array_pop( $imageParts );

        return Str::slug( implode( ' ', $imageParts ) ) . '.' . $imageExtension;
    }

    protected function urlGetContents( $url )
    {
        $ch = curl_init();
        curl_setopt( $ch, CURLOPT_URL, $url );
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
        $output = curl_exec( $ch );
        curl_close( $ch );

        return $output;
    }
}
