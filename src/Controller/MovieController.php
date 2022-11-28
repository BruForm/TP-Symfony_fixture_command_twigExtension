<?php

namespace App\Controller;

use App\Entity\Movie;
use App\Form\MovieType;
use App\Repository\MovieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\String\Slugger\SluggerInterface;

class MovieController extends AbstractController
{
    public function __construct(
        private ParameterBagInterface $parameterBag,
        private EntityManagerInterface $entityManager,
        private PaginatorInterface $paginator,
    )
    {
    }

    #[Route('/movies', name: 'app_movie_view')]
    public function index(Request $request, MovieRepository $movieRepository): Response
    {
        $qb = $movieRepository->getQbAll();
        $pagination = $this->paginator->paginate(
            $qb,
            $request->query->getInt('page', 1),
            10
        );

        return $this->render('movie/index.html.twig', [
            'movies' => $pagination,
        ]);
    }

    #[Route('/movie/add', name: 'app_movie_add')]
    public function addMovie(Request $request, SluggerInterface $slugger): Response
    {
        $movieImagesDir = $this->parameterBag->get('movieImagesDir'); // relié à config/services.yaml

        $movie = new Movie();
        $form = $this->createForm(MovieType::class, $movie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            dump($movie);
            dump($request);

            $imageFile = $form->get('imageFile')->getData();
            /**@var UploadedFile $imageFile */
            if ($imageFile) {
                // recupere le nom du fichier sans son extension
                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);

                // remplace les espaces et autres caracteres etranges du nom de fichier ex : ("chat noir"=>"chat-noir")
                $safeFilename = $slugger->slug($originalFilename);

                // Crée le nouveau nom du fichier et fait en sorte qu'il soit unique en y incorporant un unique id
                // et y recolle son extension d'origine (ex => "chat-noir-1324346746300781.jpg)
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $imageFile->guessExtension();

                try {
                    $imageFile->move(
                        $movieImagesDir,
                        $newFilename
                    );
                    $movie->setImagePath($newFilename);

                    $this->entityManager->persist($movie);
                    $this->entityManager->flush();

                } catch (\Exception $e) {

                }
            }
        }

        return $this->render('movie/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
