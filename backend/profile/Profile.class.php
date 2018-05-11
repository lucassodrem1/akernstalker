<?php
class Profile 
{
    //Create
    public function createProfile(Mysqli $conn, $request) 
    {
        //Verifica se o perfil já existe. Caso exista, não será criado.
        $error = 0;

        $sql = "SELECT `name` FROM `profiles` WHERE `name`='".$request->profileName."'";
        $query = query($conn, $sql);
        if ($query->num_rows == 0) {
            $sql = "INSERT INTO `profiles` (`name`) VALUES ('".$request->profileName."')";
            query($conn, $sql);
        } else {
            $error = 1;
        }    

        return $error;
    }

    //Get / read
    public function getProfiles(Mysqli $conn) 
    {
        $profiles = array();

        $sql = "SELECT * FROM `profiles`";
        $query = query($conn, $sql);

        while ($row = $query->fetch_assoc()) {
            $profiles[] = array(
                        "id" => $row['id'],
                        "name" => $row['name']
                    );
        }

        return $profiles;
    }

    public function getProfileById($conn, $request) 
    {
        $sql = "SELECT `id`, `name` FROM `profiles` WHERE `id`='".$request->profileID."'"; 
        $query = query($conn, $sql);
        $row = $query->fetch_assoc();
        $profile = array (
            "id" => $row['id'],
            "name" => $row['name']
        );

        return $profile;
    }

    //Update Profile.
    public function updateProfile(Mysqli $conn, $request)
    {
        //Verifica se o perfil já existe. Caso exista, o nome do perfil não será trocado.
        $error = 0;

        $sql = "SELECT `name` FROM `profiles` WHERE `name`='".$request->name."'";
        $query = query($conn, $sql);
        if ($query->num_rows == 0) {
            //Caso um perfil com esse nome não exista, será permitido a alteração.
            $sql = "UPDATE `profiles` SET `name`='".$request->name."' WHERE `id`='".$request->id."'";
            query($conn, $sql);
        } else {
            $error = 1;
        }

        return $error;
    }

    //Delete profile
    public function deleteProfile(Mysqli $conn, $request) 
    {
        $sql = "DELETE FROM `profiles` WHERE `id`='".$request->profileID."'";
        query($conn, $sql);
    }
}