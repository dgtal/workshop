<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\OrderRequest as StoreRequest;
use App\Http\Requests\OrderRequest as UpdateRequest;

class OrderCrudController extends CrudController
{

    public function setUp()
    {

        /*
		|--------------------------------------------------------------------------
		| BASIC CRUD INFORMATION
		|--------------------------------------------------------------------------
		*/
        $this->crud->setModel("App\Models\Order");
        $this->crud->setRoute("admin/order");
        $this->crud->setEntityNameStrings('orden', 'órdenes');

        /*
		|--------------------------------------------------------------------------
		| BASIC CRUD INFORMATION
		|--------------------------------------------------------------------------
		*/

        // $this->crud->setFromDb();

        // ------ CRUD FIELDS

        $this->crud->addField([
            'label' => 'Estado',
            'name' => 'status',
            'type' => 'enum',
        ]);

        $this->crud->addField([
            'label' => 'Vehículo',
            'type' => 'select2',
            'name' => 'vehicle_id',
            'entity' => 'vehicle',
            'attribute' => 'name',
            'model' => "App\Models\Vehicle",
        ]);

        $this->crud->addField([
            'label' => 'Kms',
            'type' => 'text',
            'name' => 'odometer',
        ]);

        $this->crud->addField([
            'name' => 'tasks',
            'label' => 'Servicios',
            'type' => 'table',
            'entity_singular' => 'tarea',
            'columns' => [
                'name' => 'Detalle',
            ],
            'min' => 0
        ]);

        $this->crud->addField([
            'label' => 'Notas',
            'type' => 'textarea',
            'name' => 'remarks',
        ]);

        // ------ CRUD COLUMNS

        $this->crud->addColumn([
            'label' => 'Cliente',
            'type' => 'select',
            'name' => 'customer',
            'entity' => 'vehicle',
            'attribute' => 'customer',
            'model' => "App\Models\Vehicle",
        ]);

        $this->crud->addColumn([
            'label' => 'Vehículo',
            'type' => 'custom_select',
            'name' => 'vehicle_id',
            'entity' => 'vehicle',
            'model' => "App\Models\Vehicle",
        ]);

        $this->crud->addColumn([
            'label' => 'Kms',
            'type' => 'number',
            'name' => 'odometer',
        ]);

        $this->crud->addColumn([
            'label' => 'Estado',
            'type' => 'text',
            'name' => 'status',
        ]);

        $this->crud->addColumn([
            'label' => 'Servicios',
            'type' => 'custom_multidimensional_array',
            'name' => 'tasks',
            'visible_key' => 'name',
            'empty_text' => '',
        ]);

        // ------- CRUD FILTERS

        $this->crud->addFilter([
            'type' => 'simple',
            'name' => 'pending',
            'label'=> 'Pendientes'
        ],
        false,
        function() {
            $this->crud->addClause('orWhere', 'status', 'Pendiente'); 
        });

        $this->crud->addFilter([
            'type' => 'simple',
            'name' => 'working',
            'label'=> 'En proceso'
        ],
        false,
        function() {
            $this->crud->addClause('orWhere', 'status', 'Trabajando'); 
        });

        $this->crud->addFilter([
            'type' => 'simple',
            'name' => 'done',
            'label'=> 'Finalizadas'
        ],
        false,
        function() {
            $this->crud->addClause('orWhere', 'status', 'Finalizada'); 
        });

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
}