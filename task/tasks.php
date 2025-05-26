<?php
session_start();
if (isset($_SESSION['role']) && isset($_SESSION['id']) && ($_SESSION['role'] == "admin" || $_SESSION['role'] == "client")) {
    include "DB_connection.php";
    include "app/Model/Task.php";
    include "app/Model/User.php";

    $text = "All Task";
    if (isset($_GET['due_date']) &&  $_GET['due_date'] == "Due Today") {
        $text = "Due Today";
        $tasks = get_all_tasks_due_today($conn);
        $num_task = count_tasks_due_today($conn);
    } else if (isset($_GET['due_date']) &&  $_GET['due_date'] == "Overdue") {
        $text = "Overdue";
        $tasks = get_all_tasks_overdue($conn);
        $num_task = count_tasks_overdue($conn);
    } else if (isset($_GET['due_date']) &&  $_GET['due_date'] == "No Deadline") {
        $text = "No Deadline";
        $tasks = get_all_tasks_NoDeadline($conn);
        $num_task = count_tasks_NoDeadline($conn);
    } else {
        $tasks = get_all_tasks($conn);
        $num_task = count_tasks($conn);
    }
    $users = get_all_users($conn);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <title>All Tasks</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
    <!-- FontAwesome 6 -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet" />
    <!-- Your Custom CSS -->
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
                <?php if ($_SESSION['role'] == "admin") { ?>
                    <div class="mb-3 d-flex flex-wrap gap-2">
                        <a href="create_task.php" class="btn btn-primary"><i class="fa fa-plus"></i> Create Task</a>
                        <a href="tasks.php?due_date=Due Today" class="btn btn-outline-secondary">Due Today</a>
                        <a href="tasks.php?due_date=Overdue" class="btn btn-outline-secondary">Overdue</a>
                        <a href="tasks.php?due_date=No Deadline" class="btn btn-outline-secondary">No Deadline</a>
                        <a href="tasks.php" class="btn btn-outline-secondary">All Tasks</a>
                    </div>
                <?php } ?>
                <h4 class="mb-4"><?= htmlspecialchars($text) ?> (<?= intval($num_task) ?>)</h4>

                <?php if (isset($_GET['success'])) { ?>
                    <div class="alert alert-success" role="alert">
                        <?= htmlspecialchars(stripcslashes($_GET['success'])) ?>
                    </div>
                <?php } ?>

                <?php if ($tasks != 0 && count($tasks) > 0) { ?>
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Title</th>
                                    <th scope="col">Description</th>
                                    <th scope="col">Assigned To</th>
                                    <th scope="col">Due Date</th>
                                    <th scope="col">Status</th>
                                    <th scope="col" style="width: 140px;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 0;
                                foreach ($tasks as $task) { ?>
                                    <tr>
                                        <th scope="row"><?= ++$i ?></th>
                                        <td><?= htmlspecialchars($task['title']) ?></td>
                                        <td><?= htmlspecialchars($task['description']) ?></td>
                                        <td>
                                            <?php
                                            $assignedName = "Unknown";
                                            foreach ($users as $user) {
                                                if ($user['id'] == $task['assigned_to']) {
                                                    $assignedName = htmlspecialchars($user['full_name']);
                                                    break;
                                                }
                                            }
                                            echo $assignedName;
                                            ?>
                                        </td>
                                        <td><?= $task['due_date'] === "" ? "No Deadline" : htmlspecialchars($task['due_date']) ?></td>
                                        <td><?= htmlspecialchars($task['status']) ?></td>
                                        <td>
                                            <?php if ($_SESSION['role'] == "admin") { ?>
                                                <a href="edit-task.php?id=<?= urlencode($task['id']) ?>" class="btn btn-sm btn-warning me-1">
                                                    <i class="fa fa-edit"></i> Edit
                                                </a>
                                            <?php } ?>
                                            <a href="delete-task.php?id=<?= urlencode($task['id']) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this task?');">
                                                <i class="fa fa-trash"></i> Delete
                                            </a>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                <?php } else { ?>
                    <div class="alert alert-info">No tasks found.</div>
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
