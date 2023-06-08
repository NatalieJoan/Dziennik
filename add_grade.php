<?php
require_once "database.php";

// Sprawdzamy, czy żądanie jest typu POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $first_name = $_POST['first_name_input'];
    $last_name = $_POST['last_name_input'];
    $grade = $_POST['grade_input'];
    $loggedInUserId = $_SESSION['user']['id'];

    $sql2 = "SELECT id FROM users where first_name = '$first_name' and last_name = '$last_name'";
    $result2 = mysqli_query($conn, $sql2);
    $row = mysqli_fetch_assoc($result2);
    $studentId = $row['id'];

    // Aktualizujemy rekord w bazie danych na podstawie przesłanych wartości
    $updateSql = "INSERT INTO grades (grade, student_id, teacher_id, date) VALUES ('$grade', '$studentId', '$loggedInUserId', '2002-02-02')";

    
    if (mysqli_query($conn, $updateSql)) {
        echo "ocena dodana";
    } else {
        echo "Błąd podczas dodawania: " . mysqli_error($conn);
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

        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            // Display user data here
            echo "</tr>";
        }
        ?>
    </thead>
    <tbody>
        <tr>
            <td>
                <button class='edit-btn' onclick='showEditForm(0)'>Dodaj</button>
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