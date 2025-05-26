<?php
session_start();
if (isset($_SESSION['role'], $_SESSION['id']) && $_SESSION['role'] === "admin") {
    include "DB_connection.php";
    include "app/Model/User.php";

    if (empty($_GET['id'])) {
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
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Edit User</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <input type="checkbox" id="checkbox">
    <?php include "inc/header.php"; ?>
    <div class="body">
        <?php include "inc/nav.php"; ?>
        <section class="section-1">
            <h4 class="title">
                Edit User
                <a href="user.php">Back to Users</a>
            </h4>

            <!-- Flash messages -->
            <?php if (isset($_SESSION['error'])): ?>
                <div class="danger" role="alert">
                    <?= stripcslashes($_SESSION['error']); ?>
                </div>
                <?php unset($_SESSION['error']); ?>
            <?php endif; ?>
            <?php if (isset($_SESSION['success'])): ?>
                <div class="success" role="alert">
                    <?= stripcslashes($_SESSION['success']); ?>
                </div>
                <?php unset($_SESSION['success']); ?>
            <?php endif; ?>

            <form class="form-1" method="POST" action="app/update-user.php">
                <div class="input-holder">
                    <label>Full Name</label>
                    <input
                        type="text"
                        name="full_name"
                        class="input-1"
                        placeholder="Full Name"
                        value="<?= htmlspecialchars($user['full_name']) ?>"
                        required
                    >
                </div>

                <div class="input-holder">
                    <label>Username</label>
                    <input
                        type="text"
                        name="user_name"
                        class="input-1"
                        placeholder="Username"
                        value="<?= htmlspecialchars($user['username']) ?>"
                        required
                    >
                </div>

                <div class="input-holder">
                    <label>Password <small>(leave unchanged for no change)</small></label>
                    <input
                        type="password"
                        name="password"
                        class="input-1"
                        placeholder="New Password"
                    >
                </div>

                <input type="hidden" name="id" value="<?= $user['id'] ?>">

                <button type="submit" class="edit-btn">Update</button>
            </form>
        </section>
    </div>

    <script>
        document.querySelector("#navList li:nth-child(2)").classList.add("active");
    </script>
</body>
</html>
<?php 
} else {
    $_SESSION['error'] = "Please log in first.";
    header("Location: login.php");
    exit();
}
?>
