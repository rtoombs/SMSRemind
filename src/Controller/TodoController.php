<?php
/**
 * Created by PhpStorm.
 * User: ridid44
 * Date: 2/25/2018
 * Time: 1:26 PM
 */

namespace App\Controller;

use App\Entity\ListData;
use App\Entity\User;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\HttpFoundation\Session\Session;


class TodoController extends Controller
{

    public function login() {
        return $this->render('todo/login.html.twig');
    }

    public function registerPage() {
        return $this->render('todo/register.html.twig');
    }

    public function go(Request $request) {
        $userID = 0;
        $session = $request->getSession();
        $email = $session->get('email');
        //TODO Problem checking if cant find entities

        $entityManager = $this->getDoctrine()->getManager();
        $loadUser = $entityManager->getRepository(User::class)->findOneBy(array('email' => $email));

        if ($loadUser) {
            $userID = $loadUser->getId();
            $session->set('id', $userID);
        }
        if ($session->get('logged_in')){
            return $this->render('todo/todo.html.twig',array('id' => $userID, 'logged_in' => $session->get('logged_in')));
        }
        else {
            return $this->render('todo/login.html.twig',array('denied' => 1));
        }

    }

    public function save() {
        $entityManager = $this->getDoctrine()->getManager();

        if (!empty($_POST["data"])){
            $loadedData = $entityManager->getRepository(ListData::class)->findOneBy(array('id' => 1));
            if ($loadedData) {
                $loadedData->setData($_POST["data"]);
                $loadedData->setModified(new \DateTime('now'));
                $entityManager->flush();
            }
            else {
                return new Response('Some problem occured', 500);
            }
            return new Response('All is good in controller town. Save data with id of ');
        }

    }

    public function load(Request $request) {
        $session = $request->getSession();
        $uid = $session->get('id');
        //TODO Problem checking if cant find entities
        echo($uid);
        $entityManager = $this->getDoctrine()->getManager();
        $loadInfo = $entityManager->getRepository(ListData::class)->findOneBy(array('id' => $uid));
        $temp = json_decode($loadInfo->getData());
        return new JsonResponse(array('data' => $temp));
    }

    public function userRegister(UserPasswordEncoderInterface $passwordEncoder) {
        $data = json_decode($_POST["data"], true);
        if ($data['email'] != null && $data['pass'] != null){
            $entityManager = $this->getDoctrine()->getManager();
            $emailCheck = $entityManager->getRepository(User::class)->findOneBy(array('email' => $data['email']));
            if (!$emailCheck){
                $user = new User();
                $user->setUsername($data['email']);
                $user->setEmail($data['email']);
                $password = $passwordEncoder->encodePassword($user, $data['pass']);
                $user->setPassword($password);
                $user->setActive(TRUE);
                $entityManager->persist($user);
                $entityManager->flush();

                $list = new ListData();
                $list->setData("");
                $list->setModified(new \DateTime('now'));
                $entityManager->persist($list);
                $entityManager->flush();


                $ret = array('status' => 'OK');
                return new Response(json_encode($ret));
            }
            else {
                //TODO Handle event that email is already in database
                $ret = array('status' => 'AID');
                return new Response(json_encode($ret));
            }
        }
    }

    public function checkLogin(UserPasswordEncoderInterface $passwordCheck, Request $request) {
        $data = json_decode($_POST["data"], true);
        if ($data['email'] != null && $data['pass'] != null){
            $entityManager = $this->getDoctrine()->getManager();
            $user = $entityManager->getRepository(User::class)->findOneBy(array('email' => $data['email']));
            $valid = FALSE;
            if (!empty($user)) {
                $valid = $passwordCheck->isPasswordValid($user, $data['pass']);

                if ($valid) {
                    $session = $request->getSession();
                    $session->set('logged_in', TRUE);
                    $session->set('email', $data['email']);
                    return new Response(json_encode(array('status' => 'OK')));
                }
            }
        }
        return new Response(json_encode(array('status' => 'INVALID')));
    }

    public function logout(Request $request) {
        $session = $request->getSession();
        $session->invalidate();
        return new Response("Logged out");
    }

}