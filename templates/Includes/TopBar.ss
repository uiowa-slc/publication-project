<div class="nav-container contain-to-grid" <% if $Parent.ClassName == "Issue" %>style="background-image:url('$Parent.Emblem.URL');  background-position: $Parent.Emblem.PercentageX% $Parent.Emblem.PercentageY%; background-size: cover;"<% end_if %>">
	<div class="nav-screen">
		<nav class="top-bar" data-topbar role="navigation" data-options="align:right">
			<ul class="title-area">
				<li class="name">
					<h1 class="show-for-large-up"><a href="{$baseUrl}">$SiteConfig.Title</a></h1>
					<h1 class="hide-for-large-up"><a href="{$BaseHref}">Exchanges</a></h1>
				</li>
				<li class="toggle-topbar menu-icon"><a href="#"><span>Menu</span></a></li>
			</ul>
			<section class="top-bar-section">
				<%-- Left Nav Section --%>
				<ul class="right">
					<% loop Menu(1) %>
					<li class="<% if $LinkingMode == "current" || $LinkingMode == "section" %>active<% end_if %><% if $Children || $LinkTo.Children %> has-dropdown<% end_if %>">
						<a href="$Link" title="Go to the $Title.ATT">$MenuTitle</a>

						<% if $ClassName == "NewsHolder" %>
							<ul class="dropdown">
								<% loop $BlogPosts.Limit(5) %>
									<% include TopBarLinkDropdownItem %>
								<% end_loop %>
								<li><a href="$Link">See all posts &rarr;</a></li>
							</ul>
						<% else_if $Children %>
							<ul class="dropdown">
								<% loop $Children.Sort("Created DESC") %>
									<% include TopBarLinkDropdownItem %>
								<% end_loop %>
								<li><a href="$Link">See all &rarr;</a></li>
							</ul>
						<% else_if $ClassName == "RedirectorPage" %>
							<ul class="dropdown">
								<% if $LinkTo %>
									<% with $LinkTo %>
										<% include TopBarLinkDropdownItem %>
									<% end_with %>
								<% end_if %>
								<li><a href="$Link">See all &rarr;</a></li>
							</ul>
						<% end_if %>
					</li>
					<%--<% if not $Last %><li class="divider"></li><% end_if %>--%>
					<% end_loop %>
				</ul>
			</section>
		</nav>
	</div><!-- end nav-screen -->
</div><!-- end nav-container -->
