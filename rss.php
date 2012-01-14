<?php
header ('Content-type: text/xml; charset=utf-8');
/*Конфигурационный файл*/
$server = array('local'=>'localhost','host'=>'78.108.84.245');
$login = array('local'=>'jf','host'=>'u106771');
$password = array('local'=>'test','host'=>'ayuzesVF39');
$database = array('local'=>'jf','host'=>'b106771_jf');
require_once($_SERVER['DOCUMENT_ROOT'].'/phpmailer/class.phpmailer.php'); // Класс PHPMailer
include('config/classes/classes.php'); // Подключение списка классов
include('config/objects/objects.php'); // Создание объектов классов
include('functions/dbfunctions.php'); // Функции работы с БД
// Подключение к MySQL и запись ID соединения
$dbconnectID = $c_dbase->getConnect($server,$login,$password);
$c_dbase->getDB($database); // Выбор БД
mysql_query("set names 'utf8'");

function setItems(){
    $pages_query = db_select('news','*','no','`date` desc');
    $pages = array();
    while($arr_pages = mysql_fetch_array($pages_query, MYSQL_ASSOC)){
        foreach($arr_pages as $key => $value){
            $pages[$arr_pages['id']][$key] = htmlspecialchars_decode($value);
        }
    }
    $i = 0;
    $res = '';
    foreach($pages as $key => $value){
        $value['date'] = date_create($value['date']);
        if ($i == 0) $res = '<lastBuildDate>'.date_format($value['date'],'D, d M Y H:i:s \G\M\T').'</lastBuildDate>';
        $res .= '<item>
                    <title><![CDATA['.$value['caption'].']]></title>
                    <link><![CDATA[http://яропламя.рф/news.php?q='.$value['id'].']]></link>
                    <description><![CDATA[<img src="http://яропламя.рф/img/default/logo-rss.jpg" width="31" height="31" border="0"></a>'.$value['content'].']]></description>
                    <pubDate><![CDATA['.date_format($value['date'],'D, d M Y H:i:s \G\M\T').']]></pubDate>
                    <guid><![CDATA[http://яропламя.рф/news.php?q='.$value['id'].']]></guid>
                </item>';
        $i++;
    }

    return $res;
}

$result = '<?xml version="1.0" encoding="UTF-8"?>
<rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom">
    <channel>
        <atom:link href="http://яропламя.рф/rss.php" rel="self" type="application/rss+xml" />
        <title><![CDATA[Новости КИР "Яро Пламя"]]></title>
        <link><![CDATA[http://яропламя.рф]]></link>
        <description><![CDATA[Новости Клуба Исторической Реконструкции "Яро Пламя"]]></description>

        <image>
            <title><![CDATA[RSS-канал]]></title>
            <link><![CDATA[http://яропламя.рф/news.php]]></link>
            <url><![CDATA[http://яропламя.рф/img/default/logo-rss.jpg]]></url>
        </image>

        '.setItems().'

    </channel>
</rss>';
$doc = new DOMDocument();
$doc->loadXML($result);
echo $doc->saveXML();
$c_dbase->closeConnect($dbconnectID); // Закрытие соединения с Базой Данных
?>