<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as EloquentModel;
use Backpack\CRUD\CrudTrait;
use Laravel\Scout\Searchable;

class Model extends EloquentModel
{
    use CrudTrait;
	use Searchable;

    /*
	|--------------------------------------------------------------------------
	| GLOBAL VARIABLES
	|--------------------------------------------------------------------------
	*/

    //protected $table = 'models';
    //protected $primaryKey = 'id';
    // public $timestamps = false;
    // protected $guarded = ['id'];
    protected $fillable = ['name', 'make_id', 'family_id'];

    protected $appends = ['fullname'];

    // protected $hidden = [];
    // protected $dates = [];

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
			'id' => $this->id,
			'name' => $this->name,
			'make' => $this->make->name
		];
    }

    /*
	|--------------------------------------------------------------------------
	| RELATIONS
	|--------------------------------------------------------------------------
	*/

    public function family()
    {
        return $this->belongsTo('App\Models\Family', 'family_id');
    }

    public function make()
    {
        return $this->belongsTo('App\Models\Make', 'make_id');
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
        return (string) sprintf("%s %s", $this->make->name, $this->name);
    }

    /*
	|--------------------------------------------------------------------------
	| MUTATORS
	|--------------------------------------------------------------------------
	*/
}