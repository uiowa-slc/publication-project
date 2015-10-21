<div class="row content-page">
    <div class="small-7 columns">
        <% include MemberDetails %>
        <h2>Posts by $CurrentProfile.FirstName $CurrentProfile.Surname</h2>
        <hr />

        <% if $PaginatedList.Exists %>
            <% loop $PaginatedList %>
                <% include PostSummary %>
            <% end_loop %>
        <% end_if %>
        
        $Form
        $CommentsForm

        <% with $PaginatedList %>
            <% include Pagination %>
        <% end_with %>
      
    </div>  
    <div class="large-4 columns">
    <% include BlogSideBar %>
    </div>
</div>