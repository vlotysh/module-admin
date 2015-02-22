<table class="table table-bordered span6">
<tr><th colspan="2">Данные покупателья и заказа</th>
<tr><td>Номер заказа: </td><td><?=$order->order_id?></td></tr>
<tr><td>Дата заказа: </td><td><?=$order->order_date?></td></tr>
<tr><td>Имя ползователя: </td><td><?=$order->users->first_name?></td></tr>
<tr><td>E-mail: </td><td><?=$order->users->email; ?></td></tr>
<tr><td>Телефон: </td><td><?=$order->users->phone; ?></td></tr>
<tr><td>Адрес доставки: </td><td><?=$order->users->address; ?></td></tr>
<tr><td>Обшая сумма: </td><td><?=$order->total_price; ?> руб.</td></tr>
<tr><td>Способ достваки: </td><td><?=$order->order_delivery; ?></td></tr>
</table>

<table class="table table-bordered">
<th>Изображение</th><th>Товар</th><th>Модель</th><th>Артикул</th><th>Цена</th><th>Количество</th><th>Сумма</th>
<?foreach($oproducts as $pd):?>
<tr>
<td><img style="width:100px" src="/media/products/small_<?=$pd->oproducts->main_img->name?>"></td>
<td><?=$pd->oproducts->title?></td>
<td><?=$pd->oproducts->model?></td>
<td><?=$pd->oproducts->code?></td>
<td><?=$pd->oproducts->price?></td>
<td><?=$pd->order_quantity?></td>
<td><?=$pd->order_sum?></td>
<tr>
<?endforeach?>
</table>




