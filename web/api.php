<?
$get = $_GET["get"];
$url = 'http://medinfo.in.ua//api/'.$get;
/*echo "<br>";
echo $url = 'http://medinfo.in.ua//api/'.$get;
echo "<br>";*/
echo $content = file_get_contents($url); 
?>