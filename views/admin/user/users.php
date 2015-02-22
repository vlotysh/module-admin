<?
if(@$_REQUEST['act']=='demo'){
echo '<div class="alert alert-error">У Вас нет достаточно прав на удаление</div>';
}
?>

<p align="right">
<a class="btn btn-success" href="users/add"><i class="icon-plus-sign"></i> Добавить</a>
</p>

<table class="table table-bordered">
<th>Ползователь</th><th>Имя фамилия</th><th>Email</th><th>Роль</th><th>Последный логин</th><th>Статус</th><th >функции</th>
<? foreach($users as $user):?>
	<tr>
		<td><?=$user->username?></td>
		<td><?=$user->first_name?></td>
		<td><?=$user->email?></td>
		<td><?=$user->description?></td>
	    <td><?=date('d-m-Y',$user->last_login)?></td>
		<td><? if($user->status==1) print 'Включно'; else print 'Отключено'; ?></td>
		<td>
        <a class="btn btn-success" href="users/edit/<?=$user->id?>"><i class="icon-edit"></i></a>
        <a class="btn btn-danger" href="users/delete/<?=$user->id?>"><i class="icon-trash"></i></a>
    </td>
	</tr>
<? endforeach?>
</table>



