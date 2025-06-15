<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
      <link rel="stylesheet" href="./styles/dashboard.css">
</head>
<body>

<?php
include 'sidebar.php';
?>

<div class="main-content">
  <div class="account-settings">
    <div class="account-header">
      <h2>ACCOUNT SETTINGS</h2>
      <span>FCID #202311233</span>
    </div>

    <!-- Personal Info -->
    <div class="section">
      <h3>Personal Info</h3>
      <p>Change details for your account.</p>

      <!-- Profile Name -->
      <div class="info-grid">
        <div class="label">Profile Name</div>
        <div>
          Ayumu Uehara<br>
          <span style="font-size: 0.9rem; color: #555;">Appears on your public athlete profile and on CrossFit Games leaderboards.</span>
        </div>
        <div>
            <!-- Pencil Edit Icon -->
            <svg xmlns="http://www.w3.org/2000/svg"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
                stroke-width="2"
                width="20"
                height="20"
                style="cursor: pointer;">
            <path stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M15.232 5.232l3.536 3.536M9 13l6.293-6.293a1 1 0 011.414 0l.586.586a1 1 0 010 1.414L11 15H9v-2z" />
            </svg>
        </div>
      </div>

      <!-- Date of Birth -->
    <div class="info-grid">
        <div class="label">Date of Birth</div>
            <div>September 26, 2000</div>
            <div>
                <!-- Pencil Edit Icon -->
                <svg xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                    stroke-width="2"
                    width="20"
                    height="20"
                    style="cursor: pointer;">
                <path stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M15.232 5.232l3.536 3.536M9 13l6.293-6.293a1 1 0 011.414 0l.586.586a1 1 0 010 1.414L11 15H9v-2z" />
                </svg>
            </div>
        </div>
    <div class="info-grid">
        <div class="label">Address</div>
        <div>blk 1 lot 2 street ph 4102</div>
    <div>
        <!-- Pencil Edit Icon -->
        <svg xmlns="http://www.w3.org/2000/svg"
            fill="none"
            viewBox="0 0 24 24"
            stroke="currentColor"
            stroke-width="2"
            width="20"
            height="20"
            style="cursor: pointer;">
        <path stroke-linecap="round"
                stroke-linejoin="round"
                d="M15.232 5.232l3.536 3.536M9 13l6.293-6.293a1 1 0 011.414 0l.586.586a1 1 0 010 1.414L11 15H9v-2z" />
        </svg>
    </div>
      </div>
    </div>
    <!-- Account Login -->
    <div class="section">
    <h3>Account Login</h3>

    <!-- Email -->
    <div class="info-grid">
        <div class="label">Email</div>
        <div>
        ayumuuehara26@gmail.com<br>
        <span style="font-size: 0.9rem; color: #555;">This email is linked to your account.</span>
        </div>
            <div>
        <!-- Pencil Edit Icon -->
        <svg xmlns="http://www.w3.org/2000/svg"
            fill="none"
            viewBox="0 0 24 24"
            stroke="currentColor"
            stroke-width="2"
            width="20"
            height="20"
            style="cursor: pointer;">
        <path stroke-linecap="round"
                stroke-linejoin="round"
                d="M15.232 5.232l3.536 3.536M9 13l6.293-6.293a1 1 0 011.414 0l.586.586a1 1 0 010 1.414L11 15H9v-2z" />
        </svg>
    </div>
    </div>

    <!-- Password -->
    <div class="info-grid">
        <div class="label">Password</div>
        <div>
        **********<br>
        <span style="font-size: 0.9rem; color: #555;">We recommend updating your password periodically to prevent unauthorized access.</span>
        </div>
        <div>
            <!-- Pencil Edit Icon -->
            <svg xmlns="http://www.w3.org/2000/svg"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
                stroke-width="2"
                width="20"
                height="20"
                style="cursor: pointer;">
            <path stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M15.232 5.232l3.536 3.536M9 13l6.293-6.293a1 1 0 011.414 0l.586.586a1 1 0 010 1.414L11 15H9v-2z" />
            </svg>
        </div>
    </div>
    </div> <!-- closes Account Login section -->

    <!-- Delete Account -->
    <div class="section">
    <h3>Delete your Account</h3>

    <div class="info-grid">
        <div class="label">Account Removal</div>
        <div>
        <button class="delete-btn">Delete Account</button><br>
        <span style="font-size: 0.9rem; color: #555;">This is a permanent action. All info will be deleted.</span>
        </div>
            <div>
            <!-- Pencil Edit Icon -->
            <svg xmlns="http://www.w3.org/2000/svg"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
                stroke-width="2"
                width="20"
                height="20"
                style="cursor: pointer;">
            <path stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M15.232 5.232l3.536 3.536M9 13l6.293-6.293a1 1 0 011.414 0l.586.586a1 1 0 010 1.414L11 15H9v-2z" />
            </svg>
        </div>
    </div>
    </div>

</div>

<script src="./script/test.js"></script>
</body>
</html>