

<li filter-name="<?php echo e($filter->name); ?>"
	filter-type="<?php echo e($filter->type); ?>"
	class="dropdown <?php echo e(Request::get($filter->name)?'active':''); ?>">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php echo e($filter->label); ?> <span class="caret"></span></a>
    <div class="dropdown-menu ajax-select">
	    <div class="form-group m-b-0">
	    	<input type="text" value="<?php echo e(Request::get($filter->name)?Request::get($filter->name).'|'.Request::get($filter->name.'_text'):''); ?>" id="filter_<?php echo e($filter->name); ?>">
	    </div>
    </div>
  </li>







<?php $__env->startPush('crud_list_styles'); ?>
    <!-- include select2 css-->
    <link href="<?php echo e(asset('vendor/backpack/select2/select2.css')); ?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo e(asset('vendor/backpack/select2/select2-bootstrap-dick.css')); ?>" rel="stylesheet" type="text/css" />
    <style>
	  .form-inline .select2-container {
	    display: inline-block;
	  }
	  li[filter-type="<?php echo e($filter->type); ?>"] .select2-container {
	  	display: block;
	  }
	  .select2-drop-active {
	  	border:none;
	  }
	  .select2-container .select2-choices .select2-search-field input, .select2-container .select2-choice, .select2-container .select2-choices {
	  	border: none;
	  }
	  .select2-container-active .select2-choice {
	  	border: none;
	  	box-shadow: none;
	  }
    </style>
<?php $__env->stopPush(); ?>





<?php $__env->startPush('crud_list_scripts'); ?>
	<!-- include select2 js-->
    <script src="<?php echo e(asset('vendor/backpack/select2/select2.js')); ?>"></script>
    <script>
        jQuery(document).ready(function($) {
            // trigger select2 for each untriggered select2 box
            $('#filter_<?php echo e($filter->name); ?>').select2({
			    minimumInputLength: 2,
            	allowClear: true,
        	    placeholder: "<?php echo e($filter->placeholder?$filter->placeholder:' '); ?>",
				closeOnSelect: false,
			    // tags: [],
			    ajax: {
			        url: "<?php echo e($filter->values); ?>",
			        dataType: 'json',
			        type: "GET",
			        quietMillis: 50,
			        data: function (term) {
			            return {
			                term: term
			            };
			        },
			        results: function (data) {
			            return {
			                results: $.map(data, function (item, i) {
			                    return {
			                        text: item,
			                        id: i
			                    }
			                })
			            };
			        }
			    },
		        initSelection: function (element, callback) {
		        	var value = element.val().split('|');
		        	var results = [];

		        	if (value != '') {
		        		results.push({
				          id: value[0],
				          text: value[1]
				        });
		        	}
				    callback(results[0]);
				}
			}).on('change', function (evt) {
				var val = $(this).val();
				var val_text = $(this).select2('data')?$(this).select2('data').text:null;
				var parameter = '<?php echo e($filter->name); ?>';

				<?php if(!$crud->ajaxTable()): ?>
					// behaviour for normal table
					var current_url = normalizeAmpersand('<?php echo e(Request::fullUrl()); ?>');
					var new_url = addOrUpdateUriParameter(current_url, parameter, val);
					if (val_text) {
						new_url = addOrUpdateUriParameter(new_url, parameter+"_text", val_text);
					}

					// refresh the page to the new_url
			    	new_url = normalizeAmpersand(new_url.toString());
			    	window.location.href = new_url;
			    <?php else: ?>
			    	// behaviour for ajax table
					var ajax_table = $("#crudTable").DataTable();
					var current_url = ajax_table.ajax.url();
					var new_url = addOrUpdateUriParameter(current_url, parameter, val);
					if (val_text) {
						new_url = addOrUpdateUriParameter(new_url, parameter+"_text", val_text);
					}
					new_url = normalizeAmpersand(new_url.toString());


					// replace the datatables ajax url with new_url and reload it
					ajax_table.ajax.url(new_url).load();

					// mark this filter as active in the navbar-filters
					if (URI(new_url).hasQuery('<?php echo e($filter->name); ?>', true)) {
						$("li[filter-name=<?php echo e($filter->name); ?>]").removeClass('active').addClass('active');
					}
					else
					{
						$("li[filter-name=<?php echo e($filter->name); ?>]").trigger("filter:clear");
					}
			    <?php endif; ?>
			});

			// when the dropdown is opened, autofocus on the select2
			$("li[filter-name=<?php echo e($filter->name); ?>]").on('shown.bs.dropdown', function () {
				$('#filter_<?php echo e($filter->name); ?>').select2('open');
			});

			// clear filter event (used here and by the Remove all filters button)
			$("li[filter-name=<?php echo e($filter->name); ?>]").on('filter:clear', function(e) {
				// console.log('select2 filter cleared');
				$("li[filter-name=<?php echo e($filter->name); ?>]").removeClass('active');
				$("li[filter-name=<?php echo e($filter->name); ?>] .select2").select2("val", "");
			});
        });
    </script>
<?php $__env->stopPush(); ?>



