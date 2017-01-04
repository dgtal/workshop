<form role="form">
  
  <?php if($errors->any()): ?>
  	<div class="col-md-12">
  		<div class="callout callout-danger">
	        <h4><?php echo e(trans('backpack::crud.please_fix')); ?></h4>
	        <ul>
			<?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
				<li><?php echo e($error); ?></li>
			<?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
			</ul>
		</div>
  	</div>
  <?php endif; ?>

  
  <?php $__currentLoopData = $fields; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $field): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
    <!-- load the view from the application if it exists, otherwise load the one in the package -->
	<?php if(view()->exists('vendor.backpack.crud.fields.'.$field['type'])): ?>
		<?php echo $__env->make('vendor.backpack.crud.fields.'.$field['type'], array('field' => $field), array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
	<?php else: ?>
		<?php echo $__env->make('crud::fields.'.$field['type'], array('field' => $field), array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
	<?php endif; ?>
  <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
</form>



<?php $__env->startSection('after_styles'); ?>
	<!-- CRUD FORM CONTENT - crud_fields_styles stack -->
	<?php echo $__env->yieldPushContent('crud_fields_styles'); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('after_scripts'); ?>
	<!-- CRUD FORM CONTENT - crud_fields_scripts stack -->
	<?php echo $__env->yieldPushContent('crud_fields_scripts'); ?>

	<script>
        jQuery('document').ready(function($){

          //Save button dropdown toggles
          var saveActions = $('#saveActions'),
          crudForm        = saveActions.parents('form'),
          saveActionField = $('[name="save_action"]');

          saveActions.on('click', '.dropdown-menu a', function(){
              var saveAction = $(this).data('value');
              saveActionField.val( saveAction );
              crudForm.submit();
          });

      		// Ctrl+S and Cmd+S trigger Save button click
      		$(document).keydown(function(e) {
      		    if ((e.which == '115' || e.which == '83' ) && (e.ctrlKey || e.metaKey))
      		    {
      		        e.preventDefault();
      		        // alert("Ctrl-s pressed");
      		        $("button[type=submit]").trigger('click');
      		        return false;
      		    }
      		    return true;
      		});

          <?php if( $crud->autoFocusOnFirstField ): ?>
            //Focus on first field
            <?php 
              $focusField = array_first($fields, function($field){
                  return isset($field['auto_focus']) && $field['auto_focus'] == true;
              })
             ?>

            <?php if($focusField): ?>
              window.focusField = $('[name="<?php echo e($focusField['name']); ?>"]').eq(0),
            <?php else: ?>
              var focusField = $('form').find('input, textarea, select').not('[type="hidden"]').eq(0),
            <?php endif; ?>

            fieldOffset = focusField.offset().top,
            scrollTolerance = $(window).height() / 2;

            focusField.trigger('focus');

            if( fieldOffset > scrollTolerance ){
                $('html, body').animate({scrollTop: (fieldOffset - 30)});
            }
          <?php endif; ?>
        });
	</script>
<?php $__env->stopSection(); ?>