<!-- TinyMCE -->
<script type="text/javascript" src="/js/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript" src="/js/tiny_mce/tinymce_config.js" ></script>
<!-- /TinyMCE -->
<?
if($errors){
	foreach($errors as $error){
	print '<div class="alert alert-error">'.$error.'</div>';
	}
}
?>

<form action="/admin/pages/add" method="post">
	<div class="border">
	<ul >
	<li>Название страницы <br><input class="span6" type="text" name="page_title" value="<?=$data['page_title']?>"></li>
	<li>Алиас <br><input class="span6" type="text" name="page_alias" value="<?=$data['page_alias']?>"></li>
	<li>Текст страницы<br>
	<textarea class="span6" id="elm1" name="page_text" ><?=$data['page_text']?></textarea>
	</li>
	<li>Описание страницы <br><input class="span6" type="text" name="page_description"></li>
	<li>Ключевые слова <br><input class="span6" type="text" name="page_keywords"></li>
	<li>Статус <input  type="checkbox" name="page_status" checked="checked" value="1"></li>
	<li><input class="btn" type="submit" name="submit" value=" Сахранить "></li>
	</ul>
	</div>
</form>