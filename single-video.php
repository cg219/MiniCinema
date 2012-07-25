<section id="movieDetail">
<? while ( have_posts() ): the_post();
	$postData = get_post_custom($post->ID);
?>
	<article id="single-post-<? the_ID(); ?>" <? post_class(); ?>>
		<header class="photo_container">
			<a href='<? the_permalink(); ?>'><img class="poster_image" src="<? echo $postData['custom_poster'][0]; ?>" /></a>
			<h2><? the_title(); ?></h2>
			<h3>Click to Play</h3>
		</header>
		<section>
			<h4><strong>Synopsis:</strong></h4>
			<p><? echo $postData['custom_synopsis'][0]; ?></p>
			<ul>
				<li>Genre: </li>
				<li>Share:</li>
				<li>Director: <? echo $postData['custom_director'][0]; ?></li>
				<li>Producer: <? echo $postData['custom_producer'][0]; ?></li>
				<li>Writer: <? echo $postData['custom_writer'][0]; ?></li>
				<li>Cast: <? echo $postData['custom_cast'][0]; ?></li>
				<li>Official Website: <a href="<? echo $postData['custom_website'][0]; ?>">Link</a></li>
			</ul>
		</section>
	</article>
<?

endwhile;
wp_reset_postdata();
?>
</section>