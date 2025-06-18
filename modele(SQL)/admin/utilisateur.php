<?php

require_once dirname(__DIR__, 2) . '/include(redondance)/init.php';

class CUtilisateur
{
    private int $Id_utilisateur = 0;
    private string $nom = "";
    private string $prenom = "";
    private string $mail = "";
    private string $ville = "";
    private string $mot_de_passe = "";
    private int $isClient = 0;
    private int $isAdmin = 0;
    
    private $conn;
    

    public function GetUserId()
    {

        return $this->Id_utilisateur;
    }
    public function SetUserId($Id_utilisateur)
    {
        $this->Id_utilisateur = $Id_utilisateur;
    }

    public function __construct(){
        $this->conn = $pdo;
    }
}
