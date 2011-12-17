<?php
include('inc/top.php');

$date = date('Y-m-d H:i:s');
switch($_POST['table']){
	case'pages':break;
	case'news':
		$params = array(
            'insert' => array(
                'page' => $_POST['pg'],
                'caption' => $_POST['cpt'],
                'content' => $_POST['cnt'],
                'nick' => $AUN,
                'date' => $date
            ),
            'update' => array(
                'caption' => $_POST['cpt'],
			    'content' => $_POST['cnt'],
			    'date' => $date
            ),
            'where' => array(
                'id',
                $_POST['id']
            )
        );
		break;
	case'cards':
        $params = array(
            'insert' => array(
                'name' => $_POST['nam'],
                'lname' => $_POST['lnam'],
                'nick' => $_POST['nick'],
                'avatar' => $_POST['ava'],
                'caption' => $_POST['cpt'],
                'content' => $_POST['cnt']
            ),
            'update' => array(
                'caption' => $_POST['cpt'],
                'content' => $_POST['cnt']
            ),
            'where' => array(
                'id',
                $_POST['id']
            )
        );
		break;
	case'members':
        $params = array(
            'insert' => array(
                'name' => $_POST['nam'],
                'lname' => $_POST['lnam'],
                'nick' => $_POST['nick'],
                'avatar' => $_POST['ava'],
                'rank' => $_POST['rnk'],
                'phone' => $_POST['phn'],
                'fests' => $_POST['fst'],
                'birthday' => $_POST['bdate'],
                'succdate' => $_POST['sdate'],
                'learnwork' => $_POST['lrn'],
                'people' => $_POST['ppl']
            ),
            'update' => array(
                'name' => $_POST['nam'],
                'lname' => $_POST['lnam'],
                'nick' => $_POST['nick'],
                'avatar' => $_POST['ava'],
                'rank' => $_POST['rnk'],
                'phone' => $_POST['phn'],
                'fests' => $_POST['fst'],
                'birthday' => $_POST['bdate'],
                'learnwork' => $_POST['lrn'],
                'people' => $_POST['ppl']
            ),
            'where' => array(
                'id',
                $_POST['id']
            )
        );
		break;
	case'':break;
	case'':break;
}

echo $objPage->setPage($_POST['table'],$_POST['edit'],$params);

include('inc/bottom.php');
?>