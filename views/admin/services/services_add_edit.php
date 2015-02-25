<form method="POST">

Категории к которым относиться сервис<br>

<div id="service_block">
   

 <? foreach ($categories as $cat): ?>

    		    <p>
			<input type="checkbox" name="cats[]" value="<?= $cat->id ?>" <?if(isset($data['cats'][$cat->id])):?> checked="checked"<?  endif;?>>   <?= $cat->category_title ?> 
			
	<?if(isset($data['cats'][$cat->id])):?><input type="text" id="cat_id_<?= $cat->id?>" required="required" name="cat_price[<?= $cat->id?>]" value="<?=$data['cats'][$cat->id]?>"> <?  endif;?>
    		    </p>
		    <? endforeach ?>
		    </div>

<label>Название сервиса<span class="required">*</span></label><input class="span4" type="text" name="service_title" value="<?=$data['service_title']?>">
<br>
Описание:<span class="required">*</span><br> <br><textarea rows="7" class="span6" id="elm1" name="service_description"><?= $data['service_description']; ?></textarea>
<br>
<input type='hidden' value='0' name='status'>
			Активировать <input type="checkbox" name="status" value="1" <?if(intval($data['service_status'])):?> checked="checked"<?  endif;?>>  

<br>
<br><input class="btn" type="submit" name="submit" value="Сохранить">

</form>
