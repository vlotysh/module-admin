<?
if(isset($errors)){
	foreach($errors as $error){
	print '<div class="alert alert-error">'.$error.'</div>';
	}
}
?>
<div>
	<form method="post" action=""><br>
	<label>Название группы меню: </label>
	<input type="text" name="menu_group_title" value="<?=$data['menu_group_title']?>" />
	<label>Пазиция групы меню: </label>
	<select name="menu_group_position">
	<option value="block_top">Влок верхный меню</option>
	<option value="block_left">Влок левый</option>
	<option value="block_right">Влок правый</option>
	</select><br><br>
	<input class="btn btn-success" type="submit" name="submit" value="  Сохранить " />
	</form>
</div>
