<?php

class Home extends Controller
{
    public function index()
    {
        // load views. within the views we can echo out $songs and $amount_of_songs easily
        require 'application/views/_templates/header.php';
        require 'application/views/_templates/header_end.php';
        print_r($_SESSION);
        require 'application/views/home/connexion.html';
        require 'application/views/_templates/footer.php';
    }
}
