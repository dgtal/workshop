<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as EloquentModel;
use Backpack\CRUD\CrudTrait;
use Laravel\Scout\Searchable;

class Customer extends EloquentModel
{
    use CrudTrait;
	use Searchable;

     /*
	|--------------------------------------------------------------------------
	| GLOBAL VARIABLES
	|--------------------------------------------------------------------------
	*/

    //protected $table = 'customers';
    //protected $primaryKey = 'id';
    // public $timestamps = false;
    // protected $guarded = ['id'];
    protected $fillable = ['firstname','lastname','email','address','phones'];
    // protected $hidden = [];
    // protected $dates = [];
	protected $casts = ['phones' => 'array'];

	protected $appends = array('fullname');

    /*
	|--------------------------------------------------------------------------
	| FUNCTIONS
	|--------------------------------------------------------------------------
	*/

    public function __toString()
    {
        return (string) sprintf("%s %s", $this->firstname, $this->lastname);
    }

    public function name()
    {
        return (string) sprintf("%s %s", $this->firstname, $this->lastname);
    }

    /**
     * Get the indexable data array for the model.
     *
     * @return array
     */
    public function toSearchableArray()
    {
        return [
			'id'    => $this->id,
			'name'  => $this->name(),
			'email' => $this->email
		];
    }

	public function getCreateVehicleButton()
	{
        return '<a href="' . url('/admin/vehicle/create?customer_id=' . $this->getKey()) . '" class="btn btn-xs btn-default"><i class="fa fa-car"></i> Añadir vehículo </a>';
	}

    /*
	|--------------------------------------------------------------------------
	| RELATIONS
	|--------------------------------------------------------------------------
	*/

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
     * Get the user's full name.
     *
     * @return string
     */
    public function getFullnameAttribute()
    {
        return (string) sprintf("%s %s", $this->firstname, $this->lastname);
    }

    /*
	|--------------------------------------------------------------------------
	| MUTATORS
	|--------------------------------------------------------------------------
	*/
}
