	<div id="footer">
		<ul id="footer-widgets-left">
		<?if ( ! dynamic_sidebar( 'first-footer-widget-area' ) ) : ?>

		<?php endif; // end primary widget area ?>
		</ul>
		<ul id="footer-widgets-right">
		<?if ( ! dynamic_sidebar( 'second-footer-widget-area' ) ) : ?>

		<?php endif; // end primary widget area ?>
		</ul>
	</div><!-- close:footer -->
</div><!-- close:wrapper -->
<?php wp_footer(); ?>
</body>
</html>