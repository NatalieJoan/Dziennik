<?php
require_once "database.php";

// Sprawdzamy, czy żądanie jest typu POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $first_name = $_POST['first_name_input'];
    $last_name = $_POST['last_name_input'];
    $grade = $_POST['grade_input'];
    $loggedInUserId = $_SESSION['user']['id'];

    $query = "SELECT MAX(id) + 1 AS next_id FROM grades";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    $nextId = $row['next_id'];

    $sql2 = "SELECT id FROM users where first_name = '$first_name' and last_name = '$last_name'";
    $result2 = mysqli_query($conn, $sql2);
    $row = mysqli_fetch_assoc($result2);
    $studentId = $row['id'];

    $add_history = "INSERT INTO change_history (user_id, action, table_name, record_id, old_value, new_value)
    VALUES ($loggedInUserId, 'add', 'grades', $nextId, null, $grade)";
    mysqli_query($conn, $add_history);
    // Aktualizujemy rekord w bazie danych na podstawie przesłanych wartości
    $updateSql = "INSERT INTO grades (grade, student_id, teacher_id, date) VALUES ('$grade', '$studentId', '$loggedInUserId', '2002-02-02')";

    
    if (mysqli_query($conn, $updateSql)) {
        header("Refresh:0");
        echo "Ocena dodana";
        
    } else {
        echo "Błąd podczas dodawania: " . mysqli_error($conn);
    }
}
?>
<style>
    .edit-btn {
    border-style: none; 
    background-color:rgb(113,189,38); 
    color:white; 
    margin: 10px; 
    width:190px; 
    height: 50px; 
    font-weight:bold;
}
.edit-btn:hover{
    border-style: none; 
    background-color: #4ccf6d; 
    color:white; 
    margin: 10px; 
    width:190px; 
    height: 50px; 
    font-weight:bold;
    transition: 0.2s;
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
</style>
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
            <td style='text-align:center; background-color:#b1eaee'>
                <button class='edit-btn' onclick='showEditForm(0)'>DODAJ OCENĘ</button>
                <form method='POST' action='' id='edit-form-0' style='display: none; margin: 20px;'>
                    <input type='hidden' name='id' value='0'>
                    <input type='text' name='first_name_input' placeholder='Imię'>
                    <input type='text' name='last_name_input' placeholder='Nazwisko'>
                    <input type='text' name='grade_input' placeholder='Ocena'>
                    <button type='submit'>ZAPISZ</button>
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