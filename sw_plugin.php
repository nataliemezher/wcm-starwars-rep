<?php

/**
 * Plugin Name: Star Wars Plugin
 * Description: A plugin for Star Wars Characters
 * Author: Natalie M
 * 
 */


register_activation_hook(__FILE__, 'sw_activation_run');
register_deactivation_hook(__FILE__, 'sw_deactivation_run');

function sw_activation_run()
{
    flush_rewrite_rules();
}
function sw_deactivation_run()
{
    flush_rewrite_rules();
}

//require klass filerna för att kunna nå dom här
require plugin_dir_path(__FILE__ . 'inc/class_starwars.php');
require plugin_dir_path(__FILE__ . 'inc/class_sw_posttypes.php');
