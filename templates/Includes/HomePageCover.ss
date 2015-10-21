<div class="cover-container b-lazy" data-src="$FeaturedIssue.Emblem.CroppedFocusedImage(1560, 861, false).URL" style="background-position: $FeaturedIssue.Emblem.PercentageX% $FeaturedIssue.Emblem.PercentageY%; background-size: cover;">
	<div class="cover-screen">
		<% include TopBar %>
		<div class="row issue-date">
			<div class="large-12 columns"><span><a href="issues/">$FeaturedIssue.IssueDate</a></span></div>
		</div>
		<div class="row cover-content">
			<div class="large-12 columns">
				<img src="{$ThemeDir}/images/exchanges-logo.png" alt="Exchanges Logo" />
				<% with FeaturedIssue %>
					<span>Read our latest issue: <br /> <a class="issue-title" href="$Link">$Title</a></span>
				<% end_with %>
			</div>
		</div>
	</div>
</div>