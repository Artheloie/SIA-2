<?php
session_start();

// Check if user is logged in and is admin or client
if (isset($_SESSION['role'], $_SESSION['id']) && in_array($_SESSION['role'], ['admin', 'client'])) {
    require_once "DB_connection.php";
    require_once "app/Model/User.php";

    // Sanitize session user ID
    $user_id = intval($_SESSION['id']);
    $user = get_user_by_id($conn, $user_id);

    // Redirect if user not found
    if (!$user) {
        header("Location: login.php?error=User not found");
        exit();
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <title>Profile</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
    <!-- FontAwesome 4.7 -->
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" />
    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/style.css" />
</head>

<body>
    <input type="checkbox" id="checkbox" />
    <?php include "inc/header.php"; ?>

    <div class="container-fluid">
        <div class="row">
            <nav class="col-md-2 p-0 bg-light">
                <?php include "inc/nav.php"; ?>
            </nav>

            <main class="col-md-10 p-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 class="title">Profile</h4>
                    <a href="edit_profile.php" class="btn btn-primary btn-sm">
                        <i class="fa fa-edit"></i> Edit Profile
                    </a>
                </div>

                <div class="table-responsive" style="max-width: 500px;">
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <th scope="row">Full Name</th>
                                <td><?= htmlspecialchars($user['full_name'], ENT_QUOTES, 'UTF-8'); ?></td>
                            </tr>
                            <tr>
                                <th scope="row">Username</th>
                                <td><?= htmlspecialchars($user['username'], ENT_QUOTES, 'UTF-8'); ?></td>
                            </tr>
                            <tr>
                                <th scope="row">Joined At</th>
                                <td><?= htmlspecialchars($user['created_at'], ENT_QUOTES, 'UTF-8'); ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </main>
        </div>
    </div>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const active = document.querySelector("#navList li:nth-child(3)");
        if (active) active.classList.add("active");
    </script>
</body>

</html>
<?php
} else {
    $em = urlencode("First login");
    header("Location: login.php?error=$em");
    exit();
}
?>
