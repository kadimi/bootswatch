<?php
/**
 * The header navigation.
 *
 * @package Bootswatch
 */

?>

<nav class=" navbar navbar-default <?php echo bootswatch_has( 'fixed_navbar' ) ? 'navbar-fixed-top' : 'navbar-static-top'; ?> " role="navigation">
	<div class="container">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".collapse">
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<?php 

			if ( is_home() ) {
				?>
				<h1 class="inline">
				<?php
			}

			if ( has_custom_logo() ) {
				the_custom_logo();
			} else { 
				?>
				<a class="navbar-brand site-title" href="<?php echo esc_url( home_url() ); ?>"><?php bloginfo( 'name' ); ?></a>
				<?php
			}

			if ( is_home() ) {
				?>
				</h1>
				<?php
			}

			?>
		</div>
		<div class="collapse navbar-collapse">
			<?php bootswatch_get_template_part( 'template-parts/components/header', 'menu' ); ?>
			<?php bootswatch_get_template_part( 'template-parts/components/header', 'search-form' ); ?>
		</div>
	</div>
</nav>
