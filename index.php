<?php

/**
 * CE FICHIER A POUR BUT D'AFFICHER LA PAGE D'ACCUEIL !
 */

require_once('libraries/database.php');
require_once('libraries/utils.php');


/**
 * 2. Récupération des articles
 */
$articles = findAllArticles();

/**
 * 3. Affichage
 */
$pageTitle = "Accueil";

render('articles/index', compact('pageTitle', 'articles'));
