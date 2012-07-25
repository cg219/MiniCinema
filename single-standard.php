<section id="postDetail">
<? while ( have_posts() ): the_post();
	$postData = get_post_custom($post->ID);
?>
	<article id="single-post-<? the_ID(); ?>" <? post_class(); ?>>
		<header>
			<h2><? the_title(); ?></h2>
		</header>
		<section>
			<? the_content(); ?>
		</section>
	</article>
<?

endwhile;
wp_reset_postdata();
?>
</section>