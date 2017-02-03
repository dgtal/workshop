<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as EloquentModel;
use Backpack\CRUD\CrudTrait;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

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
    protected $fillable = ['status', 'vehicle_id', 'remarks', 'odometer', 'tasks', 'autoparts', 'service_date', 'service_date_dp'];
    // protected $hidden = [];
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
		'service_date',
	];
	protected $casts = ['tasks' => 'array', 'autoparts' => 'array', 'service_date' => 'date'];
    protected $appends = ['service_date_dp'];

    /*
	|--------------------------------------------------------------------------
	| FUNCTIONS
	|--------------------------------------------------------------------------
	*/

	public function getServiceDateDpAttribute()
	{
		Log::info(Carbon::createFromFormat('Y-m-d', $this->attributes['service_date'], config('app.timezone'))->toRfc1036String());
		return Carbon::createFromFormat('Y-m-d', $this->attributes['service_date'], config('app.timezone'))->toDateTimeString();
	}

	public function setServiceDateDpAttribute($value) {
		$this->attributes['service_date'] = new Carbon($value);
	}

    public function getFormattedOdomer()
    {
		return number_format($this->attributes['odometer']);
    }

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
