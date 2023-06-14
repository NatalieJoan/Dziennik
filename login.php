<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dziennik - Logowanie</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" href="style_log_reg.css">
</head>
<body>
    <div class="container">
    <?php
        if (isset($_POST["login"])) {
           $email = $_POST["email"];
           $password = $_POST["password"];
            require_once "database.php";
            $sql = "SELECT * FROM users WHERE email = '$email'";
            $result = mysqli_query($conn, $sql);
            $user = mysqli_fetch_array($result, MYSQLI_ASSOC);
            if ($user) {
                if (password_verify($password, $user["password"])) {
                    session_start();
                    $_SESSION["user"] = $user;
                    
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
                    echo "<div class='alert alert-danger'>Nie zgadza się hasło</div>";
                }
            }
            else {
                echo "<div class='alert alert-danger'>Nie zgadza się e-mail</div>";
            }
        }
    ?>
    <form action="login.php" method="post">
        <h1>Logowanie</h1>
        <div class="form-group">
            <input type="email" placeholder="Wprowadź e-mail" name="email" class="form-control">
        </div>
        <div class="form-group">
            <input type="password" placeholder="Wprowadź hasło" name="password" class="form-control">
        </div>
        <div class="form-btn">
            <input type="submit" value="Zaloguj się" name="login" class="btn btn-primary">
        </div>
      </form>
      <div><p>Nie mam jeszcze konta <a href="registration.php">Zarejestruj się tutaj</a></p></div>
    </div>
</body>
</html>