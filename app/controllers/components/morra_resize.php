<?php
App::import('Component', 'JqImgcrop');
	/**
	*	Title:
	*		Image Resizing component
	*
	*	Description:
	*		Handle image cropping or scaling option.
	*
	**/
class MorraResizeComponent extends JqImgcropComponent {
	/**
	 * Resize / cropping Image
	 * @param string $src contains location address of source image file
	 * @param string $dst contains location address of image file will be created / resized
	 * @return void
	 * @public
	 **/
    public function resize($src, $dest, $type, $targetX = NULL , $targetY = NULL){
        $w=parent::getWidth($src);
        $h=parent::getHeight($src);

        $x1=0;
        $y1=0;
        $x2=$w;
        $y2=$h;
        $crop_widht=$x2-$x1;
        $crop_height=$y2-$y1;
        //var_dump($x2,$y2);

        // if($w>$h){
            // $margin=($w-$h)/2;
            // $x1=$margin;
            // $x2=$x1+$h;
            // $crop_widht=$x2-$x1;
        // }elseif($w<$h){
            // $margin=($w-$h)/2;
            // $y1=$margin;
            // $y2=$y1+$w;
            // $crop_height=$y2-$y1;
        // }

		$cropX = 0;
		$cropY = 0;
		$scale = 0;

		if($targetX != NULL)
		{
			if($w > $targetX && $h > $targetY){
				$tempScaleX = $targetX * 1.0 / $w;
				$tempScaleY = $targetY * 1.0 / $h;
				$scale = ($tempScaleX < $tempScaleY) ? $tempScaleX : $tempScaleY;

			}
			else if($h > $targetY){
				$scale = $targetY * 1.0 / $h;
			}
			else if($w > $targetX){
				$scale = $targetX * 1.0 / $w;
			}
			else{
				$scale = 1;
			}
			parent::resizeImage(WWW_ROOT.str_replace("/", DS,$src),$w,$h,$scale , WWW_ROOT.str_replace("/", DS,$dest));
		}
		else
		{
			if ($type == 'selected')
			{
				if($w>$h){
					$margin=($w-$h)/2;
					$x1 = $margin;
					$crop_widht = $crop_height;
				}elseif($w<$h){
					$margin=($h-$w)/2;
					$y1 = $margin;
					$crop_height = $crop_widht;
				}

				$cropX = 208;
				$cropY = 156;
			}
			else
			if ($type == 'zoom' or $type == 'people' or $type == 'awards')
			{
				if($w>$h){
					$margin=($w-$h)/2;
					$x1=$margin;
					$crop_widht=$crop_height;
					$crop_height=$crop_widht/2;
				}elseif($w<$h){
					$margin=($h-$w)/2;
					$y1 = $margin;
					$crop_height=$crop_widht/2;
				}
				$cropX = 200;
				$cropY = 100;
			}
			else
			// if ($type == 'biasa')
			{
				if($w>$h){
					$margin=($w-$h)/2;
					$x1 = $margin;
					$crop_widht = $crop_height;
				}elseif($w<$h){
					$margin=($h-$w)/2;
					$y1 = $margin;
					$crop_height = $crop_widht;
				}

				$cropX = 250;
				$cropY = 250;
			}
		}

		parent::cropImage($cropX,$cropY,$x1,$y1,$x2,$y2,$crop_widht,$crop_height,$dest,$src);

		// if ($type == 'selected')
		// {
			// parent::cropImage(100,300,$x1,$y1,$x2,$y2,$crop_widht,$crop_height,$dest,$src);
		// }
		// else
		// if ($type == 'zoom' or $type == 'people' or $type == 'awards')
		// {
			// parent::cropImage(200,100,$x1,$y1,$x2,$y2,$crop_widht,$crop_height,$dest,$src);
		// }
		// else
		// {
			// parent::cropImage(200,200,$x1,$y1,$x2,$y2,$crop_widht,$crop_height,$dest,$src);
		// }

    }
}
?>