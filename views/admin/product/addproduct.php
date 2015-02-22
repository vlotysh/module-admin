

<?if($cats_select):?>
    

		    <? foreach ($categories as $cat): ?>

<p><a href="<?= URL::carrentUrl(). URL::query(array('category'=>$cat->id),FALSE)?>">Добавить товар в категорию "<?=$cat->category_title;?>"</a></p>

		    <? endforeach ?>



<?else:?>
<!-- TinyMCE -->
<script src="//tinymce.cachefly.net/4.1/tinymce.min.js"></script>
<script>tinymce.init({selector:'#elm1'});</script>

<!-- /TinyMCE -->

<script>
    $(document).ready(function() {

	tinyMCE.get('elem2').hide();
    })
</script>
<form action="" method="post" enctype="multipart/form-data">
    <table>
	<tr>
	    <td>

		    <? foreach ($categories as $cat): ?>

    		   <? if($_GET['category'] == $cat->id):?> <h4>Добавление продукта в категорию "<?=$cat->category_title;?>" </h4><?  endif;?> 
		    <? endforeach ?>

	    </td>

	</tr>

    </table>

    <table>
	<tr><td>
		
		Выбор комплектации продукции: 
		
		<?  foreach ($services as $service) :?>
		<p><input type="checkbox" name="services[]" value="<?=$service['id']?>"> <?=$service['service_title']?></p>
		<?  endforeach;?>
		
		<?if(!$services):?>
		<p class="required">Дополнительные сервисы для данной категоии отсутствуют.</p>
		<p>Добавить сервисы можно <a href="/admin/services/add">тут</a></p>
		<?  endif;?>
		<hr>
	    </td></tr>
	<tr><td>Название: <br><input  required="required" autocomplete="off" class="span6" type="text" id="product_title"  name="title" value="<?= $data['title']; ?>"></td></tr>
        <td>Uri продукт:  <br><input class="span4" type="text"  id="uri_title" value="<?= $data['product_uri']; ?>" name="product_uri"></td>
	<tr><td>Цена: <br><input required="required" autocomplete="off" type="text" name="price" value="<?= $data['price']; ?>"> грн.</td></tr>
	<tr>
	    <td>
		Описание: <br><textarea rows="7" class="span6" id="elm1" name="description"><?= $data['description']; ?></textarea>
		<p><br><a href="javascript:;" onclick="tinyMCE.get('elm1').show();
                return false;">[Показать редактор]</a>
		    <a href="javascript:;" onclick="tinyMCE.get('elm1').hide();
                         return false;">[Убрать редактор]</a></p>

	    </td>
	</tr>
	<tr>
	    <td>
		Характеристики (перечесление через точку запятую): <br><textarea rows="4" id="elem2" class="span6"  name="values"><?= $data['values']; ?></textarea>


	    </td>
	</tr>	
	
	<tr>
	    <td>
		Комплектация (перечесление через точку запятую): <br><textarea rows="4" id="elem3" class="span6"  name="grades"><?= $data['grades']; ?></textarea>


	    </td>
	</tr>	

	<tr><td>Описание страницы <br><input class="span6" type="text" name="meta_description"></td></li>
	<tr><td>Ключевые слова <br><input class="span6" type="text" name="meta_keywords"></td></li>
	<tr><td>Загрузить изображения: <br><input type="file" id="multi" multiple name="images[]"></td></tr>
	<tr><td>


		<output id="list"></output>
		<div class="controls" style="display: none;"><input name="clear" type=button value="Очистить список файлов" onclick="clearFileInput();"/> </div>
            </td></tr>

	<tr><td colspan="2">Включено: <input type="checkbox" name="status" value="1"></td></tr>
	<tr><td colspan="2"><br><input class="btn btn-success" type="submit" name="submit" value=" Сохранить "></td></tr>
    </table>
    
    <input type="hidden" value="<?=$_GET['category'];?>" name="cat_id">
    
</form>

<?  endif;?>

