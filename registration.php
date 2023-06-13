<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dziennik - Rejestracja</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <?php
        if (isset($_POST["submit"])) {
           $firstName = $_POST["firstName"];
           $lastName = $_POST["lastName"];
           $email = $_POST["email"];
           $birthday = $_POST["birthday"];
           $address = $_POST["address"];
           $password = $_POST["password"];
           $passwordRepeat = $_POST["repeat_password"];
           
           $passwordHash = password_hash($password, PASSWORD_DEFAULT);

           $errors = array();

            if (empty($firstName) OR empty($lastName) OR empty($email) OR empty($birthday) OR empty($address) OR empty($password) OR empty($passwordRepeat)) {
            array_push($errors,"Wszystkie pola są wymagane!");
            }
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            array_push($errors, "Podano nieprawidłowy e-mail");
            }
            if (strlen($password)<1) {
            array_push($errors,"Hasło musi składać się z co najmniej 8 znaków");
            }
            if ($password!==$passwordRepeat) {
            array_push($errors,"Nie zgadza się z podanym hasłem");
            }
            require_once "database.php";
            $sql = "SELECT * FROM users WHERE email = '$email'";
            $result = mysqli_query($conn, $sql);
            $rowCount = mysqli_num_rows($result);
            if ($rowCount>0) {
            array_push($errors,"E-mail już istnieje!");
            }
            if (count($errors)>0) {
                foreach ($errors as  $error) {
                    echo "<div class='alert alert-danger'>$error</div>";
                }
            }
            else {
                $sql = "INSERT INTO users (first_name, last_name, email, birthday, address, password) VALUES ( ?, ?, ?, ?, ?, ?)";
                $stmt = mysqli_stmt_init($conn);
                $prepareStmt = mysqli_stmt_prepare($stmt,$sql);
                if ($prepareStmt) {
                    mysqli_stmt_bind_param($stmt,"ssssss", $firstName, $lastName, $email, $birthday, $address, $passwordHash);                  // ssssss oznacza kazdy jeden parametr, a my mamy ich 6 wiec jest 6 s od string
                    mysqli_stmt_execute($stmt);
                    echo "<div class='alert alert-success'>Rejestracja zakończona sukcesem!</div>";
                }
                else {
                    die("Coś poszło nie tak.");
                }
            }
        }
        ?>
        <form action="registration.php" method="post">
            <h1>Registration</h1>
            <div class="form-group">
                <input type="text" class="form-control" name="firstName" placeholder="Imię">
            </div>
            <div class="form-group">
                <input type="text" class="form-control" name="lastName" placeholder="Nazwisko">
            </div>
            <div class="form-group">
                <input type="email" class="form-control" name="email" placeholder="E-mail">
            </div>
            <div class="form-group">
                <input type="date" class="form-control" name="birthday" placeholder="">
            </div>
            <div class="form-group">
                <input type="text" class="form-control" name="address" placeholder="Adres zamieszkania">
            </div>
            <div class="form-group">
                <input type="password" class="form-control" name="password" placeholder="Hasło">
            </div>
            <div class="form-group">
                <input type="password" class="form-control" name="repeat_password" placeholder="Potwierdź hasło">
            </div>
            <div class="form-btn">
                <input type="submit" class="btn btn-primary" value="Zarejestruj się" name="submit">
            </div>
        </form>
        <div><p>Już posiadam konto <a href="login.php">Zaloguj się tutaj</a></p></div>
    </div>
</body>
</html>