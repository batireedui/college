<?php
// phone, userpassword хүлээж авна
$username = trim(post('username', 100));
$password = trim(post('password', 100));
$user_role = trim(post('user_role', 10));
// Алдааг хадгалах массив үүсгэнэ
$errors = [];

// Хэрэв phone password алдаатай бол алдааг session-д бичээд логин хуудас руу үсэргэнэ
if (sizeof($errors) > 0) {
    $_SESSION['errors'] = $errors;
    redirect('/login');
}
$where = "";
if($user_role == 1) {
    $where = "and teacher.user_role=$user_role";
}
else if($user_role > 1){
    $where = "and teacher.user_role > 1";
}
/*
_selectRow(
    "select id, fname, lname, phone from teacher where tuluv=1 and phone=? and pass=? and user_role=?",
    'ssi',
    [$username, $password, $user_role],
    $user_id,
    $user_fname,
    $user_lname,
    $user_phone
);*/

_selectRow(
    "select teacher.id, teacher.fname, teacher.lname, teacher.phone, teacher.pass, teacher.user_role, at FROM teacher WHERE teacher.tuluv=1 and teacher.phone=? $where",
    's',
    [$username],
    $user_id,
    $user_fname,
    $user_lname,
    $user_phone,
    $user_pass,
    $user_role,
    $user_at
);

if (!empty($user_id)) {
    if (password_verify($password, $user_pass)) {
        $user_agent = $_SERVER['HTTP_USER_AGENT'];
        $success = _exec(
            "insert into loginlog(user, hezee, device, ip) VALUES(?, ?, ?, ?)",
            'isss',
            [$user_id, ognoo(), $user_agent, getIpAddress()],
            $count
        );

        $_SESSION['user_id'] = $user_id;
        $_SESSION['user_fname'] = $user_fname;
        $_SESSION['user_lname'] = $user_lname;
        $_SESSION['user_role'] = $user_role;
        $_SESSION['user_phone'] = $user_phone;
        $_SESSION['user_at'] = $user_at;
        $_SESSION['errors'] = "";
        redirect('/');
        
    } else {
        $_SESSION['errors'] = ["Таны нэвтрэх нэр эсвэл нууц үг буруу байна"];
        redirect('/login');
    }
} else {
    $_SESSION['errors'] = ["Таны нэвтрэх нэр эсвэл нууц үг буруу байна"];
    redirect('/login');
}
