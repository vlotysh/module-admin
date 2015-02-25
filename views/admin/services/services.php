<p align="right">
    <a class="btn btn-success" href="services/add"><i class="icon-plus-sign"></i> Добавить</a>
</p>

<table class="table table-bordered">
    <thead>
        <tr height="30">
            <th>№</th><th>Название свойства</th><th>Категории</th><th>Статус</th><th >Функции</th>
        </tr>
    </thead>
    <tbody>
	<? $elem = '';
	
	foreach ($services as $service):
	    
	    if($elem == $service['service_title'])
		continue;
	    $elem = $service['service_title'];
	
	    ?>
	<tr>
	    <td>
		<?=$service['id'];?>
	    </td>
	     <td>
		<?=$service['service_title'];?>
	    </td>
	    <td>
		<?foreach ($services as $s):?>
		    <?if($elem == $s['service_title']):?>
			
			<?=$s['category_title'];?><br>
	    
		    <?  endif;?>
	    
		<?  endforeach;?>
	    </td>
	     
	    <td>
		<? if(!$service['service_status']):?> No <?else:?> Yes <? endif;?>
	    </td>
	    
	    <td>
		<a href="/admin/services/edit/<?=$service['id'];?>" class="btn btn-success"><i class="icon-edit"></i></a>
		<a href="/admin/services/remove/<?=$service['id'];?>" class="btn btn-danger"><i class="icon-trash"></i></a>
	    </td>
	    
	</tr>
	<?  endforeach;?>
    </tbody>
</table>