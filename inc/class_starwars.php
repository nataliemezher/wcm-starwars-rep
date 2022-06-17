<?php

class StarWars
{

    function __construct()
    {
        $this->addMenuPage();
    }

    public function addMenuPage()
    {
        add_menu_page(
            'Starwars Setting', //titel i adminmenyn
            'Starwars setting page', //titel inuti page
            'manage_options', //capability
            'sw_settings', //slug
            'dashicons-document',
            10

        );
    }
}
