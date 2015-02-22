<script>
/*
$(document).ready(function(){
 
 	$("#menu_type").change(function() {
		
	if($("#menu_type").val()=='url'){
		  $('<li></li>')
           .append('<label>Ссылка <input type="text" name="menu_url" /></label>')
           .appendTo('#forms');
			}
	if($("#menu_type").val()=='pages'){
		  $('<li></li>')
           .append('<a href="/admin/pages/add" target="newpage">Саздать страницу</a>')
           .appendTo('#forms');
			}

	
	});

 });
 */
</script>
<?
if(isset($errors)){
	foreach($errors as $error){
	print '<div class="alert alert-error">'.$error.'</div>';
	}
}
?>

<form  method="post" action="">
<ul id="forms">
<li><label>Название: </label><input class="g-4" type="text" name="menu_title" value="<?=@$data['menu_title']?>" /></li> 
<li><label>Алиас или ссылка: </label><input class="g-4"  type="text" name="menu_alias" value="<?=@$data['menu_alias']?>" /> &nbsp; (ссылка на Личный кабинет login, Ссылка на cтатей articles, ccылка на обратная связь feedback)</li> 
<li>
<label>Тип меню </label>
<select id="menu_type" name="menu_type">
  <option value="pages/page">Страница</option>
  <option value="url">Cсылка</option>
 </select> &nbsp; (Для добавление страницы надо создать страницу таким же алиасом)
</li>
</ul>
<input type="hidden" name="menu_group_id" value="<?=Request::current()->param('id');?>">
<input type="hidden" name="menu_group_position" value="<?=@$_REQUEST['position']?>">
<input class="btn btn-success" type="submit" name="submit" value="  Сохранить  ">
</form>
