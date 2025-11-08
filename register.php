<?php
require('connections.inc.php');

$register_success = '';
$register_error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);  
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $role = trim($_POST['role']);

    // Check if email already exists
    $check = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $check->bind_param("s", $email);
    $check->execute();
    $check_result = $check->get_result();

    if ($check_result->num_rows > 0) {
        $register_error = "Email already registered!";
    } else {
        // Hash the password securely
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);

        // Insert new user
        $stmt = $conn->prepare("INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $name,  $email, $hashed_password, $role);

        if ($stmt->execute()) {
            $register_success = "Registration successful! You can now <a href='login.php'>login here</a>.";
        } else {
            $register_error = "Registration failed. Please try again.";
        }

        $stmt->close();
    }
    $check->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register - Hospital Management System</title>
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
    .register-container {
      width: 100%;
      max-width: 420px;
      padding: 2rem;
      background-color: rgba(255, 255, 255, 0.95);
      border-radius: 10px;
      box-shadow: 0 4px 15px rgba(0,0,0,0.3);
    }
    .register-btn {
      background-color: #48c774;
      color: white;
    }
    .register-btn:hover {
      background-color: #3ec46d;
    }
    .lg { font-size: 19px; }
  </style>
</head>
<body>

  <div class="register-container">
    <h1 class="title has-text-centered lg">Register Account</h1>

    <?php if (!empty($register_success)) { ?>
      <p class="notification is-success has-text-centered"><?= $register_success; ?></p>
    <?php } elseif (!empty($register_error)) { ?>
      <p class="notification is-danger has-text-centered"><?= $register_error; ?></p>
    <?php } ?>

    <form method="POST">

    <div class="field">
        <label class="label">Full Name</label>
        <input class="input" type="text" name="name" placeholder="Enter your name" required>
      </div>

      <div class="field">
        <label class="label">Email</label>
        <input class="input" type="email" name="email" placeholder="Enter your email" required>
      </div>

      <div class="field">
        <label class="label">Password</label>
        <input class="input" type="password" name="password" placeholder="Enter password" required>
      </div>

      <div class="field">
        <label class="label">Select Role</label>
        <div class="select is-fullwidth">
          <select name="role" required>
            <option value="">-- Select Role --</option>
            <option value="admin">Admin</option>
            <option value="doctor">Doctor</option>
            <option value="nurse">Nurse</option>
            <option value="accountant">Accountant</option>
            <option value="receptionist">Receptionist</option>
            <option value="pharmacist">Pharmacist</option>
            <option value="labtechnician">Labtech</option>
            <option value="patients">Patients</option>
          </select>
        </div>
      </div>

      <button type="submit" class="button is-fullwidth register-btn mt-4">Register</button>
    </form>

    <p class="has-text-centered mt-3">
      Already have an account? <a href="login.php">Login</a>
    </p>
  </div>

</body>
</html>
