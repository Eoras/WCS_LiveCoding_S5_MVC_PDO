<?php
// Je gère mes routes ici
$routes = [
    'Home' => [ // HomeController

        // action, url, HTTP method
        ['showHomeAction', '/', 'GET'],
    ],
    'Personne' => [ // PersonneController
        // action, url, HTTP method
        ['showAllAction', '/personnes', 'GET'],
        ['addOrEditAction', '/addPersonne', ['GET', 'POST']],
        ['addOrEditAction', '/editPersonne/{id}', ['GET', 'POST']],
        ['deletePersonne', '/deletePersonne', 'POST']
    ]
];
