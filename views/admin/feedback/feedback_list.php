<style>
    .table th, .table td {
	 text-align: center;
    }
</style>
<table class="table table-bordered">
    <tr>
	<th>#</th><th>Имя</th><th>Тел</th><th>Эмейл</th><th>Дата</th><th></th>
    </tr>
    <?
    $i = 0;
    foreach ($feedback_items as $feedback_item):
	$i++;
	?>
        <tr <? if ($feedback_item->status == 0): ?> style="background-color: #ff6666;" <? endif; ?>>

    	<td><?= $feedback_item->id; ?></td>  
    	<td><?= $feedback_item->name; ?></td>
    	<td><?= $feedback_item->email; ?></td> 
    	<td><?= $feedback_item->phone; ?></td> 
    	<td><?= $feedback_item->date; ?></td> 
	<td>
	     <a class="btn btn-success" href="feedback/view/<?= $feedback_item->id; ?>"><i class="icon-edit"></i></a>
    <a class="btn btn-danger" href="feedback/delete/<?= $feedback_item->id; ?>"><i class="icon-trash"></i></a>
	</td>
        </tr>

    <? endforeach ?>

</table>

<?= $pagination ?>
