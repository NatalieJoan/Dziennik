<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dziennik - Rejestracja</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css"
        integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" href="style_log_reg.css">
</head>

<body>
    <div class="container">
        <?php
        use PHPMailer\PHPMailer\PHPMailer;
        use PHPMailer\PHPMailer\SMTP;
        use PHPMailer\PHPMailer\Exception;
        require "mail.php";
        if (isset($_POST["submit"])) {
            $firstName = $_POST["firstName"];
            $lastName = $_POST["lastName"];
            $email = $_POST["email"];
            $birthday = $_POST["birthday"];
            $address = $_POST["address"];
            $password = $_POST["password"];
            $passwordRepeat = $_POST["repeat_password"];
            $is_verified = 0;
            function sendMail($email, $v_code)
            {
                require ("PHPMailer/PHPMailer.php");
                require "PHPMailer/SMTP.php";
                require "PHPMailer/Exception.php";

                $mail = new PHPMailer(true);
                try {
                    $mail->isSMTP();
                    $mail->Host = 'smtp.gmail.com';
                    $mail->SMTPAuth = true;
                    $mail->Username = 'powaznymail123@gmail.com';
                    $mail->Password = 'Sekret2@';
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
                    $mail->Port = 587;

                    $mail->setFrom('powaznymail123@gmail.com', 'Dziennik');
                    $mail->addAddress($email);

                    $mail->isHTML(true);
                    $mail->Subject = 'Weryfikacja rejestracji w Dzienniku';
                    $mail->Body = "Dziękujemy za rejestrację! Kliknij w <a href='http://localhost/git/login-register/verify.php?email=$email&v_code=$v_code'>link</a>, aby zweryfikować adres e-mail'></b>";

                    $mail->send();
                    return true;
                } catch (Exception $e) {
                    echo 'Mailer Error: ' . $mail->ErrorInfo;

                    return false;
                }
            }
            $passwordHash = password_hash($password, PASSWORD_DEFAULT);
            $v_code = bin2hex(random_bytes(16));
            $errors = array();

            if (empty($firstName) or empty($lastName) or empty($email) or empty($birthday) or empty($address) or empty($password) or empty($passwordRepeat)) {
                array_push($errors, "Wszystkie pola są wymagane!");
            }
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                array_push($errors, "Podano nieprawidłowy e-mail");
            }
            if (strlen($password) < 1) {
                array_push($errors, "Hasło musi składać się z co najmniej 8 znaków");
            }
            if ($password !== $passwordRepeat) {
                array_push($errors, "Nie zgadza się z podanym hasłem");
            }
            require_once "database.php";
            $sql = "SELECT * FROM users WHERE email = '$email'";
            $result = mysqli_query($conn, $sql);
            $rowCount = mysqli_num_rows($result);
            if ($rowCount > 0) {
                array_push($errors, "E-mail już istnieje!");
            }
            if (count($errors) > 0) {
                foreach ($errors as $error) {
                    echo "<div class='alert alert-danger'>$error</div>";
                }
            } else {
                
                $sql = "INSERT INTO users (first_name, last_name, email, birthday, address, password, verification_code, is_verified) VALUES ( ?, ?, ?, ?, ?, ?, ?, ?)";
                $stmt = mysqli_stmt_init($conn);
                $prepareStmt = mysqli_stmt_prepare($stmt, $sql);
                $subject = "ss";
                $verificationCode = str_pad(rand(1000, 9999), 4, '0', STR_PAD_LEFT);
                $mailSent = send_mail($email, $subject, $verificationCode );
                if ($mailSent) {
                    mysqli_stmt_bind_param($stmt, "ssssssii", $firstName, $lastName, $email, $birthday, $address, $passwordHash, $verificationCode, $is_verified);
                    mysqli_stmt_execute($stmt);
                    echo "<div class='alert alert-success'>Rejestracja zakończona sukcesem!</div>";
                } else {
                    die("Coś poszło nie tak.");
                }
            }
        }
        ?>
        <form action="registration.php" method="post">
            <h1 style="font-size: 34px">REJESTRACJA</h1>
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
        <div>
            <p>Już posiadam konto <a href="login.php">Zaloguj się tutaj</a></p>
        </div>
    </div>
</body>

</html>