<?
if(@$_REQUEST['act']=='demo'){
echo '<div class="alert alert-error">У Вас нет достаточно прав на удаление</div>';
}
?>
<p align="right">
<a class="btn btn-success" href="<?=$url?>/category/add"><i class="icon-plus-sign"></i> Добавить</a>
</p>

<table class="table table-bordered">
	<tr><th> Название категории </th><th width="12%"> Функцыи </th></tr>
		<?foreach ($categories as $cat):?>
  	<tr><td>     
          <? if($cat->lvl > 1){
              for($i = 1; $i < $cat->lvl;$i++) {
                  echo '&nbsp;&nbsp;&nbsp;';
              }
          }?> <a href="<?=$url?>/category/edit/<?=$cat->id?>"><?=$cat->category_title ?></a></td>
		<td>
		<a class="btn btn-success" href="<?=$url?>/category/edit/<?=$cat->id?>"><i class="icon-edit"></i></a>
		<a class="btn btn-danger" href="<?=$url?>/category/delete/<?=$cat->id?>"><i class="icon-trash"></i></a>
		</td>
	</tr>  
		<?endforeach?>
</table>


		  

