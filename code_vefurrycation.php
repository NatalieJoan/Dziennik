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
    <title>Dziennik - Kod weryfurrykacyjny</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" href="style_log_reg.css">
</head>
<body>
    <div class="container">
    <?php
        if (isset($_POST["login"])) {
           $vefurrykacja = $_POST["kod"];
           
            $loggedId = $_SESSION['user']['id'];
            require_once "database.php";
            
            
            if ($vefurrykacja == $_SESSION['user']["verification_code"]) {
                $userId = $_SESSION['user']["id"];
                $sql = "UPDATE users SET is_verified = 1 WHERE id = $userId";
                $resultq = mysqli_query($conn,$sql);
                $smtm = mysqli_stmt_init($conn);
                $prepare = mysqli_stmt_prepare($smtm,$sql);
                if ($prepare)
                {
                    mysqli_stmt_execute($smtm);
                }
                
                $position = $user["position"];
                if ($position == "admin") {
                    header("Location: index_admin.php");
                } elseif ($position == "nauczyciel") {
                    header("Location: index_nauczyciel.php");
                } elseif ($position == "uczen") {
                    header("Location: index.php");
                } else {
                    header("Location: index.php");
                }
                die();
            }
            else {
                echo "<div class='alert alert-danger'>Nie zgadza się kod</div>";
            }
            
        }
    ?>
    <form action="code_vefurrycation.php" method="post">
        <h1>Logowanie</h1>
        <div class="form-group">
            <input type="text" placeholder="Wprowadź kod weryfikacyjny:" name="kod" class="form-control">
        </div>
        <div class="form-btn">
            <input type="submit" value="Zaloguj się" name="login" class="btn btn-primary">
        </div>
      </form>
    </div>
</body>
</html>