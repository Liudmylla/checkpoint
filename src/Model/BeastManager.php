<?php
/**
 * Created by PhpStorm.
 * User: sylvain
 * Date: 07/03/18
 * Time: 18:20
 * PHP version 7
 */

namespace App\Model;

/**
 * Class BeastManager
 * @package Model
 */
class BeastManager extends AbstractManager
{

    /**
     *
     */
    const TABLE = 'beast';


    /**
     * BeastManager constructor.
     * @param \PDO $pdo
     */
    public function __construct()
    {
        parent::__construct(self::TABLE);
    }
    public function selectOneBeastById(int $id)
    {
        // prepared request
        $query = "SELECT * FROM beast AS b JOIN planet AS p ON p.id = b.id_planet JOIN movie AS m ON m.id= b.id_movie WHERE p.id =:id";
        $statement = $this->pdo->prepare($query);
        $statement->bindValue('id', $id, \PDO::PARAM_INT);
        $statement->execute();

        return $statement->fetch();
    }

    public function insert(array $beast): int
    {
        //to modify
        $statement = $this->pdo->prepare("INSERT INTO " . $this->table .
        " (`name`,`area`, `picture`, `size`, `id_planet`, `id_movie` ) 
        VALUES (:name,:area,:picture,:size,:planet,:movie)");
        $statement->bindValue('name', $beast['name'], \PDO::PARAM_STR);
        $statement->bindValue('area', $beast['area'], \PDO::PARAM_STR);
        $statement->bindValue('picture', $beast['picture'], \PDO::PARAM_STR);
        $statement->bindValue('size', $beast['size'], \PDO::PARAM_INT);
        $statement->bindValue('planet', $beast['planet'], \PDO::PARAM_INT);
        $statement->bindValue('movie', $beast['movie'], \PDO::PARAM_INT);
     
      
        $statement->execute();
        return (int)$this->pdo->lastInsertId();
    }
    public function update(array $beast): bool
    {   //var_dump($beast);die();
        //to modify
        $statement = $this->pdo->prepare("UPDATE " . $this->table .
        " SET `name` = :name, 
            `area` = :area, 
            `picture` = :picture, 
            `size` = :size, 
            `id_planet` = :planet, 
            `id_movie` = :movie

        WHERE id=:id");

        $statement->bindValue('id', $beast['id'], \PDO::PARAM_INT);
        $statement->bindValue('name', $beast['name'], \PDO::PARAM_STR);
        $statement->bindValue('area', $beast['area'], \PDO::PARAM_STR);
        $statement->bindValue('picture', $beast['picture'], \PDO::PARAM_STR);
        $statement->bindValue('size', $beast['size'], \PDO::PARAM_INT);
        $statement->bindValue('planet', $beast['planet'], \PDO::PARAM_INT);
        $statement->bindValue('movie', $beast['movie'], \PDO::PARAM_INT);
     
        return $statement->execute();
    }

    public function delete(int $id): void
    {   
        // prepared request
        $statement = $this->pdo->prepare("DELETE FROM $this->table WHERE id=:id");
        $statement->bindValue('id', $id, \PDO::PARAM_INT);
        $statement->execute();

    
    }
}
