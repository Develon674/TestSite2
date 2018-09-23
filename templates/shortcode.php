<div class="myplugin-shortcode-container"></div>
<script type="text/template" id="myplugin-list-template">
    <% _.each(items, function(item) { %>
      <div>
        <h3><%= item.get('name') %></h3>
      </div>
    <% }); %>
</script>
