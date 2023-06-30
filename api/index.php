<?php
// Author: Zhengfourth <https://github.com/Zhengfourth>
$user = $_GET["user"];
$st = $_GET["style"];
$st1 = $_GET["st"];
$badgehd = "Location:https://img.shields.io/badge/";
set_time_limit(600);
$mainUrl = "https://ch.tetr.io/api/users/*";
$timeo = 0;
$ratingr = getData(str_replace("*", $user, $mainUrl));  //获取json数据并转换为数组
$timeo = $timeo +1;
$styleraw = "?longCache=true&style=*";
if (isset($_GET["style"])) //是否使用自定义style
{
    $style = str_replace("*", $st, $styleraw); //替换
    
} else {
    $style = "?longCache=true&style=for-the-badge";  //默认是for-the-badge
}
if (isset($_GET["st"])) //自定义style缩写，不可重用
{
   switch($st1){
     case "f1" : $style = "?longCache=true&style=flat";break;
     case "f2" : $style = "?longCache=true&style=flat-square";break;
     default: break;
}
    
} 
function getData($url) {
    $headers = array();
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_TIMEOUT, 600);
    $result = curl_exec($ch);
    curl_close($ch);
    $result = json_decode($result, true);
    return $result;  
}
$ratstr = $ratingr["data"]["user"]["league"]["rating"];   //从数组中提取字符串rating
$rating = intval($ratstr);    //转换为数字
if ($rating == -1) { // 特判没打满10场
	$win = $ratingr["data"]["user"]["league"]["gameswon"];
	$play = $ratingr["data"]["user"]["league"]["gamesplayed"];
	$rating = $win . "/" . $play;
}
$name = $ratingr["data"]["user"]["league"]["rank"];
if ($name == "z") {        //开始根据段位判断颜色~
    $color = "-808080.svg";
	$name = "%3F";
} else if ($name == "d") { 
	$color = "-9e81a1.svg";
} else if ($name == "d+") { 
	$color = "-9a67a0.svg";
} else if ($name == "c-") { 
	$color = "-84679b.svg";
} else if ($name == "c") { 
	$color = "-7c4e9e.svg";
} else if ($name == "c+") { 
	$color = "-5b3399.svg";
} else if ($name == "b-") { 
	$color = "-5651c7.svg";
} else if ($name == "b") { 
	$color = "-5b73df.svg";
} else if ($name == "b+") { 
	$color = "-52a6c8.svg";
} else if ($name == "a-") { 
	$color = "-49c38a.svg";
} else if ($name == "a") { 
	$color = "-72d156.svg";
} else if ($name == "a+") { 
	$color = "-23ab32.svg";
} else if ($name == "s-") { 
	$color = "-e3e132.svg";
} else if ($name == "s") { 
	$color = "-fbc90b.svg";
} else if ($name == "s+") { 
	$color = "-ffe810.svg";
} else if ($name == "ss") { 
	$color = "-fffb92.svg";
} else if ($name == "u") { 
	$color = "-ff3013.svg";
} else if ($name == "x") { 
	$color = "-ff5aff.svg";
} else {
    $color = "-black.svg";
}
$style = $style. "&logo=data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAQAAAAEABAMAAACuXLVVAAAALVBMVEVHcEwAAAAAAAAFBQUbVXofaJZ9VtCNL37JRJ+lOYQVkZ1+X+PAQKrfTqovUaqjn7QgAAAACnRSTlMAIBEwc7rMdcFvX68ANQAAAeNJREFUeNrt3b1Nw0AYxnErG9i3gHMbWIQJCA0tsAIzUKRGNGwAC7ACPRUDhIKOmhkQBsUBvVzuzmfuwvt/HLnKxy/vk5OiKPJVLyNTjQ0AAAAA7D+gjT7SAGxssgOs+glQARVQQSpAPY84UlZQx6RJOYFYgO4JWCooYQIpAaauu5BT4go65RUcBCb5KogGtOoBVEAF+SbQFVbBtZQb6aXW4l3FV1ksPbLo0yNmn1+Ue1z/BHcS4Nn/bZ7ce2cLMFcPoAIAfAYAAAAAAAAAAAAAAAAAAAAAAABKAlxKP8peXUg5l3Im/TR7HABYPQl5fJDyJuVUGsshAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAE0A+U+t4v9fpwGIeR2uwLB9RaYsgKYEgFU9AUsF6leBpQImQAVUQAVUQAVUQAVUQAVUQAVUQAVU8J8qWHrnaBrA6IvlZgO06gFUQAVUIFZgvjY4uPUHBG+eYHZMYHJAXQrAqp9AYkDncdtseeKowEQAzGbxuNMN9yu7go9ZrfZzFRjnefcE7FhA4zz/tqHSFmBIAGD0xmrZAK4JtLkBVGCpQMUqKGsCs+r7EQD4+VD/w5UAQDVJAAAAAOAPAe84sSSYxpxAFAAAAABJRU5ErkJggg==&link=https://ch.tetr.io/u/" . $user; 
$rawc1 = str_replace("_", "__", $user);
$rawc2 = str_replace("-", "--", $rawc1);
$name = str_replace("-", "--", $name);
$rawr = $badgehd . $rawc2 . "-" . $name . "  " . $rating . $color . $style;
header($rawr); //拼接并输出（修复下划线转义bug）

?>

