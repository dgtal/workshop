<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Foundation\Inspiring;

class AutodataCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'data:autodata {json-file}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Parsear JSON de marcas de Autodata';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $jsonfile = $this->argument('json-file');

        $jsonfile = file_get_contents(database_path(sprintf('/seeds/data/%s', $jsonfile)));

        $jsonfile = json_decode($jsonfile, true);

        foreach ($jsonfile['marcas'] as $marca_id => $marca) {
            $marca = trim($marca);

            $this->comment($marca_id . ' - ' . trim(substr($marca, 0, strlen($marca)-5)));

            $modelos = file_get_contents(sprintf('http://www.autodata.com.uy/list0/ab/%d/X', $marca_id));
            file_put_contents(database_path(sprintf('/seeds/data/models/%d.json', $marca_id)), $modelos);
        }
    }
}
