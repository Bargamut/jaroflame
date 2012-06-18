<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Bargamut
 * Date: 14.06.12
 * Time: 10:39
 * To change this template use File | Settings | File Templates.
 */

include('inc/top.php');

$users = db_select('users_bio left outer join users_doc on users_bio.id = users_doc.id left outer join users_club on users_bio.id = users_club.id');

//echo '<pre>';
while ($res = mysql_fetch_array($users, MYSQL_ASSOC)){
    //print_r($res);
    //foreach($res as $key => $val) {
?>
    <div style="border: 1px #000 solid; margin: 5px 0 5px 0;">
        ФИО: <?=$res['lastname'].' '.$res['firstname'].' '.$res['fathername']?><br/>
        Мед.ограничения: <?=$res['medicine']?><br/>
        Звание: <?=$res['rank']?>
    </div>
<?php
    //}
}
//echo '</pre>';
?>
