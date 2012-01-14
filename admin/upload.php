<?php
include('inc/top.php');

/**
 * Created by JetBrains PhpStorm.
 * User: Bargamut
 * Date: 06.01.12
 * Time: 18:53
 * To change this template use File | Settings | File Templates.
 */

if($msg = $objFile->upload_file($_GET['path'])){
    if($_GET['resize']){
        $src = $msg['faddr'];
        $dst = $msg['faddr_thumb'];
        $size = explode('x',$_GET['resize']);
        if($objImage->img_resize($src, $dst, $size[0], $size[1])){
            $msg['resize'] = "Ресайз OK!";
        }else{
            $msg['resize'] = "Ресайз провалился!";
        }
    }
    if($_GET['main_resize']){
        $src = $msg['faddr'];
        $dst = $msg['faddr'];
        $size = explode('x',$_GET['main_resize']);
        if($objImage->img_resize($src, $dst, $size[0], $size[1])){
            $msg['main_resize'] = "Ресайз гл.изображения OK!";
        }else{
            $msg['main_resize'] = "Ресайз гл.изображения провалился!";
        }
    }
    if($_GET['watermark']){
        $watermark_img_src = '/img/default/watermark.png';
        $msg['watermark'] = $objWatermark->make_watermark($msg['faddr'], $watermark_img_src, 100);
    }
}

echo json_encode($msg);
?>