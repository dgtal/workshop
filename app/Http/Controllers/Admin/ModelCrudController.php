<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\ModelRequest as StoreRequest;
use App\Http\Requests\ModelRequest as UpdateRequest;

class ModelCrudController extends CrudController
{

    public function setUp()
    {

        /*
		|--------------------------------------------------------------------------
		| BASIC CRUD INFORMATION
		|--------------------------------------------------------------------------
		*/
        $this->crud->setModel("App\Models\Model");
        $this->crud->setRoute("admin/model");
        $this->crud->setEntityNameStrings('modelo', 'modelos');

        /*
		|--------------------------------------------------------------------------
		| BASIC CRUD INFORMATION
		|--------------------------------------------------------------------------
		*/

        // $this->crud->setFromDb();

        // ------ CRUD FIELDS

        $this->crud->addField([
            'label' => 'Marca',
            'type' => 'select2',
            'name' => 'make_id',
            'entity' => 'make',
            'attribute' => 'name',
            'model' => "App\Models\Make",
            'value' => is_numeric($this->request->input('make_id')) ? $this->request->input('make_id') : (is_numeric($this->request->old('make_id')) ? $this->request->old('make_id') : null),
        ]);

        $this->crud->addField([
            'name' => 'name',
            'label' => 'Nombre',
            'type' => 'text',
        ]);


        // ------ CRUD COLUMNS
        $this->crud->addColumn([
            'label' => 'Marca',
            'type' => 'select',
            'name' => 'make_id',
            'entity' => 'make',
            'attribute' => 'name',
            'model' => "App\Models\Make",
        ]);

        $this->crud->addColumn([
            'label' => 'Modelo',
            'type' => 'text',
            'name' => 'name',
        ]);

        // ------ CRUD FILTERS

        $this->crud->addFilter([
            'name' => 'make_id',
            'type' => 'select2_ajax',
            'label'=> 'Marca',
            'placeholder' => 'Escribe una marca'
        ],
        url('admin/make/ajax-make-options'),
        function($value) {
            $this->crud->addClause('where', 'make_id', (int) $value);
        });


        // ------ CRUD BUTTONS

        // ------ CRUD ACCESS

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

    public function selectOptions($model_id=null) {
        $model_id = (int) $model_id;
        $term = $this->request->input('q');

        if ($model_id > 0)
            $options = \App\Models\Model::where('id', $model_id)->first();
        else
            $options = \App\Models\Model::search($term)->take(10)->get();

        return \Response::json($options);
    }
}