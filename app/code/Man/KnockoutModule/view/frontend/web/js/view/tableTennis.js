//first we have to define modules we want to use in our script
define([
    'uiComponent',
    'ko'
], function (Component, ko) {
    //we'll make our game a Component to allow someone to easily modify it in the future
    return Component.extend({
        initialize: function () {
            //next line is basically equivalent of parent::__construct() in php
            this._super();
            //let's divide our component to 2 separate elements
            //one responsible for populating our game's interface
            this.populateUi();
            //and one responsible for the gameplay itself
            this.gameplay();
        },
        populateUi: function () {
            //here we are creating an observable array and set its items to ping and pong
            this.userActions = ko.observableArray(['ping', 'pong']);
            //this observable will be responsible for storing information about currently selected action
            //initialMove will be passed from template
            this.selectedAction = ko.observable(this.initialMove);
            //and here we will create an observable without initial value
            //that will be responsible for storing computer's action
            this.aiMove = ko.observable();
        },
        gameplay: function () {
            //assign this to self so we can use it inside a function
            var self = this;
            //handleMove will be fired every time an observable inside it changes
            ko.computed(function handleMove() {
                if (self.selectedAction() == self.userActions()[0]) {
                    self.aiMove(self.userActions()[1]);
                } else {
                    self.aiMove(self.userActions()[0]);
                }
            });
        }
    });
});
