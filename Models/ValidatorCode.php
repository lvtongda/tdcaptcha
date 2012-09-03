<?php
include("session_mysql.php");
/**
 * ��֤���װ��
 * ���÷��㴴��һ��������֤��
 * @author tom
 * ��:
 */
class ValidatorCode{
    //1:���幫������
    private $width;  //�������
    private $height; //�����߶�
    private $codenum;//��֤���е��ַ�����
    private $image;  //����
      
    /**
    * ��ʼ����������
    * @param $width    ��
    * @param $height   ��
    * @param $codenum  ��֤�����ַ�����
    */
    public function __construct($width = 160,$height = 30,$codenum = 4){
        $this->width = $width;
        $this->height = $height;
        $this->codenum = $codenum;
    }
  
    /**
    * ��������
    */
    private function crateImage(){
        //2.1��������
        $this->image = imagecreate($this->width,$this->height);
        //2.2�������  �����ɫ
        $backgroundColor = imagecolorallocate($this->image
        ,mt_rand(255,255),mt_rand(255,255),mt_rand(255,255));
        imagefill($this->image,0,0,$backgroundColor);
        //2.3 ��һ�������򣬽�������֤��������
        //2.4 ��ɫ�߿�
        //$borderColor = imagecolorallocate($this->image,0,0,0);
        imagerectangle($this->image,0,0,
        $this->width-1, $this->height-1,
        $borderColor);
    }
  
    /**
    * �����������֤���е��ַ� 
    * ����  �ַ����
    */
    private function getCheckCode(){
        $code = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $temp = '';
        for($i = 0;$i < $this->codenum;$i++){
        //1:���ȡһ���±�
            $j = mt_rand(0,strlen($code) - 1);
        //2:���±�ȡ�ַ�
            $c = $code{$j};
        //3:�����ַ���
            $temp .= $c;
        }  
        return $temp;
    }
  
  
    /**
    * ����֤������ݣ����ڻ�����
    * @param resource $font ����
    */
    private function drawString($font = ''){
        //ʹ����һ�λ�һ���ַ�
        //ÿһ���ַ���ɫ�����Ҽ��
        //code ��������ַ���
        $code = $this->getCheckCode();
        $_SESSION['code'] = $code;
        for($i = 0 ; $i < $this->codenum;$i++){
    	    //����������ֵ���ɫ
    	    //0 - 130
    	    $fontcolor = imagecolorallocate(
    	    $this->image,mt_rand(0,0),mt_rand(0,0)
    	    ,mt_rand(0,0));

    	
    	    //����û�û�д����������
            if('' == $font){
                //������������С
                //3 -- 5
                $fontsize = mt_rand(3,5);
                //�ַ�ռλ��
                $x = ceil($this->width / $this->codenum) * $i + 5;
                $y = ceil(mt_rand(1,$this->height - 40));
                imagechar($this->image,$fontsize,$x,$y,$code{$i},$fontcolor);
            }else{
                //���������
                //���������С
                $fontsize = mt_rand(22,24);
                //�����ƶ� 
                $x = ceil(mt_rand(28,$this->width / $this->codenum)) * $i + 20;
                //��ʾһ��
                $y = ceil(mt_rand($fontsize,$this->height - 5));
                //��¼
                imagettftext($this->image,$fontsize,
                mt_rand(-20,20),$x,$y,
                $fontcolor,$font,$code{$i});
            }
        	
        }
  
  
    }
  
    /**
    * ��������
    */
    private function setPointArc(){
    
        //��������
        for($i = 0 ; $i < 40;$i++){
            $pointColor = imagecolorallocate($this->image,mt_rand(0,255),
            mt_rand(0,255),mt_rand(0,255));
            imagesetpixel($this->image,mt_rand(1,$this->width - 2),mt_rand(1,$this->height - 2),$pointColor);
        }
        //����������
        for($i = 1 ; $i < 16 ; $i++){
            $arcColor = imagecolorallocate($this->image,mt_rand(0,0),mt_rand(0,0),mt_rand(0,0));
            imagearc($this->image,mt_rand(-10,$this->width),
            mt_rand(-10,$this->height),mt_rand(10,200),
            mt_rand(10,200),30,100,$arcColor);
        }
    }
    public function showImage($font = ''){
        //��������
        $this->crateImage();
        //��������
        $this->drawString($font);
        //����������
        $this->setPointArc();
        //���
        imagejpeg($this->image);
    }
  
}
header("content-type:image/png;charset=utf-8");
$code = new ValidatorCode();
$code->showImage("../Content/Scraps.ttf");

