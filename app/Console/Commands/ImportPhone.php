<?php

namespace App\Console\Commands;

use App\Models\City;
use App\Models\Post;
use Illuminate\Console\Command;
use League\Csv\Reader;
use League\Csv\Statement;

class ImportPhone extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:phone';

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
     * @return mixed
     */
    public function handle()
    {
        $stream = \fopen(storage_path('import_phone_08_09_25.csv'), 'r');

        $csv = Reader::createFromStream($stream);
        $csv->setDelimiter(';');
        $csv->setHeaderOffset(0);
        //build a statement
        $stmt = (new Statement());

        $records = $stmt->process($csv);

        $phonesCity = array();

        foreach ($records as $value) {

            $phonesCity[$value['City']][] = $value['Num'];

        }

        foreach ($phonesCity as $city => $phones) {

            $cityInfo = City::where('city', $city)->first();

            if ($cityInfo) {

                if ($posts = Post::where(['city_id' => $cityInfo->id])->get()) {

                    foreach ($posts as $post) {

                        if (rand(0, 5) == 5) {
                            $post->phone = $phones[\array_rand($phones)];
                            $post->save();
                        }

                    }

                }

            }

        }


    }
}
