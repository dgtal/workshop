<!-- select2 ajax -->
<div <?php echo $__env->make('crud::inc.field_wrapper_attributes', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?> >
    <label><?php echo $field['label']; ?></label>
    <?php $entity_model = $crud->model; ?>
    <input type="hidden" name="<?php echo e($field['name']); ?>" id="select2_ajax_<?php echo e($field['name']); ?>"
        <?php if(isset($field['value'])): ?>
            value="<?php echo e($field['value']); ?>"
        <?php endif; ?>
    <?php echo $__env->make('crud::inc.field_attributes', ['default_class' =>  'form-control'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    >

    
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
    <?php $__env->stopPush(); ?>

<?php endif; ?>

<!-- include field specific select2 js-->
<?php $__env->startPush('crud_fields_scripts'); ?>
<script>
    jQuery(document).ready(function($) {
        // trigger select2 for each untriggered select2 box
        $("#select2_ajax_<?php echo e($field['name']); ?>").each(function (i, obj) {
            if (!$(obj).data("select2"))
            {
                $(obj).select2({
                    placeholder: "<?php echo e($field['placeholder']); ?>",
                    minimumInputLength: "<?php echo e($field['minimum_input_length']); ?>",
                    ajax: {
                        url: "<?php echo e($field['data_source']); ?>",
                        dataType: 'json',
                        quietMillis: 250,
                        data: function (term, page) {
                            return {
                                q: term, // search term
                                page: page
                            };
                        },
                        results: function (data, params) {
                            params.page = params.page || 1;

                            return {
                                // results: $.map(data, function (item, i) {
                                //     return {
                                //         text: item,
                                //         id: i
                                //     }
                                // }),
                                results: $.map(data, function (item) {
                                    textField = "<?php echo e($field['attribute']); ?>";
                                    return {
                                        text: item[textField],
                                        id: item["id"]
                                    }
                                }),
                                more: data.current_page < data.last_page
                            };
                        },
                        cache: true
                    },
                    initSelection: function(element, callback) {
                        // the input tag has a value attribute preloaded that points to a preselected repository's id
                        // this function resolves that id attribute to an object that select2 can render
                        // using its formatResult renderer - that way the repository name is shown preselected
                        $.ajax("<?php echo e($field['data_source']); ?>" + '/' + "<?php echo e(!isset($field['value']) ? 0 : $field['value']); ?>", {
                            dataType: "json"
                        }).done(function(data) {
                            textField = "<?php echo e($field['attribute']); ?>";
                            callback({ text: data[textField], id: data["id"] });
                        });
                    },
                });
            }
        });
    });
</script>
<?php $__env->stopPush(); ?>

