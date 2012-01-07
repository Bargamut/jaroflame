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
                /*if(!isset($pID) || $pID == ''){*/
                    $result .= '<div class="caption">Паспорта<img class="add" src="img/default/add.png" align="right" title="Создать" /></div>'.
                               '<div class="content">
                                    <ul class="cards">';

                    if(count($pages) != 0){
                        foreach($pages as $key => $value){
                            $result .= '<li id="cards'.$value['id'].'">
                                <img class="ava" src="/img/cards/test/thumb/'.$value['avatar'].'" align="left" />
                                <div id="'.$value['id'].'" class="ccaption">
                                    <span>'.$value['lname'].' "'.$value['nick'].'" '.$value['name'].'</span>
                                    <img class="del" src="img/default/del.png" align="right" title="Удалить" />
                                    <img class="edit" src="img/default/edit.png" align="right" title="Редактировать" />
                                </div>
                                <div class="ccontent">'.$value['caption'].'</div>
                            </li>';
                        }
                    }
                    $result .= '</ul>
                    </div>';
                /*}else{
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
                }*/
                break;
            case 'fests':
                break;
            case 'members':
                /*if(!isset($pID) || $pID == ''){*/
                    $result .= '<div class="caption">Состав<img class="add" src="img/default/add.png" align="right" title="Создать" /></div>'.
                               '<div class="content">';

                    foreach($pages as $key => $value){
                        $result .= '<div id="members'.$value['id'].'" class="member">
                            <img class="ava" src="'.$value['avatar'].'" align="top" />
                            <div id="'.$value['id'].'" class="mcaption">
                                <span>'.$value['lname'].' "'.$value['nick'].'" '.$value['name'].'</span>
                                <img class="del" src="img/default/del.png" align="right" title="Удалить" />
                                <img class="edit" src="img/default/edit.png" align="right" title="Редактировать" />
                            </div>
                        </div>';
                    }
                    $result .= '</div>';
                /*}else{
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
                }*/
                break;
            case 'news':
                $result .= '<div class="caption">Новости<img class="add" src="img/default/add.png" align="right" title="Создать" /></div>'.
                    '<div class="content">
                    <ul class="news">';
                    foreach($pages as $key => $value){
                        $result .= '<li id="news'.$value['id'].'">
                            <div  id="'.$value['id'].'" class="ncaption">
                                <span>'.$value['caption'].'</span>
                                <img class="del" src="img/default/del.png" align="right" title="Удалить" />
                                <img class="edit" src="img/default/edit.png" align="right" title="Редактировать" />
                            </div>
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

    /** Отправка запроса в БД и разбор массива данных
      * @param string $page
      * @param string $pID
      * @param int $edit
      * @return array|string
      */
    public function getPage($page = '', $pID = '', $edit = 0){
        $params = $this->queryArray($page, $pID);

        $pages_query = db_select($params['table'],
                                 $params['fields'],
                                 $params['where'],
                                 $params['order']);

        while($arr_pages = mysql_fetch_array($pages_query, MYSQL_ASSOC)){
            foreach($arr_pages as $key => $value){
                $pages[$arr_pages['id']][$key] = htmlspecialchars_decode($value);
                $p = $arr_pages['id']; // если запрос на редактирование
            }
        }

        // если флаг редактирования включён
        if ($edit != 0 && $pID != ''){
            return $pages[$p];
        } else {
            return $this->setSpoiler($this->pageOutput($page, $pID, $pages));
        }
    }

    /** Отправка данных в БД на запись/удаление
      * @param string $page
      * @param string $action
      * @param array $params
      * @return string
      */
    public function setPage($page = '', $action = '', $params = array()){
        $fields = '`'.implode('`,`', array_keys($params['insert'])).'`'; // поля
        $values = "'".implode("','", array_values($params['insert']))."'"; // значения
        foreach($params['update'] as $key => $value){
            $u[] = '`'.$key.'` = "'.$value.'"';
        }
        $upload = implode(',',$u); // "поле = значение" для обновления
        $where = '`'.implode('` = "', $params['where']).'"'; // условие
        $pID = $params['where'][1];

        switch($action){
            case 'insert':
                db_insert($page,$fields,$values);

                $data_query = db_select($page,'max(`id`) as `id`','no');
                while($arr_data = mysql_fetch_array($data_query,MYSQL_ASSOC)){
                    foreach($arr_data as $value){
                        $pID = $value;
                    }
                }
                $result = "{resp:'Создание завершено!',del:'Запись удалена!',id:'".$pID."'}";
                break;
            case 'update':
                db_update($page,$upload,$where);
                $result = "{resp:'Обновление завершено!',del:'Запись удалена!',id:'".$pID."'}";
                break;
            case 'delete':
                db_delete($page,$where);
                $result = "{resp:'Удаление завершено!',del:'Запись удалена!',id:''}";
                break;
            default:
                $result = "{resp:'Нет подходящего задания!',del:'Запись удалена!',id:''}";
                break;
        }
        return $result;
    }

    /** Spoiler
     * @param string $text
     * @return mixed
     */
    private function setSpoiler($text = ''){
        $rep_arr = array(
            'search' => array(
                '[MORE="',
                '"]',
                '[/MORE]'
            ),
            'replace' => array(
                '<div class="spoil"><div class="spoil_capt"><b>',
                '</b></div><div class="spoil_cont">',
                '</div></div>'
            )
        );
        return str_replace($rep_arr['search'], $rep_arr['replace'], $text);
    }
}
