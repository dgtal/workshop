<!-- select2 -->
<div <?php echo $__env->make('crud::inc.field_wrapper_attributes', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?> >
    <label><?php echo $field['label']; ?></label>
    <?php $entity_model = $crud->model; ?>
    <select
        name="<?php echo e($field['name']); ?>"
        <?php echo $__env->make('crud::inc.field_attributes', ['default_class' =>  'form-control select2'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        >

        <?php if($entity_model::isColumnNullable($field['name'])): ?>
            <option value="">-</option>
        <?php endif; ?>

            <?php if(isset($field['model'])): ?>
                <?php $__currentLoopData = $field['model']::all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $connected_entity_entry): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
                    <option value="<?php echo e($connected_entity_entry->getKey()); ?>"
                        <?php if( ( old($field['name']) && old($field['name']) == $connected_entity_entry->getKey() ) || (isset($field['value']) && $connected_entity_entry->getKey()==$field['value'])): ?>
                             selected
                        <?php endif; ?>
                    ><?php echo e($connected_entity_entry->{$field['attribute']}); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
            <?php endif; ?>
    </select>

    
    <?php if(isset($field['hint'])): ?>
        <p class="help-block"><?php echo $field['hint']; ?></p>
    <?php endif; ?>
</div>




<?php if($crud->checkIfFieldIsFirstOfItsType($field, $fields)): ?>

    
    <?php $__env->startPush('crud_fields_styles'); ?>
        <!-- include select2 css-->
        <link href="<?php echo e(asset('vendor/backpack/select2/select2.css')); ?>" rel="stylesheet" type="text/css" />
        <link href="<?php echo e(asset('vendor/backpack/select2/select2-bootstrap-dick.css')); ?>" rel="stylesheet" type="text/css" />
    <?php $__env->stopPush(); ?>

    
    <?php $__env->startPush('crud_fields_scripts'); ?>
        <!-- include select2 js-->
        <script src="<?php echo e(asset('vendor/backpack/select2/select2.js')); ?>"></script>
        <script>
            jQuery(document).ready(function($) {
                // trigger select2 for each untriggered select2 box
                $('.select2').each(function (i, obj) {
                    if (!$(obj).data("select2"))
                    {
                        $(obj).select2();
                    }
                });
            });
        </script>
    <?php $__env->stopPush(); ?>

<?php endif; ?>

