<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use App\Models\Model;

class CarMakesModelsTableSeeder extends Seeder
{
    private $car_makes = [];
    private $makes_models = [];
    private $models_files = [];

    public function __construct()
    {
        // if (!file_exists('docs/mercadolibre/marcas_modelos.json')) {
        //     echo 'El archivo json de ML no existe' . PHP_EOL;
        // }

        // $this->makes_models = json_decode(file_get_contents('docs/mercadolibre/marcas_modelos.json'), true);

        $this->car_makes = json_decode(File::get(database_path('seeds/data/segurosonline/car_makes.json')), true);

        $this->models_files = glob(database_path('seeds/data/segurosonline/models/*.json'));
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('makes')->delete();
        DB::table('families')->delete();
        DB::table('models')->delete();

        foreach ($this->car_makes as $car_make) {
            DB::table('makes')->insert([
                'id'   => $car_make['id'],
                'name' => $car_make['name'],
            ]);
        }

        foreach ($this->models_files as $model_file) {
            if (filesize($model_file) == 0)
                continue;

            $models = json_decode(File::get($model_file), true);

            foreach ($models as $model) {
                // echo $model['make_name'] . ' ' . $model['model_name'] . PHP_EOL;

                $car_model = Model::select('id','name')
                                  ->whereName((string) $model['model_name'])
                                  ->whereMakeId((int) $model['make_id'])
                                  ->first();

                if (!$car_model) {
                    DB::table('models')->insert([
                        // 'id'         => (int) $model['model_id'],
                        'make_id'    => (int) $model['make_id'],
                        'family_id'  => null,
                        'name'       => (string) $model['model_name'],
                        'created_at' => Carbon::now(),
                    ]);
                }
            }
        }
    }
}