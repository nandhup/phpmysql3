<?php
$mysqli = new mysqli(getenv('MYSQL_HOST'), getenv('MYSQL_USER'), getenv('MYSQL_PASSWORD'), getenv('MYSQL_DATABASE'));

if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: " . $mysqli->connect_error;
    exit();
}

if (!$mysqli->query("DESCRIBE `users`")) {
    $sql = "CREATE TABLE `users` (
        `id` INT(11) NOT NULL AUTO_INCREMENT,
        `name` VARCHAR(255) NOT NULL,
        `email` VARCHAR(255) NOT NULL,
        PRIMARY KEY (`id`)
    )";

    if ($mysqli->query($sql)) {
        echo "Table created successfully";
    } else {
        echo "Error creating table: " . $mysqli->error;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];

    $sql = "INSERT INTO `users` (`name`, `email`) VALUES (?, ?)";

    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param('ss', $name, $email);

    if ($stmt->execute()) {
        echo "User created successfully";
    } else {
        echo "Error creating user: " . $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>PHP MySQL Docker Example</title>
</head>
<body>
    <h1>PHP MySQL Docker Example</h1>
    <form method="post">
        <label for="name">Name:</label>
        <input type="text" name="name" id="name" required>
        <br>
        <label for="email">Email:</label>
        <input type="email" name="email" id="email" required>
        <br>
        <input type="submit" value="Create User">
    </form>
</body>
</html>
