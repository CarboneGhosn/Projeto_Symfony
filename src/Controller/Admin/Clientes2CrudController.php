<?php

namespace App\Controller\Admin;

use App\Entity\Clientes;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class Clientes2CrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Clientes::class;
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
}
