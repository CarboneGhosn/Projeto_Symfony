<?php

namespace App\Controller;

use App\Entity\Series;
use App\Repository\SeriesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
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
        $session = $request->getSession();
        $successMessage = $session->get(name:'success');
        $session->remove(name:'success');
       
        return $this->render('series/index.html.twig', [
            'seriesList' => $seriesList,
            'successMessage' => $successMessage,
        ]);
    }

    #[Route('Projeto_Symfony/public/series/create', name:'app_series_form', methods: ['GET'])]
    public function addSeriesForm(): Response
    {
        return $this->render(view:'series/form.html.twig');
    }

    #[Route('Projeto_Symfony/public/series/create', methods: ['POST'])]
    public function addSeries(Request $request): Response
    {
        $seriesName = $request->request->get(key:'name');
        $series = new Series($seriesName);
        $request->getSession()->set('success', "Série \"{$seriesName}\"adicionada com sucesso");
        
        $this->seriesRepository->add($series, flush:true);
        return new RedirectResponse(url:'/Projeto_Symfony/public/series');
    }

    #[Route('Projeto_Symfony/public/series/delete/{id}', methods: ['POST'])]
    public function deleteSeries(int $id, Request $request): Response
    {
        $this->seriesRepository->removeById($id);
        $session = $request->getSession();
        $session->set('success', 'Série deletada com sucesso');
        return new RedirectResponse(url:'/Projeto_Symfony/public/series');
    }
    #[Route('Projeto_Symfony/public/series/edit/{series}', name: 'app_edit_series_form', methods: ['GET'])]
    public function editSeriesForm(Series $series): Response 
    {
        return $this->render('series/form.html.twig', [
            'series' => $series,
        ]);
           
    }

    #[Route('Projeto_Symfony/public/series/edit/{series}', name: 'app_store_series_changes', methods: ['PATCH'])]
    public function storeSeriesChanges(): Response 
    {
        $request->getSession()->set('success', "Série editada com sucesso");

        return new RedirectResponse('/series');
    }
}
