<?php

    class lpdo {

        public  $host;
        public  $username;
        public  $password;
        public  $db;
        public  $conn;
        public  $query;

        public function constructeur($host, $username, $password, $db){
            $this->host     = $host;
            $this->username = $username;
            $this->password = $password;
            $this->db       = $db;

            $conn       = mysqli_connect("$host", "$username", "$password", "$db");
            echo mysqli_info($conn);
            $this->conn = $conn;
        }

        public function connect($host, $username, $password, $db){
            if (isset($this->conn)) {
                $this->conn = null;
                $conn = mysqli_connect("$host", "$username", "$password", "$db");
                $this->host     = $host;
                $this->username = $username;
                $this->password = $password;
                $this->db       = $db;
                $this->conn     = $conn;
            }
        }

        public function destructeur(){
            $this->conn = null;
        }

        public function close(){
            $this->destructeur();
        }

        public function execute($query)
        {
            $conn = $this->conn;
            
            $SQL = mysqli_query($conn, $query);
            $this->query = $query;
            $resultat = mysqli_fetch_assoc($SQL);
            return $resultat;
        }   

        public function getLastQuery()
        {
        if($this->query == '')
        {
        return false;
        }
        else
            {
            $query= $this->query;
            return $query; 
            }
        }

        public function getLastResult()
        {
            if($this->query == '')
            {
            return false;
            }
            else
                {
                $query= $this->query;
                $conn = $this->conn;
                $SQL = mysqli_query($conn, $query);
                $resultat = mysqli_fetch_assoc($SQL);
                return $resultat;
                }
        }

        public function getTables()
        {
            $db = $this->db;
            $link = $this->link;
            $SQL = mysqli_query($link, "SELECT table_name FROM information_schema.tables WHERE table_schema = '$db'");
            $resultat = mysqli_fetch_assoc($SQL);
            return $resultat;
        }

        public function getFields($table)
        {
            if($table == '')
            {
            return false;
            }
            else
                {
                    $conn = $this->conn;
                    $SQL = mysqli_query($conn, "SELECT COLUMN_NAME from INFORMATION_SCHEMA.COLUMNS where table_name = '$table'");
                    $resultat = mysqli_fetch_all($SQL);
                    return $resultat;
                }
        }
    }
?>
