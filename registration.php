<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Form</title>
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
            array_push($errors,"All fields are required");
            }
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            array_push($errors, "Email is not valid");
            }
            if (strlen($password)<1) {
            array_push($errors,"Password must be at least 8 charactes long");
            }
            if ($password!==$passwordRepeat) {
            array_push($errors,"Password does not match");
            }
            require_once "database.php";
            $sql = "SELECT * FROM users WHERE email = '$email'";
            $result = mysqli_query($conn, $sql);
            $rowCount = mysqli_num_rows($result);
            if ($rowCount>0) {
            array_push($errors,"Email already exists!");
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
                    echo "<div class='alert alert-success'>You are registered successfully.</div>";
                }
                else {
                    die("Something went wrong.");
                }
            }
        }
        ?>
        <form action="registration.php" method="post">
            <h1>Registration</h1>
            <div class="form-group">
                <input type="text" class="form-control" name="firstName" placeholder="First Name">
            </div>
            <div class="form-group">
                <input type="text" class="form-control" name="lastName" placeholder="Last Name">
            </div>
            <div class="form-group">
                <input type="email" class="form-control" name="email" placeholder="Email">
            </div>
            <div class="form-group">
                <input type="date" class="form-control" name="birthday" placeholder="">
            </div>
            <div class="form-group">
                <input type="text" class="form-control" name="address" placeholder="Address">
            </div>
            <div class="form-group">
                <input type="password" class="form-control" name="password" placeholder="Password">
            </div>
            <div class="form-group">
                <input type="password" class="form-control" name="repeat_password" placeholder="Confirm Password">
            </div>
            <div class="form-btn">
                <input type="submit" class="btn btn-primary" value="Register" name="submit">
            </div>
        </form>
        <div><p>Already registered <a href="login.php">Login here</a></p></div>
    </div>
</body>
</html>