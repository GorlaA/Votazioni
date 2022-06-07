<?php
////////////////////////////////////////////////////////////////////////////////
//DATABASE
//Funzione per la connessione al Database
function connettiDb(){
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "votazioniscolastiche";
    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    return $conn;
}
//funzione per verificare la correttezza delle credenziali (mail e password) inserite
function check_login($conn, $mail, $password){
    $valido = false;
    $password = hash_password($password);
    $sql = "SELECT * FROM utente WHERE mail = '$mail' AND pw = '$password'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0)
        $valido = true;
    $conn->close();
    return $valido;
}

function getIdUtente($conn, $mail){
    $sql = "SELECT id FROM utente WHERE mail = '$mail'";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $conn->close();
    return $row['id'];
}
////////////////////////////////////////////////////////////////////////////////
//hash password tipo sha1
function hash_password($password) {
    return sha1($password);
}

//funzioner per verificare il formato valido della mail inserita
function valida_mail($mail) {
    $valida = true;
    if (!filter_var($mail, FILTER_VALIDATE_EMAIL))
        $valida = false;
    return $valida;
}




//ricerca ID Admin
function get_Id_Admin()
{
    $id_Admin = null;
    $conn = connettiDb();
    $sql = "SELECT id FROM gruppo WHERE nome = 'Admin'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0)
    {
        while ($row = $result->fetch_assoc())
        {
            $id_Admin = $row['id'];
        }
    }
    return $id_Admin;
}

//ricerca ID Crea Votazione
function get_Id_Crea_Votazione()
{
    $id_Crea_Votazione = null;
    $conn = connettiDb();
    $sql = "SELECT id FROM gruppo WHERE nome = 'crea_votazione'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $id_Crea_Votazione = $row['id'];
        }

    }
    return $id_Crea_Votazione;
}
?>