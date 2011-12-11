<?php
$menu_query = db_select('menu','*','no','`id`');
while($arr_menu = mysql_fetch_array($menu_query,MYSQL_ASSOC)){
	foreach($arr_menu as $key => $value){
		$menu[$arr_menu['id']] = array('id'=>$arr_menu['id'],
									   'href'=>$arr_menu['href'],
									   'submenu'=>$arr_menu['submenu'],
									   'caption'=>$arr_menu['caption']);
	}
}
?>
<tr><td height="130px" width="900px" valign="bottom">
<img src="/img/default/logo<?=mt_rand(1,3);?>.png" align="top" />
</td></tr><tr><td height="37px" style="background:url('../img/default/hline.png');padding:0 30px 0 30px;">
<ul class="topmenu">
<?php
foreach($menu as $key => $value):
if($value['submenu'] == 0):
	$submenu = '';
	foreach($menu as $key2 => $subval){
		if($value['id'] == $subval['submenu']){
			$submenu .= '
				<a href="'.$subval['href'].'">
					<div>'.$subval['caption'].'</div>
				</a>';
		}
	}
?>
	<li>
    	<a href="<?=$value['href']?>">
        	<div><?=$value['caption']?></div>
        </a>
        <?php
        if($submenu != ''):?>
        	<div class="submenu"><?=$submenu?></div>
		<?php
        endif;
        ?>
    </li>
<?php
endif;
endforeach;
?>
</ul>
</td></tr>