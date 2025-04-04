<?php

function home() {
    session_start();
    $_SESSION['notification'] = [
        [
            'type' => 'error',
            'title' => 'Erreur',
            'message' => 'Vous devez vous connecter pour continuer'
        ]
    ];

    require 'templates/home.php';
}

function signup() {
    require 'templates/signup.php';
}

function signin() {
    require 'templates/signin.php';
}

?>