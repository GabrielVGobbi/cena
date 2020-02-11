<?php

class notfoundController extends controller
{

    public function __construct()
    {
        parent::__construct();

       

    }

    public function index()
    {

        $this->loadTemplate('obras/index', array());

    }

   


}
