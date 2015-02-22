<form method="POST" onchange="function(event) {
            this.submit();
        }">
    <div class="span4">
        <p style="float: left;">Использовать в категориях</p>

        <? foreach ($categories as $cat): ?>
            <lable style="width: 100%;float: left;" for="cat_<?= $cat->id ?>">     
                <input id="cat_<?= $cat->id ?>" name="categories[]" type="checkbox"                    
                <? if ($cat->lvl > 1): ?>
                           style="margin-left:<?= $cat->lvl * 8 ?>px"<? endif; ?> value="<?= $cat->id ?>"
/>


                <? echo $cat->category_title; ?>
            </lable>



        <? endforeach ?>

    </div>

    <div class="span4">
        <input type="text" value="" name="filte_title"/>

        <input type="submit" value="Сохранить">
    </div>



</form> 
