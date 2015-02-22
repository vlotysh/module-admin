<p align="right">
<a class="btn btn-success" href="<?=$url?>/menus/addgroup"><i class="icon-plus-sign icon-white"></i> Добавить</a>
</p>
<table class="table table-bordered table-hover">
<tr>
<th>Название</th><th>Названние анг.</th><th width="60" colspan="2">Функции</th>
</tr>
<?foreach($menus as $mg):?>
<tr>
	<td>
	<a href="<?=$url?>/menus/menu/<?=$mg->menu_group_id?>/?position=<?=$mg->menu_group_position?>"><?=$mg->menu_group_title?></a>
	</td>
	<td>
	<?=$mg->menu_group_position?>
	</td>
	<td width="30">
	<a class="btn btn-success btn-small" href="<?=$url?>/menus/editgroup/<?=$mg->menu_group_id?>"><i class="icon-edit icon-white"></i></a>
	</td>
	<td width="30">
	<a class="btn btn-danger btn-small" href="<?=$url?>/menus/deletegroup/<?=$mg->menu_group_id?>"><i class="icon-trash icon-white"></i></a>
	</td>
</tr>
<?endforeach?>
</table>