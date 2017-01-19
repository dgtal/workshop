<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as EloquentModel;
use Backpack\CRUD\CrudTrait;

class Vehicle extends EloquentModel
{
    use CrudTrait;

     /*
	|--------------------------------------------------------------------------
	| GLOBAL VARIABLES
	|--------------------------------------------------------------------------
	*/

    //protected $table = 'vehicles';
    //protected $primaryKey = 'id';
    // public $timestamps = false;
    // protected $guarded = ['id'];
    protected $fillable = ['customer_id', 'model_id', 'plate', 'vin', 'year'];
    // protected $hidden = [];
    // protected $dates = [];

    /*
	|--------------------------------------------------------------------------
	| FUNCTIONS
	|--------------------------------------------------------------------------
	*/

    public function __toString()
    {
        return (string) sprintf("%s %s", $this->make->name, $this->model->name);
    }

    public function getNameAttribute()
    {
        return (string) sprintf("%s, %s %s", $this->customer, $this->make->name, $this->model->name);
    }

	public function getCreateOrderButton()
	{
        return '<a href="' . url('/admin/order/create?vehicle_id=' . $this->getKey()) . '" class="btn btn-xs btn-default"><i class="fa fa-car"></i> Crear orden</a>';
	}

    /*
	|--------------------------------------------------------------------------
	| RELATIONS
	|--------------------------------------------------------------------------
	*/

    public function make()
    {
		return $this->model->make();

        // return $this->belongsTo('App\Models\Model', 'model_id');
    }
    public function model()
    {
        return $this->belongsTo('App\Models\Model', 'model_id');
    }

    public function customer()
    {
        return $this->belongsTo('App\Models\Customer', 'customer_id');
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
