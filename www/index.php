<?php
session_start();

ini_set('display_errors', 1);
define('ROOT', dirname(dirname(__FILE__)));

require ROOT . '/inc/conf.php';
require ROOT . '/inc/db.php';
/*if( ($_SERVER['REQUEST_URI'] != "/") and preg_match('{/$}',$_SERVER['REQUEST_URI']) ) {
    header ('Location: '.preg_replace('{/$}', '', $_SERVER['REQUEST_URI']));
    exit();
}*/

$teacher_page = array("/", "");

$page = @$_SERVER['REDIRECT_URL'];

$pageTitle = "Өвөрхангай ПК";
$favi = "/assets/img/favicon/logo.png";
if (empty($page)) {
    require ROOT . '/pages/home.php';
} 
else {
    $script = ROOT . "/pages$page.php";
    if (file_exists($script)) {
        require $script;
    } else {
        require ROOT . '/pages/404.php';
    }
}

function logError($e)
{
    _exec(
        "insert into error set
        ognoo = now(),
        ip=?,
        error_code=?,
        error=?,
        file=?,
        line=?,
        site='user'
    ",
        'sissi',
        [getIpAddress(), $e->getCode(), $e->getMessage(), $e->getFile(), $e->getLine()],
        $count
    );

    alertAdmin($e->getMessage());
}

function redirect($url)
{
    header("Location: $url");
    exit;
}

function dd($arr, $exit = false)
{
    echo '<pre>';
    print_r($arr);
    if ($exit) {
        exit;
    }
}

function post($name, $length = null)
{
    $value = $_POST[$name];

    $value = addslashes($value);

    if (!is_null($length) && mb_strlen($value) > $length) {
        $value = mb_substr($value, 0, $length);
        // Security alert! DB write, email send
        echo "<br>security alert : $name индекстэй өгөгдөл $length уртаас хэтэрсэн өгөгдөлтэй байна!<br>";
    }

    return $value;
}

function get($name, $length = null)
{
    $value = $_GET[$name];

    $value = addslashes($value);

    if (!is_null($length) && mb_strlen($value) > $length) {
        $value = mb_substr($value, 0, $length);
        // Security alert! DB write, email send
        echo "<br>security alert : $name индекстэй өгөгдөл $length уртаас хэтэрсэн өгөгдөлтэй байна!<br>";
    }

    return $value;
}

function getIpAddress()
{
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) // check ip from share internet
    {
        return $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) // to check ip is pass from proxy
    {
        return $_SERVER['HTTP_X_FORWARDED_FOR'];
    }
    return $_SERVER['REMOTE_ADDR'];
}

function alertAdmin($message)
{
    // email -> sendgrid
    // sms -> skytel web2sms url?phone=99442233&msg=aldaa: $message
}

function formatMoney($value)
{
    if ($value == '0') {
        return '';
    } else {
        $value = number_format(sprintf('%0.2f', preg_replace("/[^0-9.]/", "", $value)), 0);
        return $value;
    }
}
function ognoo()
{
    $tz = 'Asia/Ulaanbaatar';
    $timestamp = time();
    $dt = new DateTime("now", new DateTimeZone($tz)); //first argument "must" be a string
    $dt->setTimestamp($timestamp); //adjust the object to correct timestamp
    return $dt->format('Y/m/d H:i:s');
}
function ognooday()
{
    $tz = 'Asia/Ulaanbaatar';
    $timestamp = time();
    $dt = new DateTime("now", new DateTimeZone($tz)); //first argument "must" be a string
    $dt->setTimestamp($timestamp); //adjust the object to correct timestamp
    return $dt->format('Y/m/d');
}