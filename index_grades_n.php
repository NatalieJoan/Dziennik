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
    <h1>NAUCZYCIEL</h1>
    <a href="logout.php" class="btn btn-warning">Logout</a>
    <a href="index_nauczyciel.php" class="btn btn-warning">UCZNIOWIE</a>

    <table>
        <thead>
            <tr>
                <th>Student</th>
                <th>Grade</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            <?php
                require_once "database.php";
                $loggedInUserId = $_SESSION['user']['id'];
                $sql = "SELECT * FROM grades where teacher_id = $loggedInUserId";
                $result = mysqli_query($conn, $sql);

                while ($row = mysqli_fetch_assoc($result)) {
                    $id = $row['student_id'];
                    $sql2 = "SELECT first_name FROM users WHERE id = $id";
                    $result2 = mysqli_query($conn, $sql2);
                    $userRow = mysqli_fetch_assoc($result2);

                    echo "<tr>";
                    echo "<td>" . $userRow['first_name'] . "</td>";
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