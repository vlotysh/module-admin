<script>
    $(document).ready(function () {

        $('#categories,#types').change(function () {
            $('#formcategory').submit();
        });
    });

</script>

<?
if (!empty($_GET['cat_id'])) {
    (int) $catid = $_GET['cat_id'];
}

if (!empty($_GET['type_id'])) {
    (int) $type_id = $_GET['type_id'];
}
?>

<form id="formcategory" action="" method="get">
    
    

    
    <select id="categories" name="cat_id">
	<option value="">-- Показать все --</option>



	<? foreach ($categories as $cat): ?>
            <option value="<?= $cat->id ?>" <? if (isset($catid) && $cat->id == $catid): ?> selected<? endif ?> >
		<?= str_repeat('&nbsp;', 2 * $cat->lvl) . $cat->category_title ?>
            </option>
	<? endforeach ?>
    </select>



    <select id="types" name="type_id">

	<? foreach ($types as $type): ?>
            <option value="<?= $type->id ?>" <? if (isset($type_id) && $type->id == $type_id): ?> selected<? endif ?> >
		<?= $type->type_name ?>
            </option>
	<? endforeach ?>
    </select>



</form>
<?= $pagination ?>
<p align="right">
    <a class="btn btn-success" href="products/add"><i class="icon-plus-sign"></i> Добавить</a>
</p>


<table class="table table-bordered">
    <thead>
        <tr height="30">
            <th>Изображение</th><th>Название товара</th><th>Цена</th><th>Статус</th><th >Функции</th>
        </tr>
    </thead>
    <?
    $i = 0;
    foreach ($products as $product):
	$i++;
	?>
        <tr>

    	<td><a href="/media/products/<?= $product->main_img->name; ?>"><img width="80" src="/media/products/small_<?= $product->main_img->name; ?>"></a></td>
	
    	<td ><a href="products/edit/<?= $product->id; ?>"><?= $product->title ?></a></td>

    	<td align="center"><?= $product->price; ?></td>
    	<td align="center"><? if ($product->status == 1) print '<span class="label label-success">Включено</span>';
    else print '<span class="label">Отключено</span>'; ?></td>
    	<td>
    	    <a class="btn btn-success" href="products/edit/<?= $product->id; ?>"><i class="icon-edit"></i></a>
    	    <a class="btn btn-danger" href="products/delete/<?= $product->id; ?>"><i class="icon-trash"></i></a>
    	</td>
        </tr>
    <? endforeach ?>

</table>

<?= $pagination ?>
