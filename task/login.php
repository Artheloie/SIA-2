<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login | Task Management System</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: gray;
      color: gray;
    }
    .gradient-custom {
      background: gray;
    }
  </style>
</head>
<body class="gradient-custom vh-100">
  <div class="container py-5 h-100">
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col-12 col-md-8 col-lg-6 col-xl-5">
        <div class="card bg-dark text-white" style="border-radius: 2rem;">
          <div class="card-body p-5 text-center">
            <div class="mb-md-10 mt-md-0 pb-10">
              <h2 class="fw-bold mb-2 text-uppercase">Login</h2>
              <p class="text-white-100 mb-5">Please enter your username and password!</p>

              <?php if (isset($_GET['error'])) { ?>
                <div class="alert alert-danger" role="alert">
                  <?php echo stripcslashes($_GET['error']); ?>
                </div>
              <?php } ?>

              <?php if (isset($_GET['success'])) { ?>
                <div class="alert alert-success" role="alert">
                  <?php echo stripcslashes($_GET['success']); ?>
                </div>
              <?php } ?>

              <form method="POST" action="app/login.php">
                <div class="form-outline form-white mb-4">
                  <input type="text" id="typeUserX" class="form-control form-control-lg" name="user_name" placeholder="Username" required>
                  <label class="form-label" for="typeUserX">User Name</label>
                </div>

                <div class="form-outline form-white mb-4">
                  <input type="password" id="typePasswordX" class="form-control form-control-lg" name="password" placeholder="Password" required>
                  <label class="form-label" for="typePasswordX">Password</label>
                </div>

                <button type="submit" class="btn btn-outline-light btn-lg px-20">Login</button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
