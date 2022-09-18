<?php

/**
 * CE FICHIER A POUR BUT D'AFFICHER LA PAGE D'ACCUEIL !
 */

require_once("libraries/controllers/Article.php");

$controller = new Controllers\Article;
$controller->index();
