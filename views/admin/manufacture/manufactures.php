<?
if(@$_REQUEST['act']=='demo'){
echo '<div class="alert alert-error">У Вас нет достаточно прав на удаление</div>';
}
?>
<p align="right">
<a class="btn btn-success" href="manufactures/add"><i class="icon-plus-sign"></i> Добавить</a>
</p>

<table class="table table-bordered">
<tr><th>Название</th><th>Сайт</th><th>Алиас</th><th>Изображение</th><th></th></tr>
<?
foreach($data as $d){

print '<tr><td>'.$d->title.'</td><td>'.$d->url.'</td><td>'.$d->alias.'</td><td>
<a href="/media/manufactures/'.$d->image.'"><img width="100" src="/media/manufactures/small_'.$d->image.'"></a></td>
<td align="center" width="12%"><a class="btn btn-success" href="manufactures/edit/'.$d->id.'"><i class="icon-edit"></i></a>
 <a class="btn btn-danger" href="manufactures/delete/'. $d->id.'"><i class="icon-trash"></i></a>
 </td></tr>';
}

?>
</table>