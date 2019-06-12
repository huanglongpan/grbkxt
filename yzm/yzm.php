<?php
//创建随机数
session_start();
class ValidateCode
{
	private $charset='abcdefghkmnpqrstuvwxyzABCDEFGHKMNPQRSTUVWXYZ23456789';
	private $code;  //声明一个变量来保存验证码
	private $codelen=4;//声明验证码的长度
  private $width=130; //声明验证码背景的长宽
  private $height=50;
  private $img;      //图像资源句柄
  private $font;    //字体
  private $fontsize=23;
  private $fontcolor;


     //
    public function __construct(){
    	$this->font='ELEPHNT.TTF';
    }

    //生成随机码
    private function createCode(){
    	$_len=strlen($this->charset)-1;
    	for ($i=0; $i < $this->codelen; $i++) {
    		$this->code .=$this->charset[mt_rand(0,$_len)];
    	}
    	//return $this->code;
    }

    //生成背景
    private function createBJ(){
        $this->img=imagecreatetruecolor($this->width,$this->height);
        $color=imagecolorallocate($this->img, mt_rand(155,255),mt_rand(155,255) ,mt_rand(155,255));//背景颜色
        imagefilledrectangle($this->img, 0, $this->height, $this->width, 0, $color);
   }
    //生成文字
    private function createFont(){
        $_x=$this->width/$this->codelen;
        for ($i=0; $i <$this->codelen ; $i++) {
          $this->fontcolor=imagecolorallocate($this->img,mt_rand(0,154),mt_rand(0,154),mt_rand(0,154));//字体颜色
        	imagettftext($this->img, $this->fontsize, mt_rand(-30,30), $_x*$i+mt_rand(1,5), $this->height/1.5+mt_rand(1,5), $this->fontcolor, $this->font, $this->code[$i]);
        }
    }

    //生成线条雪花
    private function createLine(){
      for ($i=0; $i < 6 ; $i++) {
        $color=imagecolorallocate($this->img,mt_rand(0,154),mt_rand(0,154),mt_rand(0,154));
        imageline($this->img, mt_rand(0,$this->width), mt_rand(0,$this->height), mt_rand(0,$this->width), mt_rand(0,$this->height), $color);
      }
      for ($i=0; $i < 100 ; $i++) {
        $color=imagecolorallocate($this->img,mt_rand(200,255),mt_rand(200,255),mt_rand(200,255));
        imagestring($this->img,mt_rand(1,5), mt_rand(1,$this->width), mt_rand(1,$this->height), "*", $color);
      }
    }


   //输出图像
   private function outPut(){
   	header('content-type:image/png');
   	imagepng($this->img);
   	imagedestroy($this->img); //清除资源
   }
   //对外生成
   public function dyimg(){
   	$this->createBJ();
   	$this->createCode();
    $this->createLine();
   	$this->createFont();
   	$this->outPut();
   }

   //获取验证码
   public function getCode(){
    return strtolower($this->code);
   }

}
// $_vc=new ValidateCode();
// $_vc->dyimg();

?>