<?php
// phone, userpassword хүлээж авна
$phone = post('phone', 15);
$password = post('userpassword', 12);

// Алдааг хадгалах массив үүсгэнэ
$errors = [];

// Хэрэв phone password алдаатай бол алдааг session-д бичээд логин хуудас руу үсэргэнэ
if (strlen($phone) < 3) {
    $errors[] = "Утасны дугаар буруу байна";
}

if (strlen($password) < 1) {
    $errors[] = "Нууц үгээ зөв оруулна уу";
}

if (sizeof($errors) > 0) {
    $_SESSION['errors'] = $errors;
    redirect('/login');
}

// Базаас ийм утас нууц үгтэй хүний мэдээллийг татна
_selectRow(
    "select id, name, type from adminusers where name=? and passw=?",
    'ss',
    [$phone, $password],
    $id, $name, $type
);

/* Хэрэв мэдээлэл ирсэн байвал
1) session эхлүүлнэ
2) session-д хэрэглэгчийн мэдээллийг бичнэ
3) home хуудас руу үсэргэнэ
 */
if (!empty($name)) {
    $_SESSION['adminid'] = $id;
    $_SESSION['userid'] = $id;
    $_SESSION['adminname'] = $name;
    $_SESSION['admintype'] = $phone;
    redirect('/admin/home');
} else {
    $_SESSION['errors'] = ["Таны утас юмуу нууц үг буруу байна"];
    redirect('/login');
}