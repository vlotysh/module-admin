<ul class="nav">
	<li><a href="/admin"><i class="icon-home icon-white"></i> Панель</a></li>
		  <li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-folder-open icon-white"></i> Каталог<b class="caret"></b></a>
			<ul class="dropdown-menu">
			  <li><a href="/admin/category">Категории</a></li>
			  <li><a href="/admin/products">Товары</a></li>
			  <li><a href="/admin/manufactures">Производители</a></li>
			  <li><a href="/admin/services">Сервисы</a></li>
                          <!--li><a href="/admin/filters">Фильтры</a></li>-->
			</ul>
		  </li>
		  <li><a href="/admin/orders">Заказы</a></li>
		  <li><a href="/admin/menus"><i class="icon-file icon-white"></i> Меню</a></li>
                  <li><a href="/admin/pages"><i class="icon-file icon-white"></i> Страницы</a></li>
		  <li><a href="/admin/feedback"> Фидбэк <?if($feedcount) :?> <span class="badge"><?=$feedcount;?></span><?  endif;?></a> </li>;
		  <li><a href="/admin/articles">Статьи</a></li>
		  <li><a href="/admin/users">Пользователи</a></li>
		  <li><a href="/admin/banners">Баннеры</a></li>
		  <li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-cog icon-white"></i> Система<b class="caret"></b></a>
			<ul class="dropdown-menu">
			<li><a href="/admin/system">Система</a></li>
			<li><a href="/admin/system/settings">Настройки</a></li>			
			<li><a href="/admin/countries">Страны</a></li>
			</ul>
		   </li>
</ul>
