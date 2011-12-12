<?php
$script = basename($_SERVER['PHP_SELF']);
switch($script){
	case 'awards.php':
		$pages_query = db_select('awards','*','`page` = "'.$script.'"','`id`');
		break;
	case 'cards.php':
		$pages_query = db_select('cards','*','no','`id`');
		break;
	case 'fests.php':
		$pages_query = db_select('fest','*','`page` = "'.$script.'"','`id`');
		break;
	case 'members.php':
		$pages_query = db_select('members','*','no','`id`');
		break;
	case 'news.php':
		$pages_query = db_select('news','*','no','`date` desc');
		break;
	case 'sources.php':
		$pages_query = db_select('source','*','`page` = "'.$script.'"','`id`');
		break;
	case 'treasury.php':
		$pages_query = db_select('treasury','*','`page` = "'.$script.'"','`id`');
		break;
	case 'works.php':
		$pages_query = db_select('work','*','`page` = "'.$script.'"','`id`');
		break;
	default:
		$pages_query = db_select('pages','*','`page` = "'.$script.'"','`id`');
		break;
}
while($arr_pages = mysql_fetch_array($pages_query,MYSQL_ASSOC)){
	foreach($arr_pages as $key => $value){
		$pages[$arr_pages['id']] = array('id'=>$arr_pages['id'],
										 'page'=>$arr_pages['page'],
										 'name'=>$arr_pages['name'],
										 'lname'=>$arr_pages['lname'],
										 'avatar'=>$arr_pages['avatar'],
										 'caption'=>$arr_pages['caption'],
										 'content'=>htmlspecialchars_decode($arr_pages['content']),
										 'nick'=>$arr_pages['nick'],
										 'date'=>$arr_pages['date'],
										 'birthday'=>$arr_pages['birthday'],
										 'learnwork'=>$arr_pages['learnwork'],
										 'phone'=>$arr_pages['phone'],
										 'succdate'=>$arr_pages['succdate'],
										 'rank'=>$arr_pages['rank'],
										 'people'=>$arr_pages['people'],
										 'fests'=>$arr_pages['fest']);
	}
}
?>
<tr><td width="900px" valign="top">
    <?php
	switch($script){
		case 'awards.php':
			
			break;
		case 'cards.php':?>
        	<div class="caption">Паспорта<img class="add" src="img/default/add.png" align="right" title="Создать" /></div>
			<div class="content">
            <ul class="cards">
        	<?php
			if(count($pages) != 0){
			foreach($pages as $key => $value):?>
            	<li id="cards<?=$value['id']?>">
                	<img class="ava" src="/img/cards/test/thumb/<?=$value['avatar']?>" align="left" />
                    <div id="<?=$value['id']?>" class="ccaption">
						<span><?=$value['lname'].' "'.$value['nick'].'" '.$value['name']?></span>
                        <img class="del" src="img/default/del.png" align="right" title="Удалить" />
                        <img class="edit" src="img/default/edit.png" align="right" title="Редактировать" />
                    </div>
                    <div class="ccontent"><?=$value['caption'];?></div>
				</li>
			<?php 
			endforeach;
			}?>
            </ul>
			</div>
            <?php
			break;
		case 'fests.php':
			
			break;
		case 'members.php':?>
        	<div class="caption">Состав<img class="add" src="img/default/add.png" align="right" title="Создать" /></div>
			<div class="content">
            <ul class="members">
        	<?php
			if(count($pages) != 0){
			foreach($pages as $key => $value):?>
            	<li id="members<?=$value['id']?>">
                	<img class="ava" src="<?=$value['avatar']?>" align="left" />
                    <div id="<?=$value['id']?>" class="mcaption">
						<span><?=$value['lname'].' "'.$value['nick'].'" '.$value['name']?></span>
                        <img class="del" src="img/default/del.png" align="right" title="Удалить" />
                        <img class="edit" src="img/default/edit.png" align="right" title="Редактировать" />
                    </div>
				</li>
			<?php 
			endforeach;
			}?>
            </ul>
			</div>
            <?php
			break;
		case 'news.php':?>
			<div class="caption">Новости<img class="add" src="img/default/add.png" align="right" title="Создать" /></div>
			<div class="content">
            <ul class="news">
        	<?php
			if(count($pages) != 0){
			foreach($pages as $key => $value):?>
            	<li id="news<?=$value['id']?>">
                    <div id="<?=$value['id']?>" class="ncaption">
						<span><?=$value['caption']?></span>
                        <img class="del" src="img/default/del.png" align="right" title="Удалить" />
                        <img class="edit" src="img/default/edit.png" align="right" title="Редактировать" />
                    </div>
                    <div class="ncontent"><?=$value['content'];?></div>
                    <div class="nnick"><?=$value['nick'];?></div>
                    <div class="ndate"><?=$value['date'];?></div>
				</li>
			<?php 
			endforeach;
			}?>
            </ul>
			</div>
			<?php
			break;
		case 'sources.php':
			
			break;
		case 'works.php':
			
			break;
		default:
			foreach($pages as $key => $value):?>
			<div class="caption"><?=$value['caption']?></div>
			<div class="content"><?=$value['content']?></div>
			<?php endforeach;
			break;
	}?>
</td></tr>
<tr><td>
	<div class="content">
	<?php
    switch ($script){
		case 'callback.php':?>
			<form name="frm_callback" class="frm_callback" method="post" action="">
                <input id="u_fio" name="u_fio"
                	type="text"
                    size="50"
                	onfocus="if (this.value == 'ФИО') {$(this).val('');}"
                    onblur="if (this.value == '') {$(this).val('ФИО');}"
                	value="ФИО" /><br />
                <input id="u_email" name="u_email"
                	type="text"
                    size="21"
                	onfocus="if (this.value == 'E-mail') {$(this).val('');}"
                    onblur="if (this.value == '') {$(this).val('E-mail');}"
                    value="E-mail" />&nbsp;
                <input id="u_phone" name="u_phone"
                	type="text"
                    size="21"
                	onfocus="if (this.value == 'Телефон') {$(this).val('');}"
                    onblur="if (this.value == '') {$(this).val('Телефон');}"
                    value="Телефон" /><br />
            	<input id="u_subj" name="u_subj"
                	type="text"
                    size="50"
                	onfocus="if (this.value == 'Тема') {$(this).val('');}"
                    onblur="if (this.value == '') {$(this).val('Тема');}"
                	value="Тема" /><br />
                <textarea id="u_message" name="u_message"
                	cols="39" rows="10"
                	onfocus="if (this.value == 'Текст сообщения') {$(this).html('');}"
                    onblur="if (this.value == '') {$(this).html('Текст сообщения');}">Текст сообщения</textarea><br />
                <button id="u_subm" name="u_subm"
                	type="button"
                    class="u_subm"
                    disabled="disabled">Отправить</button>
            </form>
	<?php
    		break;
		default:
			break;
	}
	?>
    </div>
</td></tr>