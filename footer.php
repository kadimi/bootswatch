<?php
/**
 * The footer.
 *
 * @package Bootswatch
 */

?>

<footer class="container">
	<div class="row">
		<div class="col-md-12"><hr></div>
		<div class="col-md-4 col-md-offset-8">
			<p class="muted pull-right small">
				&copy; <?php echo date( 'Y' ); // WPCS: XSS OK. ?> <?php echo esc_html( get_bloginfo( 'title' ) ); ?> &ndash; Designed by <a href='https://kadimi.com/' title="Nabil Kadimi - Independent WordPress Developer" rel="nofollow">Nabil</a>
			</p>
		</div>
	</div>
</footer>

<?php wp_footer(); ?>

</body>
</html>
