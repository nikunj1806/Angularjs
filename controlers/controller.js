app.controller('scotchController', function ($scope) {

    $scope.message = 'test';

    $scope.scotches = [
        {
            name: 'Macallan 12',
            price: 50
        },
        {
            name: 'Chivas Regal Royal Salute',
            price: 10000
        },
        {
            name: 'Glenfiddich 1937',
            price: 20000
        }
    ];

}).controller('loginController', function ($scope, $http, $state) {
    $scope.login = function () {

        $scope.authenticate.do = 'authenticate';
        console.log($scope.authenticate);
        $http({
            url: 'api/v1/authenticate.php',
            method: 'POST',
            data: $scope.authenticate

        }).success(function (response) {
            
            if (response.response == 1) {
                $scope.userData = JSON.stringify(response.data);
                localStorage.setItem('user', JSON.stringify(response.data));
                notification('successfully Login', 'success');
                setTimeout(function(){
                    $state.go('home'); 
                },2000)
            }
        })
        
    }
});

