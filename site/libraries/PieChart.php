<?php
class PieChart {
	protected $image;
	protected $dataSets
	
	public function __construct() {
	
	}
	
	public function addDataSet($percent, $name = null, $color = null) {
		$this->dataSets = array(
			'percent' => $percent,
			'name' => $name,
			'color' => $color
		);
	}
	
	public function render($width, $height) {
		$this->createImage($width, $height);
		
		$startAngle = 0;
		$centerx = ($width / 2);
		$centery = ($width / 2);
		
		foreach($this->dataSets as $ds) {
			if(!array_key_exists('percent', $ds))
				return;
			
			$color = $this->getRandomColor();
			$name = "";
			$percent = $ds['percent'] / 100;
			
			if($ds['color'] != null)
				$color = $this->convertColor($ds['color']);
			if($ds['name'] != null)
				$name = $ds['name'];
			
			$angle = (360 * $percent);
			$endAngle = ($startAngle + $angle);
			
			imagefilledarc($this->image, $centerx, $centery, 50, 50, $startAngle, $endAngle, $color, IMG_ARC_PIE);
			$startAngle += $angle;
		}
		
		imagepng($this->image, null);
		imagedestroy($this->image);
	}
	
	protected function createImage($width, $height) {
		$this->image = imagecreatetruecolor($width, $height);
		imageantialias($this->image, true);
	}
	
	protected function getRandomColor() {
		$r = mt_rand(75, 200);
		$g = mt_rand(75, 200);
		$b = mt_rand(75, 200);
		
		$color = imagecolorallocate($this->image, $r, $g, $b);
		return $color;
	}
	
	protected function convertColor($color) {
		if(is_numeric($color) && $color >= 0)
			return $color;
		else if(is_array($color) && count($color) >= 3) {
			if(count($color) == 3)
				return imagecolorallocate($this->image, $color[0], $color[1], $color[2]);
			else if(count($color) == 4)
				return imagecolorallocatealpha($this->image, $color[0], $color[1], $color[2], $color[3]);
		}
		else if(is_string($color) && !is_numeric($color)) {
			//Do nothing for now.
		}
		return null;
	}
}
?>