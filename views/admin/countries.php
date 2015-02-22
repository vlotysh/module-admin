<table class="table table-bordered">
<?
$i = 0;
foreach($countries as $c):?>
<?$i++;?>

<tr><td><?=$i?></td><td><?=$c->country_name?></td><td><?=$c->iso_code_2?></td><td><?=$c->iso_code_3?></td><td><a class="btn btn-danger" href="countries/delete/<?=$c->country_id?>"><i class="icon-trash"></i></a></td></tr>
<?endforeach?>
</table>

<?=$pagination?>
