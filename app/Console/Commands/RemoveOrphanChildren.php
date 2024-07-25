<?php

namespace App\Console\Commands;

use App\Role;
use App\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class RemoveOrphanChildren extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:remove_orphan_children';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Remove orphan (without parents) children';

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
        $childRole = Role::whereName( 'student' )->first();
        if ( ! $childRole ) {
            $this->error( 'Child role not found' );

            return 1;
        }

        $children = User::whereRoleId( $childRole->id )
                        ->doesntHave( 'parents' )
                        ->get();

        if ( ! $children->count() ) {
            $this->info( 'No orphan child exists!' );

            return 0;
        }

        $this->line( "Deleting {$children->count()} orphan children..." );

        $childrenIds = $children->pluck( 'id' )->toArray();

        Schema::disableForeignKeyConstraints();
        DB::table( 'relation_user' )
          ->whereIn( 'child_id', $childrenIds )
          ->delete();

        User::whereIn( 'id', $childrenIds )
            ->delete();

        Schema::enableForeignKeyConstraints();

        $this->info( 'All orphan children deleted successfully!' );

        return 0;
    }
}
