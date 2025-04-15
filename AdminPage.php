<?php

include 'config.php';
session_start();

if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
} 

$batch = isset($_POST['batch']) ? $_POST['batch'] : '0';
$table = "parent_feedback" . $batch;

if (isset($_GET['export_csv']) && $_GET['export_csv'] === 'true') {
    $checkTableQuery = "SHOW TABLES LIKE '$table'";
    $tableExists = $con->query($checkTableQuery)->num_rows > 0;

    if ($table === 'parent_feedback0') {
        // Do nothing for the 'parent_feedback0' case
    } else {
        if (!$tableExists) {
            $_SESSION['alert'] = 'No Table Found';
            header("Location: AdminPage.php"); // Redirect to the AdminPage
            exit;
        } else {
            $sql = "SELECT * FROM $table";
            $result = $con->query($sql);

            if ($result->num_rows > 0) {
                header('Content-Type: text/csv');
                header("Content-Disposition: attachment; filename=\"$table.csv\"");

                $csv_file = fopen('php://output', 'w');

                // Output column headers
                $row = $result->fetch_assoc();
                fputcsv($csv_file, array_keys($row));

                // Output data rows
                fputcsv($csv_file, $row);
                while ($row = $result->fetch_assoc()) {
                    fputcsv($csv_file, $row);
                }

                fclose($csv_file);
                exit;
            } else {
                $_SESSION['alert'] = 'No data found.';
                header("Location: AdminPage.php"); // Redirect to the AdminPage
                exit;
            }
        }
    }
}

// Show alert if set in the session on AdminPage.php
if (isset($_SESSION['alert'])) {
    echo "<script>alert('" . $_SESSION['alert'] . "');</script>";
    unset($_SESSION['alert']); // Clear the alert after displaying it
}
?>


<html>
    <link rel="stylesheet" href="admin.css">
    <link
      rel="shortcut icon"
        href="Logo 1.avif"
      type="image/x-icon"
    />
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH"
      crossorigin="anonymous"
    />
<body>
<nav class="navbar navbar-expand-lg bg-body-white border">
      <div class="container">
        <a href="#" class="navbar-brand mx-auto mx-md-0">
          <img
            src="kce.png"
            class="mb-2 navbar-logo mb-sm-0"
            alt="Karpagam College Logo"
          />
        </a>
      </div>
    </nav>
<center>
    <form method="POST" action="">
    <!-- <img src="kce.png" class="login_logo" style="width:300px;height:130px"> -->
     <h4 class="mb-5">Alumni Parent Feedback</h4>
        <b  class="">Select Batch: &ensp;</b>
        <select name="batch">
            <option value="2023" <?= $batch === '2024' ? 'selected' : '' ?>>2019-2023</option>
            <option value="2024" <?= $batch === '2025' ? 'selected' : '' ?>>2020-2024</option>
            <option value="2025" <?= $batch === '2026' ? 'selected' : '' ?>>2021-2025</option>
            <option value="2026" <?= $batch === '2027' ? 'selected' : '' ?>>2022-2026</option>
            <option value="2027" <?= $batch === '2028' ? 'selected' : '' ?>>2023-2027</option>
            <option value="2028" <?= $batch === '2029' ? 'selected' : '' ?>>2025-2029</option>
            <!-- Add other batch options -->
        </select>
        <br>
        <button type="submit" name="submit" class="Admin_Login_Button-2 btn btn-primary" formaction="?export_csv=true">Export to CSV</button>
    </form>
</center>
</body>
</html>
