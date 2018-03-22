<?php
/**
 * Created by PhpStorm.
 * User: ridid44
 * Date: 2/25/2018
 * Time: 1:26 PM
 */

namespace App\Controller;

use App\Entity\ListData;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class TodoController extends Controller
{
    public function go() {
        //$listData = $this->getDoctrine()->getRepository(ListData::class)->findBy(array('uid' => 1));
        return $this->render('todo/todo.html.twig');
    }

    public function save() {
        $entityManager = $this->getDoctrine()->getManager();
        $TEMPUID = 1;

        if (!empty($_POST["data"])){
            $loadedData = $entityManager->getRepository(ListData::class)->findOneBy(array('uid' => 1));
            if (!$loadedData) {
                $listData = new ListData();
                $listData->setUid($TEMPUID);
                $listData->setData($_POST["data"]);
                $listData->setModified(new \DateTime('now'));
                $entityManager->persist($listData);
                $entityManager->flush();
            }
            else {
                $loadedData->setData($_POST["data"]);
                $loadedData->setModified(new \DateTime('now'));
                $entityManager->flush();
            }
            return new Response('All is good in controller town. Save data with id of ');
        } else {
            return new Response('Some problem occured', 500);
        }

    }

}