(function ($, B) {

    var products = myplugin_products,
            url = products.url,
            route = products.route;
            
            console.log(url+route);

    // Create the model that contain defaults
    var productModel = B.Model.extend({});

    var productCollection = B.Collection.extend({
        model: productModel,
        url: url + route,
    });

    var ProductListView = B.View.extend({
        el: '.myplugin-shortcode-container',

        initialize: function () {
            this.collection = new productCollection();
            this.template = _.template($('#myplugin-list-template').html());
            this.render();
        },

        render: function () {
            this.collection.fetch();
            console.log(this.collection.models);
            this.$el.html(this.template({items: this.collection.models}));

        }
    });

    $(function () {
        var productListView = new ProductListView();
    });

}(jQuery, Backbone));
