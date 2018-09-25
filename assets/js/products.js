(function ($, B, _, options) {


    let url = options.url;
    let lazyload = {check: true, class: 'lazy-load'};

    console.log(url);

    // Create the model that contain defaults
    let ProductModel = B.Model.extend({});

    let ProductCollection = B.Collection.extend({
        model: ProductModel,
        urlRoot: url,
        termId: null,

        url: function() {
            let url = new URL( this.urlRoot );
            let params = url.searchParams;

            if ( this.termId ) {
                params.set( 'term_id', this.termId );
            }

            url.search = '?' + params.toString();

            return url.toString();
        }
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

    let QuestionTermView = B.View.extend({
        events: {
          'click .answer' : 'answerClicked'
        },

        initialize: function (options) {
         this.el = options.el;
         this.$el = $(this.el);
         this.tree = options.tree;
         this.currentNode = this.tree;
         this.collection = options.collection;
         this.template = options.template;
       },

       answerClicked: function(event) {
           let element = event.currentTarget;
           this.currentNode = $(element).data('term');
           this.collection.termId = this.currentNode.term_id;
           this.collection.fetch();
           this.render();
       },

       render: function() {
           this.$el.html(this.template({
               node: this.currentNode,
               answers: this.currentNode.children
           }));
           let me = this;
           $('.answer[data-term-id]').each(function() {
              let that = $(this);
              let term_id = that.data('term-id');
              that.data('term', me.currentNode.children[term_id]);
           });
       }
    });

    let selectCategory = function(category) {

    };

    $(function () {
        let collection = new ProductCollection();

        let questionTermView = new QuestionTermView({
            el: '.myplugin-question-container',
            collection: collection,
            template: _.template($('#myplugin-question-template').html()),
            tree: options.term_tree
        });

        let productListView = new ProductListView({
            el: '.myplugin-shortcode-container',
            collection: collection,
            template: _.template($('#myplugin-list-template').html())
        });

        questionTermView.render();
        collection.fetch();
    });

}(jQuery, Backbone, _, myplugin_products));
