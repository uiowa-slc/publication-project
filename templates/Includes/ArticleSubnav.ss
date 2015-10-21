	<div class="row">
		<div class="large-12 columns">
			<div class="article-subnav">

					<div class="large-4 columns prev-container show-for-large-up">
						<% if $PreviousPage %>
							<% with $PreviousPage %>
								<a href="$Link" class="prev "> &larr; $Title</a>
							<% end_with %>
						<% else_if $Parent.LetterLink %>
							<a href="$Parent.LetterLink" class="prev">&larr; $Parent.LetterTitle</a>
						<% else %>
						&nbsp;
						<% end_if %>
					</div>
					<div class="large-4 columns next-container hide-for-large-up">
						<% if $NextPage %>
							<% with $NextPage %>
								<a href="$Link" class="next">$Title &rarr;</a><br />
							<% end_with %>
						<% end_if %>
					</div>
					<div class="large-4 columns toc-container">
						<% if $ClassName == "Article" %>
							<a href="$Parent.Link" class="toc-link">Table of Contents</a>
						<% else_if $ClassName == "Issue" %>
							<a href="$Parent.Link" class="toc-link">Issue Archive</a>
						<% end_if %>
					</div>

					<div class="large-4 columns next-container show-for-large-up end">
						<% if $NextPage %>
							<% with $NextPage %>
								<a href="$Link" class="next">$Title &rarr;</a><br />
							<% end_with %>
						<% end_if %>
					</div>
			</div>
		</div>
	</div>