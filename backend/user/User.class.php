<?php
class User 
{
    public function createUser($conn, $request) 
    {
        //Verifica se esse nome já existe.
        $error = 0;
        $sql = "SELECT `username` FROM `users` WHERE `username`='".$request->registerUsername."'";
        $query = query($conn, $sql);
        if($query->num_rows == 0) {
            //Criando usuário.
            $sql = "INSERT INTO `users` (`username`, `password`, `profile_id`) VALUES ('".$request->registerUsername."', '".password_hash($request->registerPassword, PASSWORD_DEFAULT)."', '".$request->registerProfile."')";
            query($conn, $sql);
        } else {
            $error = 1;
        }

        return $error;
    }

    public function userLogin($conn, $request)
    {
        $error = 0;
        
        //Statement de login e senha.
        $sql = "SELECT `id`, `username`, `password` FROM `users` 
                WHERE `username`= ?";
        if ($query = $conn->prepare($sql)) {
            $query->bind_param('s', $request->username);
            $query->execute();
            $query = $query->get_result();
        } else {
            die($conn->error());
        }
        
        $row = $query->fetch_assoc();

        //Verificando se a senha está correta.
        if(!(password_verify($request->password, $row['password']))) {
            $error = 1;
        } else {
            //Atualizando último login do usuário.
            date_default_timezone_set('America/Sao_Paulo');
            $date = date('Y/m/d H:i:s', time());
            $sql = "UPDATE `users` SET `last_access`='".$date."' WHERE `id`='".$row['id']."'";
            query($conn, $sql);
        }

        return $error;
    }

    public function getUsers($conn) 
    {
        $users = array();

        //Juntando a table users com profiles.
        $sql = "SELECT `users`.`id`, `users`.`username`, `users`.`create_date`, `users`.`last_access`, `profiles`.`name`
        FROM `users`
        INNER JOIN `profiles` ON `users`.`profile_id`=`profiles`.`id`";
        $query = query($conn, $sql);
        while ($row = $query->fetch_assoc()) {
            $users[] = array (
                "id" => $row['id'],
                "username" => $row['username'],
                "createDate" => date("d/m/y H:i", strtotime($row['create_date'])),
                "lastAccess" => date("d/m/y H:i", strtotime($row['last_access'])),
                "profile" => $row['name']
            );
        } 

        return $users;
    }

    public function getUserById($conn, $request) 
    {
        //Juntando a table users com profiles.
        $sql = "SELECT `users`.`id`, `users`.`username`, `users`.`create_date`, `users`.`last_access`, `profiles`.`name`
        FROM `users`
        INNER JOIN `profiles` ON `users`.`profile_id`=`profiles`.`id`
        WHERE `users`.`id`='".$request->userID."'";
        $query = query($conn, $sql);
        $row = $query->fetch_assoc();
        $user = array (
            "id" => $row['id'],
            "username" => $row['username'],
            "createDate" => date("d/m/y H:i", strtotime($row['create_date'])),
            "lastAccess" => date("d/m/y H:i", strtotime($row['last_access'])),
            "profile" => $row['name']
        );

        return $user;
    }

    //Update user.
    public function updateUser($conn, $request)
    {
        $error = 0;

        if (isset($request->newName) && $request->newName != '') {
            //Verifica se já existe esse username.
            $sql = "SELECT `username` FROM `users` WHERE `username`='".$request->newName."'";
            $query = query($conn, $sql);
            if ($query->num_rows != 0) {
                $error = 1;
            } else {
                $sql = "UPDATE `users` SET `username`='".$request->newName."' WHERE `id`='".$request->id."'";
                query($conn, $sql);
            }
        }

        if (isset($request->newPass) && $request->newPass != '') {
            $sql = "UPDATE `users` SET `password`='".password_hash($request->newPass, PASSWORD_DEFAULT)."' WHERE `id`='".$request->id."'";
            query($conn, $sql);
        }

        if (isset($request->newProfile) && $request->newProfile != '') {
            $sql = "UPDATE `users` SET `profile_id`='".$request->newProfile."' WHERE `id`='".$request->id."'";
            query($conn, $sql);
        }

        return $error;
    }

    //Delete user.
    public function deleteUser(Mysqli $conn, $request) 
    {
        $sql = "DELETE FROM `users` WHERE `id`='".$request->userID."'";
        query($conn, $sql);
    }
}