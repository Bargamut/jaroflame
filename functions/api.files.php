<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Bargamut
 * Date: 29.12.11
 * Time: 22:28
 * To change this template use File | Settings | File Templates.
 */

class Files{
    private $msg = array(); // Сообщение
    private $fileElementName = 'file';

    /** Проверка на ошибки при загрузке
     * @param $arg
     * @return string
     */
    private function onError($arg){
        switch($arg){
            case '1':$result = 'Размер загружаемого файла больше upload_max_filesize = '.ini_get('upload_max_filesize').' в php.ini';break;
            case '2':$result = 'Размер загружаемого файла превысил MAX_FILE_SIZE, указанных в форме HTML';break;
            case '3':$result = 'Файл был загружен лишь частично';break;
            case '4':$result = 'Файл не был загружен';break;
            case '6':$result = 'Отсутствует временная папка';break;
            case '7':$result = 'Не удалось записать файл на диск';break;
            case '8':$result = 'Загрузка файла остановлена по расширению';break;
            case '999':$result = 'Загрузка файла: ERROR_999';break;
            default:$result = 'Загрузка файла:Нет кода ошибки';
        }
        return $result;
    }

    /** Мультизагрузка файлов через AJAX
     * @param string $path
     */
    private function multiaxajupload($path = '/unsorted'){
        $root = $_SERVER['DOCUMENT_ROOT'];
        $raw_post = $GLOBALS['HTTP_RAW_POST_DATA'];
        $tmpfname = tempnam($root."/uploads", "php");

        $handle = fopen($tmpfname, "w");
        fwrite($handle, $raw_post);
        fclose($handle);

        $upl_dir = $root.$path.DIRECTORY_SEPARATOR; // Папка для загрузки

        //print_r($HTTP_RAW_POST_DATA);
        if (isset($_GET['qqfile'])){
            $upl_file = $_GET['qqfile'];
            $upl_file_tmp = $tmpfname;
            $fileSize = @filesize($upl_file_tmp);
        } elseif (isset($_FILES[$this->fileElementName])){
            $upl_file = $_FILES[$this->fileElementName]['name']; // Имя файла
            $upl_file_tmp = $_FILES[$this->fileElementName]['tmp_name']; // Имя временного файла
            $fileSize = @filesize($upl_file_tmp);
        } else {
            die ('{error: "server-error file not passed"}');
        }

        // Если есть ошибки
        if(!empty($_FILES[$this->fileElementName]['error'])){
            $this->onError($_FILES[$this->fileElementName]['error']);
        }elseif(empty($upl_file_tmp)||$upl_file_tmp=='none'){
            $this->msg['error'] = 'Файл не был загружен..';
        }else{
            // Если определено имя файла
            if($_GET['name']){
                $ext = explode('.',$upl_file);
                $name_arr = explode('.',$_GET['name']);
                switch($name_arr[count($name_arr)-1]){
                    case 'png':$upl_file = $_GET['name'];break;
                    case 'jpg':$upl_file = $_GET['name'];break;
                    case 'jpeg':$upl_file = $_GET['name'];break;
                    case 'gif':$upl_file = $_GET['name'];break;
                    default:$upl_file = $_GET['name'].'.'.$ext[count($ext)-1];break;
                }
            }

            // Перенос в папки
            if(rename($upl_file_tmp, $upl_dir.basename($upl_file))){
                $this->msg['status'] = "Файл верный и успешно загружен.";
                chmod($upl_dir.basename($upl_file), 0644);

                $this->msg['success'] = 'true';
            }else{
                $this->msg['status'] = "Thumb: Возможная атака!".'\n'.
                    $upl_file_tmp.'\n'.
                    $upl_dir.basename($upl_file).'\n';
                $this->msg['success'] = 'false';
            }

            // Из соображений безопасности, мы удаляем все загруженные файлы
            @unlink($_FILES[$this->fileElementName]);
            @unlink($tmpfname);
        }

        // Отладочная инфа
        $this->msg['msg'] = $this->msg;
        $this->msg['name'] = $upl_file;
        $this->msg['name_tmp'] = $upl_file_tmp;
        $this->msg['fsize'] = $fileSize;
        $this->msg['faddr'] = $path.DIRECTORY_SEPARATOR.basename($upl_file);
        $this->msg['faddr_thumb'] = $path.DIRECTORY_SEPARATOR.'thumb'.DIRECTORY_SEPARATOR.basename($upl_file);
        return $this->msg;
    }

    public function upload_file($path = '/unsorted'){
        return $this->multiaxajupload($path);
    }
}