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
        $this->validators = array('validate_name', 'validate_kuvaus');
    }
    
    public function validate_name(){
        $errors = array();
        if ($this->nimi == '' || $this->nimi == null) {
            $errors[] = 'Nimi ei saa olla tyhjä';
            
        }
        if (strlen($this->nimi) < 2) {
            $errors[] = 'Nimen tulee olla vähintään 2 merkkiä pitkä';
        }
        
        if (strlen($this->nimi) > 50) {
            $errors[] = 'Nimen tulee olla alle 50 merkkiä pitkä';
        }
        
        return $errors;
    }
    
    public function validate_kuvaus() {
        $errors = array();
        if (strlen($this->kuvaus) > 400) {
            $errors[] = 'Kuvauksen tulee olla max. 400 merkkiä pitkä';
        }
        return $errors;
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
    
    public static function findKeikat($id) {
        $query = DB::connection()->prepare('SELECT keikka_id FROM BandienKeikat WHERE yhtye_id = :id');
        $query->execute(array('id' => $id));
        $rows = $query->fetchAll();
        $keikkaids = array();
        if ($rows) {
        foreach($rows as $row) {
            $keikkaids[] = $row['keikka_id'];
        }
        return $keikkaids;
        } 
        return null;
    }
    
    public static function findPaikka($id){
        /*
        $query = DB::connection()->prepare('SELECT keikka_id FROM BandienKeikat WHERE yhtye_id = :id');
        $query->execute(array('id' => $id));
        $rows = $query->fetchAll();
        $keikkaids = array();
        $ids = join("','",$keikkaids);
        $statement = "SELECT * FROM Keikka WHERE id IN ($ids)";
        $query1 = DB::connection()->prepare($statement);
        $query1->execute();        
        $rows1 = $query1->fetchAll(); 
        if ($rows1) {
        foreach($rows1 as $row) {
            $keikat[] = $row['paikka_id'];
        }
        return $keikat;
        }
        */
        $query = DB::connection()->prepare('SELECT * FROM Keikka WHERE yhtye_id = :id LIMIT 1');
        $query->execute(array('id' => $id));
        $row = $query->fetch();
        if ($row){
            $quer = DB::connection()->prepare('SELECT * FROM Esiintymispaikka WHERE id = :paikka_id LIMIT 1');
            $paikkaid = $row['paikka_id'];
            $quer->execute(array('paikka_id' => $paikkaid));
            $row1 = $quer->fetch();
            if ($row1) {
                $paikka = new Esiintymispaikka(array(
                    'id' => $row1['id'],
                    'nimi' => $row1['nimi'],
                    'osoite' => $row1['osoite']
                ));
                return $paikka;
            }
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
    
    public function update() {
            $query = DB::connection()->prepare('UPDATE Yhtye SET nimi = :nimi, kuvaus = :kuvaus where id = :id RETURNING id');
            $query->execute(array(
            'id' => $this->id,
            'nimi' => $this->nimi,
            'kuvaus' => $this->kuvaus,
        )); 
        
        $row = $query->fetch();
        $this->id = $row['id'];
    }
    
    public function delete() {
        $query = DB::connection()->prepare('DELETE FROM Yhtye WHERE id = :id');
            $query->execute(array(
            'id' => $this->id,    
        )); 
        
    }
    
}