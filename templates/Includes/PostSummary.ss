<div class="post-summary">
    <h2>
        <a href="$Link" title="<%t Blog.ReadMoreAbout "Read more about '{title}'..." title=$Title %>">
            <% if $MenuTitle %>$MenuTitle
            <% else %>$Title<% end_if %>
        </a>
    </h2>

    <p class="post-image">
        <a href="$Link" <%t Blog.ReadMoreAbout "Read more about '{title}'..." title=$Title %>>
            $FeaturedImage.setWidth(795)
        </a>
    </p>
    
    <% if $Content %>
        <p>
            $Content.Summary(50)
            <a href="$Link">
               Continue Reading
            </a>
        </p>
    <% end_if %>
    
    <% include EntryMeta %>
</div>