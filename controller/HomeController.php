<?php

namespace Controller;

use App\Session;
use App\AbstractController;
use App\ControllerInterface;
use Model\Managers\UserManager;
use Model\Managers\TopicManager;
use Model\Managers\PostManager;
use Model\Managers\CategoryManager;

class HomeController extends AbstractController implements ControllerInterface
{

    public function index()
    {

        return [
            "view" => VIEW_DIR . "forum/home.php",
            "data" => [
                "title" => "Accueil",
                "description" => "Page d'accueil du forum"
            ]
        ];
    }


    public function forumRules()
    {

        return [
            "view" => VIEW_DIR . "rules.php"
        ];
    }


    /*public function ajax(){
            $nb = $_GET['nb'];
            $nb++;
            include(VIEW_DIR."ajax.php");
        }*/

    public function home()
    {
        return [
            "view" => VIEW_DIR . "forum/home.php",
            "data" => [
                "title" => "Accueil",
                "description" => "Page d'accueil du forum"
            ]
        ];
    }
}

