<?php
session_start();
if (isset($_SESSION['role'], $_SESSION['id']) && $_SESSION['role'] === "admin") {
    include "DB_connection.php";
    include "app/Model/User.php";

    if (empty($_GET['id'])) {
        $_SESSION['error'] = "No user specified.";
        header("Location: user.php");
        exit();
    }

    $id = (int) $_GET['id'];
    $user = get_user_by_id($conn, $id);

    if ($user === 0) {
        $_SESSION['error'] = "User not found.";
        header("Location: user.php");
        exit();
    }

    delete_user($conn, [$id]);
    $_SESSION['success'] = "User deleted successfully.";
    header("Location: user.php");
    exit();

} else {
    $_SESSION['error'] = "Please log in first.";
    header("Location: login.php");
    exit();
}
?>
