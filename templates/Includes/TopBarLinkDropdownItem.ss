<li class="<% if $LinkingMode == "current" || $LinkingMode == "section" %>active<% end_if %>">
	<a href="$Link" title="Go to the $Title.ATT" class="show-for-small-only">$MenuTitle</a>
	<a href="$Link" title="Go to the $Title.ATT" class="show-for-medium-up hide-for-large-up">$MenuTitle.LimitCharacters(15)</a>
		<a href="$Link" title="Go to the $Title.ATT" class="show-for-large-up">$MenuTitle.LimitCharacters(35)</a>
</li>