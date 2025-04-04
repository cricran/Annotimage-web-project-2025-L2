<?php

function home() {
    session_start();
    $_SESSION['notification'] = [
        [
            'type' => 'error',
            'title' => 'Erreur',
            'message' => 'Vous devez vous connecter pour continuer'
        ],
        [
            'type' => 'success',
            'title' => 'Succès',
            'message' => 'Votre compte a été créé avec succès'
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