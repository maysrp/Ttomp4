<?php
	/*
		$dir 传入目录结尾不以为“/”。
		$file和$dir
		【文件名】原文件md5.MP4||小型文件为small_源文件md5_.mp4
		$to 为给出的文件【不对其进行任何检查，请自己生成】 [小尺寸]$to.mp4.small.mp4


	*/
	class vcode{
		public $dir;
		public $dolist;
		public $prelist;
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
		public function doing_list(){//返回正在转码的文件
			$dh=opendir('./doing');//在当前目录下的doing目录下放置转换中的文件
			while(($file=readdir($dh))!==false){
				if($this->is_sh($file)){
					$info['time']=$this->ctime("./doing/".$file);
					$info['dir']="./doing/".$file;
					$this->dolist[]=$info;
				}
				return $this->dolist;
			}
		}
		public function pre_list(){
			$dh=opendir('./pre');//在当前目录下的pre目录下放置转换中的文件
			while(($file=readdir($dh))!==false){
				if($this->is_sh($file)){
					$info['time']=$this->ctime("./doing/".$file);
					$info['dir']="./doing/".$file;
					$this->prelist[]=$info;
				}
				return $this->prelist;
			}
		}
		public function do_info($dir){
			if(is_file("./doing/".$dir)){
				$re['status']=false;
				$re['con']="无该文件";
			}else{
				$string=file_get_contents("./doing/".$dir);
				$ar=explode("#R#E#M#", $string);
				if(isset($ar[1])&&isset($ar[2])){
					$re[]=$ar[1];
					$re[]=$ar[2];
				}else{
					unlink("./doing/".$dir);
				}
				return $ar;
			}
		}
		public function pre_info($dir){
			if(is_file("./pre/".$dir)){
				$re['status']=false;
				$re['con']="无该文件";
			}else{
				$string=file_get_contents("./pre/".$dir);
				$ar=explode("#R#E#M#", $string);
				if(isset($ar[1])&&isset($ar[2])){
					$re['con'][]=$ar[1];
					$re['con'][]=$ar[2];
					$re['status']=true;
				}else{
					unlink("./pre/".$dir);
					$re['status']=false;
					$re['con']="无该文件";
				}
			}
			return $re;
		}
		public function del($dir,$type="pre"){
			if(is_file("./".$type."/".$dir)){
				unlink("./".$type."/".$dir);
			}
		}
		public function redo($dir,$type=0){
			if($type){//为1时候全部重置
				$dh=opendir('./doing');
				while(($file=readdir($dh))!==false){
					if($this->is_sh($file)){
						copy("./doing/".$file,"./pre/".$file);
						unlink("./doing/".$file);
					}
					$re['status']=true;
				}
			}else{//默认转换送入的dir
				if(is_file("./doing/".$dir)){
					$re['status']=false;
					$re['con']="无该文件";
				}else{
					copy("./doing/".$dir,"./pre/".$dir);
					unlink("./doing/".$dir);
					$re['status']=true;
				}
			}
			return $re;
		}
		protected ctime($file){
			return filectime($file);
		}
		protected function is_sh($file){
			$ar=explode(".", $file);
			$exe=array_pop($ar);
			$ex=strtolower($exe);
			if($ex=="sh"){
				return true;
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
			$sc[]="cd ./pre";
			$sc[]="mv ".$out.".sh ../doing";
			if($type==1){
				$sc[]="ffmpeg -y -i ".$file." -c:v libx264 -strict -2 ".$dir."/".$out;
			}else{
				$out=$this->name($file);
				$out_small="small_".$out;
				$sc[]="ffmpeg -y -i ".$file." -c:v libx264 -strict -2 ".$dir."/".$out;
				$sc[]="ffmpeg -y -i ".$file." -c:v libx264 -strict -2 -s 848*480 ".$dir."/".$out_small;
			}
			$sc[]="rm ../doing/".$out.".sh";
			$sc[]="#R#E#M#".$file."#R#E#M#".$dir."/".$out;
			$script=implode("\n", $sc);
			file_put_contents("./pre/".$out.".sh", $script);
		}
		protected function shellto($file,$dir,$type=1){
			$sc[]=file_get_contents('head.sh');
			$sn=md5($dir);
			$sc[]="cd ./pre";
			$sc[]="mv ".$sn.".sh ../doing";
			if($type==1){
				$sc[]="ffmpeg -y -i ".$file." -c:v libx264 -strict -2 ".$dir;
			}else{
				$out_small=$dir.".small.mp4";
				$sc[]="ffmpeg -y -i ".$file." -c:v libx264 -strict -2 ".$dir;
				$sc[]="ffmpeg -y -i ".$file." -c:v libx264 -strict -2 -s 848*480 .".$out_small;
			}
			$sc[]="rm ../doing/".$sn.".sh";
			$sc[]="#R#E#M#".$file."#R#E#M#".$dir;
			$script=implode("\n", $sc);

			file_put_contents("./pre/".$sn.".sh", $script);
		}
		

	}
