<?php
/*
  | Source Code Aplikasi Toko PHP & MySQL
  | 
  | @package   : kynan
  | @file	     : logout.php 
  | @author    : kynan@gmail.com
  | 
  | 
  | 
  | 
 */
session_start();
session_destroy();
?>
<!DOCTYPE html>
<html>

<head>
  <title>Logout</title>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.all.min.js"></script>
</head>

<body>
  <script>
    const Toast = Swal.mixin({
      toast: true,
      position: "top-end",
      showConfirmButton: false,
      timer: 2000,
      timerProgressBar: true,
      didOpen: (toast) => {
        toast.addEventListener("mouseenter", Swal.stopTimer);
        toast.addEventListener("mouseleave", Swal.resumeTimer);
      },
    });

    Toast.fire({
      icon: "warning",
      title: "Logout Successful",
    }).then(() => {
      window.location.href = "../index.php";
    });
  </script>
</body>

</html>