<?php

namespace App\Console\Commands;

use App\Services\Piction\Manager;
use Illuminate\Console\Command;

class SyncImagesFromPiction extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'piction:sync';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync Artworks from Piction API';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $pictionManager = resolve( Manager::class );
        $artworks       = $pictionManager->getAllArtworks();

        if ( ! $artworks ) {
            $this->info( 'No artwork images found' );

            return 0;
        }

        $this->info( 'Total ' . count( $artworks ) . ' artworks found!' );
        $this->line( 'Syncing all of them to the database:' );

        $bar = $this->output->createProgressBar( count( $artworks ) );
        foreach ( $artworks as $artwork ) {
            $pictionManager->syncArtworkToDatabase( $artwork );
            $bar->advance();
        }

        $bar->finish();
        $this->info( PHP_EOL . 'All artworks synced successfully!' );

        // Delete old non exists artworks
        $pictionManager->deleteNonExisting( $artworks );
        $this->line( 'Deleted all non existing old artworks' );

        return 0;
    }
}
