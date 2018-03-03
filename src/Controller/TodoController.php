<?php
/**
 * Created by PhpStorm.
 * User: ridid44
 * Date: 2/25/2018
 * Time: 1:26 PM
 */

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class TodoController extends Controller
{
    public function go()
    {
        $number = mt_rand(0, 100);

        return $this->render('todo/todo.html.twig');
    }
}