<!-- TinyMCE -->
<script src="//tinymce.cachefly.net/4.1/tinymce.min.js"></script>
<script>tinymce.init({selector:'#elm1'});</script>

<form action="" method="post" enctype="multipart/form-data">
    
    <? 
    if($filters):?>
    <ul class="prop_ul">
    <?  foreach ($filters as $filter):?>
    
    <li feature_id="<?=$filter['filter_id']?>">

        <label>
            <?=$filter['filter_title']?>
             <input type="hidden" name="value[<?=$filter['filter_id']?>]" value="">
             <input type="hidden" name="filter[<?=$filter['filter_id']?>]" value="<?=$filter['filter_id']?>">
            <input type="text" value="<?=$filter['value']?>" name="filter_title[<?=$filter['filter_id']?>]">
        </label>
    
    </li>
    <? endforeach;?>
    </ul>
    <? endif;?>
    
<table>
	<tr>
		<td colspan="2">
		    Категория товара
		<select name="cat_id">

		<?foreach ($cats as $cat):?>
                <option value="<?=$cat->id?>" <? if($cat->id == $data['category_id']):?> selected="selected"<? endif;?>>
            <?=str_repeat('&nbsp;', 2 * $cat->lvl) .$cat->category_title ?>
        </option>
		<?endforeach?>
		</select>

		</td>
		
	</tr>
	
	<tr>
	    <td>
		<? foreach ($services as $service):?>
		<p> <input type="checkbox" name="services[]" value="<?=$service['id']?>" <? if($service['serv_id']):?> checked="checked" <?  endif;?>> <?=$service['service_title']?></p>
		<?  endforeach;?>
	    </td>
	</tr>
	
	<tr><td>Название: <br><input class="span6" type="text" size="30" name="title" value="<?=htmlspecialchars($data['title']);?>"></td></tr>

	<tr><td>Цена: <br><input type="text" name="price" value="<?=$data['price'];?>"></td></tr>
	<tr><td>
	Описание: <br><textarea rows="7" class="span6" id="elm1" name="description"><?=htmlspecialchars($data['description']);?></textarea>
	<p><br><a href="javascript:;" onclick="tinyMCE.get('elm1').show();return false;">[Показать редактор]</a>
		 <a href="javascript:;" onclick="tinyMCE.get('elm1').hide();return false;">[Убрать редактор]</a></p>	
	</td></tr>
	<tr>
	    <td>
		Характеристики (перечесление через точку запятую): <br><textarea rows="7" class="span6" id="elm1" name="values"><?= $data['values']; ?></textarea>


	    </td>
	</tr>
		<tr>
	    <td>
		Характеристики (перечесление через точку запятую): <br><textarea  rows="4" id="elem2" class="span6"  name="values"><?= $data['values']; ?></textarea>

	    </td>
	</tr>	
	<tr>
	    <td>
		Дата добавления <input class="span2" type="text" name="add_date" disabled="disabled" value="<?= $data['add_date']; ?>"/>
	    </td>
	</tr>
	<tr><td>Описание страницы <br><input class="span6" type="text" name="meta_description" value="<?=htmlspecialchars($data['meta_description']);?>" /></td></tr>
	<tr><td>Ключевые слова <br><input class="span6" type="text" name="meta_keywords"  value="<?=htmlspecialchars($data['meta_keywords']);?>" /></td></tr>
	<tr><td>Загрузить изображения: <input type="file" id="multi" name="images[]"></td></tr>
	<tr><td>Активна: <input type="checkbox" name="status" value="1" <? if($data['status']==1)  print 'checked'; ?>></td></tr>
	<tr><td><br><input class="btn btn-success" type="submit" name="submit" value=" Сохранить "></td></tr>
</table>

 <?if (!empty($data['images'])):?>
<a name="img"></a>
            <table width="100%" cellspacing="20">
                <tr>
                <?foreach($data['images'] as $i => $image):?>
                    <td align="center"><?=html::anchor('media/products/'. $image['name'], html::image('media/products/small_' . $image['name']), array('target' => '_blank'))?>
                        <br><?=html::anchor('admin/products/delimg/' . $image['id'], 'Удалить')?> | 
                        <?if ($image['id'] != $data['image_id'] ):?>
                        <?=html::anchor('admin/products/mainimg/' . $image['id'], 'Главная')?>
                        <?else:?>
                        Главная
                        <?endif?>
                    </td>
                    <?if ($i % 2):?>
                        </tr><tr>
                    <?endif?>
                <?endforeach?>
                </tr>
            </table>

            <?else:?>
            <div class="empty">Нет изображений</div>
            <?endif?>
</form>