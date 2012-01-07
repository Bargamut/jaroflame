<?php
include('inc/top.php');
/**
 * Created by JetBrains PhpStorm.
 * User: Bargamut
 * Date: 07.01.12
 * Time: 22:26
 * To change this template use File | Settings | File Templates.
 */
switch($_POST['m']){
    case 'crop':
        if($objImage->img_crop($_POST['src'], $_POST['dest'], $_POST['t'], $_POST['l'], $_POST['w'], $_POST['h'])){
            echo "{status: 'cropped!'}";
        }
        break;
    default:break;
}
?>