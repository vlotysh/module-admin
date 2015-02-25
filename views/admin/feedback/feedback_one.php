
<style>
    .border li {
	list-style-type: none;
    }
</style>


	<div class="border">
	<ul>
	    <li><div class="span2">Имя отправителя:</div> <input class="span6" type="text"  disabled="disabled" value="<?=$feedback->name;?>"></li>
	    
	    <li><div class="span2">Эмейд отправителя:</div> <input class="span6" type="text" disabled="disabled" value="<?=$feedback->email;?>"></li>
	    <li><div class="span2">Телефон отправителя:</div> <input class="span6" type="text" disabled="disabled" value="<?=$feedback->phone;?>"></li>
	    <li><div class="span2">Сообщение:</div> <textarea class="span6" type="text" disabled="disabled" value=""><?=$feedback->message;?></textarea></li>
	    
	    <li><div class="span2">Дата отправления:</div> <input class="span6" type="text" disabled="disabled" value="<?=$feedback->date;?>"></li>
	</ul>
	</div>
