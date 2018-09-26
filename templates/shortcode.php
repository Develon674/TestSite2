<div class="myplugin-selections-container"></div>
<div class="myplugin-question-container"></div>
<div class="myplugin-products-container"></div>
<script type="text/template" id="myplugin-products-template">
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

<script type="text/template" id="myplugin-question-template">
<div class="question-tree">
    <div class="question"><%= node.question %></div>
    <div class="answers">
    <ul>
        <% _.each(answers, function(answer) { %>
        <li>
            <div class="answer" data-term-id="<%= answer.term_id %>"><%= answer.answer %></div>
        </li>
        <% }); %>
    </ul>
    </div>
</div>
</script>

<script type="text/template" id="myplugin-selections-template">
<div class="selections">
    <ul>
    <% _.each(selections, function(selection) { %>
        <li>
            <div class="question"><%= selection.question.question %></div>
            <div class="answer"><%= selection.answer.answer %></div>
        </li>
    <% }); %>
    </ul>
</div>
</script>
