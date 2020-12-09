<?php

    class user {
        private $id;
        public $login;
        public $password;
        public $email;
        public $fisrtname;
        public $lastname;

        //- public function register($login, $password, $email, $firstname, $lastname)
        // Crée l’utilisateur en base de données. Retourne un tableau contenant
        // l’ensemble des informations concernant l’utilisateur créé.
        public function register($login, $password, $email, $firstname, $lastname){
            // connexioin à la base de donnée
            $conn = mysqli_connect('localhost', 'root', '', 'classes');
            // on verifier si le login et password existe deja
            $existe = mysqli_query($conn, "SELECT * FROM utilisateurs WHERE login='$login' && password='$password'");
            $existe = mysqli_num_rows($existe);
            $info = mysqli_fetch_assoc($existe);
            // la requete pour envoyer les infos vers la base de donnée
            if (!isset($info)) {
                $requet = mysqli_query($conn, "INSERT INTO utilisateurs (login, password, email, firstname, lastename) 
                                        VALUES ('$login', '$password', '$email', '$firstname', '$lastname')");
            }else echo "le login existe deja";
            
            return($requet);
        }

        // - public function connect($login, $password)
        // Connecte l’utilisateur, modifie les attributs présents dans la classe et
        // retourne un tableau contenant l’ensemble de ses informations.
        public function connecte($login, $password){
            // connexioin à la base de donnée
            $conn = mysqli_connect('localhost', 'root', '', 'classes');
            // on verifier si le login et password existe et juste
            $existe = mysqli_query($conn, "SELECT * FROM utilisateurs WHERE login='$login' && password='$password'");
            $existe = mysqli_num_rows($existe);
            $info = mysqli_fetch_assoc($existe);
            if ($existe > 1) {
                session_start();
                $_SESSION['id'] = $info["id"];
                $_SESSION['login'] = $info["login"];
                $_SESSION['password'] = $info["password"];
                $_SESSION['email'] = $info["email"];
                $_SESSION['firstname'] = $info["firstname"];
                $_SESSION['lastname'] = $info["lastnname"];
            }
            return($existe);
        }

        // - public function disconnect()
        // Déconnecte l’utilisateur.
        public function disconnect(){
            session_unset();
        }

        // - public function delete()
        // Supprime et déconnecte l’utilisateur.
        public function delete(){
            $login=$_SESSION['login'];
            // connexioin à la base de donnée
            $conn = mysqli_connect('localhost', 'root', '', 'classes');
            mysqli_query($conn, "DELETE FROM utilisateurs WHERE login = '$login'");
            session_unset();
        }

        // - public function update($login, $password, $email, $firstname,
        // lastname)
        // Modifie les informations de l’utilisateur en base de données.
        public function update($login, $password, $email, $firstname,$lastname){
            // connexioin à la base de donnée
            $conn = mysqli_connect('localhost', 'root', '', 'classes');
            $login=$_SESSION['login'];
            // on verifier si le login et password existe et juste
            $existe = mysqli_query($conn, "SELECT * FROM utilisateurs WHERE login='$login'");
            $existe = mysqli_num_rows($existe);
            $info = mysqli_fetch_assoc($existe);
            $login = $_SESSION['login'];
            /////////////////////////////
            if ($existe == 0) {
                mysqli_query($conn, "UPDATE utilisateurs SET 
                login='$login', password='$password', email='$email', firstname='$firstname', lastname='$lastname' WHERE login='$login'");
                
                $_SESSION['login'] = $login;
                $_SESSION['password'] = $password;
                $_SESSION['email'] = $email;
                $_SESSION['firstname'] = $firstname;
                $_SESSION['lastname'] = $lastname;
            }
        }
        // - public function isConnected()
        // Retourne un booléen permettant de savoir si un utilisateur est connecté ou
        // non.
        public function isConnected(){
            if (isset($_SESSION["login"])) {
                $connected = true;
            }else $connected = false;
            return($connected);
        }
        // - public function getAllInfos()
        // Retourne un tableau contenant l’ensemble des informations de l’utilisateur.
        public function getAllInfos(){
            // connexioin à la base de donnée
            $conn = mysqli_connect('localhost', 'root', '', 'classes');
            $login=$_SESSION['login'];
            $existe = mysqli_query($conn, "SELECT * FROM utilisateurs WHERE login='$login'");
            $info = mysqli_fetch_assoc($existe);

            return($info);
        }
        // - public function getLogin()
        // Retourne le login de l’utilisateur connecté.
        public function getLogin(){
            // connexioin à la base de donnée
            $conn = mysqli_connect('localhost', 'root', '', 'classes');
            $login=$_SESSION['login'];

            return($login);
        }
        // - public function getEmail()
        // Retourne l’adresse email de l’utilisateur connecté.
        public function getEmail(){
            // connexioin à la base de donnée
            $conn = mysqli_connect('localhost', 'root', '', 'classes');
            $email=$_SESSION['email'];

            return($email);
        }
        // - public function getFirstname()
        // Retourne le firstname de l’utilisateur connecté.
        public function getFirstname(){
            // connexioin à la base de donnée
            $conn = mysqli_connect('localhost', 'root', '', 'classes');
            $firstname=$_SESSION['firstname'];

            return($firstname);
        }
        // - public function getLastname()
        // Retourne le lastname de l’utilisateur connecté.
        public function getLastname(){
            // connexioin à la base de donnée
            $conn = mysqli_connect('localhost', 'root', '', 'classes');
            $lastname=$_SESSION['lastname'];

            return($lastname);
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