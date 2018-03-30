<?php
require "../vendor/autoload.php";
use Tools\Server;
use Tools\Request;
Server::config();

if (empty($_GET['url']))
{
    $url = '';
}
else
{
    $url = htmlspecialchars(stripslashes(trim($_GET['url'])));
}
$request = new Request($url);
$request->execute();
