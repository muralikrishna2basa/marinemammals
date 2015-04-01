<?php


class Resize
{
	public $isError = false;
	
	public $errormessage;
	
	protected $targetwidth = 80;
	
	protected $targetheight = 60;
	
	protected $targetfolder;
	
	protected $filename;
	
	protected $sourcefolder;
	
	protected $allowedext;
	
	protected $resizedfiles = array();
	
	public function __construct($sourcefolder,$targetfolder)
	{
		umask(0);
		if(is_dir($sourcefolder) || mkdir($sourcefolder, 0777)){ $this->sourcefolder = $sourcefolder;} // attempt to create the source folder if not existing
		else 
		{		
				$this->isError = true;
				$this->errormessage = "source folder not a directory";
				
		}		
		if(is_dir($targetfolder) || mkdir($targetfolder, 0777)){ $this->targetfolder = $targetfolder;}
		else 
		{
			$this->isError = true;
			$this->errormessage = "target folder not a directory";
		}
		
		$this->allowedext = array('JPG','GIF','PNG','BMP','JPEG');
	}
	public function setImageSize($width,$height)
	{
		if(is_int($width) && $width >0){ $this->targetwidth = $width;}
		if(is_int($height) && $height >0){ $this->targetheight = $height;}
		
	}
	/**
	 * Resize array of images based on a set of valid input files
	 *
	 * @param string or array $filenames
	 * @return void
	 */
	public function resizeImg($filenames)
	{
		// check that there is no a priori error
		if($this->isError){ return false;}
		
		if(is_string($filenames)){ $filenames = array($filenames);}
		
		if(!is_array($filenames))
		{ 
			$this->isError = true;$this->errormessage = "wrong input format";return false;
		}
		
		foreach($filenames as $filename)
		{
		
		if(!is_file($this->sourcefolder.$filename) || !file_exists($this->sourcefolder.$filename))
		{
			$this->resizedfiles[] = array('name'=>$filename,'isResized'=>false,'message'=>'not a file');
			continue;
		}
			
		if(in_array(strtoupper($this->getExt($filename)),$this->allowedext))
		{
			$image = $this->createImage($filename);
			if(!$image)
			{
				$this->resizedfiles[] = array('name'=>$filename,'isResized'=>false,'message'=>'Image couldn\'t be created');
				continue;
			}	
			else 
			{
							// get Image size
				$width  = imagesx($image);
				$height = imagesy($image);
				$imgratio = ($width/$height);
				// trick to preserve image ratio
				if($imgratio >1) // if width > height
				{
					$new_width = $this->targetwidth;
					$new_heigth = ($this->targetwidth/$imgratio);
				}
				else 
				{
					$new_heigth = $this->targetheight;
					$new_width = ($this->targetheight*$imgratio);
				}
							
				$new_image = imagecreatetruecolor($new_width,$new_heigth);
				ImageCopyResized($new_image, $image,0,0,0,0, $new_width, $new_heigth, $width, $height);
				$this->WriteImage($new_image,$this->targetfolder.$filename);
				ImageDestroy($new_image);
       			ImageDestroy($image);
       			$this->resizedfiles[] = array('name'=>$filename,'isResized'=>true,'message'=>'Image Resized with success');
				continue; 
			}
		}
		
		}
	}
	/**
	 * Resize directory  
	 *
	 * @return void
	 */
	public function resizeDirImages()
	{
		// check that there is no a priori error
		if($this->isError){ return false;}
		
		// open source directory and loop trough files in it
		if($handle = opendir($this->sourcefolder))
		{
			while(false !== ($file = readdir($handle)))
			{
				
				if($file!='.' && $file!='..')
				{
					$fileext = $this->getExt($file);
					
					// if its a valid extension
					if(in_array(strtoupper($fileext),$this->allowedext))
					{
						$this->resizeImg($file);
					}
				}
			}
			
		}
		else 
		{
			$this->isError = true;
			$this->errormessage = "not able to open source directory";
			return false;
		}
		closedir($handle); 
		
	}
	/**
	 * get Resized files
	 * @return array of resized with success files
	 *
	 */
	public function getResizedFiles()
	{
		$tmp = array();
		
		if(count($this->resizedfiles) == 0){ return $tmp;}
		
		foreach($this->resizedfiles as $rsfile)
		{
			if($rsfile['isResized'] == true)
			{
			 	$tmp[] = $rsfile['name'];	
			}
		}
		return $tmp;
		
	}
	/**
	 * get Non resized files
	 *
	 * @return array
	 */
	public function getNonResizedFiles()
	{
		$tmp = array();
		
		if(count($this->resizedfiles) == 0){ return $tmp;}
		
		foreach($this->resizedfiles as $rsfile)
		{
			if($rsfile['isResized'] == false)
			{
			 	$tmp[] = $rsfile['name'];	
			}
		}
		return $tmp;
	}
	/**
	 * Get File Extension
	 *
	 * @param string $filename
	 * @return string
	 */
	protected function getExt($filename)
	{
		$file = explode('.',$filename);
		
	    return end($file);
	}
	/**
	 * Write the image to it's target directory. 
	 *
	 * @param string $image
	 * @param string $dest
	 * @return void
	 */
	protected function WriteImage($image,$dest)
	{
		$ext = strtoupper($this->getExt($dest));
		switch ($ext)
		{
			case 'JPEG':case 'JPG':
				 imagejpeg($image,$dest);break;
			case 'PNG':
				imagepng($image,$dest);break;
			case 'GIF':
				imagegif($image,$dest);break;
		}
		
		return false;		
	}
	/**
	 * Create the image based on a valid filename
	 *
	 * @param string $filename
	 * @return same as imagecreatefrom
	 */
	protected function createImage($filename)
	{
		
		$ext = strtoupper($this->getExt($filename));
		switch ($ext)
		{
			case 'JPEG':case 'JPG':
				return imagecreatefromjpeg($this->sourcefolder.$filename);
			case 'PNG':
				return imagecreatefrompng($this->sourcefolder.$filename);
			case 'GIF':
				return imagecreatefromgif($this->sourcefolder.$filename);
		}
		
		return false;
	}

}
?>