<?php
if (!isset($_SESSION['user_id'])) {
  redirect("login");
} else {
  $user_id = $_SESSION['user_id'];
  $user_fname = $_SESSION['user_fname'];
  $user_lname = $_SESSION['user_lname'];
  $user_role = $_SESSION['user_role'];
  $user_phone = $_SESSION['user_phone'];
}
?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title><?= $pageTitle ?> </title>
  <link rel="icon" type="image/x-icon" href="<?= $favi ?>" />
  <meta name="description" content='Өвөрхангай ПК' />

  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />
  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet" />
  <!-- MDB -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.1/mdb.min.css" rel="stylesheet" />

  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />