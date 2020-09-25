<?php

namespace App\Controller\Admin;

use App\Entity\Deal;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class DealCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Deal::class;
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
