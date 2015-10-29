<?php

/**
 * Fix overlapping in the top due to Bootstrap's fixed navbar and WordPress admin bar
 */
add_action( 'wp_head', 'bootswatch_wp_head' );
function bootswatch_wp_head() {
    ?>
    <style>
        body {
            padding-top: 81px;
        }
        body.admin-bar .navbar-fixed-top{
            top: 32px;
        }
    </style>
<?php
}
