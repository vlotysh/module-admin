<?
if($errors){
	foreach($errors as $error){
		if(is_array($error)){
		foreach($error as $e){print '<div class="alert alert-error">'.$e.'</div>';}
		}
		else {print '<div class="alert alert-error">'.$error.'</div>';}
	}
}
?>

<div id="users">
<form method="post" action="">
Группа пользовательей<br>
<select  name="role">
<option value="">Выверите группу</option>
<option value="admin">Администратор</option>
<option value="user">Пользователь</option>
</select>

<label>Логин: <span class="required">*</span></label><input class="span4" type="text" name="username" value="<?=$data['username']?>">
<label>Проль: <span class="required">*</span></label><input class="span4" type="password" name="password">
<label>Павторить пароль: <span class="required">*</span></label><input class="span4" type="password" name="password_confirm">
<label>Имя Фамилия: <span class="required">*</span> </label><input class="span4" type="text" name="first_name" value="<?=$data['first_name']?>">
<label>Email: <span class="required">*</span></label><input class="span4" type="text" name="email" value="<?=$data['email']?>">
<label>Телефон: <span class="required">*</span></label><input class="span4" type="text" name="phone" value="<?=$data['phone']?>">
<br> Статус <input type="checkbox" name="status" value="1"><br>
<br><input class="btn" type="submit" name="submit">
</form>
</div>