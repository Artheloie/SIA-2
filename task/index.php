

<?php
session_start();
if (isset($_SESSION['role']) && isset($_SESSION['id'])) {

	include "DB_connection.php";
	include "app/Model/Task.php";
	include "app/Model/User.php";

	if ($_SESSION['role'] == "admin" || $_SESSION['role'] == "client") {
		$todaydue_task = count_tasks_due_today($conn);
		$overdue_task = count_tasks_overdue($conn);
		$nodeadline_task = count_tasks_NoDeadline($conn);
		$num_task = count_tasks($conn);
		$num_users = count_users($conn);
		$pending = count_pending_tasks($conn);
		$in_progress = count_in_progress_tasks($conn);
		$completed = count_completed_tasks($conn);
	} else {
		$num_my_task = count_my_tasks($conn, $_SESSION['id']);
		$overdue_task = count_my_tasks_overdue($conn, $_SESSION['id']);
		$nodeadline_task = count_my_tasks_NoDeadline($conn, $_SESSION['id']);
		$pending = count_my_pending_tasks($conn, $_SESSION['id']);
		$in_progress = count_my_in_progress_tasks($conn, $_SESSION['id']);
		$completed = count_my_completed_tasks($conn, $_SESSION['id']);
	}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
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
            <div class="col-md-10 p-4">
                <h4 class="mb-4"><h2><strong>Dashboard</strong></h2></h4>

                <section class="section-1">
                    <div class="row g-4">
                        <?php 
                        $cards = [];

                        if ($_SESSION['role'] == "admin" || $_SESSION['role'] == "client") {
                            $cards = [
                                ["fa-users", "$num_users Employee"],
                                ["fa-tasks", "$num_task All Tasks"],
                                ["fa-xmark", "$overdue_task Overdue"],
                                ["fa-clock", "$nodeadline_task No Deadline"],
                                ["fa-triangle-exclamation", "$todaydue_task Due Today"],
                                ["fa-bell", "$overdue_task Notifications"],
                                ["fa-square", "$pending Pending"],
                                ["fa-spinner", "$in_progress In Progress"],
                                ["fa-square-check", "$completed Completed"],
                            ];
                        } else {
                            $cards = [
                                ["fa-tasks", "$num_my_task My Tasks"],
                                ["fa-xmark", "$overdue_task Overdue"],
                                ["fa-clock", "$nodeadline_task No Deadline"],
                                ["fa-square", "$pending Pending"],
                                ["fa-spinner", "$in_progress In Progress"],
                                ["fa-square-check", "$completed Completed"],
                            ];
                        }

                        foreach ($cards as $card) {
                            echo '<div class="col-md-4">
                                    <div class="card shadow-sm text-center p-3 h-100">
                                        <i class="fa ' . $card[0] . ' fa-2x mb-2 text-primary"></i>
                                        <h6 class="mb-0">' . $card[1] . '</h6>
                                    </div>
                                </div>';
                        }
                        ?>
                    </div>
                </section>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        const active = document.querySelector("#navList li:nth-child(1)");
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
