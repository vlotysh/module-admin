<?
if(@$_REQUEST['act']=='demo'){
echo '<div class="alert alert-error">У Вас нет достаточно прав на удаление</div>';
}
?>
<p align="right">
<a class="btn btn-success" href="articles/add"><i class="icon-plus-sign"></i> Добавить</a>
</p>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>Название</th><th width="10%">Статус</th><th width="10%">Функции</th>
        </tr>
    </thead>
<? foreach ($articles as  $article):?>
<tr>
    <td><a href="articles/edit/<?=$article->article_id?>"><?=$article->article_title?></a></td>
	<td><? if($article->article_status==1) print '<span class="label label-success">Опубликовн</span>'; else print '<span class="label">Не опубликовн</span>' ?></td>
    <td>
    <a class="btn btn-success" href="articles/edit/<?=$article->article_id?>"><i class="icon-edit"></i></a> &nbsp;  
    <a class="btn btn-danger" href="articles/delete/<?=$article->article_id?>"><i class="icon-trash"></i></a>
    </td>
</tr>
<? endforeach?>

</table>