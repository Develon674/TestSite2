(function ($, B) {

    // Create the model that contain defaults
    var Person = B.Model.extend({
        defaults: {
            name: 'John Doe',
            dob: '11th September 2001',
            location: 'WTC, New York, USA',
            profession: 'Janitor',
        }
    });

    // Create a new instance of the model
    var john = new Person({name: 'John Doe', dob: '10th March 2002', location: 'Texas, USA', profession: 'Developer'});
    var ben = new Person({name: 'Ben Dover', dob: '10th March 1991', location: 'London, UK', profession: 'Musician'});

    let Persons = B.Collection.extend({
        model: Person
    });

    var personsArray = [john, ben];

    var persons = new Persons(personsArray);

    var PersonListView = B.View.extend({
        el: '.myplugin-shortcode-container',

        initialize: function () {
            this.template = _.template($('#myplugin-list-template').html());
            this.render();

            console.log('init');
        },

        render: function () {
            this.$el.html(this.template({persons: persons.models}));
        }
    });
    
    $(function () {
        var personListView = new PersonListView();
    });

}(jQuery, Backbone));
