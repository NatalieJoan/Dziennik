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
?>

<!-- HTML code for displaying the "Edytuj" button and form -->
<table>
    <thead>
    <?php
        // Pobieramy wszystkie rekordy z tabeli grades
        $sql = "SELECT * FROM grades";
        $result = mysqli_query($conn, $sql);

        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            // Display grade data here
            echo "</tr>";
        }
        ?>
    </thead>
    <tbody>
        <?php
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            // Display grade data here

            // Edycja oceny
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
        ?>
        <tr>
            <td>
                <button class='edit-btn' onclick='showEditForm(0)'>Edytuj ocenę</button>
                <form method='POST' action='' id='edit-form-0' style='display: none;'>
                    <input type='hidden' name='grade_id' value='0'>
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
