<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\CustomerRequest as StoreRequest;
use App\Http\Requests\CustomerRequest as UpdateRequest;

class CustomerCrudController extends CrudController
{

    public function setUp()
    {

        /*
		|--------------------------------------------------------------------------
		| BASIC CRUD INFORMATION
		|--------------------------------------------------------------------------
		*/
        $this->crud->setModel("App\Models\Customer");
        $this->crud->setRoute("admin/customer");
        $this->crud->setEntityNameStrings('cliente', 'clientes');

        /*
		|--------------------------------------------------------------------------
		| BASIC CRUD INFORMATION
		|--------------------------------------------------------------------------
		*/

        // $this->crud->setFromDb();

        // ------ CRUD FIELDS

        $this->crud->addField([
            'label' => 'Nombre',
            'type' => 'text',
            'name' => 'firstname',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-6'
            ]
        ]);

        $this->crud->addField([
            'label' => 'Apellido',
            'type' => 'text',
            'name' => 'lastname',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-6'
            ]
        ]);

        $this->crud->addField([
            'label' => 'Email',
            'type' => 'email',
            'name' => 'email',
        ]);

        $this->crud->addField([
            'label' => 'Dirección',
            'type' => 'text',
            'name' => 'address',
        ]);

        $this->crud->addField([
            'name' => 'phones',
            'label' => 'Teléfonos',
            'type' => 'table',
            'entity_singular' => 'Teléfono',
            'columns' => [
                'number' => 'Número',
                'description' => 'Detalle',
            ],
            'min' => 0
        ]);

        // ------ CRUD COLUMNS

        $this->crud->addColumn([
            'label' => 'Nombre',
            'type' => 'text',
            'name' => 'firstname',
        ]);

        $this->crud->addColumn([
            'label' => 'Apellido',
            'type' => 'text',
            'name' => 'lastname',
        ]);

        $this->crud->addColumn([
            'label' => 'Email',
            'type' => 'text',
            'name' => 'email',
        ]);

        $this->crud->addColumn([
            'label' => 'Dirección',
            'type' => 'text',
            'name' => 'address',
        ]);

        $this->crud->addColumn([
            'label' => 'Teléfono',
            'type' => 'multidimensional_array',
            'name' => 'phones',
            'visible_key' => 'number'
        ]);

        $this->crud->addButtonFromModelFunction('line', 'create_vehicle_button', 'getCreateVehicleButton', 'end');

        // ------ CRUD BUTTONS

        // $this->crud->addButtonFromModelFunction('line', 'open', 'getOpenButton', 'beginning');

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
        // $this->crud->allowAccess('details_row');

        // ------ REVISIONS
        // You also need to use \Venturecraft\Revisionable\RevisionableTrait;
        // Please check out: https://laravel-backpack.readme.io/docs/crud#revisions
        // $this->crud->allowAccess('revisions');

        // ------ AJAX TABLE VIEW
        // Please note the drawbacks of this though:
        // - 1-n and n-n columns are not searchable
        // - date and datetime columns won't be sortable anymore
        $this->crud->enableAjaxTable();

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

    public function selectOptions($customer_id=null) {
        $customer_id = (int) $customer_id;
        $term = $this->request->input('q');

        if ($customer_id > 0)
            $options = \App\Models\Customer::where('id', $customer_id)->first();
        else
            $options = \App\Models\Customer::search($term)->take(10)->get();

        return \Response::json($options);
    }
}
