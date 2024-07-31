<?php
if (!isset($_SESSION['user_id']) || !isset($_SESSION['user_fname'])) {
  redirect("/login");
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
  <style>
    .alert {
      --mdb-alert-padding-x: 0.8rem;
      --mdb-alert-padding-y: 0.3rem;
    }

    .btn-outline-primary {
      --mdb-btn-active-bg: #386bc0;
      --mdb-btn-active-color: #fff;
    }

    .btn-outline-warning {
      --mdb-btn-active-bg: #e4a11b;
      --mdb-btn-active-color: #fff;
    }

    [class*=btn-outline-] {
      --mdb-btn-border-width: 1px;
    }

    .table>:not(caption)>*>* {
      padding: 0.3rem 0.8rem;
    }

    .active_row {
      background-color: #d1b2f7;
    }

    .editcell {
      background-color: #dddddd;
      padding: 5px 10px 5px 10px;
      border-radius: 10px;
    }
    .hovercell td:hover {
        background-color: azure; !important;
    }
  </style>