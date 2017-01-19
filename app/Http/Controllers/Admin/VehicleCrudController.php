<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\VehicleRequest as StoreRequest;
use App\Http\Requests\VehicleRequest as UpdateRequest;

class VehicleCrudController extends CrudController
{

    public function setUp()
    {

        /*
		|--------------------------------------------------------------------------
		| BASIC CRUD INFORMATION
		|--------------------------------------------------------------------------
		*/
        $this->crud->setModel("App\Models\Vehicle");
        $this->crud->setRoute("admin/vehicle");
        $this->crud->setEntityNameStrings('vehículo', 'vehículos');

        /*
		|--------------------------------------------------------------------------
		| BASIC CRUD INFORMATION
		|--------------------------------------------------------------------------
		*/

        // $this->crud->setFromDb();

        // ------ CRUD FIELDS
        // $this->crud->addField([
        //     'label' => 'Modelo',
        //     'type' => 'select2',
        //     'name' => 'model_id',
        //     'entity' => 'model',
        //     'attribute' => 'name',
        //     'model' => "App\Models\Model",
        // ]);

        $this->crud->addField([
            'label' => "Cliente",
            'type' => "select2_ajax",
            'name' => 'customer_id',
            'entity' => 'customer',
            'attribute' => "fullname",
            'model' => "App\Models\Customer",
            'data_source' => url("admin/customer/ajax-customer-options"),
            'placeholder' => "Cliente",
            'minimum_input_length' => 4,
            'value' => $this->request->input('customer_id'),
        ]);

        $this->crud->addField([
            'label' => "Marca / Modelo",
            'type' => "select2_ajax",
            'name' => 'model_id',
            'entity' => 'model',
            'attribute' => "fullname",
            'model' => "App\Models\Model",
            'data_source' => url("admin/model/ajax-model-options"),
            'placeholder' => "Modelo",
            'minimum_input_length' => 4,
        ]);

        $this->crud->addField([
            'label' => 'Año',
            'type' => 'text',
            'name' => 'year',
        ]);

        $this->crud->addField([
            'label' => 'Matrícula',
            'type' => 'text',
            'name' => 'plate',
        ]);

        $this->crud->addField([
            'label' => 'Chasis',
            'type' => 'text',
            'name' => 'vin',
        ]);

        // ------ CRUD COLUMNS
        $this->crud->addColumn([
            'label' => 'Cliente',
            'name' => 'customer_id',
            'type' => 'custom_select',
            'entity' => 'customer',
            'model' => "App\Models\Customer",
        ]);

        $this->crud->addColumn([
            'label' => 'Marca',
            'type' => 'select',
            'name' => 'make',
            'entity' => 'model',
            'attribute' => 'make',
            'model' => "App\Models\Model",
        ]);

        $this->crud->addColumn([
            'label' => 'Modelo',
            'type' => 'select',
            'name' => 'model_id',
            'entity' => 'model',
            'attribute' => 'name',
            'model' => "App\Models\Model",
        ]);

        $this->crud->addButtonFromModelFunction('line', 'create_order_button', 'getCreateOrderButton', 'end');

        // ------ CRUD BUTTONS
        // possible positions: 'beginning' and 'end'; defaults to 'beginning' for the 'line' stack, 'end' for the others;
        // $this->crud->addButton($stack, $name, $type, $content, $position); // add a button; possible types are: view, model_function
        // $this->crud->addButtonFromModelFunction($stack, $name, $model_function_name, $position); // add a button whose HTML is returned by a method in the CRUD model
        // $this->crud->addButtonFromView($stack, $name, $view, $position); // add a button whose HTML is in a view placed at resources\views\vendor\backpack\crud\buttons
        // $this->crud->removeButton($name);
        // $this->crud->removeButtonFromStack($name, $stack);

        // ------ CRUD ACCESS
        // $this->crud->allowAccess(['list', 'create', 'update', 'reorder', 'delete']);
        // $this->crud->denyAccess(['list', 'create', 'update', 'reorder', 'delete']);

        // ------ CRUD REORDER
        // $this->crud->enableReorder('label_name', MAX_TREE_LEVEL);
        // NOTE: you also need to do allow access to the right users: $this->crud->allowAccess('reorder');

        // ------ CRUD DETAILS ROW
        // $this->crud->enableDetailsRow();
        // NOTE: you also need to do allow access to the right users: $this->crud->allowAccess('details_row');
        // NOTE: you also need to do overwrite the showDetailsRow($id) method in your EntityCrudController to show whatever you'd like in the details row OR overwrite the views/backpack/crud/details_row.blade.php

        // ------ REVISIONS
        // You also need to use \Venturecraft\Revisionable\RevisionableTrait;
        // Please check out: https://laravel-backpack.readme.io/docs/crud#revisions
        // $this->crud->allowAccess('revisions');

        // ------ AJAX TABLE VIEW
        // Please note the drawbacks of this though:
        // - 1-n and n-n columns are not searchable
        // - date and datetime columns won't be sortable anymore
        // $this->crud->enableAjaxTable();

        // ------ DATATABLE EXPORT BUTTONS
        // Show export to PDF, CSV, XLS and Print buttons on the table view.
        // Does not work well with AJAX datatables.
        // $this->crud->enableExportButtons();

        // ------ ADVANCED QUERIES
        // $this->crud->addClause('active');
        // $this->crud->addClause('type', 'car');
        // $this->crud->addClause('where', 'name', '==', 'car');
        // $this->crud->addClause('whereName', 'car');
        // $this->crud->addClause('whereHas', 'posts', function($query) {
        //     $query->activePosts();
        // });
        // $this->crud->with(); // eager load relationships
        // $this->crud->orderBy();
        // $this->crud->groupBy();
        // $this->crud->limit();
    }

	public function store(StoreRequest $request)
	{
		// your additional operations before save here
        $redirect_location = parent::storeCrud();
        // your additional operations after save here
        // use $this->data['entry'] or $this->crud->entry
        return $redirect_location;
	}

	public function update(UpdateRequest $request)
	{
		// your additional operations before save here
        $redirect_location = parent::updateCrud();
        // your additional operations after save here
        // use $this->data['entry'] or $this->crud->entry
        return $redirect_location;
	}

    public function selectOptions($vehicle_id=null) {
        $vehicle_id = (int) $vehicle_id;
        $term = $this->request->input('q');

        if ($vehicle_id > 0)
            $options = \App\Models\Vehicle::where('id', $vehicle_id)->first();
        else
            $options = \App\Models\Vehicle::search($term)->take(10)->get();

        return \Response::json($options);
    }
}
