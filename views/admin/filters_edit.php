<form method="POST" onchange="function(event) {
            this.submit();
        }">

    <div class="span4">
        <p style="float: left;">Использовать в категориях</p>

<? #var_dump($filter['cat_id']);
#exit();?>
        <? foreach ($categories as $cat): ?>
         <lable style="width: 100%;float: left;" for="cat_<?=$cat->id?>">     
        <input id="cat_<?=$cat->id?>" name="categories[]" type="checkbox"                    
                <? if ($cat->lvl > 1): ?>
                                                            style="margin-left:<?= $cat->lvl * 8 ?>px"<? endif; ?> value="<?= $cat->id ?>"
                                                        <?
                                                        if(is_int(array_search($cat->id,$filter_cats))) {
                                                            echo "checked ='checked'";
                                                        }
                                                        ?>/>
             
            
                 <? echo $cat->category_title;?>
                </lable>



        <? endforeach ?>

    </div>

    <div class="span4">
        <input type="text" value="<?= $filter['filter_title']; ?>" name="filte_title"/>
        <input type="hidden" name="filter_id" value="<?= $filter['id'] ?>">
        <ul>

            <? $filter = 0;
            foreach ($values as $value):
                ?>
                <li><?= $value['value']; ?></li>
            <? endforeach; ?>
        </ul>


        <ul class="prop_ul">
            <li feature_id="1">
                <input type="hidden" name="value[1]" value="">
                <input type="hidden" name="filter[1]" value="1">
                <input id="autosearch" type="text" name="filter_title[1]" placeholder="1">
            </li>

            <li feature_id="2">
                <input type="hidden" name="value[2]" value="">
                <input type="hidden" name="filter[2]" value="2">
                <input id="autosearch" type="text" name="filter_title[2]" placeholder="2">
            </li>

        </ul>

        <label>
            <input type="checkbox" name="valuess[1]"> Диагональ
        </label>

        <label>
            <input type="checkbox" name="valuess[2]"> Операционная система
        </label>
        <hr>
        <!--<label class="property">
            <input type="text" name="new_features_names[]">
        </label>
        <input class="simpla_inp" type="text" name="new_features_values[]">
        <hr>
        <label class="property">
            <input type="text" name="new_features_names[]">
        </label>
        <input class="simpla_inp" type="text" name="new_features_values[]">
        <hr>-->
        <input type="submit" value="Сохранить">
    </div>

</form>

