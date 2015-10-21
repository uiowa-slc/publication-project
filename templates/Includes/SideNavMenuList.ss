	<% if not InSection("issues-archive") %>
		<% with $FeaturedIssue %>
			<% include SideNavIssueItem %>
			<% loop $Children %>
				<% include SideNavMenuItem %>
			<% end_loop %>
		<% end_with %>
	<% else %>
		<% with $Level(2) %>
			<% include SideNavIssueItem %>
		<% end_with %>
		<% loop $Menu(3) %>
			<% include SideNavMenuItem %>
		<% end_loop %>
	<% end_if %>