
<td>
	<?php
		if ($entry->{$column['entity']}) {
            echo isset($column['attribute']) ? $entry->{$column['entity']}->{$column['attribute']} : $entry->{$column['entity']};
	    }
	?>
</td>