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

<form action="" method="post">
	<div class="border">
	<ul>
	<li><br>Название странийы <span class="required">*</span><br><input class="span6" type="text" name="article_title" value="<?=$data['article_title']?>"><br></li>
	<li>Алиас <span class="required">*</span><br><input class="span6" type="text" name="article_alias" value="<?=$data['article_alias']?>"><br><br></li>
	<li>Текст <span class="required">*</span>
	<textarea class="span6" id="elm1" name="article_text"><?=htmlspecialchars_decode($data['article_text'])?></textarea><br>
	</li>
	<li>Описание страницы <br><input class="span6" type="text" name="article_description" value="<?=$data['article_description']?>"></li>
	<li>Ключевые слова <br><input class="span6" type="text" name="article_keywords" value="<?=$data['article_keywords']?>"></li>
	<li>Опубликовн <span class="required">*</span> <input type="checkbox" name="article_status" value="1" <? if($data['article_status']==1) print 'checked'?>></li>
	<li><br><input class="btn" type="submit" name="submit" value=" Сахранить "></li>
	</ul>
	</div>
</form>