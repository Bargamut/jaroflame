<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Bargamut
 * Date: 12.12.11
 * Time: 11:03
 * To change this template use File | Settings | File Templates.
 */
class Pages{
    // Составление запроса в БД
    private function queryArray($page, $pID){
        $params = array('table' => 'pages',
                        'fields' => '*',
                        'where' => '`page` = "'.$page.'"',
                        'order' => '`id`',
                        'limit' => '1');
        $fields = array();

        // Определение параметров запроса для конкретной страницы
        switch($page){
            case 'awards': // награды
                $params['table'] = 'awards'; break;
            case 'cards': // паспорта
                $params['table'] = 'cards';
                (isset($pID) && $pID != '') ?
                    $params['where'] = '`id` = "'.htmlspecialchars($pID).'"'
                  : $params['where'] = 'no';
                break;
            case 'fests': // фестивали
                $params['table'] = 'fests'; break;
            case 'members': // состав
                $params['table'] = 'members';
                (isset($pID) && $pID != '') ?
                    $params['where'] = '`id` = "'.htmlspecialchars($pID).'"'
                  : $params['where'] = 'no';
                break;
            case 'news': // новости
                $params['table'] = 'news';
                (isset($pID) && $pID != '') ?
                    $params['where'] = '`id` = "'.htmlspecialchars($pID).'"'
                  : $params['where'] = 'no';
                $params['order'] = '`date` desc';
                break;
            case 'sources': // источники
                $params['table'] = 'sources'; break;
            case 'works': // мастерская
                $params['table'] = 'works'; break;
            default:
                break;
        }

        return $params;
    }

    // Вывод страницы на экран
    private function pageOutput($page, $pID, $pages){
        $result = '<tr>'.'<td width="900px" valign="top">';
        switch($page){
            case 'awards':
                break;
            case 'cards':
                if(!isset($pID) || $pID == ''){
                    $result .= '<div class="caption">Паспорта</div>'.
                               '<div class="content">
                                    <ul class="cards">';

                    if(count($pages) != 0){
                        foreach($pages as $key => $value){
                            $result .= '<li id="cards'.$value['id'].'">
                                <a href="/cards.php?p='.$value['id'].'">
                                    <img class="ava" src="/img/cards/test/thumb/'.$value['avatar'].'" align="left" />
                                    <div id="'.$value['id'].'" class="ccaption">
                                        <span>'.$value['lname'].' "'.$value['nick'].'" '.$value['name'].'</span>
                                    </div>
                                    <div class="ccontent">'.$value['caption'].'</div>
                                </a>
                            </li>';
                        }
                    }
                    $result .= '</ul>
                    </div>';
                }else{
                    if(count($pages) != 0){
                        foreach($pages as $key => $value){
                            $result .= '<div class="caption">'.
                            $value['lname'].' "'.$value['nick'].'" '.$value['name'].' - '.$value['caption'].'
                        </div>
                        <div class="content">'.
                            $value['content'].'
                        </div>';
                        }
                    }
                }
                break;
            case 'fests':
                break;
            case 'members':
                if(!isset($pID) || $pID == ''){
                    $result .= '<div class="caption">Состав</div>'.
                               '<div class="content">';

                    foreach($pages as $key => $value){
                        $result .= '<div id="members'.$value['id'].'" class="member">
                            <a href="/members.php?q='.$value['id'].'" >
                                <img class="ava" src="'.$value['avatar'].'" align="top" />
                                <div id="'.$value['id'].'" class="mcaption">
                                    <span>'.$value['lname'].' "'.$value['nick'].'" '.$value['name'].'</span>
                                </div>
                            </a>
                        </div>';
                    }
                    $result .= '</div>';
                }else{
                    foreach($pages as $key => $value){
                        $result .= '<div class="caption">'.
                            $value['lname'].' "'.$value['nick'].'" '.$value['name']
                        .'</div>
                        <div class="content">
                            <img class="ava" src="'.$value['avatar'].'" align="left" />
                            <ul class="subcont">
                                <li>Состоит в КИР "Яро Пламя" с '.$value['succdate'].'.</li>
                                <li>Имеет звание "'.$value['rank'].'".</li>
                                <li>Подопечные:<br />
                                    <div>'.$value['people'].'</div></li>
                                <li>Мероприятия, в которых принимал участие:<br />
                                    <div>'.$value['fests'].'</li>
                            </ul>
                        </div>';
                    }
                }
                break;
            case 'news':
                $result .= '<div class="caption">Новости</div>'.
                    '<div class="content">
                    <ul class="news">';
                    foreach($pages as $key => $value){
                        $result .= '<li id="news'.$value['id'].'">
                            <div  id="'.$value['id'].'" class="ncaption">'.$value['caption'].'<a href="/news.php?q='.$value['id'].'" >URL</a></div>
                            <div class="ncontent">'.$value['content'].'</div>
                            <div class="nnick">'.$value['nick'].'</div>
                            <div class="ndate">'.$value['date'].'</div>
                        </li>';
                    }
                $result .= '</ul>
                    </div>';
                break;
            case 'sources':
                break;
            case 'works':
                break;
            default:
                foreach($pages as $key => $value){
                    $result .= '<div class="caption">'.$value['caption'].'</div>
                          <div class="content">'.$value['content'].'</div>';
                }
                break;
        }
        $result .= '</td></tr>';
        return $result;
    }

    // Отправка запроса в БД и разбор массива данных
    public function getPage($page = '', $pID = ''){
        $params = $this->queryArray($page, $pID);

        $pages_query = db_select($params['table'],
                                 $params['fields'],
                                 $params['where'],
                                 $params['order']);

        $pages = array();
        while($arr_pages = mysql_fetch_array($pages_query, MYSQL_ASSOC)){
            foreach($arr_pages as $key => $value){
                $pages[$arr_pages['id']][$key] = htmlspecialchars_decode($value);
            }
        }
        return $this->pageOutput($page, $pID, $pages);
    }

    // Запись страницы в базу
    public function setPage($page = '', $param){
        return 0;
    }
}
