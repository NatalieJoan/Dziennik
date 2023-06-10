<?php
require_once "database.php";

// Sprawdzamy, czy żądanie jest typu POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $first_name = $_POST['first_name_input'];
    $last_name = $_POST['last_name_input'];
    $birthday = $_POST['birthday_input'];
    $address = $_POST['address_input'];
    $password = $_POST['password_input'];
    $klasa = $_POST["klasa_input"];
    $email = $_POST['email_input'];
    $position = $_POST['position_input'];
    $passwordHash = password_hash($password, PASSWORD_DEFAULT);

    // Aktualizujemy rekord w bazie danych na podstawie przesłanych wartości
    $updateSql = "INSERT INTO users (first_name, last_name, email, birthday, address, password, klasa, position)  
    VALUES ('$first_name', '$last_name', '$email', '$birthday', '$address', '$passwordHash', '$klasa', '$position')";
    
    if (mysqli_query($conn, $updateSql)) {
        echo "Użytkownik dodany";
    } else {
        echo "Błąd podczas dodawania: " . mysqli_error($conn);
    }
}
?>

<!-- HTML code for displaying the "Dodaj" button and form -->
<table>
    <!-- Your table header here -->
    <thead>
        <!-- Table headers here -->
    </thead>
    <tbody>
        <?php
        // Pobieramy wszystkie rekordy z tabeli users
        $sql = "SELECT * FROM users";
        $result = mysqli_query($conn, $sql);

        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            // Display user data here
            echo "</tr>";
        }
        ?>
        <tr>
            <td>
                <button class='edit-btn' onclick='showEditForm(0)'>Dodaj</button>
                <form method='POST' action='' id='edit-form-0' style='display: none;'>
                    <input type='hidden' name='id' value='0'>
                    <!-- Input fields for adding a new user -->
                    <input type='text' name='first_name_input' placeholder='Imię'>
                    <input type='text' name='last_name_input' placeholder='Nazwisko'>
                    <input type='text' name='email_input' placeholder='Email'>
                    <input type='text' name='birthday_input' placeholder='Data urodzenia'>
                    <input type='text' name='address_input' placeholder='Adres'>
                    <input type='text' name='password_input' placeholder='Hasło'>
                    <input type='text' name='klasa_input' placeholder='Klasa'>
                    <input type='text' name='position_input' placeholder='Stanowisko'>
                    <button type='submit'>Zapisz</button>
                </form>
            </td>
        </tr>
    </tbody>
</table>

