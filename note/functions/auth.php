<?php
// functions/auth.php
session_start();

function isLoggedIn() {
    return isset($_SESSION['user']);
}

function isAdmin() {
    return (isset($_SESSION['role']) && $_SESSION['role'] === 'admin');
}

function isStudent() {
    return (isset($_SESSION['role']) && $_SESSION['role'] === 'student');
}

function requireLogin() {
    if (!isLoggedIn()) {
        header("Location: ../pages/login.php");
        exit;
    }
}
?>