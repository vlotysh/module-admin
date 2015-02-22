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
<br/>

<form action="" method="post">
<table>
<tr><td><select name="cat_id">
    <option value="">
        --Выберите категорию--
    </option>
    <?foreach ($categories as $cat):?>
        <option value="<?=$cat->id?>">
            <?=str_repeat('&nbsp;', 2 * $cat->lvl) .$cat->category_title ?>
        </option>
    <?endforeach?>
</select></td></tr>
	<tr>
	<td>Название категории <input class="span4" type="text" id="category_title"  name="category_title"></td>
	</tr>
        <tr>
	<td>Uri категории <input class="span4" type="text"  id="uri_title" name="uri"></td>
	</tr>
	<tr>
	<td><textarea class="span4" name="category_description"></textarea></td>
	</tr>
	<tr>
	<td><input type="file" name="category_image"></td>
	</tr>
	<tr>
	<td><input class="btn" type="submit" name="submit" value=" Сохранить "></td>
	</tr>
</table>
</form>