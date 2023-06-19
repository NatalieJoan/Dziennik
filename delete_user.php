<?php
// delete_user.php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once "database.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $userId = $_POST['userId'];

  try {
    // Delete user logic here
    $deleteSql = "DELETE FROM users WHERE id = $userId";

    if (mysqli_query($conn, $deleteSql)) {
      // User deleted successfully
      mysqli_close($conn);
      header("Location: index_admin.php");
      exit;
    } else {
      throw new mysqli_sql_exception("Error deleting user: " . mysqli_error($conn));
    }
  } catch (mysqli_sql_exception $e) {
    header("Location: index_admin.php");
    echo "Cannot delete user, assigned to a grade";
  }
}
?>