<?php
class Images{
    /**
     * @desc Функция img_resize(): генерация thumbnails
     * @param $src - имя исходного файла
     * @param $dest - имя генерируемого файла
     * @param $width - ширина генерируемого изображения, в пикселях
     * @param $height - высота генерируемого изображения, в пикселях
    Необязательные параметры:
     * @param int $rgb - цвет фона, по умолчанию - белый
     * @param int $quality - качество генерируемого JPEG, по умолчанию - максимальное (100)
     * @return bool
     */
    private function imgage_resize($src, $dest, $width, $height, $rgb=0xFFFFFF, $quality=100){
        $root = $_SERVER['DOCUMENT_ROOT'];
        $src = $root.$src;
        $dest = $root.$dest;

        if (!file_exists($src)) return false;

        $size = getimagesize($src);

        if ($size === false) return false;

        // Определяем исходный формат по MIME-информации, предоставленной
        // функцией getimagesize, и выбираем соответствующую формату
        // imagecreatefrom-функцию.
        $format = strtolower(substr($size['mime'], strpos($size['mime'], '/')+1));
        $icfunc = "imagecreatefrom".$format;
        if (!function_exists($icfunc)) return false;

        $x_ratio = $width / $size[0];
        $y_ratio = $height / $size[1];

        $ratio = min($x_ratio, $y_ratio);
        $use_x_ratio = ($x_ratio == $ratio);

        $new_width = $use_x_ratio ? $width : floor($size[0] * $ratio);
        $new_height = !$use_x_ratio ? $height : floor($size[1] * $ratio);
        $new_left = $use_x_ratio ? 0 : floor(($width - $new_width) / 2);
        $new_top = !$use_x_ratio ? 0 : floor(($height - $new_height) / 2);

        $isrc = $icfunc($src);
        $idest = imagecreatetruecolor($width, $height);
        imagecolortransparent($idest,$rgb);
        imagealphablending($idest,0);
        imagesavealpha($idest,1);

        $trasparent = imagecolorallocatealpha($idest,255,255,255,127);
        imagefilledrectangle($idest, 0, 0, $width, $height, $trasparent);

        imagecopyresampled($idest, $isrc, $new_left, $new_top, 0, 0, $new_width, $new_height, $size[0], $size[1]);
        switch ($format){
            case 'jpeg':
                imagejpeg($idest, $dest, $quality);
                break;
            case 'png':
                imagepng($idest, $dest);
                break;
            case 'gif':
                imagegif($idest, $dest);
                break;
        }
        imagedestroy($isrc);
        imagedestroy($idest);
        return true;
    }

    private function imgage_crop($src, $dest, $top, $left, $width, $height, $rgb=0xFFFFFF, $quality=100){
        $root = $_SERVER['DOCUMENT_ROOT'];
        $src = $root.$src;
        $dest = $root.$dest;

        if (!file_exists($src)) return false;

        $size = getimagesize($src);

        if ($size === false) return false;

        // Определяем исходный формат по MIME-информации, предоставленной
        // функцией getimagesize, и выбираем соответствующую формату
        // imagecreatefrom-функцию.
        $format = strtolower(substr($size['mime'], strpos($size['mime'], '/')+1));
        $icfunc = "imagecreatefrom".$format;
        if (!function_exists($icfunc)) return false;

        $isrc = $icfunc($src);
        $idest = imagecreatetruecolor($width, $height);
        imagecolortransparent($idest,$rgb);
        imagealphablending($idest,0);
        imagesavealpha($idest,1);

        $trasparent = imagecolorallocatealpha($idest,255,255,255,127);
        imagefilledrectangle($idest, 0, 0, $width, $height, $trasparent);

        imagecopyresampled($idest, $isrc, 0, 0, $left, $top, $width, $height, $width, $height);
        switch ($format){
            case 'jpeg':
                imagejpeg($idest, $dest, $quality);
                break;
            case 'png':
                imagepng($idest, $dest);
                break;
            case 'gif':
                imagegif($idest, $dest);
                break;
        }
        imagedestroy($isrc);
        imagedestroy($idest);
        return true;
    }

    /** Случайный цвет
     * @return string
     */
    public function rand_color(){
        $code=array_merge(range('a','z'),range('0','9'));
        $result='#';
        for($i=0;$i<5;$i++){$result.=$code[array_rand($code)];}
        return $result;
    }

    public function img_resize($src, $dest, $width, $height, $rgb=0xFFFFFF, $quality=100){
        $this->imgage_resize($src, $dest, $width, $height, $rgb, $quality);
    }

    public function img_crop($src, $dest, $top, $left, $width, $height, $rgb=0xFFFFFF, $quality=100){
        $this->imgage_crop($src, $dest, $top, $left, $width, $height, $rgb, $quality);
    }
}
?>