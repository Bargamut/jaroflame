<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Bargamut
 * Date: 14.06.12
 * Time: 10:39
 * To change this template use File | Settings | File Templates.
 */

include('inc/top.php');
?>
Имя: <?=$_POST['firstname']?><br />
Фамилия: <?=$_POST['lastname']?><br />
Отчество: <?=$_POST['fathername']?><br />
Дата рождения: <?=$_POST['birthday']?><br />
<hr />
<b>Паспорт</b><br />
серия: <?=$_POST['p_serial']?><br />
номер: <?=$_POST['p_number']?><br />
место выдачи: <?=$_POST['p_issuance']?><br />
дата выдачи: <?=$_POST['p_date']?><br />
Адрес прописки: <?=$_POST['reg_address']?><br />
Место учёбы: <?=$_POST['studies']?><br />
Место работы: <?=$_POST['work']?><br />
Мед. ограничения: <?=$_POST['medicine']?><br />
<hr />
Дата прихода в Клуб: <?=$_POST['borndate']?><br />
Звание: <?=$_POST['rank']?><br />
Фестивали: <?=$_POST['fests']?><br />
Подопечные: <?=$_POST['wards']?><br />
Награды: <?=$_POST['awards']?>  <br />
<?php
$bio = "'".$_POST['firstname']."','".$_POST['lastname']."','".$_POST['fathername']."','".$_POST['birthday']."'";
$doc = "'".$_POST['p_serial']."','".$_POST['p_number']."','".$_POST['p_issuance']."','".$_POST['p_date']."','".$_POST['reg_address']."','".$_POST['studies']."','".$_POST['work']."','".$_POST['medicine']."'";
$club = "'".$_POST['borndate']."','".$_POST['rank'].$_POST['fests']."','"."','".$_POST['wards']."','".$_POST['awards']."'";

db_insert('users_bio', '`firstname`,`lastname`,`fathername`,`birthday`', $bio);
db_insert('users_doc', '`p_seria`,`p_number`,`p_issuance`,`p_date`,`reg_address`,`studies`,`work`,`medicine`', $doc);
db_insert('users_club', '`borndate`,`rank`,`fests`,`wards`,`awards`', $club);

?>
