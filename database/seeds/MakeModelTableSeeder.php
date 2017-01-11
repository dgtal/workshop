<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class MakeModelTableSeeder extends Seeder
{
    public function run()
    {
        $make_models = json_decode(file_get_contents(database_path('/seeds/data/make_models.json')), true);

        ksort($make_models['marcas']);

        $families = [];

        DB::table('makes')->delete();
        DB::table('families')->delete();
        DB::table('models')->delete();

        foreach ($make_models['marcas'] as $make_id => $make_name) {
        //     $make = new App\Models\Make();
        //     $make->id = (int) $make_id
        //     $make->name = $make_name;
        //     $make->save();
        //     unset($department);

            DB::table('makes')->insert([
                'id'         => (int) $make_id,
                'name'       => (string) trim(preg_replace('@\<[^\>]*\>$@', '', $make_name)),
                'created_at' => Carbon::now(),
            ]);
        }

        foreach ($make_models['autos'] as $model) {
            print_r($model);

            if ((int) $model['codigoFamilia'] != 0 && !in_array($model['codigoFamilia'], $families)) {
                DB::table('families')->insert([
                    'id'         => (int) $model['codigoFamilia'],
                    'make_id'    => (int) $model['codigoMarca'],
                    'name'       => (string) $model['familia'],
                    'created_at' => Carbon::now(),
                ]);

                $families[] = $model['codigoFamilia'];
            }

            DB::table('models')->insert([
                'id'         => (int) $model['id'],
                'make_id'    => (int) $model['codigoMarca'],
                'family_id'  => (int) $model['codigoFamilia'] == 0 ? null : (int) $model['codigoFamilia'],
                'name'       => (string) $model['modelo'],
                'created_at' => Carbon::now(),
            ]);
        }
    }
}