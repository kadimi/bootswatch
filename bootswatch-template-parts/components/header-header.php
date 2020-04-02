<?php
/**
 * The header.
 *
 * @package Bootswatch
 */

?>

<header class="header" role="banner">
	<a class="screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'bootswatch' ); ?></a>
	<?php bootswatch_get_template_part( 'template-parts/components/header', 'nav' ); ?>
	<?php bootswatch_get_template_part( 'template-parts/components/header', 'custom-header' ); ?>
</header>
