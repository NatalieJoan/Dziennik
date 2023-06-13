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
    <title>Dziennik</title>
</head>
<body>
<div class="container">
    <h1>HISTORIA - ADMIN</h1>
    <a href="logout.php" class="btn btn-warning">Wyloguj się</a>
    <a href="index_grades_a.php" class="btn btn-warning">Oceny</a>
    <a href="index_admin.php" class="btn btn-warning">Użytkownicy</a>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Data wykonania</th>
                <th>ID użytkownika</th>
                <th>Akcja</th>
                <th>ID operacji</th>
                <th>Stara wartość</th>
                <th>Nowa wartość</th>
            </tr>
        </thead>
        <tbody>
        <?php

        require_once "database.php";

        // Pobieramy wszystkie rekordy z tabeli users
        $sql = "SELECT * FROM change_history";
        $result = mysqli_query($conn, $sql);

        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>" . $row['change_id'] . "</td>";
            echo "<td>" . $row['timestamp'] . "</td>";
            echo "<td><a href='users.php?id=" . $row['user_id'] . "'>" . $row['user_id'] . "</a></td>";
            echo "<td>" . $row['action'] . "</td>";
            echo "<td>" . $row['record_id'] . "</td>";
            echo "<td>" . $row['old_value'] . "</td>";
            echo "<td>" . $row['new_value'] . "</td>";
            echo "</tr>";
        }
        mysqli_close($conn);
        ?>
        </tbody>
    </table>
</div>
</body>
</html>