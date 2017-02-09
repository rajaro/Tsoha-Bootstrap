<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Kayttaja extends BaseModel {
    
    public $id, $nimi, $password;
            
        public function __construct($attributes){
        parent::__construct($attributes);
        $this->validators = array('validate_name');
    }
    
    public function validate_name(){
        $errors = array();
        if ($this->nimi == '' || $this->nimi == null) {
            $errors[] = 'Nimi ei saa olla tyhjä';
            
        }
        if (strlen($this->nimi) < 2) {
            $errors[] = 'Nimen tulee olla vähintään 2 merkkiä pitkä';
        }
        
        return $errors;
    }
    
    public static function authenticate($nimi, $password) {
        $query = DB::connection()->prepare('SELECT * FROM Kayttaja WHERE nimi = :nimi AND password = :password LIMIT 1');
        $query->execute(array('nimi' => $nimi, 'password' => $password));
        
        $row = $query->fetch();
        if ($row) {
            $kayttaja = new Kayttaja(array(
                'id' => $row['id'],
                'nimi' => $row['nimi'],
                'password' => $row['password']
            ));
            return $kayttaja;
        } else {
            return null;
        }
    }
    
    public static function all() {
        $query = DB::connection()->prepare('SELECT * FROM Kayttaja');
        $query->execute();
        $rows = $query->fetchAll();
        $kayttajat = array();
        
        foreach($rows as $row) {
            $kayttajat[] = new Kayttaja(array(
                'id' => $row['id'],
                'nimi' => $row['nimi'],
                'password' => $row['password']
            ));
        }
        return $kayttajat;
    }
    
    public static function find($id){
        $query = DB::connection()->prepare('SELECT * FROM Kayttaja WHERE id = :id LIMIT 1');
        $query->execute(array('id' => $id));
        $row = $query->fetch();
        
        if ($row) {
            $kayttaja = new Yhtye(array(
                'id' => $row['id'],
                'nimi' => $row['nimi'],
                'password' => $row['password'],
            ));
            return $kayttaja;
        }
        return null;
    }
    
       public function save() {
        $query = DB::connection()->prepare('INSERT INTO Kayttaja (nimi, password) VALUES (:nimi, :password) RETURNING id');
        $query->execute(array(
            'nimi' => $this->nimi,
            'password' => $this->password,
        )); 
        
        $row = $query->fetch();
        $this->id = $row['id'];
    }
    
    public function update() {
            $query = DB::connection()->prepare('UPDATE Kayttaja SET nimi = :nimi, password = :password where id = :id RETURNING id');
            $query->execute(array(
            'id' => $this->id,
            'nimi' => $this->nimi,
            'password' => $this->password,
        )); 
        
        $row = $query->fetch();
        $this->id = $row['id'];
    }
    
    public function delete() {
        $query = DB::connection()->prepare('DELETE FROM Kayttaja WHERE id = :id');
            $query->execute(array(
            'id' => $this->id,    
        )); 
        
    }
}