<?php
//Check if data is valid & generate error if not so
$errors = [];
if ($name == "") {
    $errors['name'] = 'Je moet een naam opgeven.';
}
if ($date == "") {
    $errors['date'] = 'Je moet een datum opgeven.';
}
if ($time == "") {
    $errors['time'] = 'Je moet een tijd opgeven.';
}
