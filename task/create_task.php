<?php 
session_start();
if (isset($_SESSION['role']) && isset($_SESSION['id']) && $_SESSION['role'] == "admin") {
    include "DB_connection.php";
    include "app/Model/User.php";

    $users = get_all_users($conn, "employee");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Task</title>
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

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-2 p-0 bg-light">
                <?php include "inc/nav.php" ?>
            </div>
            <div class="col-md-8 p-4">
                <h2><strong>Create Task</strong></h2>

                <!-- Flash Messages -->
                <?php if (isset($_GET['error'])): ?>
                    <div class="alert alert-danger"><?= stripcslashes($_GET['error']); ?></div>
                <?php endif; ?>

                <?php if (isset($_GET['success'])): ?>
                    <div class="alert alert-success"><?= stripcslashes($_GET['success']); ?></div>
                <?php endif; ?>

                <form method="POST" action="app/add-task.php" class="row g-3">
                    <div class="col-md-6">
                        <label for="title" class="form-label">Title</label>
                        <input type="text" name="title" class="form-control" id="title" placeholder="Title">
                    </div>
                    <div class="col-md-6">
                        <label for="due_date" class="form-label">Due Date</label>
                        <input type="date" name="due_date" class="form-control" id="due_date">
                    </div>
                    <div class="col-12">
                        <label for="description" class="form-label">Description</label>
                        <textarea name="description" class="form-control" id="description" rows="3" placeholder="Description"></textarea>
                    </div>
                    <div class="col-md-5">
                        <label for="assigned_to" class="form-label">Assign to</label>
                        <select name="assigned_to" class="form-select" id="assigned_to">
                            <option value="0">Select employee</option>
                            <?php if ($users != 0): foreach ($users as $user): ?>
                                <option value="<?= $user['id'] ?>"><?= $user['full_name'] ?></option>
                            <?php endforeach; endif; ?>
                        </select>
                    </div>
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary">Create Task</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        const active = document.querySelector("#navList li:nth-child(3)");
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
