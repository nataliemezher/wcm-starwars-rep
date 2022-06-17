<div class="wrap">
    <h1><?php echo esc_html(get_admin_page_title()); ?></h1>

    <?php
    foreach ($films->results as $film) : ?>

        <div>
            <h3><?php echo $film->title ?></h3>
            <form class="sw-import" action="<?php echo admin_url('admin-ajax.php') ?>" method="post">
                <?php wp_nonce_field('sw-nonce', 'nonce'); ?>
                <input type="hidden" name="url" value="<?php echo $film->url; ?>">
                <input type="hidden" name="action" value="sw_handle_form">
                <button type="submit">Importera</button>

            </form>
        </div>


    <?php endforeach; ?>

</div>