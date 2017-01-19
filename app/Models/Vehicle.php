<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as EloquentModel;
use Backpack\CRUD\CrudTrait;
use Laravel\Scout\Searchable;

class Vehicle extends EloquentModel
{
    use CrudTrait;
	use Searchable;

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
    protected $appends = ['fullname'];

    /*
	|--------------------------------------------------------------------------
	| FUNCTIONS
	|--------------------------------------------------------------------------
	*/

    /**
     * Get the indexable data array for the model.
     *
     * @return array
     */
    public function toSearchableArray()
    {
        return [
			'id'    => $this->id,
			'make'  => $this->make->name,
			'model' => $this->model->name,
            'plate' => $this->plate,
            'owner' => $this->customer->fullname,
		];
    }

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

    /**
     * Get the model's full name.
     *
     * @return string
     */
    public function getFullnameAttribute()
    {
        return (string) sprintf("%s %s (%s)", $this->make->name, $this->model->name, $this->plate);
    }

    /*
	|--------------------------------------------------------------------------
	| MUTATORS
	|--------------------------------------------------------------------------
	*/
}
