<?php
/**
 * Created by PhpStorm.
 * User: pauldossantos
 * Date: 03/10/2018
 * Time: 15:54
 */

namespace App\Controller;

abstract class AbstractController
{
    protected $twig;

    public function __construct()
    {
        $loader = new \Twig_Loader_Filesystem(__DIR__ . '/../Template');
        $this->twig = new \Twig_Environment($loader, []);
    }
}
