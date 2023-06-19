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
    $deleteSql = "DELETE FROM grades WHERE grade_id = $userId";

    if (mysqli_query($conn, $deleteSql)) {
      // User deleted successfully
      mysqli_close($conn);

      // Check user's position and redirect accordingly
      if ($_SESSION['user']['position'] == 'nauczyciel') {
        header("Location: index_grades_n.php");
      } else if ($_SESSION['user']['position'] == 'admin') {
        header("Location: index_grades_a.php");
      } else {
        // Redirect to a default page if position is neither 'nauczyciel' nor 'admin'
        header("Location: index.php");
      }
      exit;
    } else {
      throw new mysqli_sql_exception("Error deleting grade: " . mysqli_error($conn));
    }
  } catch (mysqli_sql_exception $e) {
    // Check user's position and redirect accordingly
    if ($_SESSION['user']['position'] == 'nauczyciel') {
      header("Location: index_grades_n.php");
    } else if ($_SESSION['user']['position'] == 'admin') {
      header("Location: index_grades_a.php");
    } else {
      // Redirect to a default page if position is neither 'nauczyciel' nor 'admin'
      header("Location: index.php");
    }
  }
}
<<<<<<< HEAD
?>
=======

?>
>>>>>>> 76183f4cf5a8f4a13bb273a6dc91f4ad5bf93868
