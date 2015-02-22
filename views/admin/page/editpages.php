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
	<div>
	<ul>
	<li>Название странийы: <span class="required">*</span><br><input class="span6" type="text" name="page_title" value="<?=$data['page_title']?>"></li>
	<li>Алиас: <span class="required">*</span><br><input class="span6" type="text" name="page_alias" value="<?=$data['page_alias']?>"></li>
	<li>Текст страницы
	<textarea class="span6" name="page_text"><?=htmlspecialchars_decode($data['page_text'])?></textarea><br>
	</li>
	<li>Описание страницы: <br><input type="text" class="span6" name="page_description" value="<?=$data['page_description']?>"></li>
	<li>Ключевые слова <br><input type="text" class="span6" name="page_keywords" value="<?=$data['page_keywords']?>"></li>
	<li>Статус: <span class="required">*</span> <input type="checkbox" name="page_status" value="1" <? if($data['page_status']==1) print 'checked'?>></li>
	<li><br><input class="btn" type="submit" name="submit" value=" Сахранить "></li>
	</ul>
	</div>
</form>