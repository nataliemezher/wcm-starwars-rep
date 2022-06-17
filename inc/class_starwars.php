<?php


class StarWarsF
{
    public string $apiurl = 'https://swapi.dev/api/';



    function __construct()
    {

        $this->addScript();
        $this->addAjax();
        $this->addMenuPage();
    }


    public function addMenuPage()
    {
        add_action('admin_menu', [$this, 'setUpPage']);
    }

    public function setUpPage()
    {
        add_menu_page(
            'Starwars Setting api', //titel inuti page
            'Starwars Setting', //titel i adminmenyn
            'manage_options', //capability
            'sw_settings', //slug
            [$this, 'createSWMenu'], //cb funktion nedan
            'dashicons-document', //dashicon r
            2 //plats i menyn

        );
    }
    //få ut det vi vill ha på sidan
    public function createSWMenu()
    {

        //kollar om transient först finns genom get
        $films = get_transient('sw-film-list');

        if (!$films) {
            $apicall = wp_remote_get($this->apiurl . 'films');
            $films = json_decode(wp_remote_retrieve_body($apicall));

            set_transient('sw-film-list', $films);
        }
        include_once plugin_dir_path(__FILE__) . '../partials/sw_menupage.php';
        //göra ett anrop till apiurl, sedan få ut det man vill ha från api, filmer i detta fallet fr sw apiet
        //$this $api_url för variabeln finnsi klassen


        //html filen

    }
    public function addScript()
    {
        add_action('init', [$this, 'enqueueScripts']);
    }

    public function enqueueScripts()
    {
        wp_register_script('starwars_script', plugins_url('../assets/starwars.js', __FILE__), [], '1.0', true);
        wp_enqueue_script('starwars_script');
    }
    public function addAjax()
    {
        add_action('wp_ajax_sw_form', [$this, 'handlingForm']);
        add_action('wp_ajax_nopriv_sw_form', [$this, 'handlingForm']);
    }


    public function handlingForm()
    {
        if (!wp_verify_nonce($_POST['nonce'], 'sw-nonce')) {
            wp_send_json_error('Fel', 401);
            exit();
        }
        $apicall = wp_remote_get($_POST['url']);
        $film = json_decode(wp_remote_retrieve_body($apicall));
        $existingPost = post_exists($film->title);
        $newPost =  wp_insert_post([
            'ID' => $existingPost,
            'post_title' =>  $film->title,
            'post_type' => 'sw_film',
            'meta_input' => [
                'director' => $film->firector,
                'episode_id' => $film->episode_id,
                'producer' => $film->producer,
                'release_date' =>  $film->release_date,
                'url' => $film->url,
            ]
        ]);
        $apicallChar = wp_remote_get($_POST['url']);
        $character = json_decode(wp_remote_retrieve_body($apicallChar));
        $existingCharPost = post_exists($character->name);

        $newCharPost = wp_insert_post([
            'ID' => $existingCharPost,
            'post_title' => $character->name,
            'post_type' => 'sw_character',
            'meta_input' => [
                'birthdate' => $character->birth_year,
                'eye_color' => $character->eye_color,
                'hair_color' => $character->hair_color,
                'height' => $character->height,
                'homeworld' => $character->homeworld,
                'films' => $character->films,
                'url' => $character->url
            ]

        ]);

        if (!is_wp_error($newPost, $newCharPost)) {
            wp_send_json_success([
                'status' => 'success',
                'message' => 'Starwars film har lagts till',


            ]);
        } else {
            wp_send_json_error([
                'status' => 'error',
                'message' => 'Något gick fel'
            ]);
        }
    }
}
