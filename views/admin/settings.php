<h3>Настройки сайта</h3>
<div id="settings">
<form action="" method="post">
<ul>
	<li><b>Адрес сайта</b><br><input class="span6" type="text" name="url" value="<?=$settings->url?>"/>
	<li><b>Заголовок сайта</b><br><input class="span6" type="text" name="title" value="<?=$settings->title?>"/>
	<li><b>E-mail сайта</b><br><input class="span6" type="text" name="email" value="<?=$settings->email?>"/>
	<li><b>Описание сайта</b><br><input class="span6" type="text" name="meta_description" value="<?=$settings->meta_description?>"/>
	<li><b>Ключевые слова</b><br><textarea class="span6" name="meta_keywords" /><?=$settings->meta_keywords?></textarea>
	<li><br><input class="btn btn-success" type="submit" name="submit" value=" Сахранить " />
</ul>
</form>
</div>