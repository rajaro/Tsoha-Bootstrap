<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Yhtye extends BaseModel{
    
    
    public $id, $nimi, $kuvaus;
    
    public function __construct($attributes){
        parent::__construct($attributes);
    }
    
    public static function all() {
        $query = DB::connection()->prepare('SELECT * FROM Yhtye');
        $query->execute();
        $rows = $query->fetchAll();
        $yhtyeet = array();
        
        foreach($rows as $row) {
            $yhtyeet[] = new Yhtye(array(
                'id' => $row['id'],
                'nimi' => $row['nimi'],
                'kuvaus' => $row['kuvaus'],
            ));
        }
        return $yhtyeet;
    }
    
    public static function find($id){
        $query = DB::connection()->prepare('SELECT * FROM Yhtye WHERE id = :id LIMIT 1');
        $query->execute(array('id' => $id));
        $row = $query->fetch();
        
        if ($row) {
            $yhtye = new Yhtye(array(
                'id' => $row['id'],
                'nimi' => $row['nimi'],
                'kuvaus' => $row['kuvaus'],
            ));
            return $yhtye;
        }
        return null;
    }
    
       public function save() {
        $query = DB::connection()->prepare('INSERT INTO Yhtye (nimi, kuvaus) VALUES (:nimi, :kuvaus) RETURNING id');
        $query->execute(array(
            'nimi' => $this->nimi,
            'kuvaus' => $this->kuvaus,
        )); 
        
        $row = $query->fetch();
        $this->id = $row['id'];
    }
    
}