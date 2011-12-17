<?php
include('inc/top.php');

echo json_encode($objPage->getPage($_POST['table'],$_POST['id'],1));

include('inc/bottom.php');
?>