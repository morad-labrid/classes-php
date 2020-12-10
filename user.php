<?php

    class user {
        private $id;
        public  $login;
        public  $password;
        public  $email;
        public  $firstname;
        public  $lastname;

        //- public function register($login, $password, $email, $firstname, $lastname)
        // Crée l’utilisateur en base de données. Retourne un tableau contenant l’ensemble des informations concernant l’utilisateur créé.
        public function register($login, $password, $email, $firstname, $lastname){
            // connexioin à la base de donnée
            $conn = mysqli_connect('localhost', 'root', '', 'classes');
            // on verifier si le login et password existe deja
            $existe = mysqli_query($conn, "SELECT * FROM utilisateurs WHERE login='$login'");
            $info   = mysqli_fetch_assoc($existe);
            var_dump($existe);
            // la requete pour envoyer les infos vers la base de donnée
            if (!isset($info)) {
                mysqli_query($conn, "INSERT INTO utilisateurs (login, password, email, firstname, lastname) 
                                        VALUES ('$login', '$password', '$email', '$firstname', '$lastname')");
                echo "bien inscrit";
            }else echo "le login existe deja";
            
            return([$login, $password, $email, $firstname, $lastname]);
        }

        // - public function connect($login, $password)
        // Connecte l’utilisateur, modifie les attributs présents dans la classe et retourne un tableau contenant l’ensemble de ses informations.
        public function connect($login, $password){
            // connexioin à la base de donnée
            $conn = mysqli_connect('localhost', 'root', '', 'classes');
            // on verifier si le login et password existe et juste
            $existe = mysqli_query($conn, "SELECT * FROM utilisateurs WHERE login='$login' && password='$password'");
            $info   = mysqli_fetch_assoc($existe);
            if (isset($info)) {

                $this->id        = $info["id"];
                $this->login     = $info["login"];
                $this->password  = $info["password"];
                $this->email     = $info["email"];
                $this->firstname = $info["firstname"];
                $this->lastname  = $info["lastname"];
            }
            return([$this->id, $this->login, $this->password, $this->email, $this->firstname, $this->lastname]);
        }

        // - public function disconnect()
        // Déconnecte l’utilisateur.
        public function disconnect(){
            $this->login        = null;
            $this->password     = null;
            $this->email        = null;
            $this->firstname    = null;
            $this->lastname     = null;
        }

        // - public function delete()
        // Supprime et déconnecte l’utilisateur.
        public function delete(){
            // connexioin à la base de donnée
            $conn = mysqli_connect('localhost', 'root', '', 'classes');
            $login = $this->login;
            mysqli_query($conn, "DELETE FROM utilisateurs WHERE login = '$login'");
            $this->id        = null;
            $this->login     = null;
            $this->password  = null;
            $this->email     = null;
            $this->firstname = null;
            $this->lastname  = null;
        }

        // - public function update($login, $password, $email, $firstname,lastname)
        // Modifie les informations de l’utilisateur en base de données.
        public function update($login, $password, $email, $firstname,$lastname){
            // connexioin à la base de donnée
            $conn   = mysqli_connect('localhost', 'root', '', 'classes');
            $login  = $this->login;
            // on verifier si le login et password existe et juste
            $existe = mysqli_query($conn, "SELECT * FROM utilisateurs WHERE login='$login'");
            $existe = mysqli_num_rows($existe);
            $info   = mysqli_fetch_assoc($existe);
            /////////////////////////////
            if ($existe == 0) {
                mysqli_query($conn, "UPDATE utilisateurs SET 
                login='$login', password='$password', email='$email', firstname='$firstname', lastname='$lastname' WHERE login='$login'");
                $this->login        = $login;
                $this->password     = $password;
                $this->email        = $email;
                $this->firstname    = $firstname;
                $this->lastname     = $lastname;
            }
        }
        // - public function isConnected()
        // Retourne un booléen permettant de savoir si un utilisateur est connecté ou non.
        public function isConnected(){
            if (isset($this->login)) {
                  $connected = true;
            }else $connected = false;

            return($connected);
        }
        // - public function getAllInfos()
        // Retourne un tableau contenant l’ensemble des informations de l’utilisateur.
        public function getAllInfos(){
            return([$this->id, $this->login, $this->password, $this->email, $this->firstname, $this->lastname]);
        }
        // - public function getLogin()
        // Retourne le login de l’utilisateur connecté.
        public function getLogin(){
            return($this->login);
        }
        // - public function getEmail()
        // Retourne l’adresse email de l’utilisateur connecté.
        public function getEmail(){
            return($this->email);
        }
        // - public function getFirstname()
        // Retourne le firstname de l’utilisateur connecté.
        public function getFirstname(){
            return($this->firstname);
        }
        // - public function getLastname()
        // Retourne le lastname de l’utilisateur connecté.
        public function getLastname(){
            return($this->lastname);
        }
        // - public function refresh()
        // Met à jour les attributs de la classe à partir de la base de données.
        public function refresh(){
            // connexioin à la base de donnée
            $conn = mysqli_connect('localhost', 'root', '', 'classes');
            mysqli_refresh($conn, MYSQLI_REFRESH_LOG);
        }
    }
?>