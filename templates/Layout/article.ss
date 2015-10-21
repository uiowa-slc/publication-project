<% include Breadcrumb %>
<div class="article">


<div class="row">


	<div id="poetry" data-equalizer data-equalizer-mq="large-up">
		<div class="large-6 columns poem {$languageCode}" id="original-work" lang="{$languageCode}" <% if OriginalRTL %>dir="rtl"<% end_if %>>
			<article>
				<div class="poem-unstranslated-title poem-info" data-equalizer-watch>
					<div>
						<% if $UntranslatedTitle && $TranslatedTitle %>
							<h1>$UntranslatedTitle</h1>
						<% else %>
							<h1>$Title</h1>
						<% end_if %>
					</div>
					<span class="author">
						<% if $Authors %>By
						<% loop $Authors %>
							<a href="$Link">$Name</a><% if not $Last %>, <% end_if %>
						<% end_loop %> 
						<% end_if %>
					</span>
					<p class="hide-for-large-up author">
						<a href="#translated-work">View Translated Work &darr;</a>
					</p>
				</div>
				<div class="poem-content">
					$Content
				</div>
			</article>
		</div>
		<div class="large-6 columns poem" id="translated-work">
			<article class="translated">
				<div class="poem-translated-title poem-info" data-equalizer-watch>
					<div>
						<% if $TranslatedTitle && $TranslatedTitle %><h1>$TranslatedTitle</h1>
						<% else %> 
						<h1 style="visibility:hidden;">$Title</h1>
						<% end_if %>
					</div>
						<span class="author">
							Translated <% if $OriginalLanguage %>from the {$OriginalLanguage} by <% end_if %>
							<% loop $Translators %>
							<a href="$Link">$Name</a><% if not $Last %>, <% end_if %>
							<% end_loop %>
							
							<% if $TranslatorNote %><br /><a role="button" class="" href="#" data-reveal-id="translator-notes-modal">View Translator Notes</a><% end_if %>
						</span>

					<p class="hide-for-large-up author">
						<a href="#original-work">View Original Work &uarr;</a>
					</p>
				</div>
				<div class="poem-content">
				$Content2
				</div>
				<p class="hide-for-large-up">
					<br /><br /><a href="#original-work">View Original Work &uarr;</a>
				</p>
			</article>
		</div>
		
	</div>
</div>
	<% include ArticleSubNav %>

	<div id="translator-notes-modal" class="reveal-modal medium" data-reveal>
		<h1>Translator Notes</h1>
		$TranslatorNote
		<hr />
		<p><% loop $Translators %><a href="$Link">$Name</a><br /><% end_loop %></p>
		<a class="close-reveal-modal">&#215;</a>
	</div>

</div>