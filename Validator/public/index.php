<?php

include __DIR__ . "/../Validator.php";

$validate = new Validator();

$validation = $validate->check($_POST, [
    'username' => [
        'required' => true,
        'min' => 2,
        'max' => 15,
    ],
    'email' => [
        'required' => true,
        'email' => true,
    ],
    'password' => [
        'required' => true,
        'min' => 3,
    ],
    'password_again' => [
        'required' => true,
        'matches' => 'password',
    ],
]);

if ($validation->passed()) {
    echo 'validation passed!!!';
} else {
    foreach ($validation->errors() as $error) {
        echo $error . '<br>';
    }
}

include __DIR__ . "/../index.view.php";
