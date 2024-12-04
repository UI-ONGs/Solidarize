<?php
session_start();

function isLoggedIn() {
    return isset($_SESSION['user_id']) && isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true;
}

function requireLogin() {
    if (!isLoggedIn()) {
        header('Location: ../Login.php');
        exit;
    }
}

function requireGuest() {
    if (isLoggedIn()) {
        header('Location: ../Perfil.php');
        exit;
    }
}