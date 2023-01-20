<?php
session_start();
//Require music data to use variable in this file
/** @var $db */
require_once "includes/database.php";

if(isset($_GET['id'])){
    if($_GET['id'] !== ''){
        $deleteId = $_GET['id'];
        $deleteQuery = "DELETE FROM `reserveringen` WHERE id = $deleteId";
        mysqli_query($db, $deleteQuery);
    }
}

//Get the result set from the database with a SQL query
$query = "SELECT * FROM reserveringen";
$result = mysqli_query($db, $query);

//Loop through the result to create a custom array
$reserveringen = [];
while ($row = mysqli_fetch_assoc($result)) {
    $reserveringen[] = $row;
}

//Close connection
mysqli_close($db);

?>
<!doctype html>
<html lang="en">
<head>
    <title>Reserveringen</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<nav>
    <img class="navimg" src="img/metrologo.png">

    <ul>
        <ui><a href="overzicht.php">Mijn Reserveringen</a></ui>
        <ui><a href="create.php">Reserveren</a></ui>
    </ul>
</nav>
<h1>Uw Reserveringen</h1>
<section class="reserveringen">
        <?php $found = false;
        foreach ($reserveringen as $index => $reservering) {
            if ($reservering['user_id'] == $_SESSION['loggedInUser']['id'] || $_SESSION['loggedInUser']['id'] == 10) {
            $found = true;?>
    <section class="reservering">
            <tr class="reserveringenn">
                <td><?= $reservering['name'] ?></td>
                <td><?= $reservering['date'] ?></td>
                <td><?= $reservering['time'] ?></td>
                <td><a href="update.php?id=<?= $reservering['id'] ?>">Edit</a></td>
                <td><a href="overzicht.php?id=<?= $reservering['id'] ?>">Delete</a></td>
            </tr>
    </section>
        <?php }
            } ?>
</section>
</body>
</html>