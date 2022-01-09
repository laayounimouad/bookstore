<?php

namespace App\Controller;

use App\Repository\AuteurRepository;
use App\Repository\GenreRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Repository\LivreRepository;
use DateTime;
use Symfony\Component\HttpFoundation\Request;

class HomeController extends AbstractController
{

    
    /**
     * @Route("/", name="home", methods={"GET"})
     */
    public function index(LivreRepository $livreRepository,AuteurRepository $auteurRepository,GenreRepository $genreRepository): Response
    {
        return $this->render('index.html.twig', [
            'controller_name' => 'HomeController',
            'livres'    => $livreRepository->findAll(),
            'auteurs'   => $auteurRepository->findAll(),
            'genres'    => $genreRepository->findAll()
        ]);
    }


    /**
     * @Route("/search/auteur", name="search_auteur", methods={"GET"})
     */
    public function searchByAuteur(LivreRepository $livreRepository,Request $request,AuteurRepository $auteurRepository,GenreRepository $genreRepository): Response
    {
        $id=$request->query->get('_auteur');
        //var_dump($id);
        $auteurid=$auteurRepository->find($id);
        return $this->render('index.html.twig', [
            'livres' => $auteurid->getLivres(),
            'auteurs' => $auteurRepository->findAll(),
            'genres'    => $genreRepository->findAll()
        ]);
    }
    
    
    /**
     * @Route("/search/genre", name="search_genre", methods={"GET"})
     */
    public function searchByGenre(LivreRepository $livreRepository,Request $request,AuteurRepository $auteurRepository,GenreRepository $genreRepository): Response
    {
        $id=$request->query->get('_genre');
        //var_dump($id);
        $genreid=$genreRepository->find($id);
        return $this->render('index.html.twig', [
            'livres' => $genreid->getLivres(),
            'auteurs' => $auteurRepository->findAll(),
            'genres'    => $genreRepository->findAll()
        ]);
    }
    
    
    /**
     * @Route("/search/date", name="search_date", methods={"GET"})
     */
    public function searchByDate(LivreRepository $livreRepository,Request $request,AuteurRepository $auteurRepository,GenreRepository $genreRepository): Response
    {
        $date=$request->query->get('_date');
        //var_dump($id);
        // $genreid=$genreRepository->find($id);
        return $this->render('index.html.twig', [
            'livres' => $livreRepository->findBy(['date_de_parution'=>new DateTime($date)]),
            'auteurs' => $auteurRepository->findAll(),
            'genres'    => $genreRepository->findAll()
        ]);
    }

    
    /**
     * @Route("/search/titre", name="search", methods={"GET"})
     */
    public function searchBytitre(LivreRepository $livreRepository,Request $request,AuteurRepository $auteurRepository,GenreRepository $genreRepository): Response
    {
        $titre=$request->query->get('_titre');
        //var_dump($id);
        // $genreid=$genreRepository->find($id);
        return $this->render('index.html.twig', [
            'livres' => $livreRepository->findByTitreField($titre),
            'auteurs' => $auteurRepository->findAll(),
            'genres'    => $genreRepository->findAll()
        ]);
    }
    
}

