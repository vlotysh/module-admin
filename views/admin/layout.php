<!DOCTYPE html>
<html lang="ru">
    <head>
        <title>Панель управления TopCommerce CMS</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="/media/css/bootstrap.css" rel="stylesheet" media="screen">
        <link href="/media/css/bootstrap-responsive.css" rel="stylesheet">
        <link href="/media/css/admin-styles.css" rel="stylesheet">
        <script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
        <script src="//code.jquery.com/ui/1.11.1/jquery-ui.min.js"></script>
	<?php foreach ($scripts as $file_script): ?>
	    <?= HTML::script($file_script) ?>
	<?php endforeach ?>
        <base href="http://<?= $_SERVER['HTTP_HOST']; ?>/admin/">
    </head>

    <body>

        <div class="container-fluid">

	    <div class="row-fluid no-iframe">

                <div class="span12" style="background-color: #343434; padding:5px 0 5px 0" >		<div class="span4">	
                        <span style="font-size:20px; color:#fff">TopCommerce CMS</span>
                    </div>	
                    <div class="span7" style="text-align:right;">
                        <a href="http://<?= $_SERVER['HTTP_HOST']; ?>" target="_blank">Просмотр сайта</a> &nbsp; 
                        <a href="users/edit/<?= $admin_info ?>"><i class="icon-user icon-white"></i><?= $admin_info->first_name; ?></a> &nbsp; -->
                        <a href="auth/logout"><i class="icon-off icon-white"></i> Выход</a>
                    </div></div>

            </div>

	    <div class="row-fluid">
                <div class="span12">
                    <div class="navbar navbar-inverse">
                        <div class="navbar-inner">
                            <div class="container-fluid">
                                <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                </a>
                                <div class="nav-collapse collapse">
				    <?= $admin_menu ?>
                                </div>
                                <!--/.nav-collapse -->
                            </div>
                            <!--/.container-fluid -->
                        </div>
                        <!--/.navbar-inner -->
                    </div>
                    <!--/.navbar -->
<div role="tabpanel">

  <!-- Nav tabs -->
  <ul class="nav nav-tabs" role="tablist">
    <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">Home</a></li>
    <li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">Profile</a></li>
    <li role="presentation"><a href="#messages" aria-controls="messages" role="tab" data-toggle="tab">Messages</a></li>
    <li role="presentation"><a href="#settings" aria-controls="settings" role="tab" data-toggle="tab">Settings</a></li>
  </ul>

  <!-- Tab panes -->
  <div class="tab-content">
    <div role="tabpanel" class="tab-pane active" id="home">1</div>
    <div role="tabpanel" class="tab-pane" id="profile">2</div>
    <div role="tabpanel" class="tab-pane" id="messages">3</div>
    <div role="tabpanel" class="tab-pane" id="settings">4</div>
  </div>

</div>
                </div>
            </div>

            <div class="notification-block">

		<?php if (count($errors) > 0): ?>

		    <?php foreach ($errors as $error) : ?>

			<div class="alert alert-error">
			    <button class="close" data-dismiss="alert" type="button">×</button>
			    <b>Ошибка!</b> <br> <?php echo HTML::chars($error) ?>
			</div>

    <?php endforeach; ?>

		<?php endif; ?>

		<?php if (count($message) > 0): ?>

		    <?php foreach ($message as $mes) : ?>

			<div class="alert alert-success">
			    <button class="close" data-dismiss="alert" type="button">×</button>
			    <b>Сообщение</b><br><?php echo HTML::chars($mes) ?>

			</div>
    <?php endforeach; ?>

		<?php endif; ?>

            </div>
            <div class="row-fluid">
		<div class="inner_content">
		    <div class="span12">
			<h3><?= $page_title ?></h3>
<?= $block_center ?>
		    </div>
		</div>
	    </div>
            <div class="row">
                <div class="span12"><br><p align="right">TopCommerce CMS 2014 &copy;</div>
            </div>
        </div>
<?php ///echo View::factory('profiler/stats') ;  ?>

	<?php // ProfilerToolbar::render(true); ?>
    </body>
</html>