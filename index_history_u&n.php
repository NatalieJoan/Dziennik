<?php
session_start();
error_reporting(E_ERROR | E_PARSE);

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
    <link rel="stylesheet" href="style_index.css?v=<?php echo time(); ?>">
    <title>Dziennik</title>
</head>

<body>
<div class="container">
    <?php if ($_SESSION['user']['position'] == 'uczen'): ?>
        <h1 class="h1">HISTORIA - uczeń</h1>
    <?php endif; ?> 

    <?php if ($_SESSION['user']['position'] == 'nauczyciel'): ?>
        <h1 class="h1">HISTORIA - nauczyciel</h1>
    <?php endif; ?>

    <a href="logout.php" class="btn btn-warning">Wyloguj się</a>

                <?php if ($_SESSION['user']['position'] == 'uczen'): ?>
                    <a href="index_grades_u.php" class="btn btn-warning">Oceny</a>
                <?php endif; ?>

                <?php if ($_SESSION['user']['position'] == 'nauczyciel'): ?>
                    <a href="index_grades_n.php" class="btn btn-warning">Oceny</a>
                <?php endif; ?>
            </div>
        </div>
        <table>
            <thead>

            </thead>
            <tbody>
                <?php

                require_once "database.php";
                $loggedId = $_SESSION['user']['id'];
                // Pobieramy wszystkie rekordy z tabeli users
                $sql = "SELECT * FROM change_history WHERE ";

                if ($_SESSION['user']['position'] == 'nauczyciel') {
                    $sql .= "user_id = $loggedId";
                } else {
                    $sql .= "record_id IN (SELECT id FROM grades WHERE student_id = $loggedId) or Student_Id = $loggedId";
                }

                $result = mysqli_query($conn, $sql);

        if ($_SESSION['user']['position'] == 'nauczyciel')
        {
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td><b>Made change -" . $row['action'] . "- at " . $row['timestamp'] . ".";
                echo "</b></td>";
                echo "</tr>";
                $sql_uczen = "SELECT * from users where id = (select student_id from grades where id = {$row['record_id']})";
                $result2 = mysqli_query($conn, $sql_uczen);
                $uczen = mysqli_fetch_assoc($result2);
                if ( $row['action'] == 'add')
                {                
                    $firstName = $uczen['first_name'];
                    $lastName = $uczen['last_name'];
                    $newValue = $row['new_value'];
            
                    if ($firstName !== null && $lastName !== null && $newValue !== null) {
                        echo "<tr><td>" . $firstName . " " . $lastName . " nowa ocena - " . $newValue . "</td></tr>";
                    }
                    else {
                        echo "<tr><td>Ocena usunieta</td></tr>";
                    }                }
                else if ( $row['action'] == 'delete')
                {               
                    $sql_uczen = "SELECT * FROM users WHERE id = " . $row['Student_Id'];
                    $result2 = mysqli_query($conn, $sql_uczen);
                    $uczen = mysqli_fetch_assoc($result2);
                    echo "<tr><td>" . $uczen['first_name'] . " " . $uczen['last_name'] . " usunięto ocenę - " . $row['old_value'] . "</td></tr>";
                }
                else
                {
                    echo "<tr><td>";
                    if ($uczen['first_name'] !== null && $uczen['last_name'] !== null && $row['old_value'] !== null && $row['new_value'] !== null) {
                        echo $uczen['first_name'] . " " . $uczen['last_name'] . " zmieniono ocenę - " . $row['old_value'] . " na " . $row['new_value'];
                    }
                    else {
                        echo "Ocena usunieta";
                    }  
                    echo "</td></tr>";                }
            }
        }
        if($_SESSION['user']['position'] == 'uczen')
        {
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td><b>Change -" . $row['action'] . "- at " . $row['timestamp'] . ".";
                echo "</b></td>";
                echo "</tr>";
                $sql_nauczyciel = "SELECT * from users where id = (select teacher_id from grades where id = {$row['record_id']})";
                $result2 = mysqli_query($conn, $sql_nauczyciel);
                $nauczyciel = mysqli_fetch_assoc($result2);
                if ( $row['action'] == 'add')
                {                
                    echo "<tr><td>";
                    if ($nauczyciel['last_name'] !== null && $row['new_value'] !== null) {
                        echo $nauczyciel['last_name'] . " wpisał/a nową ocenę - " . $row['new_value'];
                    }else {
                        echo "Ocena usunieta";
                    }  

                    echo "</td></tr>";
                                    }
                else if ( $row['action'] == 'delete')
                {   
                    $sql_nauczyciel = "SELECT * from users where id = {$row['user_id']}";
                    $result2 = mysqli_query($conn, $sql_nauczyciel);
                    $nauczyciel = mysqli_fetch_assoc($result2);             
                    echo "<tr><td>" . $nauczyciel['last_name'] . " usunął/ęła ocenę - " . $row['old_value'] . "</td></tr>";
                }
                else
                {
                    echo "<tr><td>";
                    if ($nauczyciel['last_name'] !== null && $row['old_value'] !== null && $row['new_value'] !== null) {
                        echo $nauczyciel['last_name'] . " zmienił/a Twoją ocenę z " . $row['old_value'] . " na " . $row['new_value'];
                    }else {
                        echo "Ocena usunieta";
                    }  
                    echo "</td></tr>";
                                    }   
            }
        }
        mysqli_close($conn);
        ?>
        </tbody>
    </table>
</div>
</body>

</html>