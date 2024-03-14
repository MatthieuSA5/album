<?php
function connexion($local, $login, $mdp, $bdd){
    $cnx = mysqli_connect($local, $login, $mdp, $bdd);
    if (mysqli_connect_errno()) {
        echo "Echec de la connexion : ",mysqli_connect_error();
        exit();
      }
    return $cnx;
}

function get($table, $id=null){
    $cnx=connexion("localhost","root","","album");
    $sql="SELECT * FROM albums ";
    if($id !=null) {
        $sql.="WHERE id=".$id;
    }
    return mysqli_query($cnx, $sql);
}

function query($sql){

}

function set($table, $data, $id=null){

}

function del($table, $id){

}

?>