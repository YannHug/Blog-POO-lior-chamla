<?php

/**
 * Retourne une connexion à la base de données
 *
 * @return PDO
 */
function getPdo(): PDO
{
    /**
     * Attention, on précise ici deux options :
     * - Le mode d'erreur : le mode exception permet à PDO de nous prévenir violament quand on fait une connerie ;-)
     * - Le mode d'exploitation : FETCH_ASSOC veut dire qu'on exploitera les données sous la forme de tableaux associatifs
     */
    $pdo = new PDO('mysql:host=localhost;dbname=blogpoo;charset=utf8', 'root', 'root', [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);
    return $pdo;
}


function findAllArticles(): array
{
    $pdo = getPdo();
    // On utilisera ici la méthode query (pas besoin de préparation car aucune variable n'entre en jeu)
    $resultats = $pdo->query('SELECT * FROM articles ORDER BY created_at DESC');
    // On fouille le résultat pour en extraire les données réelles
    $articles = $resultats->fetchAll();

    return $articles;
}

/**
 * Retourne un article en fonction de son identifiant
 *
 * @param integer $article_id
 */
function findArticle(int $article_id)
{
    // On va ici utiliser une requête préparée car elle inclue une variable qui provient de l'utilisateur : Ne faites jamais confiance à ce connard d'utilisateur ! :D

    $pdo = getPdo();

    $query = $pdo->prepare("SELECT * FROM articles WHERE id = :article_id");

    // On exécute la requête en précisant le paramètre :article_id 
    $query->execute(['article_id' => $article_id]);

    // On fouille le résultat pour en extraire les données réelles de l'article
    $article = $query->fetch();

    return $article;
}


function deleteArticle(int $id): void
{
    $pdo = getPdo();

    $query = $pdo->prepare('DELETE FROM articles WHERE id = :id');
    $query->execute(['id' => $id]);
}

function findComment($id)
{
    $pdo = getPdo();

    $query = $pdo->prepare('SELECT * FROM comments WHERE id = :id');
    $query->execute(['id' => $id]);

    $comment = $query->fetch();
    return $comment;
}

function findAllComments(int $article_id): array
{
    $pdo = getPdo();

    //Pareil, toujours une requête préparée pour sécuriser la donnée filée par l'utilisateur (cet enfoiré en puissance !)
    $query = $pdo->prepare("SELECT * FROM comments WHERE article_id = :article_id");

    $query->execute(['article_id' => $article_id]);

    $commentaires = $query->fetchAll();

    return $commentaires;
}

function deleteComment(int $id): void
{
    $pdo = getPdo();

    $query = $pdo->prepare('DELETE FROM comments WHERE id = :id');
    $query->execute(['id' => $id]);
}

function createComment(string $author, string $content, int $article_id): void
{
    $pdo = getPdo();

    $query = $pdo->prepare('INSERT INTO comments SET author = :author, content = :content, article_id = :article_id, created_at = NOW()');
    $query->execute(compact('author', 'content', 'article_id'));
}
