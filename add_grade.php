<?php
require_once "database.php";
error_reporting(E_ERROR | E_PARSE);
// Sprawdzamy, czy żądanie jest typu POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $first_name = $_POST['first_name_input'];
    $last_name = $_POST['last_name_input'];
    $grade = $_POST['grade_input'];
    $loggedInUserId = $_SESSION['user']['id'];
    if ($grade < 1 || $grade > 6) {
        echo "Ocena musi być między 1 a 6";
        return;
    }
    $query = "SELECT MAX(id) + 1 AS next_id FROM grades";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    $nextId = $row['next_id'];

    $sql2 = "SELECT id FROM users where first_name = '$first_name' and last_name = '$last_name'";
    $result2 = mysqli_query($conn, $sql2);
    $row = mysqli_fetch_assoc($result2);
    $studentId = $row['id'];

   

    
    try {
        $updateSql = "INSERT INTO grades (grade, student_id, teacher_id, date) VALUES ('$grade', '$studentId', '$loggedInUserId', CURDATE())";
    
        if (mysqli_query($conn, $updateSql)) {
            $add_history = "INSERT INTO change_history (user_id, action, table_name, record_id, old_value, new_value)
            VALUES ($loggedInUserId, 'add', 'grades', $nextId, null, $grade)";
            mysqli_query($conn, $add_history);
            // Aktualizujemy rekord w bazie danych na podstawie przesłanych wartości
            $updateSql = "INSERT INTO grades (grade, student_id, teacher_id, date) VALUES ('$grade', '$studentId', '$loggedInUserId', CURRENT_DATE())";
            header("Refresh:0");
            if ($_SESSION['user']['position'] == 'nauczyciel') {
                $redirectUrl = 'index_grades_n.php';
            } elseif ($_SESSION['user']['position'] == 'admin') {
                $redirectUrl = 'index_grades_a.php';
            }
    
            if (!empty($redirectUrl)) {
                echo '<meta http-equiv="refresh" content="0;url=' . $redirectUrl . '">';
            }
            echo "Ocena dodana";
        } else {
            echo "Nie można znaleźć ucznia";
        }
    } catch (Exception $e) {
        echo "Nie można znaleźć ucznia";
    }
    
    
}
?>

<!-- HTML code for displaying the "Dodaj" button and form -->
<table>
    <thead>
    <?php
        // Pobieramy wszystkie rekordy z tabeli users
        $sql = "SELECT * FROM grades";
        $result = mysqli_query($conn, $sql);
        ?>
    </thead>
    <tbody>
        <tr>
            <td>
                <button class='edit-btn' onclick='showEditForm(0)'>Dodaj ocenę</button>
                <form method='POST' action='' id='edit-form-0' style='display: none;'>
                    <input type='hidden' name='id' value='0'>
                    <input type='text' name='first_name_input' placeholder='Imię'>
                    <input type='text' name='last_name_input' placeholder='Nazwisko'>
                    <input type='text' name='grade_input' placeholder='Ocena'>
                    <button type='submit'>Zapisz</button>
                </form>
            </td>
        </tr>
    </tbody>
</table>
<script>
    function showEditForm(formId) {
        var form = document.getElementById('edit-form-' + formId);
        if (form.style.display === 'none') {
            form.style.display = 'block';
        } else {
            form.style.display = 'none';
        }
    }
</script>