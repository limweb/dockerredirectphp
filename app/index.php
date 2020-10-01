<?php
//----docker env---example--
// SERVER_REDIRECT:"aaa==http://bbb.com,bbb==https://ccc.com"
// DEFAULT_REDIRECT:"https://yourdomain.com"
//----docker env-----


$uri = trim($_SERVER['PATH_INFO'],'/');
$route = '';
$redirect = '';
$pathinfo = [];
if($uri){
    $uris = explode("/",$uri);
    $route = $uris[0];
}
$redirect_str = $_ENV['SERVER_REDIRECT'];
$default = $_ENV['DEFAULT_REDIRECT']?:'/';
$redirects = explode(',',$redirect_str);
foreach ($redirects as $key => $red) {
    list($key,$url) = explode("==",$red);
    if($key){
        $pathinfo[$key] = $url;
    }
}
$redirect = $pathinfo[$route];
header('HTTP/1.1 301 Moved Permanently');
if($redirect){
    header('Location: '.$redirect,true,301);
} else {
    header('Location: '.$default,true,301);
}
exit();
