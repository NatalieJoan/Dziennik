<style>
.edit-btn{
    border-style: none; 
    background-color: turquoise; 
    color:white;  width:100px; 
    height: 32px; 
    font-weight:bold; 
    box-shadow: inset 1px 7px 20px 2px steelblue;
}
.edit-btn:hover{
    border-style: none; 
    background-color: darkturquoise; 
    color:white;  width:100px; 
    height: 32px; 
    font-weight:bold; 
    transition: 0.2s;
    box-shadow: rgba(63, 63, 99, 0.8) inset 1px 7px 20px 2px; 
}
button[type=submit]{
    border-style: none; 
    background-color:rgb(128, 128, 130, 0.6); 
    color:white;  width:100px; 
    height: 32px; 
    font-weight:bold; 
    box-shadow: rgba(63, 63, 99, 0.297) inset 1px 7px 20px 2px;
}
button[type=submit]:hover{
    border-style: none; 
    background-color:rgb(128, 128, 130, 1); 
    color:white;  width:100px; 
    height: 32px; 
    font-weight:bold; 
    transition: 0.2s;
    box-shadow: rgba(63, 63, 99, 0.297) inset 1px 7px 20px 2px;
}
input {
    width: 40px;
    height: 32px;
}
</style>
<?php
require_once "database.php";
error_reporting(E_ERROR | E_PARSE);
$userpos = $_SESSION['user']['position'];
$loggedInUserId = $_SESSION['user']['id'];
// Sprawdzamy, czy żądanie jest typu POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $gradeId = $_POST['grade_id'];
    
    $oldGrade = " select grade from grades where id = $gradeId";
    $result = mysqli_query($conn, $oldGrade);
    $row = mysqli_fetch_assoc($result);
    $oldGradeValue = $row['grade'];
    $newGrade = $_POST['grade_input'];
    if ($newGrade > 6 || $newGrade <1)
    {
        echo "Ocena musi być między 1 a 6";
    }
    else{
        $add_history = "INSERT INTO change_history (user_id, action, table_name, record_id, old_value, new_value)
    VALUES ($loggedInUserId, 'update', 'grades', $gradeId, $oldGradeValue, $newGrade)";

    // Aktualizujemy ocenę w bazie danych na podstawie przesłanych wartości
    $updateSql = "UPDATE grades SET grade='$newGrade' WHERE id=$gradeId";
    mysqli_query($conn, $add_history);

    if (mysqli_query($conn, $updateSql)) {
        echo "Ocena została zaktualizowana";
    } else {
        echo "Błąd podczas aktualizacji oceny: " . mysqli_error($conn);
    }
    }

    
}

$sql = "SELECT * FROM grades";

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
            <input type='hidden' name='grade_id' value='" . $row['id'] . "' style='display: flex;'>
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

