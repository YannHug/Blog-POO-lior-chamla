<?php

require_once('libraries/models/Model.php');

class Article extends Model
{
    /**
     * Retourne tous les articles
     *
     * @return array
     */
    public function findAll(): array
    {
        // On utilisera ici la méthode query (pas besoin de préparation car aucune variable n'entre en jeu)
        $resultats = $this->pdo->query('SELECT * FROM articles ORDER BY created_at DESC');
        // On fouille le résultat pour en extraire les données réelles
        $articles = $resultats->fetchAll();

        return $articles;
    }

    /**
     * Retourne un article en fonction de son identifiant
     *
     * @param integer $article_id
     */
    public function find(int $article_id)
    {
        // On va ici utiliser une requête préparée car elle inclue une variable qui provient de l'utilisateur : Ne faites jamais confiance à ce connard d'utilisateur ! :D

        $query = $this->pdo->prepare("SELECT * FROM articles WHERE id = :article_id");

        // On exécute la requête en précisant le paramètre :article_id 
        $query->execute(['article_id' => $article_id]);

        // On fouille le résultat pour en extraire les données réelles de l'article
        $article = $query->fetch();

        return $article;
    }

    /**
     * Permet la suppression d'un article
     *
     * @param integer $id
     * @return void
     */
    public function delete(int $id): void
    {
        $query = $this->pdo->prepare('DELETE FROM articles WHERE id = :id');
        $query->execute(['id' => $id]);
    }
}
