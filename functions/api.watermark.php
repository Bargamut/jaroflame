<?php
class watermark{ 
	/** функция, которая сливает два исходных изображения в одно
	$main_img_obj - исходное изображение, на которое нужно поставить водяной знак
	$watermark_img_obj - сам водяной знак, должен содержать альфа-канал
	$alpha_level - значение прозрачности альфа-канала водяного знака, (0-100, по умолчнию = 100)*/
	function create_watermark($main_img_src, $watermark_img_src, $alpha_level = 100){
		if (!file_exists($main_img_src)) return false;
		$size = getimagesize($main_img_src);
		if ($size === false) return false;
		
		// Определяем исходный формат по MIME-информации, предоставленной
		// функцией getimagesize, и выбираем соответствующую формату
		// imagecreatefrom-функцию.
		$format = strtolower(substr($size['mime'], strpos($size['mime'], '/')+1));
		$icfunc = "imagecreatefrom".$format;
		if (!function_exists($icfunc)) return false;
		
		/*$x_ratio = $width / $size[0];
		$y_ratio = $height / $size[1];
		
		$ratio = min($x_ratio, $y_ratio);
		$use_x_ratio = ($x_ratio == $ratio);
		
		$new_width = $use_x_ratio ? $width : floor($size[0] * $ratio);
		$new_height = !$use_x_ratio ? $height : floor($size[1] * $ratio);
		$new_left = $use_x_ratio ? 0 : floor(($width - $new_width) / 2);
		$new_top = !$use_x_ratio ? 0 : floor(($height - $new_height) / 2);*/
		
		$main_img_obj = $icfunc($main_img_src);
		$watermark_img_obj = imagecreatefrompng($watermark_img_src);
		
		//------------------------------------------------------------------
		# переводим значение прозрачности альфа-канала из % в десятки
		$alpha_level/= 100; 
		
		# расчет размеров изображения (ширина и высота)
		$main_img_obj_w = imagesx( $main_img_obj );
		$main_img_obj_h = imagesy( $main_img_obj );
		$watermark_img_obj_w = imagesx( $watermark_img_obj );
		$watermark_img_obj_h = imagesy( $watermark_img_obj );
		
		
		# создание нового watermark
		$rgb=0xFFFFFF;
		$watermark_temp_h = floor($main_img_obj_h*0.3);
		$watermark_temp_w = floor($watermark_img_obj_w*($watermark_temp_h/$watermark_img_obj_h));
		
		$watermark_temp = imagecreatetruecolor($watermark_temp_w, $watermark_temp_h);
		imagecolortransparent($watermark_temp,$rgb);
		imagealphablending($watermark_temp,0);
		imagesavealpha($watermark_temp,1);
		
		$trasparent = imagecolorallocatealpha($watermark_temp,255,255,255,127);
		imagefilledrectangle($watermark_temp, 0, 0, $watermark_temp_w, $watermark_temp_h, $trasparent);
		
		imagecopyresampled($watermark_temp, $watermark_img_obj,
						   0, 0,
						   0, 0,
						   $watermark_temp_w, $watermark_temp_h,
						   $watermark_img_obj_w, $watermark_img_obj_h);
		
		# определение координат центра изображения
		/*$main_img_obj_min_x=floor(($main_img_obj_w/2)-($watermark_img_obj_w/2));
		$main_img_obj_max_x=ceil(($main_img_obj_w/2)+($watermark_img_obj_w/2));
		$main_img_obj_min_y=floor(($main_img_obj_h/2)-($watermark_img_obj_h/2));
		$main_img_obj_max_y=ceil(($main_img_obj_h/2)+($watermark_img_obj_h/2));*/ 
		
		# определение координат правого края изображения
		$main_img_obj_min_x=floor($main_img_obj_w-$watermark_temp_w);
		$main_img_obj_max_x=ceil($main_img_obj_w+$watermark_temp_w);
		$main_img_obj_min_y=floor($main_img_obj_h-$watermark_temp_h);
		$main_img_obj_max_y=ceil($main_img_obj_h+$watermark_temp_h);
		
		# создание нового изображения
		$return_img = imagecreatetruecolor( $main_img_obj_w, $main_img_obj_h );
		
		# пройдемся по изображению
		for( $y = 0; $y < $main_img_obj_h; $y++ ){
			for ($x = 0; $x < $main_img_obj_w; $x++ ){
				$return_color = NULL;
		
				# определение истинного расположения пикселя в пределах
				# нашего водяного знака
				$watermark_x = $x - $main_img_obj_min_x;
				$watermark_y = $y - $main_img_obj_min_y;
		
				# выбор информации о цвете для наших изображений
				$main_rgb = imagecolorsforindex( $main_img_obj,
										 imagecolorat( $main_img_obj, $x, $y ) );
		
				# если наш пиксель водяного знака непрозрачный 
				if ($watermark_x >= 0 && $watermark_x < $watermark_temp_w &&
					$watermark_y >= 0 && $watermark_y < $watermark_temp_h ){
						$watermark_rbg = imagecolorsforindex( $watermark_temp,
										 imagecolorat( $watermark_temp,
													   $watermark_x,
													   $watermark_y ) );
		
					# использование значения прозрачности альфа-канала
					$watermark_alpha = round(((127-$watermark_rbg['alpha'])/127),2);
					$watermark_alpha = $watermark_alpha * $alpha_level;
		
					# расчет цвета в месте наложения картинок
					$avg_red = $this->_get_ave_color( $main_rgb['red'],
							   $watermark_rbg['red'], $watermark_alpha );
					$avg_green = $this->_get_ave_color( $main_rgb['green'],
								 $watermark_rbg['green'], $watermark_alpha );
					$avg_blue = $this->_get_ave_color( $main_rgb['blue'],
								$watermark_rbg['blue'], $watermark_alpha );
			
					# используя полученные данные, вычисляем индекс цвета
					$return_color = $this->_get_image_color(
									$return_img, $avg_red, $avg_green, $avg_blue );
		
					# если же не получиться выбрать цвет, то просто возьмем
					# копию исходного пикселя 
				} else { $return_color = imagecolorat( $main_img_obj, $x, $y ); } 
				# из полученных пикселей рисуем новое изображение
				imagesetpixel($return_img, $x, $y, $return_color );
			}
		}
		# если сохранение включено - сохраняем на сервер
		if($save = 'save'){
			switch ($format){
				case 'jpeg':imagejpeg($return_img, $main_img_src, 100);break;
				case 'png':imagepng($return_img, $main_img_src);break;
				case 'gif':imagegif($return_img, $main_img_src);break;
			}
			imagedestroy($return_img);
			return 'saved';
		}else{# при отключённом сохранении
			# отображаем изображение с водяным знаком
			return $return_img;
		}
	} # конец функции create_watermark()
	
	# усреднение двух цветов с учетом прозрачности альфа-канала
	function _get_ave_color($color_a, $color_b, $alpha_level){
		return round((($color_a*(1-$alpha_level))+($color_b*$alpha_level))); 
	}
	
	# возвращаем значения ближайших RGB-составляющих нового рисунка
	function _get_image_color($im, $r, $g, $b){
		$c=imagecolorexact($im, $r, $g, $b);
		if ($c!=-1) return $c;
		$c=imagecolorallocate($im, $r, $g, $b);
		if ($c!=-1) return $c;
		return imagecolorclosest($im, $r, $g, $b);
	}
} 
?> 