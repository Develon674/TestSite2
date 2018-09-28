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

        url: function () {
            let url = new URL(this.urlRoot);
            let params = url.searchParams;

            if (this.termId) {
                params.set('term_id', this.termId);
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
            this.collection.bind('update', function () {
                me.render();
            });
            this.template = options.template;
        },

        render: function () {
            this.$el.html(this.template({items: this.collection.models, lazyload: lazyload}));
        }
    });

    let SelectionsManager = B.Model.extend({
        selectionsList: [],
        
        initialize: function (args) {
            this.collection = args.collection;
        },
        
        selectItem: function (answer) {
            let curItem = this.getCurrentItem();
            let item = {answer: answer};
            if (curItem) {
                item.question = curItem.answer;
            }
            this.selectionsList.push(item);

            this.collection.termId = answer.term_id;
            this.collection.fetch();
            
            this.trigger('item_selected', [answer]);
        },
        selectPrevItem: function (index) {
            let item = this.selectionsList[index];
            let answer = item.answer;
            for (
                    let i = this.selectionsList.length - 1; // Happens in the beginning
                    i > index; // Has to be true for loop to continue
                    i-- // Happens at end of each iteration
                    ) {
                this.selectionsList.pop();
            }
            this.selectItem(answer);
        },
        getCurrentItem: function () {
            return this.selectionsList.slice(-1)[0];
        },
        getSelections: function () {
            return this.selectionsList.slice(1, this.selectionsList.length);
        }
    });

    let QuestionTermView = B.View.extend({
        events: {
            'click .answer': 'answerClicked'
        },

        initialize: function (options) {
            this.el = options.el;
            this.$el = $(this.el);
            this.tree = options.tree;
            this.template = options.template;
            this.selections = options.selections;
            
            let me = this;
            this.selections.on('item_selected', function (term) {
                me.render();
            });
        },

        answerClicked: function (event) {
            let element = event.currentTarget;
            this.selections.selectItem($(element).data('term'));
        },

        render: function () {
            let current = this.selections.getCurrentItem().answer;
            this.$el.html(this.template({
                node: current,
                answers: current.children,
            }));
            let me = this;
            $('.answer[data-term-id]').each(function () {
                let that = $(this);
                let term_id = that.data('term-id');
                that.data('term', current.children[term_id]);
            });
        }
    });

    let SelectionsView = B.View.extend({
        events: {
            'click li': 'selectionClicked',
        },
        
        initialize: function (options) {
            this.el = options.el;
            this.$el = $(this.el);
            this.selections = options.selections;
            this.template = options.template;
            
            let me = this;
            this.selections.on('item_selected', function (term) {
                me.render();
            });
        },

        render: function () {
            this.$el.html(this.template({
                selections: this.selections.getSelections(),
            }));
        },
        
        selectionClicked: function (event) {
            let el = event.currentTarget;
            let index = $(el).index();
            this.selections.selectPrevItem(index);
        },
    });

    $(function () {
        let collection = new ProductCollection();
        let selections = new SelectionsManager({
            collection: collection,
        });

        let questionTermView = new QuestionTermView({
            el: '.myplugin-question-container',
            collection: collection,
            selections: selections,
            template: _.template($('#myplugin-question-template').html()),
            tree: options.term_tree
        });

        let productListView = new ProductListView({
            el: '.myplugin-products-container',
            collection: collection,
            template: _.template($('#myplugin-products-template').html())
        });

        let selectionsView = new SelectionsView({
            el: '.myplugin-selections-container',
            selections: selections,
            template: _.template($('#myplugin-selections-template').html())
        });

        selections.selectItem(options.term_tree);
        //questionTermView.render();
        //collection.fetch();
    });

}(jQuery, Backbone, _, myplugin_products));
