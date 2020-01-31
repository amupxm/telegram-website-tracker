<?php
session_start();


class bot
{
  public  $token;
  public $user_agent ;

  function __construct($token)
  {
    $this->token = $token;
    $this->user_agent= $_SERVER['HTTP_USER_AGENT'];
  }
  function send_request($function){
        $url = "https://api.telegram.org/"."bot".$this->token."/".$function;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($ch);
        curl_close($ch);
  }
  function sendMesage($message,$chat_id){
    $this->send_request("sendmessage?"."chat_id=$chat_id&text=$message");
  }

  function getIp(){
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    return $ip;
  }
  function getBrowser() {

      $user_agent = $this->user_agent;

      $browser        = "Unknown Browser";

      $browser_array = array(
                              '/msie/i'      => 'Internet Explorer',
                              '/firefox/i'   => 'Firefox',
                              '/safari/i'    => 'Safari',
                              '/chrome/i'    => 'Chrome',
                              '/edge/i'      => 'Edge',
                              '/opera/i'     => 'Opera',
                              '/netscape/i'  => 'Netscape',
                              '/maxthon/i'   => 'Maxthon',
                              '/konqueror/i' => 'Konqueror',
                              '/mobile/i'    => 'Handheld Browser'
                       );

      foreach ($browser_array as $regex => $value)
          if (preg_match($regex, $user_agent))
              $browser = $value;

      return $browser;
  }
  function getOS() {

      $user_agent = $this->user_agent;

      $os_platform  = "Unknown OS Platform";

      $os_array     = array(
                            '/windows nt 10/i'      =>  'Windows 10',
                            '/windows nt 6.3/i'     =>  'Windows 8.1',
                            '/windows nt 6.2/i'     =>  'Windows 8',
                            '/windows nt 6.1/i'     =>  'Windows 7',
                            '/windows nt 6.0/i'     =>  'Windows Vista',
                            '/windows nt 5.2/i'     =>  'Windows Server 2003/XP x64',
                            '/windows nt 5.1/i'     =>  'Windows XP',
                            '/windows xp/i'         =>  'Windows XP',
                            '/windows nt 5.0/i'     =>  'Windows 2000',
                            '/windows me/i'         =>  'Windows ME',
                            '/win98/i'              =>  'Windows 98',
                            '/win95/i'              =>  'Windows 95',
                            '/win16/i'              =>  'Windows 3.11',
                            '/macintosh|mac os x/i' =>  'Mac OS X',
                            '/mac_powerpc/i'        =>  'Mac OS 9',
                            '/linux/i'              =>  'Linux',
                            '/ubuntu/i'             =>  'Ubuntu',
                            '/iphone/i'             =>  'iPhone',
                            '/ipod/i'               =>  'iPod',
                            '/ipad/i'               =>  'iPad',
                            '/android/i'            =>  'Android',
                            '/blackberry/i'         =>  'BlackBerry',
                            '/webos/i'              =>  'Mobile'
                      );

      foreach ($os_array as $regex => $value)
          if (preg_match($regex, $user_agent))
              $os_platform = $value;

      return $os_platform;
  }
  function SendDetails($chatId){
    if(isset($_SESSION['info'])){
      $text=$_SESSION['info'];
      $this->sendMesage($text,$chatId);
    }
      else{
      $url = $_SERVER['REQUEST_URI'];
      $os= $this->getOS();
      $broser = $this->getBrowser();
      $ip =  $this->getIp();
      $text = urlencode("new visitor \n\n\xF0\x9F\x8F\x81 In URL :$url \n\n\xF0\x9F\x92\xBB Clint OS : $os \n\n\xE2\x9E\xA1 Clint Browser Engine : $broser \n\n\xF0\x9F\x8C\x8F Clint IP :$ip");
      $_SESSION['info']=$text;
      $this->sendMesage($text,$chatId);
    }
  }

}
if($_SERVER["HTTPS"] != "on")
{
    header("Location: https://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]);
    exit();
}else {

$myBot = new bot('425094733:AAEbgAucwoGK4GIckoLj9bubF_EfExdU8nA');
$chatId="330611756";
$myBot->SendDetails($chatId);

}
