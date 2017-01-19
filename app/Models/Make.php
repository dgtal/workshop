<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as EloquentModel;
use Backpack\CRUD\CrudTrait;

class Make extends EloquentModel
{
    use CrudTrait;

     /*
	|--------------------------------------------------------------------------
	| GLOBAL VARIABLES
	|--------------------------------------------------------------------------
	*/

    //protected $table = 'makes';
    //protected $primaryKey = 'id';
    // public $timestamps = false;
    // protected $guarded = ['id'];
    protected $fillable = ['name'];
    // protected $hidden = [];
    // protected $dates = [];

    /*
	|--------------------------------------------------------------------------
	| FUNCTIONS
	|--------------------------------------------------------------------------
	*/

    // /**
    //  * The "booting" method of the model.
    //  *
    //  * @return void
    //  */
    // protected static function boot()
    // {
    //     parent::boot();

    //     static::addGlobalScope('ordered', function(\Illuminate\Database\Eloquent\Builder $builder) {
    //         $builder->orderBy('name');
    //     });
    // }

    public function __toString()
    {
        return (string) sprintf("%s", $this->name);
    }

	public function getCreateModelButton()
	{
        return '<a href="' . url('/admin/model/create?make_id=' . $this->getKey()) . '" class="btn btn-xs btn-default"><i class="fa fa-car"></i> Añadir modelo </a>';
	}

    /*
	|--------------------------------------------------------------------------
	| RELATIONS
	|--------------------------------------------------------------------------
	*/

    public function customers()
    {
        return $this->hasManyThrough('App\Models\Customer', 'App\Models\Model');
    }

    public function models()
    {
        return $this->hasMany('App\Models\Model');
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
