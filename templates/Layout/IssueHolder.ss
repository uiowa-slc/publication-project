<article>
	<div class="row content-page">
		<div class="large-12 columns">
			<header>
				<h1>Archive</h1>
			</header>
			<div class="content-text">
				<ul class="issue-card-list">
					<% loop Children.Sort("Created DESC") %>
						<% include IssueCard %>
					<% end_loop %>
				</ul>
			</div>
			<h2>Older Issues</h2>
			$Content
		</div>
	</div>
</article>

