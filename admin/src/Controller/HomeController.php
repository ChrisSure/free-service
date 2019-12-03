<?php
/**
 * Created by PhpStorm.
 * User: ktv911
 * Date: 29.10.19
 * Time: 10:27
 */

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function home(): Response
    {
        return $this->render('admin/home.html.twig');
    }


}