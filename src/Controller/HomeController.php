<?php
/**
 * Created by PhpStorm.
 * User: pauldossantos
 * Date: 02/10/2018
 * Time: 20:01
 */

namespace App\Controller;

class HomeController extends AbstractController
{
    /**
     * @return string
     */
    public function showHomeAction()
    {
        return $this->twig->render('home.html.twig');
    }
}
