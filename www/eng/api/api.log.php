<?php
/**
 * User: Bargamut
 * Date: 15.07.12
 * Time: 22:46
 */

/**
 * Class JF_Log
 */
class JF_Log {
    private $db_instance;
    private $conf;

    public function __construct() {
        if      (func_num_args() == 1) { $this->db_instance = func_get_arg(0); }
        elseif  (func_num_args() == 2) {
            $this->db_instance  = func_get_arg(0);
            $this->conf         = func_get_arg(1);
        }
    }

    //Log::write('message', 'file');
    public function writeLog() {
        $this->write();
    }

    private function write ($mess = '', $fname = 'main'){
        if (strlen(trim($mess)) > 2 && preg_match("/^([_a-z0-9A-Z]+)$/i", $fname, $matches)) {
            $file_path  = $_SERVER['DOCUMENT_ROOT'] . 'logs/' . $fname . '.txt';
            $text       = htmlspecialchars($mess) . "\r\n";
            $handle     = fopen($file_path, "a");

            @flock ($handle, LOCK_EX);
            fwrite ($handle, $text);
            fwrite ($handle, "==============================================================\r\n\r\n");
            @flock ($handle, LOCK_UN);
            fclose ($handle);

            return true;
        } else {
            return false;
        }
    }
}

/**
 * Запись в БД
 *
 * @param $msg
 * @param $type
 *
 * @return array
 */
function writeBySql($msg, $type) {
    if (($this->db_instance instanceof MySQL) == false) {
        return array(
            'status'    => false,
            'message'   => 'Некорректное подключение к БД'
        );
    }

    if (preg_replace('/\s*/i', '', $msg) == '') {
        return array(
            'status'    => false,
            'message'   => 'Message is empty'
        );
    }

    if (($remote_addr = $_SERVER['REMOTE_ADDR']) == '') { $remote_addr = "REMOTE_ADDR_UNKNOWN"; }
    if (($request_uri = $_SERVER['REQUEST_URI']) == '') { $request_uri = "REQUEST_URI_UNKNOWN"; }

    $result = $this->db_instance->query('INSERT INTO site_log (remote_addr, request_uri, message) VALUES (%s, %s, %s, %s)', array($type, $remote_addr, $request_uri, $msg));

    if ($result) {
        return array('status' => true);
    } else {
        return array('status' => false, 'message' => 'Ошибка записи в БД');
    }
}