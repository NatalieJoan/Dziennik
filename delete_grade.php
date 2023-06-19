<?php
// delete_grade.php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once "database.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $userId = $_POST['userId'];
  $oldvalue = $_POST['oldGrade'];
  $loggedInUserId = $_POST['inputId'];
  $position = $_POST['position'];
  $student = $_POST['student'];




  try {
    // Delete user logic here
    $deleteSql = "DELETE FROM grades WHERE id = $userId";

    if (mysqli_query($conn, $deleteSql)) {
      $add_history = "INSERT INTO change_history (user_id, action, table_name, record_id, old_value, new_value, Student_Id)
      VALUES ($loggedInUserId, 'delete', 'grades', $userId, $oldvalue, null,$student  )";
      mysqli_query($conn, $add_history);

      mysqli_close($conn);
      if ($position == 'admin')
      {
        header("Location: index_grades_a.php");
      }
      else
      {
        header("Location: index_grades_n.php");
      }
      
      exit;
    } else {
      throw new mysqli_sql_exception("Error deleting grade: " . mysqli_error($conn));
    }
  } catch (mysqli_sql_exception $e) {
    header("Refresh:0");
  }
}
?>
