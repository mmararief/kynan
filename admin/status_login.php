<?php
// Tambahkan di awal file PHP
header('Access-Control-Allow-Origin: http://localhost:3000');
header('Access-Control-Allow-Credentials: true');

session_start();

if (isset($_SESSION['USER'])) {
    echo json_encode(array('status' => 'success', 'user' => $_SESSION['USER']));
} else {
    echo json_encode(array('status' => 'error', 'message' => 'User not logged in'));
}
