var app = angular.module('routerApp', ['ui.router']);

app.config(function($stateProvider, $urlRouterProvider) {
    
    $urlRouterProvider.otherwise('/login');
    
    $stateProvider
        //----------login state---------------//
        .state('login', {
            url: '/login',
            templateUrl: 'templates/login.html',
            //controller:loginController
        })
        
        // HOME STATES AND NESTED VIEWS 
        .state('home', {
            url: '/home',
            templateUrl: 'templates/partial-home.html'
        })
        
        // nested list with custom controller
        .state('home.list', {
            url: '/list',
            templateUrl: 'templates/partial-home-list.html',
            controller: function($scope) {
                $scope.dogs = ['Bernese', 'Husky', 'Goldendoodle'];
            }
        })
        
        // nested list with just some random string data
        .state('home.paragraph', {
            url: '/paragraph',
            template: 'I could sure use a drink right now.'
        })
        
        // ABOUT PAGE AND MULTIPLE NAMED VIEWS 
        .state('about', {
            url: '/about',
            views: {
                '': { templateUrl: 'templates/partial-about.html' },
                'columnOne@about': { template: 'Look I am a column!' },
                'columnTwo@about': { 
                    templateUrl: 'templates/table-data.html',
                    controller: 'scotchController'
                }
            }
            
        });
        
});

