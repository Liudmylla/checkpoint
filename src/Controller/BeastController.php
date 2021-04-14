<?php


namespace App\Controller;

use App\Model\BeastManager;
use App\Model\MovieManager;
use App\Model\PlanetManager;


/**
 * Class BeastController
 * @package Controller
 */
class BeastController extends AbstractController
{


    /**
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function list() : string
    {
        $beastsManager = new BeastManager();
        $beasts = $beastsManager->selectAll();
        return $this->twig->render('Beast/list.html.twig', ['beasts' => $beasts]);
    }


    /**
     * @param int $id
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function details(int $id)  : string
    {
      // TODO : A page which displays all details of a specific beasts.
      $beastManager = new BeastManager();
      $beast = $beastManager->selectOneById($id);
      $planetManager = new PlanetManager();
      $planet = $planetManager->selectOneById($beast['id_planet']);
      $movieManager = new MovieManager();
      $movie =$movieManager->selectOneById($beast['id_movie']);

   
        return $this->twig->render('Beast/details.html.twig',
            
            ['beast'=>$beast,
            'planet'=>$planet,
            'movie'=>$movie
            ]
            
        );
    }


    /**
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function add(): string
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // clean $_POST data
            $beast = array_map('trim', $_POST);
            $beastManager = new BeastManager();
            $beastManager->insert($beast);
          
         
            header('Location:/beast/list/');
        }
        $planetManager = new PlanetManager();
        $planets = $planetManager->selectAll();
        $movieManager = new MovieManager();
        $movies =$movieManager->selectAll();

        return $this->twig->render('Beast/add.html.twig',

        [
        'planets'=>$planets,
        'movies'=>$movies
        ]
    );
    }



    /**
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function edit(int $id) : string
    {
      $beastManager = new BeastManager();
      $beast = $beastManager->selectOneById($id);
      $planetManager = new PlanetManager();
      $planets = $planetManager->selectAll();
      $movieManager = new MovieManager();
      $movies =$movieManager->selectAll();

      // TODO : An edition page where your can edit a beast.
      if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // clean $_POST data
        $beast = array_map('trim', $_POST);

        // TODO validations (length, format...)

        // if validation is ok, update and redirection
        $beastManager->update($beast);
        header('Location: /beast/list/' );
    }

    return $this->twig->render('Beast/edit.html.twig',
    ['beast'=>$beast,
    'planets'=>$planets,
    'movies'=>$movies
    ]
);
       
    }
   

    /**
     * Delete a specific item
     */
    public function delete(int $id)
    {
        
          $beastManager = new BeastManager();
         // $beast = $beastManager->selectOneById($id);
       
          $beastManager->delete($id);
          header('Location:/Beast/list' );
        
    }
}
