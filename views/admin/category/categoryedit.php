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
</select>

<select name="template">
<option value="">--Выберате шаблон--</option>
<option value="products_list">Список</option>
<option value="products_column">Колонки</option>
</select>

</td></tr>
	<tr>
	<td><input type="text" class="span4"  name="category_title" value="<?=$data['category_title']?>" ></td>
	</tr>
	<tr>
	<td><textarea class="span6" name="category_description"><?=$data['category_description']?></textarea></td>
	</tr>
	<tr>
	<td><input type="file" name="category_image"></td>
	</tr>
	<tr>
	<td><input class="btn" type="submit" name="submit" value=" Сохранить "></td>
	</tr>
</table>
</form>