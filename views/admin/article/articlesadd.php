<!-- TinyMCE -->
<script type="text/javascript" src="/js/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript" src="/js/tiny_mce/tinymce_config.js" ></script>
<!-- TinyMCE -->

<?
if($errors){
	foreach($errors as $error){
	print '<div class="alert alert-error">'.$error.'</div>';
	}
}
?>

<form action="" method="post">
	<div>
	<ul>
	<li>Название странийы <span class="required">*</span><br><input class="span6" type="text" name="article_title" value="<?=$data['article_title']?>"></li>
	<li>Алиас <span class="required">*</span><br><input class="span6" type="text" name="article_alias" value="<?=$data['article_alias']?>"></li>
	<li>Текст <span class="required">*</span>
	<textarea class="span6" id="elm1" name="article_text" value="<?=$data['article_text']?>"></textarea><br>
	</li>
	<li>Описание страницы <br><input class="span6" type="text" name="article_description"></li>
	<li>Ключевые слова <br><input class="span6" type="text" name="article_keywords"></li>
    <li>Опубликовн <input type="checkbox" name="article_status" checked="checked" value="1" /></li>
	<li><br><input class="btn" type="submit" name="submit" value=" Сахранить "></li>
	</ul>
	</div>
</form>