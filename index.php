<?php

// Inclut l'autoloader de Composer
require_once __DIR__ . '/vendor/autoload.php';

// Charge Twig
$loader = new \Twig\Loader\FilesystemLoader(__DIR__ . '/templates');
$twig = new \Twig\Environment($loader);

// Charge le template "home.html.twig"
$template = $twig->load('home.html.twig');

// Rendre le template avec des données (si nécessaire)
echo $template->render();
