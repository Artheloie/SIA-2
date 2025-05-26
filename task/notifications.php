<?php 
session_start();
if (isset($_SESSION['role']) && isset($_SESSION['id'])) {
    include "DB_connection.php";
    include "app/Model/Notification.php";

    $notifications = get_all_my_notifications($conn, $_SESSION['id']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Notifications</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
    <!-- FontAwesome 6 -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet" />
    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/style.css" />
</head>
<body>
    <input type="checkbox" id="checkbox" />
    <?php include "inc/header.php" ?>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-2 p-0 bg-light">
                <?php include "inc/nav.php" ?>
            </div>
            <div class="col-md-10 p-4">
                <h4 class="mb-4"><strong>All Notifications:<strong></h4>

                <?php if (isset($_GET['success'])) { ?>
                    <div class="alert alert-success" role="alert">
                        <?= htmlspecialchars(stripcslashes($_GET['success'])) ?>
                    </div>
                <?php } ?>

                <?php if ($notifications != 0 && count($notifications) > 0) { ?>
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>Message</th>
                                    <th>Type</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 0;
                                foreach ($notifications as $notification) { ?>
                                    <tr>
                                        <th scope="row"><?= ++$i ?></th>
                                        <td><?= htmlspecialchars($notification['message']) ?></td>
                                        <td><?= htmlspecialchars($notification['type']) ?></td>
                                        <td><?= htmlspecialchars($notification['date']) ?></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                <?php } else { ?>
                    <div class="alert alert-info">You have zero notifications.</div>
                <?php } ?>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        const active = document.querySelector("#navList li:nth-child(4)");
        if (active) active.classList.add("active");
    </script>
</body>
</html>
<?php 
} else { 
    $em = "First login";
    header("Location: login.php?error=$em");
    exit();
}
?>
