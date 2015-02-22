<p align="right">
<a class="btn btn-success" href="<?=$url?>/menus/add/<?=Request::current()->param('id');?>/?position=<?=$_REQUEST['position']?>"> <i class="icon-plus-sign icon-white"></i> Добавить</a>
</p>
<br>
<table class="table table-bordered table-hover">
<thead>
<tr><th>Название меню</th><th>Тип меню</th><th>Ссылка</th><th width="50" colspan="2">Функции</th>
</thead>
<tbody>
<?foreach($menus as $m):?>
<tr>
<td><?=$m->menu_title?></td><td><?=$m->menu_type?></td><td><?=$m->menu_alias?></td>
<td width="30"><a class="btn btn-success btn-small" href="<?=$url?>/menus/edit/<?=$m->menu_id?>"><i class="icon-edit icon-white"></i></a></td>
<td width="30"><a class="btn btn-danger btn-small" href="<?=$url?>/menus/delete/<?=$m->menu_id?>"><i class="icon-trash icon-white"></i></a></td>
</tr>
<?endforeach?>
</tbody>
</table>