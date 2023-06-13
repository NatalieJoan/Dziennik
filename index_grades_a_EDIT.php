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
    <?php if ($_SESSION['user']['position'] == 'admin'): ?>
        <h1 class="h1">OCENY edycja - ADMIN</h1>
    <?php endif; ?> 
    <?php if ($_SESSION['user']['position'] == 'nauczyciel'): ?>
        <h1 class="h1">OCENY edycja - nauczyciel</h1>
    <?php endif; ?>
    
    <a href="logout.php" class="btn btn-warning">Logout</a>
    <?php if ($_SESSION['user']['position'] == 'admin'): ?>
        <a href="index_admin.php" class="btn btn-warning">uzytkownicy</a>
    <?php endif; ?>
    <?php if ($_SESSION['user']['position'] == 'nauczyciel'): ?>
        <a href="index_nauczyciel.php" class="btn btn-warning">uczniowie</a>
    <?php endif; ?>
    <table class="table">
        <thead>
            <tr>
            <?php if ($_SESSION['user']['position'] == 'admin'): ?>
                <th>Student</th>
                <th>Teacher</th>
                <th>Grade</th>
                <th>Date</th>
            <?php endif; ?>
            
            <?php if ($_SESSION['user']['position'] == 'nauczyciel'): ?>
                <th>Student</th>
                <th>Grade</th>
                <th>Date</th>
            <?php endif; ?>
               
            </tr>
        </thead>

        <tbody>
            
            <?php
                require_once "database.php";
                require_once "edit_grade.php";
                mysqli_close($conn);
            ?>
        
        </tbody>
            
    </table>
    <script>
    function showEditForm(formId) {
        var form = document.getElementById('edit-form-' + formId);
        if (form.style.display === 'none') {
            form.style.display = 'block';
        } else {
            form.style.display = 'none';
        }
    }
</script>
</div>
</body>
</html>