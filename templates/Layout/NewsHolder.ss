
<div class="row">
    <div class="large-12 columns">
        <a href="$Link" class="button breadcrumb tiny">$Title</a>
    </div>
</div>

<div class="row content-page">
    <div class="large-7 columns">
            <h1>
                <% if $ArchiveYear %>
                    <%t Blog.Archive "Archive" %>:
                    <% if $ArchiveDay %>
                        $ArchiveDate.NiceUS
                    <% else_if $ArchiveMonth %>
                        $ArchiveDate.format("F, Y")
                    <% else %>
                        $ArchiveDate.format("Y")
                    <% end_if %>
                <% else_if $CurrentTag %>
                    <%t Blog.Tag "Tag" %>: $CurrentTag.Title
                <% else_if $CurrentCategory %>
                    <%t Blog.Category "Category" %>: $CurrentCategory.Title
                <% else %>
                    
                <% end_if %>
            </h1>
        <% if $PaginatedList.Exists %>
            <% loop $PaginatedList %>
                <% include PostSummary %>
            <% end_loop %>
        <% else %>
            <p><%t Blog.NoPosts "There are no posts." %></p>
        <% end_if %>
    </div>


    <div class="large-4 columns">
    <% include BlogSideBar %>
    </div>
</div>
<% with $PaginatedList %>
    <% include Pagination %>
<% end_with %>
