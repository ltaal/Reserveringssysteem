<?php
$name = '';
$date = '';
$time = '';
//Require database in this file
/** @var $db */
require_once "includes/database.php";

//If the ID isn't given, redirect to the homepage
if (!isset($_GET['id']) || $_GET['id'] === '') {
    header('Location: overzicht.php');
    exit;
}

//Retrieve the GET parameter from the 'Super global'
$reserveringenId = $_GET['id'];

//Get the record from the database result
$query = "SELECT * FROM reserveringen WHERE id = " . $reserveringenId;
$result = mysqli_query($db, $query);

//If the album doesn't exist, redirect back to the homepage
if (mysqli_num_rows($result) == 0) {
    header('Location: overzicht.php');
    exit;
}

//Transform the row in the DB table to a PHP array
$reserveringen = mysqli_fetch_assoc($result);


/** @var mysqli $db */

//Check if Post isset, else do nothing
if (isset($_POST['submit'])) {
//Require database in /this file & image helpers
    require_once "includes/database.php";
    //Postback with the data showed to the user, first retrieve data from 'Super global'
    $name = $_POST['name'];
    $date = $_POST['date'];
    $time = $_POST['time'];

//Require the form validation handling
    require_once "includes/form-validation.php";

    if (empty($errors)) {
        //Save the record to the database
        $query = "UPDATE reserveringen
                  SET name = '$name', date = '$date', time = '$time'
                  WHERE id = '$reserveringenId'";

        $result = mysqli_query($db, $query) or die('Error: ' . mysqli_error($db) . ' with query ' . $query);

        //Close connection
        mysqli_close($db);

        // Redirect to overzicht.php
        header('Location: overzicht.php');
        exit;
    }
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/style.css"/>
    <link rel="icon" href="img/atelier58.png">
    <title>Reservering aanpassen - <?= $reserveringen['name'] ?></title>
</head>
<body>
<div class="container px-4">
    <h1 class="title mt-4">Reservering aanpassen</h1>

    <section class="columns">
        <form class="column is-6" action="" method="post">
            <div class="field is-horizontal">
                <div class="field-label is-normal">
                    <label class="label" for="name">Naam</label>
                </div>
                <div class="field-body">
                    <div class="field">
                        <div class="control">
                            <input class="input" id="name" type="text" name="name" value="<?= $reserveringen['name'] ?>"/>
                        </div>
                        <p class="help is-danger">
                            <?= $errors['name'] ?? '' ?>
                        </p>
                    </div>
                </div>
            </div>

            <div class="field is-horizontal">
                <div class="field-label is-normal">
                    <label class="label" for="date">Datum</label>
                </div>
                <div class="field-body">
                    <div class="field">
                        <div class="control">
                            <input class="input" id="date" type="text" name="date" value="<?= $reserveringen['date'] ?>"/>
                        </div>
                        <p class="help is-danger">
                            <?= $errors['date'] ?? '' ?>
                        </p>
                    </div>
                </div>
            </div>

            <div class="field is-horizontal">
                <div class="field-label is-normal">
                    <label class="label" for="time">Tijd</label>
                </div>
                <div class="field-body">
                    <div class="field">
                        <div class="control">
                            <input class="input" id="time" type="text" name="time" value="<?= $reserveringen['time'] ?>"/>
                        </div>
                        <p class="help is-danger">
                            <?= $errors['time'] ?? '' ?>
                        </p>
                    </div>
                </div>
            </div>

            <div class="field is-horizontal">
                <div class="field-label is-normal"></div>
                <div class="field-body">
                    <button class="button is-link is-fullwidth" type="submit" name="submit">Save</button>
                </div>
            </div>
        </form>
    </section>
    <section class="button"><a href="overzicht.php">Terug.</a></section>
</div>
</body>
</html>
