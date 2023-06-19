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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css"
        integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" href="style_index.css">
    <title>Dziennik</title>
</head>

<body>
    <div class="container">
        <div class="headers">
            <h1 class="h1">OCENY - ADMIN</h1>
            <div class="menu">
                <a href="logout.php" class="btn btn-warning">Wyloguj się</a>
                <a href="index_admin.php" class="btn btn-warning">Użytkownicy</a>
                <a href="index_grades_EDIT.php" class="btn btn-warning">Edytuj ocenę</a>
                <a href="index_history.php" class="btn btn-warning">Historia</a>
            </div>
        </div>
        <table class="table">
            <thead>
                <tr>
                    <th>Uczeń</th>
                    <th>Nauczyciel</th>
                    <th>Oceny</th>
                    <th>Data</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php
                require_once "database.php";
                $sql = "SELECT * FROM grades";
                $result = mysqli_query($conn, $sql);
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . $row['teacher_id'] . "</td>";
                    echo "<td>" . $row['student_id'] . "</td>";
                    echo "<td>" . $row['grade'] . "</td>";
                    echo "<td>" . $row['date'] . "</td>";
                    echo "<td>
                        <form method='POST' action='delete_grade.php' onsubmit='return confirm(\"Jesteś pewny, że chcesz usunąć tę ocenę?\")'>
                            <input type='hidden' name='userId' value='" . $row['id'] . "'>
                            <input type='hidden' name='oldGrade' value='" . $row['grade'] . "'>
                            <input type='hidden' name='inputId' value='" . $_SESSION['user']['id'] . "'>
                            <input type='hidden' name='student' value='" . $row['student_id'] . "'>
                            <input type='hidden' name='position' value='admin'>
                            <button type='submit' class='btn btn-danger'>Usuń</button>
                        </form>
                    </td>";
                    echo "</tr>";
                }
                require_once "add_grade.php";
                mysqli_close($conn);
                ?>
            </tbody>

        </table>
    </div>
</body>

</html>