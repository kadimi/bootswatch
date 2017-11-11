<?php
/**
 * The header.
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

	<header class="header" role="banner">

		<a class="screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'bootswatch' ); ?></a>

		<?php $navbar_unique_id = esc_attr( uniqid( 'navbar-' ) ); ?>

		<nav class="navbar navbar-expand-lg navbar-light bg-light <?php echo bootswatch_has( 'fixed_navbar' ) ? 'fixed-top' : ''; ?>">
			<div class="container">
				<?php if ( is_home() ) { ?><h1 class="inline"><?php } ?>
					<a class="navbar-brand site-title" href="<?php echo esc_url( home_url() ); ?>"><?php bloginfo( 'name' ); ?></a>
				<?php if ( is_home() ) { ?></h1><?php } ?>
				<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#<?php echo $navbar_unique_id; ?>" aria-controls="<?php echo $navbar_unique_id; ?>" aria-expanded="false" aria-label="<?php echo 'Toggle navigation'; ?>">
					<span class="navbar-toggler-icon"></span>
				</button>

				<div class="collapse navbar-collapse" id="<?php echo $navbar_unique_id; ?>">
					<?php bootswatch_get_template_part( 'template-parts/components/header', 'menu' ); ?>
					<?php bootswatch_get_template_part( 'template-parts/components/header', 'search-form' ); ?>
				</div>
			</div>
		</nav>

		<?php do_action( 'bootswatch_after_nav' ); ?>
	</header>

	<?php bootswatch_get_template_part( 'template-parts/components/header', 'custom-header' ); ?>
