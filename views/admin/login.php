<!DOCTYPE html>
<html lang="en">
  <head>
    <title></title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href="../css/bootstrap.min.css" rel="stylesheet" media="screen">
	<script src="../js/jquery-1.8.3.min.js"></script>
	<script src="../js/bootstrap.min.js"></script>
  </head>
  <body>



                <a class="close" data-dismiss="alert" href="#">×</a>
	
<h3 align="center"><?=$title?></h3>


<div class="container">
	<div class="row">
		<div class="span3  offset4 well">
			<legend><?=$page_title?></legend>
<?
if(isset($errors)){
	foreach ($errors as $error){
	print '<div class="alert alert-error"><a class="close" data-dismiss="alert" href="#">×</a>'.$error.'</div>';
	}
}
?>
			<form method="POST" action="">
			<input type="text" id="username" class="span3" name="username" placeholder="Username">
			<input type="password" id="password" class="span3" name="password" placeholder="Password">
            <label class="checkbox">
            	<input type="checkbox" name="remember" value="1"> Запомнить
            </label>
			<input class="btn  btn-info  span2" type="submit" name="submit" value="Вход">
		</div>
	</div>
</div>  

  </body>
</html>
  