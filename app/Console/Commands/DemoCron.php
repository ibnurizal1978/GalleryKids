<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Modules\AdminShare\Entities\AdminShare;
use Illuminate\Http\Request;
class DemoCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'demo:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
    public function handle(Request $request)
    {
         try {
            $client = new \GuzzleHttp\Client();
            $response = $client->request('GET', 'https://dmz.nationalgallery.sg/r/st/Piction_login/USERNAME/TRINAX/PASSWORD/TRINAX/JSON/T', ['headers' => [
                    'Accept' => 'application/json',
                    'SvcAuth' => 'VFJJTkFY,VkEyOFloSjlDd3lCWmRLVA==',
                ],
            ]);
            $data = json_decode((string) $response->getBody()->getContents());
            $SURL = $data->SURL;


            try {
                $response = $client->request('GET', 'https://dmz.nationalgallery.sg/r/st/IQ/surl/' . $SURL . '/OUTPUT_STYLE/COMPACT/RETURN/DIRECT/INCLUDE_DERIVS/2345/URL_PREFIX/https:$PICTIONSLASH$$PICTIONSLASH$dmz.nationalgallery.sg$PICTIONSLASH$piction$PICTIONSLASH$/SHOW_FULLTAG/TRUE/DISABLE_ATTRIBS/category,date_created/METATAG_VIEW/GROUP/METATAGS/ARTWORK%20DATA,KIDS_GALLERY/search/HIER_CATEGORY:%22National%20Collections%20Artworks%20%22%20AND%20META:%22KIDS_GALLERY.PUBLISH_TO_KIDS_CLUB,YES%22', ['headers' => [
                        'Accept' => 'application/json',
                        'SvcAuth' => 'VFJJTkFY,VkEyOFloSjlDd3lCWmRLVA==',
                    ],
                ]);
                $data = json_decode((string) $response->getBody()->getContents());
				

//                    foreach($data[''])   
            } catch (\Exception $e) {
                echo $e->getMessage();
            }


//                    foreach($data[''])   
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
        unset($data[0]);

        $image = '';
        $newARTIST = '';
        $testTitle = '';
        foreach ($data as $da) {
            if (count(AdminShare::whereUid($da->umo_id)->get())) {
                
            } else {
                $ARTIST = $da->metadata->{'ARTWORK DATA.ARTIST'};
                $id = $da->umo_id;
                $TITLE = $da->metadata->{'ARTWORK DATA.TITLE'};
                $CLASSIFICATION = $da->metadata->{'ARTWORK DATA.CLASSIFICATION'};
                $CREDITLINE = $da->metadata->{'ARTWORK DATA.CREDITLINE'};
                $DATE_OF_ART_CREATED = $da->metadata->{'ARTWORK DATA.DATE_OF_ART_CREATED'};
                $images = $da->derivs;
                foreach ($images as $img) {
                    $image = $img->url;
                }
                if ($DATE_OF_ART_CREATED) {
                    $ART_CREATED = $DATE_OF_ART_CREATED;
                } else {
                    $ART_CREATED = '';
                }
                foreach ($ARTIST as $Ar) {

                    $newARTIST = $Ar->{'ARTWORK DATA.ARTIST:ARTIST_DOB'};
                }


                foreach ($TITLE as $ti) {
                    $testTitle = $ti;
                }


                $adminShare = new AdminShare();
                $dataShare = $request->only(['image', 'TITLE', 'ARTIST', 'DATE_OF_ART_CREATED',
                    'CLASSIFICATION', 'CREDITLINE', 'status']);
                $dataShare['image'] = $image;
                $dataShare['uid'] = $id;
                $dataShare['TITLE'] = $testTitle;
                $dataShare['ARTIST'] = $newARTIST;
                $dataShare['DATE_OF_ART_CREATED'] = $ART_CREATED;
                $dataShare['CLASSIFICATION'] = $CLASSIFICATION;
                $dataShare['CREDITLINE'] = $CREDITLINE;
                $dataShare['status'] = 'Disable';
                //dd($dataShare);
                $adminShare = $adminShare->create($dataShare);
                
            }
        }
        \Log::info("Cron is working fine!");
     
        /*
           Write your database logic we bellow:
           Item::create(['name'=>'hello new']);
        */
      
        $this->info('Demo:Cron Cummand Run successfully!');
    }
}
