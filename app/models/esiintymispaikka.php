<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Esiintymispaikka extends BaseModel{
    
    
    public $id, $nimi, $osoite;
    
    public function __construct($attributes){
        parent::__construct($attributes);
    }
    
    public static function all() {
        $query = DB::connection()->prepare('SELECT * FROM Esiintymispaikka');
        $query->execute();
        $rows = $query->fetchAll();
        $paikat = array();
        
        foreach($rows as $row) {
            $paikat[] = new Esiintymispaikka(array(
                'id' => $row['id'],
                'nimi' => $row['nimi'],
                'osoite' => $row['osoite']
            ));
        }
        return $paikat;
    }
    
    public static function find($id){
        $query = DB::connection()->prepare('SELECT * FROM Esiintymispaikka WHERE id = :id LIMIT 1');
        $query->execute(array('id' => $id));
        $row = $query->fetch();
        
        if ($row) {
            $paikka = new Esiintymispaikka(array(
                'id' => $row['id'],
                'nimi' => $row['nimi'],
                'osoite' => $row['osoite'],
            ));
            return $paikka;
        }
        return null;
    }
    
    public function save() {
        $query = DB::connection()->prepare('INSERT INTO Esiintymispaikka (nimi, osoite) VALUES (:nimi, :osoite) RETURNING id');
        $query->execute(array(
            'nimi' => $this->nimi,
            'osoite' => $this->osoite
        )); 
        
        $row = $query->fetch();
        $this->id = $row['id'];
    }
    
    public function delete() {
        $query = DB::connection()->prepare('DELETE FROM Esiintymispaikka WHERE id = :id');
            $query->execute(array(
            'id' => $this->id,
        )); 
        
    }
}