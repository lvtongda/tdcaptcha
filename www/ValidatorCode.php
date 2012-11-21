<?php
header("Content-Type:text/html; charset=utf-8");
require_once('../conf/config.php');

session_start();
//$clientsonid = mysql_escape_string(md5(session_id()+'shijieheping'));
//$privkey = mysql_escape_string($_GET['privkey']);
$clientsonid = isset($_GET['clientsonid']) ? mysql_escape_string($_GET['clientsonid']) : false;
$pubkey = isset($_GET['pubkey']) ? mysql_escape_string($_GET['pubkey']) : false;

class ValidatorCode {
    private $width;  
    private $height; 
    private $codenum;
    private $image;
    private $draw;
    private $pubkey;

    public function __construct($width = 160, $height = 30, $codenum = 4) {
        $this->width = $width;
        $this->height = $height;
        $this->codenum = $codenum;
    }

    private function crateImage() {
        $this->image = new Gmagick();
        $this->image->newimage($this->width, $this->height, 'white', 'png');
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


    private function drawString($font, $pubkey, $clientsonid) {
        $code = $this->getCheckCode();
        $start_time = time();
        $sqlstr = 'SELECT privatekey from db_client WHERE publickey = "'. $pubkey. '" LIMIT 1';
        $result = mysql_query($sqlstr);
        if (mysql_affected_rows() < 1) {
            die('pubkey not founded');
        }
        else {
            $row = mysql_fetch_array($result);
            $privkey = $row['privatekey'];

            $code = $this->getCheckCode();
            $start_time = time();
            $sql = 'SELECT privatekey, clientsonid FROM db_captcha WHERE privatekey="'. $privkey . '" AND clientsonid="'. $clientsonid .'" LIMIT 1';
            mysql_query($sql);
            if(mysql_affected_rows() < 1) {
                $row = mysql_fetch_array($result);
                $sql = 'INSERT INTO db_captcha(privatekey, clientsonid, captcha, start_time) VALUES("'. $privkey .'", "'. $clientsonid.'", "'. $code . '", '.$start_time.')';
                var_dump($sql);
                mysql_query($sql);
            }else {
                $sql = 'UPDATE db_captcha SET captcha="' . $code . '" WHERE privatekey="' . $row["privatekey"] . '" AND clientsonid="' . $clientsonid . '" LIMIT 1';
                mysql_query($sql);
            }

            $fontsize = mt_rand(30, 45);
            $x = mt_rand(20, 35);
            $y = mt_rand(25, 30);
            $this->draw = new GmagickDraw();
            $this->draw->annotate($x, $y, $code);
            $this->draw->setfontsize($fontsize);
            $this->draw->setfont($font);
        }
    }

    private function setPointArc() {
        for($i = 0 ; $i < 80;$i++) {
            $this->draw->point(mt_rand(1, $this->width - 2),mt_rand(1, $this->height - 2));
        }
        
        for($i = 1 ; $i < 70 ; $i++) {
            $this->draw->arc(mt_rand(-10, $this->width),
            mt_rand(-10, $this->height), mt_rand(0,200),
            mt_rand(0,200), 40, 100);
        }
    }
    
    public function showImage($font, $pubkey, $clientsonid) {
        $this->crateImage();
        $this->drawString($font, $pubkey, $clientsonid);
        $this->setPointArc();
        $this->image->drawimage($this->draw);
        echo $this->image;
    }

}

header("content-type:image/png");
$code = new ValidatorCode();
$code->showImage("../content/Scraps.ttf", $pubkey, $clientsonid);
