<?php
if(!empty($_SESSION["adminid"])) {
    
} else {
    redirect('/login');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>ТЭНДОҮ ТӨВ</title>
  <!-- plugins:css -->
  <link rel="stylesheet" href="/vendors/feather/feather.css">
  <link rel="stylesheet" href="/vendors/ti-icons/css/themify-icons.css">
  <link rel="stylesheet" href="/vendors/css/vendor.bundle.base.css">
  <!-- endinject -->
  <!-- Plugin css for this page -->
  <link rel="stylesheet" href="/vendors/mdi/css/materialdesignicons.min.css">
  <!-- End plugin css for this page -->
  <!-- inject:css -->
  <link rel="stylesheet" href="/css/vertical-layout-light/style.css">
  <!-- endinject -->
  <link rel="shortcut icon" href="/images/favicon.png" />
  <link rel="stylesheet" type="text/css" href="/css/dataTable.css">
  <style>
    .editcell {
        background-color: #dddddd;
        padding;padding: 10px;
        border-radius: 10px;
    }
  </style>