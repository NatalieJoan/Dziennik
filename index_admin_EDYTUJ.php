<?php
session_start();
if (!isset($_SESSION["user"])) {
   header("Location: login.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <title>User Dashboard</title>
</head>
<body>
<div class="container">
    <h1>UŻYTKOWNICY - ADMIN</h1>
    <a href="logout.php" class="btn btn-warning">Logout</a>
    <a href="index_grades_a.php" class="btn btn-warning">OCENY</a>
    <a href="index_admin.php" class="btn btn-warning">Powrot</a>

    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Last Name</th>
                <th>Email</th>
                <th>klasa</th>
                <th>Position</th>
                
            </tr>
        </thead>
        <tbody>
        <?php
        

        require_once "database.php";

        // Sprawdzamy, czy żądanie jest typu POST
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $id = $_POST['id'];
            $first_name = $_POST['first_name_input'];
            $last_name = $_POST['last_name_input'];
            $klasa = $_POST["klasa_input"];
            $email = $_POST['email_input'];
            $position = $_POST['position_input'];

            // Aktualizujemy rekord w bazie danych na podstawie przesłanych wartości
            $updateSql = "UPDATE users SET first_name='$first_name', last_name='$last_name', email='$email', `klasa` = '$klasa', `position`='$position' WHERE id=$id";
            if (mysqli_query($conn, $updateSql)) {
                echo "Rekord został pomyślnie zaktualizowany";
            } else {
                echo "Błąd podczas aktualizacji rekordu: " . mysqli_error($conn);
            }
        }

        // Pobieramy wszystkie rekordy z tabeli users
        $sql = "SELECT * FROM users";
        $result = mysqli_query($conn, $sql);

        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>" . $row['first_name'] . "</td>";
            echo "<td>" . $row['last_name'] . "</td>";
            echo "<td>" . $row['email'] . "</td>";
            echo "<td>" . $row['klasa'] . "</td>";
            echo "<td>" . $row['position'] . "</td>";
            echo "<td>
                    <button class='edit-btn' onclick='showEditForm(" . $row['id'] . ")'>Edytuj</button>
                    <form method='POST' action='' id='edit-form-" . $row['id'] . "' style='display: none;'>
                        <input type='hidden' name='id' value='" . $row['id'] . "'>
                        <input type='text' name='first_name_input' value='" . $row['first_name'] . "'>
                        <input type='text' name='last_name_input' value='" . $row['last_name'] . "'>
                        <input type='text' name='email_input' value='" . $row['email'] . "'>
                        <input type='text' name='klasa_input' value='" . $row['klasa'] . "'>
                        <input type='text' name='position_input' value='" . $row['position'] . "'>
                        <button type='submit'>Zapisz</button>
                    </form>
                </td>";
            echo "</tr>";
        }
        mysqli_close($conn);
        ?>
        
        <script>
            // Funkcja do wyświetlania formularza edycji
            function showEditForm(rowId) {
                const editForm = document.getElementById('edit-form-' + rowId);
                editForm.style.display = 'block';
            }
            function showEditGradeForm(rowId) {
                const editGradeForm = document.getElementById('edit-grade-form-' + rowId);
                editGradeForm.style.display = 'block';
            }

        </script>


        </tbody>
    </table>
</div>

</body>
</html>