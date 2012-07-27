<?php
/**
 * The template for displaying the footer.
 *
 * @package WordPress
 * @subpackage Starkers
 * @since Starkers HTML5 3.0
 */
?>

	<footer id="mini_footer">
	</footer>

<?php
	/* Always have wp_footer() just before the closing </body>
	 * tag of your theme, or you will break many plugins, which
	 * generally use this hook to reference JavaScript files.
	 */

	wp_footer();
?>
</section>
<script src="<? echo get_template_directory_uri(); ?>/js/fm.js"></script>
<script src="<? echo get_template_directory_uri(); ?>/js/scripts.js"></script>
</body>
</html>