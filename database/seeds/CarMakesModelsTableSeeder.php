<?php

use Illuminate\Database\Seeder;

class CarMakesModelsTableSeeder extends Seeder
{
    private $ml_makes_models = [];

    public function __construct()
    {
        if (!file_exists('docs/mercadolibre/marcas_modelos.json')) {
            echo 'El archivo json de ML no existe' . PHP_EOL;
        }

        $this->ml_makes_models = json_decode(file_get_contents('docs/mercadolibre/marcas_modelos.json'), true);
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->ml_makes_models as $car_make) {

            DB::table('car_makes')->insert([
                'id'   => $car_make['id'],
                'name' => $car_make['name'],
            ]);

            foreach ($car_make['models'] as $car_model) {
                DB::table('car_models')->insert([
                    'id'          => $car_model['id'],
                    'name'        => $car_model['name'],
                    'car_make_id' => $car_make['id'],
                ]);
            }
        }
    }
}