<div class="myplugin-shortcode-container"></div>
<script type="text/template" id="myplugin-list-template">
<% _.each(items, function(item) { %>
<div>
<% if (item.get('post_thumbnail_url')) { %>
<div class="img<% if (!lazyload.check) { %> <%= lazyload.class %><% } %>" <% if (lazyload.check) { %>style="background-image:url(<% } else { %>data-src="<% } %><%= item.get('post_thumbnail_url') %><% if (lazyload.check) { %>);<% } %>"></div>
<% } %>
<% if (item.get('post_title') || item.get('post_content')) { %>
<div class="content">
<% if (item.get('post_title')) { %><h3 class="post-title"><%= item.get('post_title') %></h3><% } %>
<% if (item.get('post_content')) { %>
<%= item.get('post_content') %>
<% } %>
</div>
<% } %>
</div>
<% }); %>
</script>
