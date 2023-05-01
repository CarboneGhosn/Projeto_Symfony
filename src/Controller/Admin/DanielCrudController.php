<?php

namespace App\Controller\Admin;

use App\Entity\Daniel;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use Symfony\Component\Routing\Annotation\Route;

class DanielCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Daniel::class;
    }

    /**
    * @Route("daniel","daniel")
    */
    // public function teste(){
    // return $this->render('DanielCrudController', []);
    // }

    
           
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
}
