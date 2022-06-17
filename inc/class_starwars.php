<?php

class StarWars
{

    function __construct()
    {
        $this->addMenuPage();
    }


    public function addMenuPage()
    {
        add_action('admin_menu', [$this, 'setUpPage']);
    }

    public function setUpPage()
    {
        add_menu_page(
            'Starwars Setting', //titel i adminmenyn
            'Starwars setting page', //titel inuti page
            'manage_options', //capability
            'sw_settings', //slug
            [$this, 'createSWMenu'], //cb funktion nedan
            'dashicons-document', //dashicon r
            2 //plats i menyn

        );
    }

    public function createSWMenu()
    {
        include_once plugin_dir_path(__FILE__) . '../partials/sw_menupage.php';
    }
}
