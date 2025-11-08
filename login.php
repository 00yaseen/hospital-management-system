<?php
require('connections.inc.php');

$login_error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    $stmt = $conn->prepare("SELECT id, username, email, password, role FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        if (password_verify($password, $user['password'])) {
          
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['name'] = $user['username'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['role'] = strtolower($user['role']);

            // Redirect based on role
            switch ($_SESSION['role']) {
                case 'admin':
                    header("Location: admin/dashboard.php");
                    exit;
                case 'doctor':
                    header("Location: doctor/dashboard.php");
                    exit;
                case 'nurse':
                    header("Location: nurse/dashboard.php");
                    exit;
                case 'accountant':
                    header("Location: accountant/dashboard.php");
                    exit;
                case 'receptionist':
                    header("Location: receptionist/dashboard.php");
                    exit;
                case 'pharmacist':
                    header("Location: pharmacist/dashboard.php");
                    exit;
                case 'labtechnician':
                    header("Location: labtech/dashboard.php"); 
                    exit;
                case 'patient':
                    header("Location: patients/dashboard.php");
                    exit;
                default:
                    $login_error = "Role not recognized.";
            }
        } else {
            $login_error = "Invalid Password!";
        }
    } else {
        $login_error = "Invalid Email!";
    }

    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Hospital Management System - Login</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css">
  <style>
    body {
      background: url('hospital.jpg') no-repeat center center fixed;
      background-size: cover;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      font-family: 'Segoe UI', sans-serif;
      margin: 0;
    }
    body::before {
      content: "";
      position: fixed;
      top: 0; left: 0;
      width: 100%; height: 100%;
      background-color: rgba(0,0,0,0.3);
      z-index: -1;
    }
    .login-container {
      width: 100%;
      max-width: 400px;
      padding: 2rem;
      background-color: rgba(255, 255, 255, 0.95);
      border-radius: 10px;
      box-shadow: 0 4px 15px rgba(0,0,0,0.3);
    }
    .login-btn {
      background-color: #4a90e2;
      color: white;
    }
    .login-btn:hover {
      background-color: #357abd;
    }
    .lg { font-size: 19px; }
  </style>
</head>
<body>
  <div class="login-container">
    <h1 class="title has-text-centered lg">HMS Login</h1>

    <?php if (!empty($login_error)) { ?>
      <p class="notification is-danger has-text-centered"><?= htmlspecialchars($login_error); ?></p>
    <?php } ?>

    <form method="POST">
      <div class="field">
        <label class="label">Email</label>
        <input class="input" type="email" name="email" placeholder="Enter your email" required>
      </div>

      <div class="field">
        <label class="label">Password</label>
        <input class="input" type="password" name="password" placeholder="Enter your password" required>
      </div>

      <button type="submit" class="button is-fullwidth login-btn mt-4">Login</button>
    </form>
  </div>
</body>
</html>
