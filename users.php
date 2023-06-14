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
    <h1>UŻYTKOWNIK</h1>
    <a href="logout.php" class="btn btn-warning">Wyloguj się</a>
    <a href="index_admin.php" class="btn btn-warning">Powrot</a>
    <?php
    if (isset($_GET['id'])) {
        $userId = $_GET['id'];
        echo "User ID: " . $userId;
        require_once "database.php";
        $sql = "SELECT first_name, last_name, position FROM users WHERE id = $userId";
        $result = $conn->query($sql);
        
        $user = $result->fetch_assoc();
        $firstName = $user['first_name'];
        $lastName = $user['last_name'];

        echo "<h2>Uzytkownik: " . $firstName . " " . $lastName . "</h2>";
        
        if ($user['position'] == 'uczen')
        {
            $sql2 = "SELECT grade, teacher_id, date from grades where student_id = $userId";
            $result2 = mysqli_query($conn, $sql2);
            
            if ($result2 && $result2->num_rows > 0) {
                $row = $result2->fetch_assoc();
                $grade = $row['grade'];
                $teacher = $row['teacher_id'];
                $timetime = $row['date'];
                $sql3 = "SELECT first_name, last_name from users where id = $teacher";
                $resultteacher = mysqli_query($conn, $sql3);
                $teachername = mysqli_fetch_assoc($resultteacher);


                // Display the user's first name and last name
                echo "<p>Ocena: " . $grade . " " . $timetime . " Wpisana przez: " . $teachername['first_name'] . " " . $teachername['last_name'] . "</p>";
            } else {
                echo "Uczen nie posiada zadnej oceny.";
            }
        }
        else if ($user['position'] == 'nauczyciel')
        {
            $sql2 = "SELECT grade, student_id, date from grades where teacher_id = $userId";
            $result2 = mysqli_query($conn, $sql2);
            
            if ($result2 && $result2->num_rows > 0) {
                $row = $result2->fetch_assoc();
                $grade = $row['grade'];
                $teacher = $row['student_id'];
                $timetime = $row['date'];
                $sql3 = "SELECT first_name, last_name from users where id = $teacher";
                $resultteacher = mysqli_query($conn, $sql3);
                $teachername = mysqli_fetch_assoc($resultteacher);


                // Display the user's first name and last name
                echo "<p>Ocena: " . $grade . " " . $timetime . " Dana: " . $teachername['first_name'] . " " . $teachername['last_name'] . "</p>";
            } else {
                echo "Uzytkownik nie wpisal zadnej oceny.";
            }
        }
        else {
            echo "Administrator.";
        }
        
        
        
        $conn->close();

    } else {
        echo "No user ID provided.";
    }
    ?>
</div>
</body>
</html>