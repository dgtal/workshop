<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as EloquentModel;
use Backpack\CRUD\CrudTrait;

class Order extends EloquentModel
{
    use CrudTrait;

     /*
	|--------------------------------------------------------------------------
	| GLOBAL VARIABLES
	|--------------------------------------------------------------------------
	*/

    // protected $table = 'orders';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    // protected $guarded = ['id'];
    protected $fillable = ['status', 'vehicle_id', 'remarks', 'odometer', 'tasks', 'autoparts'];
    // protected $hidden = [];
    // protected $dates = [];
	protected $casts = ['tasks' => 'array', 'autoparts' => 'array'];

    /*
	|--------------------------------------------------------------------------
	| FUNCTIONS
	|--------------------------------------------------------------------------
	*/

    /*
	|--------------------------------------------------------------------------
	| RELATIONS
	|--------------------------------------------------------------------------
	*/

    public function vehicle()
    {
        return $this->belongsTo('App\Models\Vehicle', 'vehicle_id');
    }

    /*
	|--------------------------------------------------------------------------
	| SCOPES
	|--------------------------------------------------------------------------
	*/

    /*
	|--------------------------------------------------------------------------
	| ACCESORS
	|--------------------------------------------------------------------------
	*/

    /*
	|--------------------------------------------------------------------------
	| MUTATORS
	|--------------------------------------------------------------------------
	*/
}
