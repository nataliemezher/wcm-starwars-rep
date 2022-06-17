
<?php
class SW_Post_Types
{

    public function __construct()
    {
        //construct körs när klassen initerar
        $this->addPostTypeAction();
        //$this->addPostType();
    }

    private function addPostTypeAction()
    {
        add_action('init', [$this, 'addPostType']);
        add_action('init', [$this, 'addPostTypeFilm']);
    }


    public function addPostType()
    {


        register_post_type('sw_character', [
            'labels' => [
                'name' => 'Characters', //namn i menyn
                'singular' => 'Character',

            ],
            'public' => true,
            'supports' => [
                'title',
                'custom-fields',
                'thumbnail',
                'custom-fields',
            ]

        ]);
    }


    public function addPostTypeFilm()
    {
        register_post_type('sw_film', [
            'labels' => [
                'name' => 'Starwars Films',
                'singular' => 'Starwars Film',

            ],
            'public' => true,
            'supports' => [
                'title',
                'custom-fields',
                'thumbnail',
                'custom-fields',
            ]

        ]);
    }
}
