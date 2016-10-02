<?php
/**
 * The header for our theme.
 *
 * This is the template that displays all of the <footer> section and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Bootswatch
 */

?>

<footer class="container">
	<div class="row">
		<hr>
		<div class="col-lg-12">
			<div class="col-md-8">
				<nav>
					<a href="#">Terms of Service</a> | <a href="#">Privacy</a>
				</nav>
			</div>
			<div class="col-md-4">
				<p class="muted pull-right small">© <?php echo date( 'Y' ) ?> <?php echo get_bloginfo( 'title' ); ?>.</p>
			</div>
		</div>
	</div>
</footer>

<?php wp_footer(); ?>

</body>
</html>
