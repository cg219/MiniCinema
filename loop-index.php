<section id="movies">
<?
$index = 0;
$args = array(
	'post_type' => 'mini_video',
	'posts_per_page' => '6',
	
);
$query = new WP_Query( $args );

while ( $query->have_posts() ): $query->the_post();
	$postData = get_post_custom($post->ID);
	$alternateClass = $index % 2 == 0 ? 'even' : 'odd';
?>
	<article id="post-<? the_ID(); ?>" <? post_class($alternateClass); ?>>
		<div class="photo_container">
			<a href="<? the_permalink(); ?>"><img class="thumbnail_image" src="<? echo $postData['custom_thumb'][0]; ?>" /></a>
			<h2><? the_title(); ?></h2>
		</div>
	</article>
<?
	$index++;
endwhile;
wp_reset_postdata();
?>
</section>