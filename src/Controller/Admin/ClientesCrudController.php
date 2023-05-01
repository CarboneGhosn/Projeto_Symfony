<?php

namespace App\Controller\Admin;

use App\Entity\Clientes;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use Symfony\Component\Routing\Annotation\Route;

class ClientesCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Clientes::class;
    }

    /**
    * @Route("teste","teste")
    */
    public function teste(){
        return $this->render('index.html.twig', [ 
            
            
           
            
        ]);

        
    }
    /*
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('title'),
            TextEditorField::new('description'),
        ];
    }
    */

         ##[Route('/homepage', name: 'admin')]  
    public function qualquerCoisa(){

        return $this->render('ClientesCrudController.php', [
            "title" => "Daniel"
        ]);
    
    }
}
    