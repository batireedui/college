<?php
session_start();
date_default_timezone_set('Asia/Singapore');
ini_set('display_errors', 1);
define('ROOT', dirname(dirname(__FILE__)));

require ROOT . '/inc/conf.php';
require ROOT . '/inc/db.php';

$teacher_page = array("/", "");

$page = @$_SERVER['REDIRECT_URL'];

$cdn = "https://uvcollege.edu.mn/";

$pageTitle = "Өвөрхангай ПК";

$favi = "https://surgalt.uvcollege.edu.mn/images/logo.jpg";
$tuluvIrc = [1 => "Ирсэн", 2 => "Өвчтэй", 3 => "Чөлөөтэй", 4 => "Тасалсан"];
$tuluvIrcShort = [1 => "И", 2 => "Ө", 3 => "Ч", 4 => "Т"];
$tuluvColor = [1 => "success", 2 => "warning", 3 => "primary", 4 => "danger"];

$tuluv_Teacher = [1 => "Идэвхтэй", 2 => "Гарсан"];
$tuluv_Main = [0 => "Идэвхгүй", 1 => "Идэвхтэй"];
$tuluv_Class = [1 => "Идэвхтэй", 2 => "Төгссөн"];
$tuluv_Student = [1 => "Идэвхтэй", 2 => "Төгссөн", 3 => "Гарсан"];

$atID = [20000 => "Албаны менежер", 20001 => "Хэлтэс/Тэнхмийн дарга/эрхлэгч"];

//erh дээр 0 гэж шалгавал админ байна
$erh = [1 => "ЦАГ БҮРТГЭЛИЙН ТАЙЛАН ГАРГАХ", 2 => "ЦАГ БҮРТГҮҮЛЭХ ХҮСЭЛТ АВАХ", 3 => "ЗАР ИЛГЭЭХ", 4 => "ТОХИРГОО", 5 => "МЭДЭЭ", 6 => "НУУЦ ҮГ СЭРГЭЭХ", 8 => 'СУДАЛГАА', 9 => 'ИРЦИЙН ТАЙЛАН', 10 => 'ЦАГ БҮРТГЭЛ', 11 => 'Б ЦАГ ТООЦОХ', 12 => 'Б ЦАГ БИЧИХ', 13 => 'БҮРТГЭЛ'/*, 7 => "admin home"*/];

$school_name = "Өвөрхангай аймаг дахь Политехник коллеж";

$starton = 2023;
$thison = date("Y");
$thismonth = date("m");

_selectRowNoParam(
    "select this_on from jil",
    $this_on
);

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
    for ($i = 0; $i < $length; ++$i) {
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
        default:
            return $cag;
    }
}

function amralt($ognoo)
{
    $dayOfWeek = date('w', strtotime($ognoo));
    if ($dayOfWeek == 0 || $dayOfWeek == 6)
        return true;
    else return false;
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
        default:
            return $day;
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
    $dt = new DateTime("now", new DateTimeZone($tz));
    $dt->setTimestamp($timestamp);
    return $dt->format('Y/m/d H:i:s');
}
function ognooday()
{
    $tz = 'Asia/Ulaanbaatar';
    $timestamp = time();
    $dt = new DateTime("now", new DateTimeZone($tz));
    $dt->setTimestamp($timestamp);
    return $dt->format('Y/m/d');
}
function checkErh($erhtoo, $user_role, $user_id)
{
    _selectRowNoParam(
        "SELECT COUNT(id) FROM `admin` WHERE user_id = '$user_id'",
        $admin
    );
    if ($admin > 0) {
        return true;
    } else {
        $nemelt = " and at_id = $user_role";
        _selectRowNoParam(
            "SELECT COUNT(id) FROM `department` WHERE manager_id = '$user_id'",
            $dmanager
        );
        _selectRowNoParam(
            "SELECT COUNT(id) FROM `office` WHERE manager_id = '$user_id'",
            $omanager
        );

        if ($omanager > 0) {
            $nemelt = " and (at_id = $user_role or at_id = 20000)";
        }
        if ($dmanager > 0) {
            $nemelt = " and (at_id = $user_role or at_id = 20001)";
        }
        if ($dmanager > 0 && $dmanager > 0) {
            $nemelt = " and (at_id = $user_role or (at_id = 20001 or at_id = 20000))";
        }
        _selectRowNoParam(
            "SELECT COUNT(id) FROM `at_tax` WHERE erh='$erhtoo' $nemelt",
            $menuEseh
        );
        if ($menuEseh > 0) {
            return true;
        }
        return false;
    }
}
class cagBodoh
{
    public $utga;
    public $cag;
    public $udur;

    public function __construct($utga, $cag, $udur)
    {
        $this->utga = $utga;
        $this->cag = $cag;
        $this->udur = $udur;
    }
}

function udurCag($cags, $dayof)
{
    $udur = 0;
    if (count($cags) > 0) {
        $udur = 1;
    }

    if (count($cags) > 1) {
        $index = count($cags);

        $start = "$dayof $cags[0]";
        $end = "$dayof " . $cags[$index - 1];

        $start = new DateTime("$start");
        $end = new DateTime("$end");

        $interval = $start->diff($end);

        $hours = $interval->h;
        $minutes = $interval->i;

        return new cagBodoh("$hours ц $minutes мин", "$hours:$minutes", $udur);
    } else return new cagBodoh("", "00:00", $udur);
}

function sumCag($times)
{
    $sum = "00:00";
    if (count($times) > 0) {
        $sum = new DateTime($times[0]);

        foreach (array_slice($times, 1) as $time) {
            // DateInterval-ийг үүсгэнэ
            $interval = new DateInterval('PT' . str_replace(':', 'H', $time) . 'M');
            $sum->add($interval);
        }
    }
    return $sum->format('H:i');
}

function hocrolt($expectedTime, $now)
{
    // Хоцрогдлыг тооцоолно
    $now = DateTime::createFromFormat('H:i:s', $now);
    $expectedTime = DateTime::createFromFormat('H:i:s', $expectedTime);

    $interval = $now->diff($expectedTime);
    if ($now > $expectedTime) {
        if ($interval->h > 0) {
            return $interval->h . " ц " . $interval->i . " мин";
        } elseif ($interval->i > 0) {
            return $interval->i . " мин";
        }
    } else {
        return ""; //Хоцролт байхгүй
    }
}
function hocroltOne($expectedTime, $now)
{
    // Хоцрогдлыг тооцоолно
    $now = DateTime::createFromFormat('H:i:s', $now);
    $expectedTime = DateTime::createFromFormat('H:i:s', $expectedTime);

    $interval = $now->diff($expectedTime);

    if ($now > $expectedTime) {
        return ($interval->h * 60) + $interval->i;
    } else {
        return 0; //Хоцролт байхгүй
    }
}
