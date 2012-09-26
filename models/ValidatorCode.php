<?php
session_start();
/**
 * 验证码封装类
 * 作用方便创建一个灵活的验证码
 * @author tom
 * 例:
 */
class ValidatorCode{
  //1:定义公共属性
  private $width;  //画布宽度
  private $height; //画布高度
  private $codenum;//验证码中的字符个数
  private $image;  //画布
  
  /**
   * 初始化画布参数
   * @param $width    宽
   * @param $height   高
   * @param $codenum  验证码中字符个数
   */
  public function __construct($width = 160,$height = 30,$codenum = 4){
    $this->width = $width;
    $this->height = $height;
    $this->codenum = $codenum;
  }
  
  /**
   * 创建画布
   */
  private function crateImage(){
   //2.1创建画布
   $this->image = imagecreate($this->width,$this->height);
   //2.2画布填充  随机颜色
   $backgroundColor = imagecolorallocate($this->image
   ,mt_rand(255,255),mt_rand(255,255),mt_rand(255,255));
   imagefill($this->image,0,0,$backgroundColor);
   //2.3 画一矩形区域，将来把验证画在里面
   //2.4 黑色边框
   //$borderColor = imagecolorallocate($this->image,0,0,0);
   imagerectangle($this->image,0,0,
   $this->width-1, $this->height-1,
   $borderColor);
  }
  
  /**
   * 产生随机的验证码中的字符 
   * 数字  字符组件
   */
  private function getCheckCode(){
   $code = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
   $temp = '';
   for($i = 0;$i < $this->codenum;$i++){
   	  //1:随机取一个下标
   	  $j = mt_rand(0,strlen($code) - 1);
   	  //2:从下标取字符
   	  $c = $code{$j};
   	  //3:连接字符串
   	  $temp .= $c;
   }   
   return $temp;
  }
  
  
  /**
   * 将验证码的内容，画在画布上
   * @param resource $font 字体
   */
  private function drawString($font = ''){
    //使方法一次画一个字符
    //每一个字符颜色，并且间距
     //code 随机产生字符串
    $code = $this->getCheckCode();
    $_SESSION['code'] = $code;
  	for($i = 0 ; $i < $this->codenum;$i++){
    	//随机产生文字的颜色
    	//0 - 130
    	$fontcolor = imagecolorallocate(
    	$this->image,mt_rand(0,0),mt_rand(0,0)
    	,mt_rand(0,0));

    	
    	//如果用户没有传入字体参数
    	if('' == $font){
    		//随机产生字体大小
    		//3 -- 5
    		$fontsize = mt_rand(3,5);
    		//字符占位置
    		$x = ceil($this->width / $this->codenum) * $i + 5;
    		$y = ceil(mt_rand(1,$this->height - 40));
    	    imagechar($this->image,$fontsize,$x,$y,$code{$i},$fontcolor);
    	}else{
    	 //有字体参数
         //定义字体大小
         $fontsize = mt_rand(22,24);
         //左右移动 
         $x = ceil(mt_rand(28,$this->width / $this->codenum)) * $i + 20;
         //显示一半
         $y = ceil(mt_rand($fontsize,$this->height - 5));
         //显录
         imagettftext($this->image,$fontsize,
         mt_rand(-20,20),$x,$y,
         $fontcolor,$font,$code{$i});
    	}
        	
    }
  
  
  }
  
  /**
   * 画噪声点
   */
  private function setPointArc(){
    
  	//画噪声点
  	for($i = 0 ; $i < 40;$i++){
    	$pointColor = imagecolorallocate($this->image,mt_rand(0,255),
    	mt_rand(0,255),mt_rand(0,255));
    	imagesetpixel($this->image,mt_rand(1,$this->width - 2),mt_rand(1,$this->height - 2),$pointColor);
    }
    //画噪声弧线
    for($i = 1 ; $i < 16 ; $i++){
     $arcColor = imagecolorallocate($this->image,mt_rand(0,0),mt_rand(0,0),mt_rand(0,0));
     imagearc($this->image,mt_rand(-10,$this->width),
     mt_rand(-10,$this->height),mt_rand(10,200),
     mt_rand(10,200),30,100,$arcColor);
    }
  }
  public function showImage($font = ''){
    //创建画布
    $this->crateImage();
    //加入验码
    $this->drawString($font);
    //加入噪声点
    $this->setPointArc();
    //输出
    imagejpeg($this->image);
  }
  
}
header("content-type:image/png;charset=utf-8");
$code = new ValidatorCode();
$code->showImage("../Content/Scraps.ttf");

