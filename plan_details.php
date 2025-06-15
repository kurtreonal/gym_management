<?php
/* ----------------–  SET‑UP  ---------------- */
include 'connection.php';
session_start();
$admin_id = $_SESSION['admin_id'] ?? null;
if (!$admin_id) {
    header("Location: AdminAccess.php"); exit();
}

/* ---------  HANDLE  POST  ACTIONS  ---------- */
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    /*---------- UPDATE / DELETE / (UN)HIGHLIGHT ----------*/
    if (isset($_POST['action'])) {
        $id = intval($_POST['membership_id']);

        switch ($_POST['action']) {
            case 'update':
                $stmt = $con->prepare(
                    "UPDATE membership_plan
                     SET plan_name   = ?,
                         plan_details = ?,
                         membership_price = ?,
                         duration_days    = ?
                     WHERE membership_id = ? AND admin_id = ?"
                );
                $stmt->bind_param(
                    "ssiiii",
                    $_POST['plan_name'],
                    $_POST['plan_details'],
                    $_POST['membership_price'],
                    $_POST['duration_days'],
                    $id,
                    $admin_id
                );
                $stmt->execute();
                break;

            case 'delete':
                $stmt = $con->prepare(
                    "DELETE FROM membership_plan
                     WHERE membership_id = ? AND admin_id = ?"
                );
                $stmt->bind_param("ii", $id, $admin_id);
                $stmt->execute();
                break;

            case 'highlight':
            case 'unhighlight':
                $flag = ($_POST['action'] === 'highlight') ? 1 : 0;
                $stmt = $con->prepare(
                    "UPDATE membership_plan
                     SET is_highlighted = ?
                     WHERE membership_id = ? AND admin_id = ?"
                );
                $stmt->bind_param("iii", $flag, $id, $admin_id);
                $stmt->execute();
                break;
        }

        header("Location: plan_details.php"); exit();
    }

    /*----------------  ADD  NEW  PLAN  -------------------*/
    $stmt = $con->prepare(
        "INSERT INTO membership_plan
         (plan_name, plan_details, membership_price, duration_days, admin_id)
         VALUES (?, ?, ?, ?, ?)"
    );
    $stmt->bind_param(
        "ssiii",
        $_POST['plan_name'],
        $_POST['plan_details'],
        $_POST['membership_price'],
        $_POST['duration_days'],
        $admin_id
    );
    $stmt->execute();

    header("Location: plan_details.php"); exit();
}

/* --------------  FETCH ALL PLANS  ---------------- */
$plans = $con->query(
    "SELECT * FROM membership_plan
     WHERE admin_id = $admin_id
     ORDER BY membership_id DESC"
);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Membership Plans</title>
    <link rel="stylesheet" href="./styles/adminpage.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css">
</head>
<body>
<?php include 'admin-sidebar.php'; ?>

<div class="main-content">
  <div class="container py-4">
    <h2>Membership Plans</h2>

    <div class="table-responsive">
      <table class="table">
        <thead>
          <tr>
            <th>Plan&nbsp;Name</th>
            <th>Details</th>
            <th>Price&nbsp;(₱)</th>
            <th>Duration&nbsp;(days)</th>
            <th>Modify</th>
          </tr>
        </thead>
        <tbody>
          <?php while ($row = $plans->fetch_assoc()): ?>
            <?php if (isset($_GET['edit']) && $_GET['edit'] == $row['membership_id']): /* === EDIT MODE === */?>
              <tr>
                <form method="POST">
                  <td><input type="text"     name="plan_name"        value="<?= htmlspecialchars($row['plan_name'])        ?>" class="form-control" required></td>
                  <td><textarea              name="plan_details"                            class="form-control" required><?= htmlspecialchars($row['plan_details']) ?></textarea></td>
                  <td><input type="number"   name="membership_price" value="<?= $row['membership_price'] ?>" class="form-control" required></td>
                  <td><input type="number"   name="duration_days"    value="<?= $row['duration_days']    ?>" class="form-control" required></td>
                  <td>
                      <input type="hidden" name="membership_id" value="<?= $row['membership_id'] ?>">
                      <input type="hidden" name="action" value="update">
                      <button class="btn btn-success btn-sm">Save</button>
                      <a href="plan_details.php" class="btn btn-secondary btn-sm">Cancel</a>
                  </td>
                </form>
              </tr>
            <?php else: /* === DISPLAY MODE === */?>
              <tr>
                <td><?= htmlspecialchars($row['plan_name']) ?></td>
                <td><?= nl2br(htmlspecialchars($row['plan_details'])) ?></td>
                <td><?= number_format($row['membership_price'], 2) ?></td>
                <td><?= $row['duration_days'] ?></td>
                <td>
                    <!-- Update -->
                    <a href="plan_details.php?edit=<?= $row['membership_id'] ?>" class="btn btn-outline-light btn-sm">Update</a>

                    <!-- Delete -->
                    <form method="POST" style="display:inline;">
                        <input type="hidden" name="membership_id" value="<?= $row['membership_id'] ?>">
                        <input type="hidden" name="action" value="delete">
                        <button class="btn btn-outline-light btn-sm" onclick="return confirm('Delete this plan?')">Delete</button>
                    </form>

                    <!-- Highlight / Unhighlight -->
                    <?php if ($row['is_highlighted']): ?>
                        <form method="POST" style="display:inline;">
                            <input type="hidden" name="membership_id" value="<?= $row['membership_id'] ?>">
                            <input type="hidden" name="action" value="unhighlight">
                            <button class="btn btn-secondary btn-sm">Unhighlight</button>
                        </form>
                        <span class="badge bg-warning text-dark ms-1">&#10003;</span>
                    <?php else: ?>
                        <form method="POST" style="display:inline;">
                            <input type="hidden" name="membership_id" value="<?= $row['membership_id'] ?>">
                            <input type="hidden" name="action" value="highlight">
                            <button class="btn btn-warning btn-sm">Highlight</button>
                        </form>
                    <?php endif; ?>
                </td>
              </tr>
            <?php endif; ?>
          <?php endwhile; ?>
        </tbody>
      </table>
    </div>

    <!-- -------------  ADD NEW PLAN  ------------- -->
    <form method="POST" class="mt-4">
      <h4>Add New Plan</h4>
      <div class="d-flex flex-wrap gap-3 justify-content-between">
        <input class="form-control flex-fill" style="min-width:180px"   name="plan_name"        placeholder="Plan Name"    required>
        <textarea class="form-control flex-fill" style="min-width:200px" name="plan_details"     placeholder="Plan Details" required></textarea>
        <input class="form-control"                 style="width:140px"  name="membership_price" placeholder="Price"        type="number" step="0.01" required>
        <input class="form-control"                 style="width:140px"  name="duration_days"    placeholder="Days"         type="number" required>
        <button class="btn btn-dark w-100"          style="max-width:140px">Add Plan</button>
      </div>
    </form>

  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
