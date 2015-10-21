<div class="row">
	<div class="large-6 large-centered columns end text-center table-of-contents">
		<h2>Table of Contents</h2>
			<article>
				<h3><span><a href="$LetterLink">$LetterTitle</a></span></h3>
			</article>
		<% loop $Children %>
			<article>
				<h3><a href="$Link">$Title</a></h3>
				<p>$TranslatorByline</p>
			</article>
		<% end_loop %>
	</div>
</div>

<% include ArticleSubnav %>