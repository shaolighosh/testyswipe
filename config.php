<?php
$host = 'database-1.chg26u24qmmz.us-east-1.rds.amazonaws.com';
$db   = 'yswipe';
$user = 'admin';
$pass = 'Asesino1!697106';
 

$conn = mysqli_connect($host, $user, $pass, $db) or die("Connection failed");

$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

$opt = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
    PDO::ATTR_EMULATE_PREPARES   => false,
];
$pdo = new PDO($dsn, $user, $pass, $opt);
/*function url()
{
    return sprintf(
    "%s://%s",
    isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http',
    $_SERVER['SERVER_NAME']
    );
}

$base_url = url();*/

//define("site_url", $base_url."/theGudingLightCo");


const HTTP_OK = 200;
const HTTP_BAD_REQUEST = 200;
const HTTP_NOT_FOUND = 404;
const HTTP_UNAUTHORIZED = 401;
const HTTP_FORBIDDEN = 403;
const HTTP_NOT_FOUND = 404;
