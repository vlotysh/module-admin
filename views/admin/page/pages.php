<?
if(@$_REQUEST['act']=='demo'){
echo '<div class="alert alert-error">У Вас нет достаточно прав на удаление</div>';
}
?>
<p align="right">
<a class="btn btn-success" href="pages/add"><i class="icon-plus-sign"></i> Добавить</a>
</p>
<table class="table table-bordered">
    <thead>
        <tr>
            <th width="80%">Название</th><th>Алиас</th><th width="10%">Статус</th><th width="10%">Функции</th>
        </tr>
    </thead>
<? foreach ($pages as  $page):?>
<tr>
    <td><a href="pages/edit/<?=$page->page_id?>"><?=$page->page_title?></a></td>
	<td><?=$page->page_alias ?></td>
	<td><? if($page->page_status==1) print '<span class="label label-success">Опубликовн</span>'; else print '<span class="label">Не опубликовн</span>' ?></td>
    <td>
    <a class="btn btn-success" href="pages/edit/<?=$page->page_id?>"><i class="icon-edit"></i></a>
    <a class="btn btn-danger" href="pages/delete/<?=$page->page_id?>"><i class="icon-trash"></i></a>
    </td>
</tr>
<? endforeach?>

</table>