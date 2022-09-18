<?php

require_once('libraries/database.php');

abstract class Model
{

    protected $pdo;
    protected $table;

    public function __construct()
    {
        $this->pdo = getPdo();
    }

    /**
     * Retourne un item en fonction de son identifiant
     *
     * @param integer $id
     */
    public function find(int $id)
    {
        // On va ici utiliser une requête préparée car elle inclue une variable qui provient de l'utilisateur : Ne faites jamais confiance à ce connard d'utilisateur ! :D

        $query = $this->pdo->prepare("SELECT * FROM {$this->table} WHERE id = :id");

        // On exécute la requête en précisant le paramètre :article_id 
        $query->execute(['id' => $id]);

        // On fouille le résultat pour en extraire les données réelles de l'item
        $item = $query->fetch();

        return $item;
    }

    /**
     * Retourne tous les articles
     *
     * @return array
     */
    public function findAll(?string $order = ""): array
    {
        // On utilisera ici la méthode query (pas besoin de préparation car aucune variable n'entre en jeu)
        $sql = "SELECT * FROM {$this->table}";

        if ($order) {
            $sql .= " ORDER BY " . $order;
        }

        $resultats = $this->pdo->query($sql);
        // On fouille le résultat pour en extraire les données réelles
        $item = $resultats->fetchAll();

        return $item;
    }

    /**
     * Permet la suppression d'un article
     *
     * @param integer $id
     * @return void
     */
    public function delete(int $id): void
    {
        $query = $this->pdo->prepare("DELETE FROM {$this->table} WHERE id = :id");
        $query->execute(['id' => $id]);
    }
}
