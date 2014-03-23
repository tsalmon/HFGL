<?php

class Home extends Controller
{
    public function index()
    {
        // load views. within the views we can echo out $songs and $amount_of_songs easily
        require 'application/views/_templates/header.php';
        require 'application/views/home/connexion.html';
        require 'application/views/_templates/footer.php';
    }

    public function exampleOne()
    {
        echo "page une";
        // load views. within the views we can echo out $songs and $amount_of_songs easily
        //require 'application/views/_templates/header.php';
        //require 'application/views/home/example_one.php';
        //require 'application/views/_templates/footer.php';
    }

    public function exampleTwo()
    {
        // load views. within the views we can echo out $songs and $amount_of_songs easily
        require 'application/views/_templates/header.php';
        require 'application/views/home/example_two.php';
        require 'application/views/_templates/footer.php';
    }
}
