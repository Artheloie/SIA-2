<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login | Task Management System</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    body {
      background-color:rgb(166, 168, 172);
    }
    .login-card {
      max-width: 400px;
      margin: auto;
      margin-top: 200px;
      padding: 50px;
      background-color:rgb(96, 215, 221);
      border-radius: 8px;
      box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
    }
    .login-title {
      font-size: 28px;
      font-weight: bold;
      text-align: center;
    }
    .form-control::placeholder {
      color: #adb5bd;
    }
    .input-group-text {
      background-color: #ffffff;
      border-right: none;
    }
    .form-control {
      border-left: none;
    }
    .form-control:focus {
      box-shadow: none;
    }
  </style>
</head>
<body>

<div class="login-card">
  <div class="login-title mb-4">
    <strong>T.M.S</strong> LOGIN
  </div>
  <p class="text-center text-muted mb-4">Sign in with your credentials!</p>

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
    <div class="mb-3 input-group">
      <span class="input-group-text"><i class="fas fa-user"></i></span>
      <input type="text" class="form-control" name="user_name" placeholder="Username" required>
    </div>

    <div class="mb-4 input-group">
      <span class="input-group-text"><i class="fas fa-lock"></i></span>
      <input type="password" class="form-control" name="password" placeholder="Password" required>
    </div>

    <div class="d-grid">
      <button type="submit" class="btn btn-primary">Login</button>
    </div>
  </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
