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
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit User</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- FontAwesome 6 -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <input type="checkbox" id="checkbox">
    <?php include "inc/header.php"; ?>

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-2 p-0 bg-light">
                <?php include "inc/nav.php"; ?>
            </div>

            <div class="col-md-10 p-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2><strong>Edit User</strong></h2>
                    <a href="user.php" class="btn btn-secondary">
                        <i class="fa fa-arrow-left me-1"></i> Back to Users
                    </a>
                </div>

                <!-- Flash messages -->
                <?php if (isset($_SESSION['error'])): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <?= stripcslashes($_SESSION['error']); ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    <?php unset($_SESSION['error']); ?>
                <?php endif; ?>
                <?php if (isset($_SESSION['success'])): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <?= stripcslashes($_SESSION['success']); ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    <?php unset($_SESSION['success']); ?>
                <?php endif; ?>

                <form method="POST" action="app/update-user.php" class="needs-validation" novalidate>
                    <div class="mb-3">
                        <label class="form-label">Full Name</label>
                        <input
                            type="text"
                            name="full_name"
                            class="form-control"
                            placeholder="Full Name"
                            value="<?= htmlspecialchars($user['full_name']) ?>"
                            required
                        >
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Username</label>
                        <input
                            type="text"
                            name="user_name"
                            class="form-control"
                            placeholder="Username"
                            value="<?= htmlspecialchars($user['username']) ?>"
                            required
                        >
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Password <small class="text-muted">(leave blank to keep current password)</small></label>
                        <input
                            type="password"
                            name="password"
                            class="form-control"
                            placeholder="New Password"
                        >
                    </div>

                    <input type="hidden" name="id" value="<?= $user['id'] ?>">

                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-save me-1"></i> Update
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        const active = document.querySelector("#navList li:nth-child(2)");
        if (active) active.classList.add("active");
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
