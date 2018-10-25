<?php
// J'active mes sessions pour pouvoir les afficher ou les setter.
session_start();

require '../vendor/autoload.php';
require '../connect.php';
require_once '../app/dispatcher.php';

/* A chaque fois que la page est chargée complètement, je la supprime la session "alerte" afin qu'elle ne
s'affiche pas à nouveau si j'actualise la page */
unset($_SESSION['alerts']);
