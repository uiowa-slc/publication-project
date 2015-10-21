<li class="article-nav pastissues">
	<% loop $AllIssues.Sort(Sort DESC) %>
		<a href="$Link">
			<section class="nav-li-content">
				<h4>$IssueNumber $Title</h4>
				<p class="nav-deets">$IssueDate</p>
			</section>
		</a>
	<% end_loop %>
	<a href="issues-archive/">
		<section class="nav-li-content">
			<h4>Older Issues</h4>
			<p class="nav-deets">2003-2012</p>
		</section>
	</a>
</li>