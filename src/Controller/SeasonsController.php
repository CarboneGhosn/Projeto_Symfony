<?php

namespace App\Controller;


use App\Entity\Series;
use App\Entity\Season;
use App\Entity\Episode;
use App\Repository\SeriesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\Cache\ItemInterface;
use DateTime\DateInterval;

class SeasonsController extends AbstractController
{
   public function __construct(private CacheInterface $cache)
   {
        $this->seriesRepository = new SeriesRepository;
   }


    #[Route('Projeto_Symfony/public/series/{series}/seasons', name: 'app_seasons')]
    public function index(Series $series): Response
    {
        $seasons = $this->cache->get(
            "series_{$series->getId()}_seasons",
        function (ItemInterface $item) use ($series) {
            $item->expiresAfter(new \DateInterval('PT10S'));
        
            /** @var PersistentCollection $seasons */
            $seasons = $series->getSeasons();
            $seasons->initialize();

            return $seasons;
        }
    );


        return $this->render('seasons/index.html.twig', [
            'series' => $series,
            'seasons' => $seasons,
        ]);
    }

}
