<?php
session_start();
include 'connection.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: sign-in.php");
    exit;
}

$user_id = $_SESSION['user_id'] ?? null;
$user_data = [];

if ($user_id) {
    // FETCH user and address
    $stmt = $con->prepare("
        SELECT
            u.first_name,
            u.last_name,
            u.date_of_birth,
            u.email,
            u.fcid,
            a.street,
            a.city,
            a.postal_code
        FROM users u
        LEFT JOIN user_address a ON u.user_id = a.user_id
        WHERE u.user_id = ?
    ");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user_data = $result->fetch_assoc();
    $stmt->close();
}

// Handle form update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_field'])) {
    $field = $_POST['update_field'];

    switch ($field) {
        case 'name':
            $first_name = $_POST['first_name'];
            $last_name = $_POST['last_name'];
            $stmt = $con->prepare("UPDATE users SET first_name = ?, last_name = ? WHERE user_id = ?");
            $stmt->bind_param("ssi", $first_name, $last_name, $user_id);
            $stmt->execute();
            break;

        case 'dob':
            $dob = $_POST['date_of_birth'];
            $stmt = $con->prepare("UPDATE users SET date_of_birth = ? WHERE user_id = ?");
            $stmt->bind_param("si", $dob, $user_id);
            $stmt->execute();
            break;

        case 'address':
            $street = $_POST['street'];
            $city = $_POST['city'];
            $postal_code = $_POST['postal_code'];
            $check = $con->prepare("SELECT address_id FROM user_address WHERE user_id = ?");
            $check->bind_param("i", $user_id);
            $check->execute();
            $res = $check->get_result();
            if ($res->num_rows > 0) {
                $stmt = $con->prepare("UPDATE user_address SET street = ?, city = ?, postal_code = ? WHERE user_id = ?");
                $stmt->bind_param("ssii", $street, $city, $postal_code, $user_id);
            } else {
                $stmt = $con->prepare("INSERT INTO user_address (user_id, street, city, postal_code) VALUES (?, ?, ?, ?)");
                $stmt->bind_param("issi", $user_id, $street, $city, $postal_code);
            }
            $stmt->execute();
            break;

        case 'email':
            $email = $_POST['email'];
            $stmt = $con->prepare("UPDATE users SET email = ? WHERE user_id = ?");
            $stmt->bind_param("si", $email, $user_id);
            $stmt->execute();
            break;

        case 'password':
            $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
            $stmt = $con->prepare("UPDATE users SET password = ? WHERE user_id = ?");
            $stmt->bind_param("si", $password, $user_id);
            $stmt->execute();
            break;

        case 'delete_account':
            $stmt = $con->prepare("DELETE FROM users WHERE user_id = ?");
            $stmt->bind_param("i", $user_id);
            $stmt->execute();
            session_destroy();
            header("Location: login.php");
            exit;
            break;
    }

    header("Location: account_settings.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Account Settings</title>
  <link rel="stylesheet" href="./styles/dashboard.css">
  <style>
    .edit-form input[type="text"], .edit-form input[type="date"], .edit-form input[type="email"], .edit-form input[type="password"] {
      width: 90%;
      padding: 5px;
      margin-bottom: 5px;
    }
    .edit-form button {
      margin-right: 5px;
    }
  </style>
</head>
<body>

<?php include 'sidebar.php'; ?>

<div class="main-content">
  <div class="account-settings">
    <div class="account-header">
      <h2>ACCOUNT SETTINGS</h2>
      <span>FCID #<?= htmlspecialchars($user_data['fcid'] ?? 'N/A') ?></span>
    </div>

    <!-- Personal Info -->
    <div class="section">
      <h3>Personal Info</h3>
      <p>Change details for your account.</p>

      <!-- Profile Name -->
      <div class="info-grid">
        <div class="label">Profile Name</div>
        <div id="nameDisplay">
          <?= htmlspecialchars($user_data['first_name'] . ' ' . $user_data['last_name']) ?><br>
          <span style="font-size: 0.9rem; color: #555;">Appears on your public athlete profile.</span>
        </div>
        <div>
          <svg onclick="editField('name')" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" width="20" height="20" style="cursor: pointer;">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536M9 13l6.293-6.293a1 1 0 011.414 0l.586.586a1 1 0 010 1.414L11 15H9v-2z" />
          </svg>
        </div>
      </div>
      <form method="POST" class="info-grid edit-form" id="nameForm" style="display:none;">
        <div class="label">Edit Name</div>
        <div>
          <input type="text" name="first_name" placeholder="First Name" value="<?= htmlspecialchars($user_data['first_name']) ?>">
          <input type="text" name="last_name" placeholder="Last Name" value="<?= htmlspecialchars($user_data['last_name']) ?>">
        </div>
        <div>
          <button type="submit" name="update_field" value="name">Save</button>
          <button type="button" onclick="cancelEdit('name')">Cancel</button>
        </div>
      </form>

      <!-- Date of Birth -->
      <div class="info-grid">
        <div class="label">Date of Birth</div>
        <div id="dobDisplay">
          <?= date("F j, Y", strtotime($user_data['date_of_birth'] ?? '')) ?>
        </div>
        <div>
          <svg onclick="editField('dob')" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" width="20" height="20" style="cursor: pointer;">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536M9 13l6.293-6.293a1 1 0 011.414 0l.586.586a1 1 0 010 1.414L11 15H9v-2z" />
          </svg>
        </div>
      </div>
      <form method="POST" class="info-grid edit-form" id="dobForm" style="display:none;">
        <div class="label">Edit DOB</div>
        <div><input type="date" name="date_of_birth" value="<?= $user_data['date_of_birth'] ?>"></div>
        <div>
          <button type="submit" name="update_field" value="dob">Save</button>
          <button type="button" onclick="cancelEdit('dob')">Cancel</button>
        </div>
      </form>

      <!-- Address -->
      <div class="info-grid">
        <div class="label">Address</div>
        <div id="addressDisplay">
          <?= htmlspecialchars($user_data['street'] . ', ' . $user_data['city'] . ' ' . $user_data['postal_code']) ?>
        </div>
        <div>
          <svg onclick="editField('address')" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" width="20" height="20" style="cursor: pointer;">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536M9 13l6.293-6.293a1 1 0 011.414 0l.586.586a1 1 0 010 1.414L11 15H9v-2z" />
          </svg>
        </div>
      </div>
      <form method="POST" class="info-grid edit-form" id="addressForm" style="display:none;">
        <div class="label">Edit Address</div>
        <div>
          <input type="text" name="street" placeholder="Street" value="<?= htmlspecialchars($user_data['street']) ?>"><br>
          <input type="text" name="city" placeholder="City" value="<?= htmlspecialchars($user_data['city']) ?>"><br>
          <input type="text" name="postal_code" placeholder="Postal Code" value="<?= htmlspecialchars($user_data['postal_code']) ?>">
        </div>
        <div>
          <button type="submit" name="update_field" value="address">Save</button>
          <button type="button" onclick="cancelEdit('address')">Cancel</button>
        </div>
      </form>
    </div>

    <!-- Account Login -->
    <div class="section">
      <h3>Account Login</h3>

      <!-- Email -->
      <div class="info-grid">
        <div class="label">Email</div>
        <div id="emailDisplay">
          <?= htmlspecialchars($user_data['email']) ?><br>
          <span style="font-size: 0.9rem; color: #555;">This email is linked to your account.</span>
        </div>
        <div>
          <svg onclick="editField('email')" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" width="20" height="20" style="cursor: pointer;">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536M9 13l6.293-6.293a1 1 0 011.414 0l.586.586a1 1 0 010 1.414L11 15H9v-2z" />
          </svg>
        </div>
      </div>
      <form method="POST" class="info-grid edit-form" id="emailForm" style="display:none;">
        <div class="label">Edit Email</div>
        <div><input type="email" name="email" value="<?= htmlspecialchars($user_data['email']) ?>"></div>
        <div>
          <button type="submit" name="update_field" value="email">Save</button>
          <button type="button" onclick="cancelEdit('email')">Cancel</button>
        </div>
      </form>

      <!-- Password -->
      <div class="info-grid">
        <div class="label">Password</div>
        <div>**********<br>
          <span style="font-size: 0.9rem; color: #555;">We recommend updating your password periodically to prevent unauthorized access.</span>
        </div>
        <div>
          <svg onclick="editField('password')" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" width="20" height="20" style="cursor: pointer;">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536M9 13l6.293-6.293a1 1 0 011.414 0l.586.586a1 1 0 010 1.414L11 15H9v-2z" />
          </svg>
        </div>
      </div>
      <form method="POST" class="info-grid edit-form" id="passwordForm" style="display:none;">
        <div class="label">New Password</div>
        <div><input type="password" name="password"></div>
        <div>
          <button type="submit" name="update_field" value="password">Save</button>
          <button type="button" onclick="cancelEdit('password')">Cancel</button>
        </div>
      </form>
    </div>

    <!-- Delete Account -->
    <div class="section">
      <h3>Delete your Account</h3>
      <form method="POST" class="info-grid">
        <div class="label">Account Removal</div>
        <div>
          <button class="delete-btn" type="submit" name="update_field" value="delete_account">Delete Account</button><br>
          <span style="font-size: 0.9rem; color: #555;">This is a permanent action. All info will be deleted.</span>
        </div>
        <div></div>
      </form>
    </div>
  </div>
</div>

<script>
function editField(field) {
  document.getElementById(field + 'Form').style.display = 'grid';
  document.getElementById(field + 'Display').style.display = 'none';
}
function cancelEdit(field) {
  document.getElementById(field + 'Form').style.display = 'none';
  document.getElementById(field + 'Display').style.display = 'block';
}
</script>
</body>
</html>
