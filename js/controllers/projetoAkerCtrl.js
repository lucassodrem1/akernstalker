angular.module("projetoAker").controller("indexCtrl", function ($scope, $http) {
    //Create User
    $scope.create = {};
    $scope.createUser = function () {
        $http.post("backend/user/create_user.php", $scope.create).then(function (response) {
            if (response.data == 1) {
                document.getElementById("alert-messages").innerHTML = "";
                var div = document.createElement("div");
                div.className = "alert alert-danger text-center";
                div.innerHTML = "Este nome já está cadastrado!";
                document.getElementById("alert-messages").appendChild(div);
            }
            else {
                document.getElementById("alert-messages").innerHTML = "";
                var div = document.createElement("div");
                div.className = "alert alert-success text-center";
                div.innerHTML = "Conta criada com sucesso!";
                document.getElementById("alert-messages").appendChild(div);
            }
        });
        delete $scope.create;
        $scope.registerForm.$setPristine();
    };
    //Get profiles
    $http.get("backend/profile/get_profiles.php").then(function (response) {
        $scope.profiles = response.data;
    });
});
angular.module("projetoAker").controller("loginCtrl", function ($scope, $http) {
    //Ação de login do usuário.
    $scope.login = {};
    $scope.userLogin = function () {
        $http.get("backend/user/user_login.php", {
            params: { username: $scope.login.username, password: $scope.login.password }
        }).then(function (response) {
            if (response.data == 1) {
                document.getElementById("alert-messages").innerHTML = "";
                var div = document.createElement("div");
                div.className = "alert alert-danger text-center";
                div.innerHTML = "Nome ou senha incorretos ou não existem!";
                document.getElementById("alert-messages").appendChild(div);
            }
            else {
                document.getElementById("alert-messages").innerHTML = "";
                var div = document.createElement("div");
                div.className = "alert alert-success text-center";
                div.innerHTML = "Bem-vindo!";
                document.getElementById("alert-messages").appendChild(div);
            }
        });
        delete $scope.login;
        $scope.loginForm.$setPristine();
    };
});
angular.module("projetoAker").controller("manageUserCtrl", function ($scope, $http) {
    //Get users
    //Crio uma função para depois poder atualizar a tabela chamando getUsers().
    var getUsers = function () {
        $http.get("backend/user/get_users.php").then(function (response) {
            $scope.users = response.data;
        });
    };
    getUsers();
    //Get profiles
    $http.get("backend/profile/get_profiles.php").then(function (response) {
        $scope.profiles = response.data;
    });
    //Apagando user do db.
    $scope.deleteUser = function (user) {
        $http["delete"]("backend/user/delete_user.php", {
            params: { userID: user.id }
        }).then(function (success) {
            document.getElementById("alert-messages").innerHTML = "";
            var div = document.createElement("div");
            div.className = "alert alert-success text-center";
            div.innerHTML = "O usu\u00E1rio <b>" + user.username + "</b> foi excluido!";
            document.getElementById("alert-messages").appendChild(div);
            //Atualizando tabela no html.
            getUsers();
        });
    };
});
angular.module("projetoAker").controller("updateUserCtrl", function ($scope, $http, $routeParams) {
    //Pegando informações do usuário selecionado.
    $http.get("backend/user/get_user_by_id.php", {
        params: { userID: $routeParams.userID }
    }).then(function (response) {
        $scope.user = response.data;
    });
    //Get profiles
    $http.get("backend/profile/get_profiles.php").then(function (response) {
        $scope.profiles = response.data;
    });
    $scope.edit = {};
    $scope.editUser = function () {
        //Juntando as informações do form com o id do user.
        var request = { id: $scope.user.id, newName: $scope.edit.name, newPass: $scope.edit.password, newProfile: $scope.edit.profile };
        //Update user
        $http.put("backend/user/update_user.php", request).then(function (response) {
            document.getElementById("alert-messages").innerHTML = "";
            var div = document.createElement("div");
            div.className = "alert alert-success text-center";
            div.innerHTML = "Dados de usuário alterados com sucesso!";
            document.getElementById("alert-messages").appendChild(div);
        });
    };
});
angular.module("projetoAker").controller("createProfileCtrl", function ($scope, $http) {
    //Create profile
    $scope.create = {};
    $scope.createProfile = function () {
        $http.post("backend/profile/create_profile.php", $scope.create).then(function (response) {
            if (response.data == 1) {
                document.getElementById("alert-messages").innerHTML = "";
                var div = document.createElement("div");
                div.className = "alert alert-danger text-center";
                div.innerHTML = "Este perfil já existe!";
                document.getElementById("alert-messages").appendChild(div);
            }
            else {
                document.getElementById("alert-messages").innerHTML = "";
                var div = document.createElement("div");
                div.className = "alert alert-success text-center";
                div.innerHTML = "Perfil criado com sucesso!";
                document.getElementById("alert-messages").appendChild(div);
            }
        });
        delete $scope.create;
        $scope.profileForm.$setPristine();
    };
});
angular.module("projetoAker").controller("manageProfileCtrl", function ($scope, $http) {
    //Get profiles
    //Crio uma função para depois poder atualizar a tabela chamando getProfiles().
    var getProfiles = function () {
        $http.get("backend/profile/get_profiles.php").then(function (response) {
            $scope.profiles = response.data;
        });
    };
    getProfiles();
    //Delete Profiles
    $scope.deleteProfile = function (profile) {
        //Apagando os profiles no db.
        $http["delete"]("backend/profile/delete_profile.php", {
            params: { profileID: profile.id }
        }).then(function (response) {
            document.getElementById("alert-messages").innerHTML = "";
            var div = document.createElement("div");
            div.className = "alert alert-success text-center";
            div.innerHTML = "O perfil <b>" + profile.name + "</b> foi excluido!";
            document.getElementById("alert-messages").appendChild(div);
            //Atualizando tabela no html.
            getProfiles();
        });
    };
});
angular.module("projetoAker").controller("updateProfileCtrl", function ($scope, $http, $routeParams) {
    //Pegando informações do profile escolhido.
    $http.get("backend/profile/get_profile_by_id.php", {
        params: { profileID: $routeParams.profileID }
    }).then(function (response) {
        $scope.profile = response.data;
    });
    //Update profile
    $scope.editProfile = function (editName) {
        //Juntando id do perfil com o nome desejado para jogar no put.
        var request = { id: $scope.profile.id, name: editName };
        $http.put('backend/profile/update_profile.php', request).then(function (response) {
            //Verificando se já existe ou não o profile com o nome desejado.
            if (response.data == 1) {
                document.getElementById("alert-messages").innerHTML = "";
                var div = document.createElement("div");
                div.className = "alert alert-danger text-center";
                div.innerHTML = "Já existe um perfil com este nome!";
                document.getElementById("alert-messages").appendChild(div);
            }
            else {
                document.getElementById("alert-messages").innerHTML = "";
                var div = document.createElement("div");
                div.className = "alert alert-success text-center";
                div.innerHTML = "O perfil <b>" + $scope.profile.name + "</b> foi alterado para <b>" + request.name + "</b>";
                document.getElementById("alert-messages").appendChild(div);
                //Alterando nome original para aparecer no alert-messages.
                $scope.profile.name = request.name;
            }
        });
    };
});
//Routes
angular.module("projetoAker").config(function ($routeProvider) {
    $routeProvider
        .when("/", {
        controller: "indexCtrl",
        templateUrl: "index.html"
    })
        .when("/login", {
        controller: "loginCtrl",
        templateUrl: "view/login.html"
    })
        .when("/manage_user", {
        controller: "manageUserCtrl",
        templateUrl: "view/manage_user.html"
    })
        .when("/update_user/:userID", {
        controller: "updateUserCtrl",
        templateUrl: "view/update_user.html"
    })
        .when("/create_profile", {
        controller: "createProfileCtrl",
        templateUrl: "view/create_profile.html"
    })
        .when("/manage_profile", {
        controller: "manageProfileCtrl",
        templateUrl: "view/manage_profile.html"
    })
        .when("/update_profile/:profileID", {
        controller: "updateProfileCtrl",
        templateUrl: "view/update_profile.html"
    });
});
