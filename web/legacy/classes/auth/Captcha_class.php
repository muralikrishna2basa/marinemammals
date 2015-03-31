<?php
Class Captcha 
{
	/**
	 * Length of captcha
	 *
	 * @var int
	 */
	protected $length;
	
	/**
	 * Available set of characters and numbers 
	 * used for the captcha
	 * 
	 * @var unknown_type
	 */
	protected $alphabet;
	
	/**
	 * Path to available fonts 
	 *
	 * @var array
	 */
	protected $fonts = array();
	
	/**
	 * Font directory 
	 *
	 * @var string
	 */
	protected $fonts_dir;
	
	/**
	 * Image directory 
	 *
	 * @var string
	 */
	protected $img_dir;
	
	/**
	 * Get all captcha's in the directory
	 *
	 * @var array
	 */
	protected $img_src = array();
	
	/**
	 * Code corresponding to the current capcha
	 *
	 * @var string
	 */
	protected $code;
	
	/**
	 * Complete path to the created image
	 *
	 * @var string
	 */
	protected $filename;
	
	/**
	 * Salt set for encryption
	 *
	 * @var string
	 */
	protected $secret;
	
	/**
	 * Error management : error message
	 *
	 * @var string 
	 */
	public $errormessage;


	/**
	 * Error management : error state
	 *
	 * @var bool
	 */
	public $isError = false;
	
	/**
	 * Image extension
	 *
	 * @var string
	 */
	protected $ext;
	
	/**
	 * Maximum number of images in the image folder
	 *
	 * @var int
	 */
	protected $maximg = 50;
	
	/**
	 * Constructor
	 *
	 * @param Font directory $fonts_dir
	 * @param Image directory $img_dir
	 * @param int $length
	 */
	public function __construct($fonts_dir,$img_dir,$length = false)
	{

		$this->secret = "lapida";
		
		if(is_dir($img_dir))
		{
			$this->img_dir = $img_dir;
			
		}
		else 
		{
			$this->errormessage = "Image directory not found";
			$this->isError = true;
		}
		
		if(is_dir($fonts_dir)) 
		{ 
			$this->fonts_dir = $fonts_dir;
			$this->loadFonts();
		}
		else 
		{
			$this->errormessage = "Font directory not found";
			$this->isError = true;
		}
		
		if(is_int($length) && $length >3)
		{
			$this->length = $length;
		}
		else 
		{
			$this->length = mt_rand(3,10);
		}
		
		$this->alphabet = 'ABCDEFGHJKLMNPQRSTUVWXYZ23456789';
		
		
		$this->loadImages();
		
		$this->ext = ".png";
		
	}
	/**
	 * Delete all images from the image folder
	 *
	 */
	protected function DeleteImages()
	{
		foreach($this->img_src as $todelete)
		{
			if(is_file($todelete)){unlink($todelete);}
		}
	}
	/**
	 * Load the set of images in the image folder
	 *
	 */
	protected function loadImages()
	{
		$dh = opendir($this->img_dir);
		$max = 0;
		while (($file = readdir($dh)) !== false && $max !=100) 
		{
				$max++;
				if($file!='.' && $file!='..'){$this->img_src[] = $this->img_dir.$file;}
		}
		closedir($dh);	
	}
	/**
	 * Set the current salt, to be added in the encryption
	 *
	 * @param string $salt
	 * @return bool
	 */
	public function setSalt($salt)
	{
		if(isset($salt) && is_string($salt) && strlen($salt)>3)
		{
			$this->secret = $salt;
			return true;
		}
		else 
		{
			return false;
		}
	}
	/**
	 * Return current filename
	 *
	 * @return string
	 */
	public function getImage()
	{
			return $this->filename;
	}
	/**
	 * Set Current image name ( including path & ext)
	 *
	 */
	protected function setImageName()
	{
		$this->filename = $this->img_dir.md5($this->secret.$this->code).$this->ext;
	}
	/**
	 * Check captcha validity
	 * Compares the entered encrypted and saled word against the image names of the img_dir folder 
	 * if a correspondance is founded, then it retun true, else it return false
	 * 
	 * @param  string $in
	 * @return bool
	 */
	public function checkCaptcha($in)
	{
		
		$file = $this->img_dir.md5($this->secret.$in).$this->ext;
		
		if(in_array($file,$this->img_src))
		{
			if(is_file($file)){unlink($file);}
			return true;
			
		}
		else 
		{
			return false;
		}
	}
	/**
	 * Load fonts in the class
	 *
	 */
	protected function loadFonts()
	{

		$dh = opendir($this->fonts_dir);
		while (($file = readdir($dh)) !== false) 
		{
				if($file!='.' && $file!='..'){$this->fonts[] = $this->fonts_dir.$file;}
		}
		closedir($dh);
	}
	/**
	 * Add font to the list of current fonts 
	 *
	 * @param unknown_type $font
	 */
	public function addFont($font)
	{
		$this->fonts[] = $font;
	}
	/**
	 * Get the code to be displayed on the screen
	 * It chooses letter and number randomly 
	 * 
	 * 
	 * @return string
	 */
	public function getCode()
	{
		$string = "";
		
		for($i = 0;$i<$this->length;++$i)
		{
			$string .=$this->alphabet[mt_rand(0,strlen($this->alphabet)-1)];
		}
	
		return $string;
	}
	/**
	 * Set Maximal number of images in the image folder
	 *
	 * @param unknown_type $in
	 */
	public function setMaxImg($in)
	{
		if(is_int($in) && $in > 1) { $this->maximg = $in;}
	}
	/**
	 * Create Captcha image and drop it to the image folder
	 *
	 * @return void
	 */
	public function CreateImage()
	{
		// Prevent the number of images to increase indefinitely
		if(count($this->img_src)>$this->maximg){ $this->DeleteImages();}
		
		if($this->isError) { return false;}
		
		$this->code = $this->getCode();
		
		$image = imagecreatetruecolor(30*$this->length,50);
		
		// background image creation
		
		for($i = 0;$i < imagesx($image);++$i)
		{
			for($j =0;$j<imagesy($image);++$j)
			{
				if(mt_rand(1,5) == 4)
				{
					$red = mt_rand(0,100);
					$green = mt_rand(0,100);
					$blue = mt_rand(0,100);
				}
				else 
				{
					$red = mt_rand(100,150);
					$green = mt_rand(100,150);
					$blue = mt_rand(100,150);
				}
				$color = imagecolorallocate($image,$red,$green,$blue);
				imagesetpixel($image,$i,$j,$color);
				imagecolordeallocate($image,$color);		
			}
		}
		$red = mt_rand(0,240);
		$green = mt_rand(0,240);
		$blue = mt_rand(0,240);
		$color = imagecolorallocate($image,$red,$green,$blue);
		imagerectangle($image,0,0,imagesx($image)-1,imagesy($image)-1,$color);
		imagecolordeallocate($image,$color);	
		
		
		
		for($i = 0;$i< $this->length;++$i)
		{
			$red   = mt_rand(150,240);
			$green = mt_rand(150,240);
			$blue  = mt_rand(150,240);
			
			$size = mt_rand(20,30);
			$angle = mt_rand(-10,20);
			$x = 13 + (20 * $i);
			$y  = mt_rand(30,imagesy($image)-10);
			$color = imagecolorallocate($image,$red,$green,$blue);
			$font = $this->fonts[mt_rand(0,count($this->fonts)-1)];
			
			imagettftext($image,$size,$angle,$x,$y,$color,$font,$this->code[$i]);
			imagecolordeallocate($image,$color);	
		}
		$this->setImageName();
		imagepng($image,$this->filename);
	}
	
}

?>