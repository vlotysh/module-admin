<?
if($errors){
	foreach($errors as $error){
	print '<div class="alert alert-error">'.$error.'</div>';
	}
}
?>

<form action="" method="post" enctype="multipart/form-data">
<div class="border">
	<ul>
		<li>Название<br><input class="span4" type="text" name="title" value="<?=$data['title']?>"></li>
		<li>Алиас <br><input class="span4" type="text" name="alias" value="<?=$data['alias']?>"></li>
		<li>Ссылка <br><input class="span4" type="text" name="url" value="<?=$data['url']?>"></li>
		<li><br>Изображение <input type="file" name="image"></li>
		<li><br><input class="btn" type="submit" name="submit" value=" Сохранить "></li>
	</ul>
</div>
</form>