<?php
header("Content-Type:text/html; charset=utf-8");
require_once('../config/config_global.php');
$clientsonid = $_GET['s'];
$pubkey = $_GET['pubkey'];

class ValidatorCode {
    private $width;  
    private $height; 
    private $codenum;
    private $image;
    private $pubkey;  

    public function __construct($width = 160,$height = 30,$codenum = 4) {
        $this->width = $width;
        $this->height = $height;
        $this->codenum = $codenum;
    }

    private function crateImage() {
        $this->image = imagecreate($this->width,$this->height);
        $backgroundColor = imagecolorallocate($this->image
        ,mt_rand(255,255),mt_rand(255,255),mt_rand(255,255));
        imagefill($this->image,0,0,$backgroundColor);
        imagerectangle($this->image,0,0,
        $this->width-1, $this->height-1,
        $borderColor);
    }

    private function getCheckCode() {
        $code = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $temp = '';
        
        for($i = 0;$i < $this->codenum;$i++){
            $j = mt_rand(0,strlen($code) - 1);
            $c = $code{$j};
            $temp .= $c;
    }   
        return $temp;
    }


    private function drawString($font = '', $pubkey, $clientsonid) {
        $code = $this->getCheckCode();
        $start_time = time();
        $sql = "SELECT publickey, clientsonid FROM db_captcha WHERE publickey='$pubkey' AND clientsonid='$clientsonid'";
        mysql_query($sql);
        if(mysql_affected_rows() < 1) {
            $sql = "INSERT INTO db_captcha(publickey, clientsonid, captcha, start_time) VALUES('$pubkey', '$clientsonid', '$code', '$start_time')";
            mysql_query($sql);
        }else {
            $sql = "UPDATE db_captcha SET captcha='$code' WHERE publickey='$pubkey' AND clientsonid='$clientsonid'";
            mysql_query($sql);
        }

        for($i = 0 ; $i < $this->codenum;$i++) {
            $fontcolor = imagecolorallocate(
            $this->image,mt_rand(0,0),mt_rand(0,0)
            ,mt_rand(0,0));

            if('' == $font) {
                $fontsize = mt_rand(3,5);
                $x = ceil($this->width / $this->codenum) * $i + 5;
                $y = ceil(mt_rand(1,$this->height - 40));
                imagechar($this->image,$fontsize,$x,$y,$code{$i},$fontcolor);
            }else {
                $fontsize = mt_rand(22,24);
                $x = ceil(mt_rand(28,$this->width / $this->codenum)) * $i + 20;
                $y = ceil(mt_rand($fontsize,$this->height - 5));
                imagettftext($this->image,$fontsize,
                mt_rand(-20,20),$x,$y,
                $fontcolor,$font,$code{$i});
            }
        }
    }

    private function setPointArc() {
        for($i = 0 ; $i < 40;$i++) {
            $pointColor = imagecolorallocate($this->image,mt_rand(0,255),
            mt_rand(0,255),mt_rand(0,255));
            imagesetpixel($this->image,mt_rand(1,$this->width - 2),mt_rand(1,$this->height - 2),$pointColor);
        }
        
        for($i = 1 ; $i < 16 ; $i++) {
            $arcColor = imagecolorallocate($this->image,mt_rand(0,0),mt_rand(0,0),mt_rand(0,0));
            imagearc($this->image,mt_rand(-10,$this->width),
            mt_rand(-10,$this->height),mt_rand(10,200),
            mt_rand(10,200),30,100,$arcColor);
        }
    }
    
    public function showImage($font = '', $pubkey, $clientsonid) {
        $this->crateImage();
        $this->drawString($font, $pubkey, $clientsonid);
        $this->setPointArc();
        imagejpeg($this->image);
    }
}

header("content-type:image/png;charset=utf-8");
$code = new ValidatorCode();
$code->showImage("../content/Scraps.ttf", $pubkey, $clientsonid);
