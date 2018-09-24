(function ($, B, _, options) {


    let url = options.url;
    let lazyload = {check: true, class: 'lazy-load'};

    console.log(url);

    // Create the model that contain defaults
    let ProductModel = B.Model.extend({});

    let ProductCollection = B.Collection.extend({
        model: ProductModel,
        url: url
    });
    

    let ProductListView = B.View.extend({

        initialize: function (options) {
            this.el = options.el;
            this.$el = $(this.el);
            this.collection = options.collection;
            var me = this;
            this.collection.bind('update', function(){
                me.render();
            });
            this.template = options.template;
        },

        render: function () {
            this.$el.html(this.template({items: this.collection.models, lazyload: lazyload}));
        }
    });

    $(function () {
        let collection = new ProductCollection();
        let productListView = new ProductListView({
            el: '.myplugin-shortcode-container',
            collection: collection,
            template: _.template($('#myplugin-list-template').html())
        });
        collection.fetch();
    });

}(jQuery, Backbone, _, myplugin_products));
