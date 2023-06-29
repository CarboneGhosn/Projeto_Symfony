<?php

namespace App\Controller;

use App\DTO\SeriesCreateFromInput;
use App\Entity\Series;
use App\Entity\Season;
use App\Entity\Episode;
use App\Form\SeriesType;
use App\Repository\SeriesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SeriesController extends AbstractController
{
    public function __construct(private SeriesRepository $seriesRepository, private EntityManagerInterface $entityManager)
    {
        $this->seriesRepository = $seriesRepository;
    }

    #[Route('/series', name: 'app_series', methods: ['GET'])]
    public function seriesList(Request $request): Response
    {
        $seriesList = $this->seriesRepository->findAll();
     
        return $this->render('series/index.html.twig', [
            'seriesList' => $seriesList,
            
        ]);
    }

    #[Route('Projeto_Symfony/public/series/create', name:'app_series_form', methods: ['GET'])]
    public function addSeriesForm(): Response
    {
        
        $seriesForm = $this->createForm(SeriesType::class, new SeriesCreateFromInput());
        return $this->renderForm('series/form.html.twig', compact(var_name: 'seriesForm'));
    }

    #[Route('Projeto_Symfony/public/series/create',name:'app_add_series', methods: ['POST'])]
    public function addSeries(Request $request): Response
    {
        $input = new SeriesCreatefromInput();
        $seriesForm = $this->createForm(SeriesType::class, $input)
        ->handleRequest($request);

        if (!$seriesForm->isValid()) {
            return $this->renderForm('series/form.html.twig', compact(var_name: 'seriesForm'));
        }

        $series = new Series($input->seriesName);
        for ($i = 1; $i < $input->seasonsQuantity; $i++) {
          $season = new Season($i);
         for ($j = 1;$j <= $input->episodesPerSeason;$j++) {
            $season->addEpisode(new Episode($j));
         }
          $series->addSeason($season);
        }

        $this->addFlash('success', 
        "Série \"{$series->getName()}\" adicionada com sucesso");
        
        $this->seriesRepository->add($series, flush:true);
        return new RedirectResponse(url:'/Projeto_Symfony/public/series');
    }

    #[Route('Projeto_Symfony/public/series/delete/{id}', methods: ['POST'])]
    public function deleteSeries(int $id, Request $request): Response
    {
        
        $this->seriesRepository->removeById($id);
        $this->addFlash('success', "Série removida com sucesso");
        
        return new RedirectResponse(url:'/Projeto_Symfony/public/series');
    }
    #[Route('Projeto_Symfony/public/series/edit/{series}', name: 'app_edit_series_form', methods: ['GET'])]
    public function editSeriesForm(Series $series): Response 
    {
        $seriesForm = $this->createForm(SeriesType::class, $series, ['is_edit' => true]);
        return $this->renderForm('series/form.html.twig', compact('seriesForm', 'series'));
           
    }

    #[Route('Projeto_Symfony/public/series/edit/{series}', name: 'app_store_series_changes', methods: ['PATCH'])]
    public function storeSeriesChanges(Series $series, Request $request): Response 
    {
        $seriesForm = $this->createForm(SeriesType::class, $series, ['is_edit' => true]);
        $seriesForm->handleRequest($request);

        if (!$seriesForm->isValid()) {
            return $this->renderForm('series/form.html.twig', compact('seriesForm', 'series'));
        }

        $this->addFlash('success', "Série \"{$series->getName()}\" editada com sucesso");
        $this->entityManager->flush();

        return new RedirectResponse('/Projeto_Symfony/public/series');
    }

}
