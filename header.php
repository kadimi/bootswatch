<?php
/**
 * The header for our theme.
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Bootswatch
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>

	<header class="header">

		<nav class=" navbar navbar-default <?php echo bootswatch_use( 'fixed_navbar' ) ? 'navbar-fixed-top' : 'navbar-static-top'; ?> ">
			<div class="container">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".collapse">
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<a class="navbar-brand" href="<?php echo esc_url( home_url() ); ?>"><?php bloginfo( 'name' ); ?></a>
				</div>
				<div class="collapse navbar-collapse">
					<?php
					wp_nav_menu( array(
						'theme_location' => 'primary',
						'container' => false,
						'menu_class' => 'nav navbar-nav' . ( ! bootswatch_use( 'search_form_in_header' ) ? ' navbar-right' : '' ),
						'walker' => new Bootswatch_Nav_Walker,
						'fallback_cb' => false,
						'depth' => 2,
					) );
					?>
					<?php
					if ( bootswatch_use( 'search_form_in_header' ) ) {
						bootswatch_search_form( 'navbar-form pull-right' );
					}
					?>
				</div>
			</div>
		</nav>

		<?php do_action( 'bootswatch_after_nav' ); ?>
	</header>
