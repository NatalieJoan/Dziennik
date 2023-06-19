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
<<<<<<< HEAD
            <h1>UŻYTKOWNICY - ADMIN</h1>
            <div class="menu" style="padding-left:28%;">
=======
            <h1>UŻYTKOWNICY - ADMIN:</h1>
            <?php echo "<h2> " . $_SESSION['user']['first_name'] . " ". $_SESSION['user']['last_name'] . "</h2>"; ?>

            <div class="menu">
>>>>>>> 76183f4cf5a8f4a13bb273a6dc91f4ad5bf93868
                <a href="logout.php" class="btn btn-warning">Wyloguj się</a>
                <a href="index_grades_a.php" class="btn btn-warning">Oceny</a>
                <a href="index_admin_EDYTUJ.php" class="btn btn-warning">Edytuj</a>
            </div>
        </div>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Imię</th>
                    <th>Nazwisko</th>
                    <th>E-mail</th>
                    <th>Klasa</th>
                    <th>Adres</th>
                    <th>Urodziny</th>
                    <th>Stanowisko</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php

                require_once "database.php";

                $sql = "SELECT * FROM users";
                $result = mysqli_query($conn, $sql);

                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td><a href='users.php?id=" . $row['id'] . "'>" . $row['id'] . "</a></td>";
                    echo "<td>" . $row['first_name'] . "</td>";
                    echo "<td>" . $row['last_name'] . "</td>";
                    echo "<td>" . $row['email'] . "</td>";
                    echo "<td>" . $row['klasa'] . "</td>";
                    echo "<td>" . $row['address'] . "</td>";
                    echo "<td>" . $row['birthday'] . "</td>";
                    echo "<td>" . $row['position'] . "</td>";
                    echo "<td>
            <form method='POST' action='delete_user.php' onsubmit='return confirm(\"Jesteś pewny, że chcesz usunąć tego użytkownika?\")'>
              <input type='hidden' name='userId' value='" . $row['id'] . "'>
              <button type='submit'>Usuń</button>
            </form>
          </td>";
                    echo "</tr>";
                }
                require_once "add_user.php";

                mysqli_close($conn);
                ?>

            </tbody>
        </table>
    </div>
</body>

</html>