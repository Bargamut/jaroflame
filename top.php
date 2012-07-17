<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Bargamut
 * Date: 29.06.12
 * Time: 4:17
 */
include_once('eng/site.conf.php');

$db_index = db_connect('idb2.majordomo.ru', 'u134474', 'CP4awWNd6G');
db_select_db('b134474_jf', $db_index);
?>