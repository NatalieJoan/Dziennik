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
            <h1>OCENY - UCZEŃ</h1>
            <div class="menu">
                <a href="logout.php" class="btn btn-warning">Wyloguj się</a>
                <a href="index_history_u&n.php" class="btn btn-warning">Historia</a>
                <a href="index.php" class="btn btn-warning">Nauczyciele</a>
            </div>
        </div>
        <table>
            <thead>
                <tr>
                    <th>Uczeń</th>
                    <th>Ocena</th>
                    <th>Data</th>
                </tr>
            </thead>
            <tbody>
                <?php
                require_once "database.php";
                $loggedInUserId = $_SESSION['user']['id'];
                $sql = "SELECT * FROM grades where student_id = $loggedInUserId";
                $result = mysqli_query($conn, $sql);

                while ($row = mysqli_fetch_assoc($result)) {
                    $id = $row['teacher_id'];
                    $sql2 = "SELECT last_name FROM users WHERE id = $id";
                    $result2 = mysqli_query($conn, $sql2);
                    $userRow = mysqli_fetch_assoc($result2);

                    echo "<tr>";
                    echo "<td>" . $userRow['last_name'] . "</td>";
                    echo "<td>" . $row['grade'] . "</td>";
                    echo "<td>" . $row['date'] . "</td>";
                    echo "</tr>";
                }
                // Close the database connection
                mysqli_close($conn);
                ?>
            </tbody>
        </table>
    </div>
</body>

</html>