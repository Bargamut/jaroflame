<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Bargamut
 * Date: 12.12.11
 * Time: 11:03
 * To change this template use File | Settings | File Templates.
 */
class output{
    private $pages_query;
    private $params = array('table' => '',
                            'fields' => '',
                            'where' => '',
                            'order' => '',
                            'limit' => '');
    public function getPage($page = '', $pID){
        switch($page){
            case 'awards':
                $params['table'] = 'awards';
                $params['fields'] = '*';
                $params['where'] = '`page` = "'.$page.'"';
                $params['order'] = '`id`';
                break;
            case 'cards':
                $params['table'] = 'cards';
                $params['fields'] = '*';
                (isset($pID) && $pID != '') ? $params['where'] = '`id` = "'.htmlspecialchars($pID).'"' : $params['where'] = 'no';
                $params['order'] = '`id`';
                break;
            case 'fest':
                $params['table'] = 'fest';
                $params['fields'] = '*';
                $params['where'] = '`page` = "'.$page.'"';
                $params['order'] = '`id`';
                break;
            case 'members':
                $params['table'] = 'members';
                $params['fields'] = '*';
                (isset($pID) && $pID != '') ? $params['where'] = '`id` = "'.htmlspecialchars($pID).'"' : $params['where'] = 'no';
                $params['order'] = '`id`';
                break;
            case 'news':
                $params['table'] = 'news';
                $params['fields'] = '*';
                (isset($pID) && $pID != '') ? $params['where'] = '`id` = "'.htmlspecialchars($pID).'"' : $params['where'] = 'no';
                $params['order'] = '`date` desc';
                break;
            case 'source':
                $params['table'] = 'source';
                $params['fields'] = '*';
                $params['where'] = '`page` = "'.$page.'"';
                $params['order'] = '`id`';
                break;
            case 'work':
                $params['table'] = 'work';
                $params['fields'] = '*';
                $params['where'] = '`page` = "'.$page.'"';
                $params['order'] = '`id`';
                break;
            default:
                $pages_query = db_select('pages','*','`page` = "'.$page.'"','`id`');
                break;
        }
        $pages_query = db_select('awards','*','`page` = "'.$page.'"','`id`');
    }
}
