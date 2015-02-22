<script type='text/javascript'> 
    $(function(){ 
        $("#form").change(function() {
            $('body').css({opacity: .3});
           $(this).submit();
        });
    }) 

</script>

<form method="GET" id="form">

    <div class="row">
        <div class="span12">
            <div  class="span7">
               <ul>
                <!-- дерево фильтров -->
                <? #Helper_Producthelper::buildFiltersTree($allfilters); 
 foreach ($allfilters as $filter):
                ?>
                <li><li><a href="/admin/filters/edit<?= URL::query(array('filter_id' => $filter['id']), false) ?>"><? echo $filter['filter_title'] ?></a> <a href="/admin/filters/delete<?= URL::query(array('filter_id' => $filter['id']), false) ?>">Удалить</a></li>
                
                <?  endforeach;?>
               </ul>
            </div>

            <div class="span4">
                <div>Название категори</div>
                <ul class="list-unstyled">
                    <? foreach ($categories as $cat): ?>
                        <li> 

                            <? if ($cat->lvl > 1): ?>
                                <span style="margin-left:<?= $cat->lvl * 8 ?>px"></span>
                            <? endif; ?>

                            <? if ($_GET && $cat->id == Request::factory()->query('cat_id')): ?>
                                <span><?= $cat->category_title; ?></span>
                            <? else : ?>
                                <a href="/admin/filters<?= URL::query(array('cat_id' => $cat->id),false) ?>"><?= $cat->category_title; ?></a>

                            <? endif; ?>

                        </li>

                    <? endforeach ?>



                </ul>

            </div>
            
        </div>
    </div>
    
    <div class="row">
         <div class="span12">
             <a href="/admin/filters/add"><span class="label label-primary">Добавить новый фильтер</span></a>
         </div>
    </div>

</form>



<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

