<?
if(@$_REQUEST['act']=='demo'){
echo '<div class="alert alert-error">У Вас нет достаточно прав на удаление</div>';
}
?>

<table class="table table-bordered">
<tr><th>Заказ №</th><th>Дата заказа</th><th>Ползователь</th><th>Email</th><th>Телефон</th><th>Сумма</th><th>Статус</th><th></th></tr>
<? foreach ($orders as  $order):?>
  <tr>
  <td>
    <span style="margin-left:10px"><a href="orders/details/<?=$order->order_id; ?>" title="Просмотр заказа детально"><?=$order->order_id; ?> <i class="icon-eye-open"></i></a></span>
  </td>
  
  <td><?=$order->order_date?></td>
  
  <td><a href="users/edit/<?=$order->users->id; ?>"><?=$order->users->first_name; ?></a></td>

  <td><?=$order->users->email; ?></td>
  <td><?=$order->users->phone; ?></td>
  <td><?=$order->total_price; ?></td>
  <td><? if($order->order_status==0) print '<span class="label label-warning">не оплачен</span>'; else print '<span class="label label-success">Оплачен</span>'; ?></td>
  <td><a class="btn btn-danger" href="orders/delete/<?=$order->order_id?>"><i class="icon-trash"></i></a></td>
  </tr>
 <? endforeach?>
</table>
