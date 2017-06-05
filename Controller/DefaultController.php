<?php

namespace PartFire\MailChimpBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('PartFireMailChimpBundle:Default:index.html.twig');
    }
}
