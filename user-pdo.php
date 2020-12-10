<?php

    class userpdo {
        private $id;
        public $login;
        public $password;
        public $email;
        public $firstname;
        public $lastname;

        //- public function register($login, $password, $email, $firstname, $lastname)
        // Crée l’utilisateur en base de données. Retourne un tableau contenant l’ensemble des informations concernant l’utilisateur créé.
        public function register($login, $password, $email, $firstname, $lastname){
            //nouvelle connextion à la bdd
            $conn = new PDO("mysql:host=localhost;dbname=classes","root","");
            // Insertion dans la base de donnée
            $send = $conn->prepare('INSERT INTO utilisateurs(login, email, password, firstname, lastname) VALUES(:login, :email, :password, :firstname, :lastname)');
            $send->execute(['login'     => $login,
                            'email'     => $email,
                            'password'  => $password,
                            'firstname' => $firstname,
                            'lastname'  => $lastname ]);
            return([$this->id, $this->login, $this->password, $this->email, $this->firstname, $this->lastname]);
        }

        // - public function connect($login, $password)
        // Connecte l’utilisateur, modifie les attributs présents dans la classe et
        // retourne un tableau contenant l’ensemble de ses informations.
        public function connect($login, $password){
            // connexioin à la base de donnée
            $conn = new PDO("mysql:host=localhost; dbname=classes", "root", "");
            // on verifier si le login et password existe et juste
            $existe = $conn->prepare("SELECT * FROM utilisateurs WHERE login= :login && password= :password");
            $existe->execute(  ['login'    => $login,
                                'password' => $password]);
            $info = $existe->fetch();
            if ($info == true) {
                $this->id        = $info["id"];
                $this->login     = $info["login"];
                $this->password  = $info["password"];
                $this->email     = $info["email"];
                $this->firstname = $info["firstname"];
                $this->lastname  = $info["lastname"];
            }else
            return([$this->id, $this->login, $this->password, $this->email, $this->firstname, $this->lastname]);
        }

        // - public function disconnect()
        // Déconnecte l’utilisateur.
        public function disconnect(){
            $this->id        = null;
            $this->login     = null;
            $this->password  = null;
            $this->email     = null;
            $this->firstname = null;
            $this->lastname  = null;
        }

        // - public function delete()
        // Supprime et déconnecte l’utilisateur.
        public function delete(){
            // connexioin à la base de donnée
            $conn = new PDO("mysql:host=localhost; dbname=classes", "root", "");
            $delete = $conn->prepare("DELETE FROM utilisateurs WHERE login = :login");
            $delete->execute(['login'=>$this->login]);
            $this->id        = null;
            $this->login     = null;
            $this->password  = null;
            $this->email     = null;
            $this->firstname = null;
            $this->lastname  = null;
        }

        // - public function update($login, $password, $email, $firstname, lastname)
        // Modifie les informations de l’utilisateur en base de données.
        public function update($login, $password, $email, $firstname,$lastname){
            // connexioin à la base de donnée
            $conn = new PDO("mysql:host=localhost; dbname=classes", "root", "");
            // on verifier si le login et password existe et juste
            $update = $conn->prepare("SELECT * FROM utilisateurs WHERE login='$login'");
            $update -> execute(['login'=>$this->login]);
            /////////////////////////////
            $this->login     = $login;
            $this->password  = $password;
            $this->email     = $email;
            $this->firstname = $firstname;
            $this->lastname  = $lastname;
        }
        // - public function isConnected()
        // Retourne un booléen permettant de savoir si un utilisateur est connecté ou
        // non.
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