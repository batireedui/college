<?php
session_start();
date_default_timezone_set('Asia/Singapore');
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

$cdn = "https://admin.ireedui.site/";

$pageTitle = "Өвөрхангай ПК";
$favi = "https://uvcollege.edu.mn/wp-content/uploads/2021/09/cropped-icon-32x32.png";
$tuluvIrc = [1 => "Ирсэн", 2 => "Өвчтэй", 3 => "Чөлөөтэй", 4 => "Тасалсан"];
$tuluvIrcShort = [1 => "И", 2 => "Ө", 3 => "Ч", 4 => "Т"];
$tuluvColor= [1 => "success", 2 => "warning", 3 => "primary", 4 => "danger"];

$school_name = "Өвөрхангай аймаг дахь Политехник коллеж";

$starton = 2023;
$thison = date("Y");

if (empty($page)) {
    require ROOT . '/pages/home.php';
} else {
    $script = ROOT . "/pages$page.php";
    if (file_exists($script)) {
        require $script;
    } else {
        require ROOT . '/pages/404.php';
    }
}

function tokenGen($length = 32)
{
    $stringSpace = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $pieces = [];
    $max = mb_strlen($stringSpace, '8bit') - 1;
    for ($i = 0; $i < $length; ++ $i) {
        $pieces[] = $stringSpace[random_int(0, $max)];
    }
    return implode('', $pieces);
}

function cagtoRoma($cag)
{
    switch ($cag) {
        case '1-р цаг':
            return "I";
        case '2-р цаг':
            return "II";
        case '3-р цаг':
            return "III";
        case '4-р цаг':
            return "IV";
        case '5-р цаг':
            return "V";
        case '6-р цаг':
            return "VI";
        case '7-р цаг':
            return "VII";
        case '8-р цаг':
            return "VII";
        default: return $cag;
    }
}

function dayofweek($ognoo)
{
    $day = date('w', strtotime($ognoo));
    switch ($day) {
        case 1:
            return "Даваа";
        case 2:
            return "Мягмар";
        case 3:
            return "Лхагва";
        case 4:
            return "Пүрэв";
        case 5:
            return "Баасан";
        case 6:
            return "Бямба";
        case 0:
            return "Ням";
        default: return $day;
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
