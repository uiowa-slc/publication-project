<% with $FeaturedIssue %>
	<div class="row">
		<div class="large-12 issue-preview columns">
			<h2 class="banner text-center">In this Issue:</h2>
			<ul class="small-block-grid-1 large-block-grid-3 text-center">
				<% loop $RandomArticles.Limit(2) %>
					<% include PoemCard %>
				<% end_loop %>
					<li class="start-reading"><a href="$Link">Start reading &rarr;</a></li>
			</ul>
			<hr />
		</div>
	</div>
<% end_with %>

<div class="row">

<% with $FeaturedIssue %>
	<div class="large-7 columns">
		<h2 class="banner text-center">$LetterTitle</h2>
		$LetterFromEditor
		<div class="row">
			<div class="large-12 columns">
				<div class="article-subnav">
						<div class="toc-container">
							<a href="$Link" class="toc-link">Table of Contents</a>
						</div>
				</div>
			</div>
		</div>
	</div>

<% end_with %>
	<div class="large-4 columns" id="news">
		<h2 class="banner text-center">From the Blog:</h2>
		<ul class="large-block-grid-1 news-list">
			<% loop $Blog.BlogPosts.Limit(4) %>
				<li>
					<article class="$FirstLast">
						<h3><a href="$Link">$Title </a></h3>
						<% include EntryMeta %>
					</article>
				</li>

			<% end_loop %>
			<li><h3 class="text-center"><a href="blog/">Blog archive</a></h3></li>
		</ul>

	</div>
</div>


