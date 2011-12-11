<?php
$script = basename($_SERVER['PHP_SELF']);
switch($script){
	case 'awards.php':
		$pages_query = db_select('awards','*','`page` = "'.$script.'"','`id`');
		break;
	case 'cards.php':
        (isset($_GET['p'])||$_GET['p'] != '') ? $where = '`id` = "'.htmlspecialchars($_GET['p']).'"' : $where = 'no';
		$pages_query = db_select('cards','*',$where,'`id`');
		break;
	case 'fest.php':
		$pages_query = db_select('fest','*','`page` = "'.$script.'"','`id`');
		break;
	case 'members.php':
		(isset($_GET['q'])||$_GET['q'] != '') ? $where = '`id` = "'.htmlspecialchars($_GET['q']).'"' : $where = 'no';
		$pages_query = db_select('members','*',$where,'`id`');
		break;
	case 'news.php':
		(isset($_GET['q'])||$_GET['q'] != '') ? $where = '`id` = "'.htmlspecialchars($_GET['q']).'"' : $where = 'no';
		$pages_query = db_select('news','*',$where,'`date` desc');
		break;
	case 'source.php':
		$pages_query = db_select('source','*','`page` = "'.$script.'"','`id`');
		break;
	case 'work.php':
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
										 'succdate'=>$arr_pages['succdate'],
										 'rank'=>htmlspecialchars_decode($arr_pages['rank']),
										 'people'=>htmlspecialchars_decode($arr_pages['people']),
										 'fests'=>htmlspecialchars_decode($arr_pages['fests']));
	}
}
?>
<tr><td width="900px" valign="top">
    <?php
	switch($script){
		case 'awards.php':
			
			break;
		case 'cards.php':
        	if(!isset($_GET['p'])||$_GET['p']==''){?>
                <div class="caption">Паспорта</div>
                <div class="content">
                <ul class="cards">
				<?php
                if(count($pages) != 0){
                foreach($pages as $key => $value):?>
                    <li id="cards<?=$value['id']?>">
                    	<a href="/cards.php?p=<?=$value['id']?>">
                        <img class="ava" src="/img/cards/test/thumb/<?=$value['avatar']?>" align="left" />
                        <div id="<?=$value['id']?>" class="ccaption">
                            <span><?=$value['lname'].' "'.$value['nick'].'" '.$value['name']?></span>
                        </div>
                        <div class="ccontent"><?=$value['caption'];?></div>
                        </a>
                    </li>
                <?php 
                endforeach;
                }?>
                    </ul>
                    </div>
            <?php
			}else{
				if(count($pages) != 0){
				foreach($pages as $key => $value):?>
					<div class="caption">
						<?=$value['lname'].' "'.$value['nick'].'" '.$value['name'].' - '.$value['caption'];?>
					</div>
					<div class="content">
						<?=$value['content'];?>
					</div>
				<?php 
				endforeach;
				}
			}
			break;
		case 'fest.php':
			
			break;
		case 'members.php':
        	if(!isset($_GET['q']) || $_GET['q'] == ''){?>
                <div class="caption">Состав</div>
                <div class="content">
				<?php
                foreach($pages as $key => $value):?>
                    <div id="members<?=$value['id'];?>" class="member">
                        <a href="/members.php?q=<?=$value['id'];?>" >
                            <img class="ava" src="<?=$value['avatar'];?>" align="top" />
                            <div id="<?=$value['id']?>" class="mcaption">
                                <span><?=$value['lname'].' "'.$value['nick'].'" '.$value['name'];?></span>
                            </div>
                        </a>
                    </div>
                <?php 
                endforeach;?>
                </div>
            <?php
			}else{
				foreach($pages as $key => $value):?>
					<div class="caption">
						<?=$value['lname'].' "'.$value['nick'].'" '.$value['name'];?>
					</div>
					<div class="content">
                            <img class="ava" src="<?=$value['avatar'];?>" align="left" />
                            <ul class="subcont">
                            	<li>Состоит в КИР "Яро Пламя" с <?=$value['succdate'];?>.</li>
                                <li>Имеет звание "<?=$value['rank'];?>".</li>
                                <li>Подопечные:<br />
                                    <div><?=$value['people'];?></div></li>
                                <li>Мероприятия, в которых принимал участие:<br />
                                    <div><?=$value['fests'];?></li>
                            </ul>
                    </div>
                <?php 
                endforeach;
			}
            break;
		case 'news.php':?>
			<div class="caption">Новости</div>
			<div class="content">
            <ul class="news">
        	<?php
			foreach($pages as $key => $value):?>
            	<li>
                    <div class="ncaption"><?=$value['caption'];?><a href="/news.php?q=<?=$value['id'];?>" >URL</a></div>
                    <div class="ncontent"><?=$value['content'];?></div>
                    <div class="nnick"><?=$value['nick'];?></div>
                    <div class="ndate"><?=$value['date'];?></div>
				</li>
			<?php 
			endforeach;?>
            </ul>
			</div>
			<?php
			break;
		case 'source.php':
			
			break;
		case 'work.php':
			
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