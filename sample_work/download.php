<?php
$book_md5=$_GET['md5'];

function get_data($book_md5){
$options  = array('http' => array('user_agent' => 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/74.0.3729.169 Safari/537.36'));
$context  = stream_context_create($options);
$data=file_get_contents('http://booksdescr.org/ads.php?md5='.$book_md5,false,$context);
preg_match_all('/<a[^>]+>/i', $data, $result);
$link=$result[0][0];
$link= substr($link, strpos($link, 'http'));
$link=substr($link, 0, -2);
return $link;
}

$link=get_data($book_md5);
header("Location:$link");
?>
