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
<label>Логин</label> <input class="span4" type="text" name="username" value="<?=$users->username?>">
<label>Проль <span class="required">*</span></label><input class="span4" type="password" name="password" >
<label>Павторить пароль <span class="required">*</span></label><input class="span4" type="password" name="password_confirm">
<label>Имя Фамилия <span class="required">*</span></label><input class="span4" type="text" name="first_name" value="<?=$users->first_name?>">
<label>Email <span class="required">*</span></label><input class="span4" type="text" name="email" value="<?=$users->email?>">
<label>Телефон: <span class="required">*</span></label><input class="span4" type="text" name="phone" value="<?=$users->phone?>">
<label>Статус <input type="checkbox" name="status" value="1" <? if($users->status==1) print 'checked'; else print ''; ?>></label>
<input class="btn" type="submit" name="submit" value=" Сохранить "></li>
</ul>
</form>
</div>