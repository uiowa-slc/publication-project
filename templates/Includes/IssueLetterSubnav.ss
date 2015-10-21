	<div class="row">
		<div class="large-12 columns">
			<div class="article-subnav">

					<div class="large-4 columns prev-container show-for-large-up">
					&nbsp;
					</div>

					<div class="large-4 columns toc-container">
						<a href="$Parent.Link" class="toc-link">Table of Contents</a>
					</div>

					<div class="large-4 columns next-container end">
					<% if $Children %>
						<% with $Children.First %>
							<a href="$Link" class="next">$Title &rarr;</a><br />
						<% end_with %>
					<% end_if %>
					</div>
			</div>
		</div>
	</div>