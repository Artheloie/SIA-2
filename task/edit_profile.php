<?php
session_start();
if (isset($_SESSION['role']) && isset($_SESSION['id']) && ($_SESSION['role'] == "admin" || $_SESSION['role'] == "client")) {
    include "DB_connection.php";
    include "app/Model/User.php";
    $user = get_user_by_id($conn, $_SESSION['id']);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add User</title>
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
    <?php include "inc/header.php" ?>
    <div class="body">
        <?php include "inc/nav.php" ?>
        <section class="section-1">
            <h4 class="title">Edit Profile <a href="profile.php">Profile</a></h4>
            <form class="form-1" method="POST" action="app/update-profile.php">
                <?php if (isset($_SESSION['error'])) { ?>
                <div class="danger" role="alert">
                    <?php echo stripcslashes($_SESSION['error']); ?>
                </div>
                <?php }
                    unset($_SESSION['error']);
                    ?>

                <?php if (isset($_SESSION['success'])) { ?>
                <div class="success" role="alert">
                    <?php echo stripcslashes($_SESSION['success']); ?>
                </div>
                <?php }
                    unset($_SESSION['success']);
                    ?>
                <div class="input-holder">
                    <lable>Full Name</lable>
                    <input type="text" name="full_name" class="input-1" placeholder="Full Name"
                        value="<?= $user['full_name'] ?>"><br>
                </div>

                <div class="input-holder">
                    <lable>Old Password</lable>
                    <input type="text" value="**********" name="password" class="input-1"
                        placeholder="Old Password"><br>
                </div>
                <div class="input-holder">
                    <lable>New Password</lable>
                    <input type="text" name="new_password" class="input-1" placeholder="New Password"><br>
                </div>
                <div class="input-holder">
                    <lable>Confirm Password</lable>
                    <input type="text" name="confirm_password" class="input-1" placeholder="Confirm Password"><br>
                </div>

                <button class="edit-btn">Change</button>
            </form>

        </section>
    </div>

    <script type="text/javascript">
    var active = document.querySelector("#navList li:nth-child(3)");
    active.classList.add("active");
    </script>
</body>

</html>
<?php } else {
    $em = "First login";
    header("Location: login.php?error=$em");
    exit();
}
?>
