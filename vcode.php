<?php
	/*
		$dir 传入目录结尾不以为“/”。
		$file和$dir
		【文件名】原文件md5.MP4||小型文件为small_源文件md5_.mp4
		$to 为给出的文件【不对其进行任何检查，请自己生成】 [小尺寸]$to.mp4.small.mp4

	*/
	class vcode{
		public $dir;
		public function __construct(){
			$this->dir=dirname(__FILE__);
		}
		public function mp4($file,$to,$type){
			if($this->isfile($file,$to)){
				$this->shellto($file,$to,$type);
			}
		}

		public function vcode($file,$dir,$type=1){//推荐
			if($this->file($file,$dir)){
				$this->shell($file,$dir,$type);
			}
		}
		protected function isfile($file,$to){
			$f=is_file($file);
			$d=is_file($to);
			if($f&&(!$d)){
				return true;
			}else{
				return false;
			}
		}
		protected function file($file,$dir){
			$f=is_file($file);
			$d=is_dir($dir);
			if($f&&$d){
				return true;
			}else{
				return false;
			}
		}
		protected function name($file){
			$pre=md5_file($file);
			return $pre.".mp4";
		} 
		protected function shell($file,$dir,$type=1){
			$sc[]=file_get_contents('head.sh');
			$out=$this->name($file);
			$sc[]="mv ".$out.".sh ../doing";
			if($type==1){
				$sc[]="ffmpeg -i ".$file." -c:v libx264 -strict -2 ".$dir."/".$out;
			}else{
				$out=$this->name($file);
				$out_small="small_".$out;
				$sc[]="ffmpeg  -i ".$file." -c:v libx264 -strict -2 ".$dir."/".$out;
				$sc[]="ffmpeg  -i ".$file." -c:v libx264 -strict -2 -s 848*480 ".$dir."/".$out_small;
			}
			$sc[]="rm ../doing/".$out.".sh";
			$script=implode("\n", $sc);
			file_put_contents("./pre/".$out.".sh", $script);
		}
		protected function shellto($file,$dir,$type=1){
			$sc[]=file_get_contents('head.sh');
			$sn=md5($dir);
			$sc[]="mv ".$sn.".sh ../doing";
			if($type==1){
				$sc[]="ffmpeg  -i ".$file." -c:v libx264 -strict -2 ".$dir;
			}else{
				$out_small=$dir.".small.mp4";
				$sc[]="ffmpeg  -i ".$file." -c:v libx264 -strict -2 ".$dir;
				$sc[]="ffmpeg  -i ".$file." -c:v libx264 -strict -2 -s 848*480 .".$out_small;
			}
			$sc[]="rm ../doing/".$sn.".sh";
			$script=implode("\n", $sc);

			file_put_contents("./pre/".$sn.".sh", $script);
		}
		

	}