<div class="row content-page">
	<div class="small-12 columns">
		<h2>Works contributed by {$Contributor.Name}:</h2>
		<hr />
		<% if $Contributor.Articles %>
			<ul class="small-block-grid-1 large-block-grid-3">
				<% loop $Contributor.Articles %>
					<% include PoemCard %>
				<% end_loop %>
			</ul>
		<% end_if %>
		<% if $Contributor.BiographicalDetails %><p>$Contributor.BiographicalDetails</p><% end_if %>		
	</div> 	
</div>
