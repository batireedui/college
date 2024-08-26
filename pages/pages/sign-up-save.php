<?php
$username = post('username', 50);
$userpassword = post('userpassword', 10);
$confirmpassword = post('confirmpassword', 10);
$phone = post('phone', 15);
$email = post('email', 150);
$terms = post('terms');

// Алдаануудыг хадгалах массив
$errors = [];

// Хэрэглэгчийн нэр шаардлага хангаж буй эсэх
if (mb_strlen($username) < 4) {
    $errors[] = "Хэрэглэгчийн нэрийн урт дор хаяж 4 үсгээс тогтоно";
}

// Ийм утастай хэрэглэгч бүртгэлтэй эсэх
_select(
    $stmt, $count,
    "select count(*) from users where phone=?",
    's',
    [$phone],
    $numberOfPhone
);

_fetch($stmt);

if ($numberOfPhone > 0) {
    $errors[] = "$phone утасны дугаар аль хэдийн бүртгэлтэй байна.";
}

// Ийм имэйлтэй хэрэглэгч бүртгэлтэй эсэх
_selectRow(
    "select count(*) from users where email=?",
    's',
    [$email],
    $numberOfEmail
);

if ($numberOfEmail > 0) {
    $errors[] = "$email имэйл аль хэдийн бүртгэлтэй байна.";
}

// Нууц үгүүд хоорондоо таарч буй эсэх
if ($userpassword != $confirmpassword) {
    $errors[] = "Нууц үгүүд хоорондоо таарахгүй байна";
}

// Үйлчилгээний нөхцлийг шалгах
if (empty($terms)) {
    $errors[] = "Та үйлчилгээний нөхцлийг уншиж зөвшөөрөх шаардлагатай";
}

// Ямар ч алдаагүй бол базд бүртгэнэ
if (sizeof($errors) == 0) {
    $success = _exec(
        "insert into users set name=?, pass=?, phone=?, email=?",
        'ssss',
        [$username, $userpassword, $phone, $email],
        $count
    );

    $_SESSION['name'] = $username;
    $_SESSION['phone'] = $phone;
    $_SESSION['email'] = $email;

    redirect("/user/home");
} else {
    $_SESSION['errors'] = $errors;
    redirect("/sign-up");
}