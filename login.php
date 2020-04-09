<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title> Netland CP</title>
</head>

<body>
<?php
session_start();

$host = '127.0.0.1:3306';
$db = 'netland';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
];
try {
    $pdo = new PDO($dsn, $user, $pass, $options);
    } catch (\PDOException $e) {
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}
    ?>

    <h1> Netland Admin Panel </h1>
    
    <form action="login.php" method="POST">
        <input type="text" name="username" placeholder="username">
        <input type="password" name="password" placeholder="password">
        <input type="submit" value="login" name="submit">   
    </form>

    <?php
    $user;
    $password;

    if (isset($_POST['submit'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];

        // $query = 'SELECT * FROM gebruikers';

        $user = "SELECT *
            FROM gebruikers WHERE username='$username'";
        $q = $pdo->query($user);
        $data = $q->fetchAll(PDO::FETCH_ASSOC);

         if (isset($data)) {
        echo("<div class='redstatus'><b>Login failed, due to incorrect credentials </b></div>");
    }

      foreach ($data as $row) {

        if ($password == $row['wachtwoord']){
            setcookie('loggedInUser', $row['id']);
            header("Location: index.php");
            exit();
        
        }
    }
}

    ?>

</body>

</html>