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
    public function go() {
        return $this->render('todo/todo.html.twig');
    }

    public function save() {
        var_dump($_POST["data"]);
        if (empty($POST["data"])){
            return new Response('All is good in controller town');
        } else {
            return new Response('Some problem occured', 500);
        }

    }

}