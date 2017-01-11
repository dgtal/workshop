<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Foundation\Inspiring;

class MercadoLibreCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'data:mercadolibre';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Parsear JSON de marcas/modelos de Mercado Libre';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $url_make   = 'https://api.mercadolibre.com/categories/MLA1744';
        $url_models = 'https://api.mercadolibre.com/categories/%s';

        $json_makes = file_get_contents($url_make);

        $makes = json_decode($json_makes, true);

        $makes_data = [];

        foreach ($makes['children_categories'] as $make) {
            $make_id = (int) str_replace('MLA', '', $make['id']);

            $makes_data[$make_id] = ['id' => $make_id, 'name' => $make['name'], 'models' => []];

            $this->comment($make['name']);

            $models = json_decode(file_get_contents(sprintf($url_models, $make['id'])), true);

            foreach ($models['children_categories'] as $model) {
                $this->comment(' > ' . $model['name']);

                $model_id = (int) str_replace('MLA', '', $model['id']);

                $makes_data[$make_id]['models'][] = ['id' => $model_id, 'name' => $model['name']];
            }
        }

        file_put_contents(database_path('/seeds/mercadolibre/marcas_modelos.json'), json_encode($makes_data), FILE_APPEND);
    }
}