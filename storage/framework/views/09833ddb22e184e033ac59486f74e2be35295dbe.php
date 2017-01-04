

<li filter-name="<?php echo e($filter->name); ?>"
	filter-type="<?php echo e($filter->type); ?>"
	class="<?php echo e(Request::get($filter->name)?'active':''); ?>">
    <a 	href=""
		parameter="<?php echo e($filter->name); ?>"
    	><?php echo e($filter->label); ?></a>
  </li>








    





<?php $__env->startPush('crud_list_scripts'); ?>
    <script>
		jQuery(document).ready(function($) {
			$("li[filter-name=<?php echo e($filter->name); ?>] a").click(function(e) {
				e.preventDefault();

				var parameter = $(this).attr('parameter');

				<?php if(!$crud->ajaxTable()): ?>
					// behaviour for normal table
					var current_url = normalizeAmpersand("<?php echo e(Request::fullUrl()); ?>");

					if (URI(current_url).hasQuery(parameter)) {
						var new_url = URI(current_url).removeQuery(parameter, true);
					} else {
						var new_url = URI(current_url).addQuery(parameter, true);
					}

					// refresh the page to the new_url
			    	new_url = normalizeAmpersand(new_url.toString());
			    	window.location.href = new_url;
			    <?php else: ?>
			    	// behaviour for ajax table
					var ajax_table = $("#crudTable").DataTable();
					var current_url = ajax_table.ajax.url();

					if (URI(current_url).hasQuery(parameter)) {
						var new_url = URI(current_url).removeQuery(parameter, true);
					} else {
						var new_url = URI(current_url).addQuery(parameter, true);
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

			// clear filter event (used here and by the Remove all filters button)
			$("li[filter-name=<?php echo e($filter->name); ?>]").on('filter:clear', function(e) {
				// console.log('dropdown filter cleared');
				$("li[filter-name=<?php echo e($filter->name); ?>]").removeClass('active');
			});
		});
	</script>
<?php $__env->stopPush(); ?>

