<?php
require_once "database.php";

// Sprawdzamy, czy żądanie jest typu POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $gradeId = $_POST['grade_id'];
    $newGrade = $_POST['grade_input'];

    // Aktualizujemy ocenę w bazie danych na podstawie przesłanych wartości
    $updateSql = "UPDATE grades SET grade='$newGrade' WHERE id=$gradeId";

    if (mysqli_query($conn, $updateSql)) {
        echo "Ocena została zaktualizowana";
    } else {
        echo "Błąd podczas aktualizacji oceny: " . mysqli_error($conn);
    }
}



$sql = "SELECT * FROM grades";
$userpos = $_SESSION['user']['position'];
$loggedInUserId = $_SESSION['user']['id'];
if ($userpos != 'admin')
{
    $sql = "SELECT * FROM grades where teacher_id = $loggedInUserId";
}
$result = mysqli_query($conn, $sql);

if ($userpos != 'admin')
{
    while ($row = mysqli_fetch_assoc($result)) {
        $id = $row['student_id'];
        $sql2 = "SELECT first_name FROM users WHERE id = $id";
        $result2 = mysqli_query($conn, $sql2);
        $userRow = mysqli_fetch_assoc($result2);

        echo "<tr>";
        echo "<td>" . $userRow['first_name'] . "</td>";
        echo "<td>" . $row['grade'] . "</td>";
        echo "<td>" . $row['date'] . "</td>";
        echo "<td>
        <button class='edit-btn' onclick='showEditForm(" . $row['id'] . ")'>Edytuj</button>
        <form method='POST' action='' id='edit-form-" . $row['id'] . "' style='display: none;'>
            <input type='hidden' name='grade_id' value='" . $row['id'] . "'>
            <input type='text' name='grade_input' value='" . $row['grade'] . "'>
            <button type='submit'>Zapisz</button>
        </form>
        </td>";
        echo "</tr>";
    }
}
if ($userpos == 'admin')
{
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>" . $row['teacher_id'] . "</td>";
        echo "<td>" . $row['student_id'] . "</td>";
        echo "<td>" . $row['grade'] . "</td>";
        echo "<td>" . $row['date'] . "</td>";
        echo "<td>
        <button class='edit-btn' onclick='showEditForm(" . $row['id'] . ")'>Edytuj</button>
        <form method='POST' action='' id='edit-form-" . $row['id'] . "' style='display: none;'>
            <input type='hidden' name='grade_id' value='" . $row['id'] . "'>
            <input type='text' name='grade_input' value='" . $row['grade'] . "'>
            <button type='submit'>Zapisz</button>
        </form>
        </td>";
        echo "</tr>";
    }
}

?>

