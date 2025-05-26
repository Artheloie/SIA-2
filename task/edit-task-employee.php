<?php
session_start();
if (isset($_SESSION['role']) && isset($_SESSION['id']) && $_SESSION['role'] == "employee") {
	include "DB_connection.php";
	include "app/Model/Task.php";
	include "app/Model/User.php";

	if (!isset($_GET['id'])) {
		header("Location: tasks.php");
		exit();
	}
	$id = $_GET['id'];
	$task = get_task_by_id($conn, $id);

	if ($task == 0) {
		header("Location: tasks.php");
		exit();
	}
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Edit Task</title>
	<!-- Bootstrap 5 CSS -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
	<!-- Font Awesome -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<!-- Custom CSS -->
	<link rel="stylesheet" href="css/style.css">
</head>

<body>
	<input type="checkbox" id="checkbox">
	<?php include "inc/header.php"; ?>
	<div class="container-fluid">
		<div class="row">
			<nav class="col-md-2 p-0 bg-light">
				<?php include "inc/nav.php"; ?>
			</nav>
			<main class="col-md-10 p-4">
				<div class="d-flex justify-content-between align-items-center mb-4">
					<h4 class="title">Edit Task</h4>
					<a href="my_task.php" class="btn btn-secondary btn-sm">
						<i class="fa fa-arrow-left"></i> Back to Tasks
					</a>
				</div>

				<?php if (isset($_SESSION['error'])): ?>
					<div class="alert alert-danger"><?= htmlspecialchars(stripcslashes($_SESSION['error'])) ?></div>
					<?php unset($_SESSION['error']); ?>
				<?php endif; ?>

				<?php if (isset($_SESSION['success'])): ?>
					<div class="alert alert-success"><?= htmlspecialchars(stripcslashes($_SESSION['success'])) ?></div>
					<?php unset($_SESSION['success']); ?>
				<?php endif; ?>

				<form method="POST" action="app/update-task-employee.php">
					<div class="mb-3">
						<label class="form-label"><strong>Title:</strong></label>
						<p class="form-control-plaintext"><?= htmlspecialchars($task['title']) ?></p>
					</div>

					<div class="mb-3">
						<label class="form-label"><strong>Description:</strong></label>
						<p class="form-control-plaintext"><?= htmlspecialchars($task['description']) ?></p>
					</div>

					<div class="mb-3">
						<label for="status" class="form-label">Status</label>
						<select name="status" id="status" class="form-select" required>
							<option value="pending" <?= $task['status'] == "pending" ? 'selected' : '' ?>>Pending</option>
							<option value="in_progress" <?= $task['status'] == "in_progress" ? 'selected' : '' ?>>In Progress</option>
							<option value="completed" <?= $task['status'] == "completed" ? 'selected' : '' ?>>Completed</option>
						</select>
					</div>

					<input type="hidden" name="id" value="<?= $task['id'] ?>">

					<button type="submit" class="btn btn-primary">Update</button>
				</form>
			</main>
		</div>
	</div>

	<!-- Bootstrap 5 JS Bundle -->
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

	<script>
		// Highlight active nav item
		const active = document.querySelector("#navList li:nth-child(2)");
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
