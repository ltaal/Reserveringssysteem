<?php
session_start();

$user_id = $_SESSION['loggedInUser']['id'];

/** @var $db */
require_once "includes/database.php";

$nameError = '';
$dateError = '';
$timeError = '';

$name = '';
$date = '';
$time = '';

if (isset($_POST['submit'])) {
    $name   = $_POST['name'];
    $date = $_POST['date'];
    $time  = $_POST['time'];

    if ($_POST['name'] == "") {
        $nameError = "Dit veld mag niet leeg zijn, probeer het opnieuw!";
    }
    if ($_POST['date'] == "") {
        $dateError = "Dit veld mag niet leeg zijn, probeer het opnieuw!";
    }
    if ($_POST['time'] == "") {
        $timeError = "Dit veld mag niet leeg zijn, probeer het opnieuw!";
    }else{
        $query = "INSERT INTO reserveringen (name, date, time, user_id)
                  VALUES ('$name', '$date', '$time', '$user_id')";
        $result = mysqli_query($db, $query) or die('Error: '.mysqli_error($db). ' with query ' . $query);

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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css">
    <title>Reserveren</title>
</head>
<body>
<div class="container px-4">
    <h1 class="title mt-4">Nieuwe reservering maken</h1>
    <?php if (!empty($errors)): ?>
        <section class="content">
            <ul class="notification is-danger">
                <?php foreach ($errors as $error): ?>
                    <li><?= $error; ?></li>
                <?php endforeach; ?>
            </ul>
        </section>
    <?php endif; ?>

    <section class="columns">
        <form class="column is-6" action="" method="post">
            <div class="field is-horizontal">
                <div class="field-label is-normal">
                    <label class="label" for="name">Naam</label>
                </div>
                <div class="field-body">
                    <input class="input" id="name" type="text" name="name" value="<?= isset($_POST['name']) ? $_POST['name'] : ''?>"/>
                    <?= $nameError ?>
                </div>
            </div>
            <div class="field is-horizontal">
                <div class="field-label is-normal">
                    <label class="label" for="date">Datum</label>
                </div>
                <div class="field-body">
                    <input class="input" id="date" type="date" name="date" value="<?= isset($_POST['date']) ? $_POST['date'] : ''?>"/>
                    <?= $dateError ?>
                </div>
            </div>
            <div class="field is-horizontal">
                <div class="field-label is-normal">
                    <label class="label" for="time">Tijd</label>
                </div>
                <div class="field-body">
                    <input class="input" id="time" type="time" name="time" value="<?= isset($_POST['time']) ? $_POST['time'] : ''?>"/>
                    <?= $timeError ?>
                </div>
            </div>
            <div class="field is-horizontal">
                <div class="field-label is-normal"></div>

                <div class="field-body">
                    <button class="button is-link is-fullwidth" type="submit" name="submit">Opslaan</button>
                </div>
            </div>
        </form>
    </section>
    <a class="button mt-4" href="overzicht.php">&laquo; Ga Terug</a>
</div>
</body>
</html>

