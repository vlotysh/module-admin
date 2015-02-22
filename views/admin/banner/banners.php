<?
if(@$_REQUEST['act']=='demo'){
echo '<div class="alert alert-error">У Вас нет достаточно прав на удаление</div>';
}
?>
<p align="right">
<a class="btn btn-success" href="banners/add"><i class="icon-plus-sign"></i> Добавить</a>
</p>
<table class="table table-bordered">
    <thead>
        <tr height="30">
            <th>Название</th><th>Ссылка</th><th>Изображение</th><th>Статус</th><th>Функции</th>
        </tr>
    </thead>
<? foreach ($banners as  $b):?>
<tr>
    <td><a href="banners/edit/<?=$b->banner_id?>"><?=$b->banner_title?></a></td>
	<td><?=$b->banner_url?></td>
	<td><a href="/media/banners/<?=$b->banner_image?>"><?=$b->banner_image?></a></td>
	<td><? if($b->banner_status==1) print '<span class="label label-success">Активна</span>'; else print '<span class="label">Не активна</span>'; ?></td>
    <td width="100" align="center">
    <a class="btn btn-success" href="banners/edit/<?=$b->banner_id?>"><i class="icon-edit"></i></a>
    <a class="btn btn-danger" href="banners/delete/<?=$b->banner_id?>"><i class="icon-trash"></i></a>
    </td>
</tr>
<? endforeach?>

</table>