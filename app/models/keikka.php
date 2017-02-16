<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Keikka extends BaseModel{
    
    
    public $id, $esiintymispaikka_id, $yhtye_id, $pvm, $hinta;
    
    public function __construct($attributes){
        parent::__construct($attributes);
    }
    
    public static function all() {
        $query = DB::connection()->prepare('SELECT * FROM Keikka');
        $query->execute();
        $rows = $query->fetchAll();
        $keikat = array();
        
        foreach($rows as $row) {
            $keikat[] = new Keikka(array(
                'id' => $row['id'],
                'keikka_id' => $row['paikka_id'],
                'yhtye_id' => $row['yhtye_id'],
                'pvm' => $row['paivamaara'],
                'hinta' => $row['hinta']
            ));
        }
        return $keikat;
    }
    
    public static function find($id){
        $query = DB::connection()->prepare('SELECT * FROM Keikka WHERE id = :id LIMIT 1');
        $query->execute(array('id' => $id));
        $row = $query->fetch();
        
        if ($row) {
            $keikka = new Keikka(array(
                'id' => $row['id'],
                'esiintymispaikka_id' => $row['paikka_id'],
                'yhtye_id' => $row['yhtye_id'],
                'pvm' => $row['paivamaara'],
                'hinta' => $row['hinta']
            ));
            return $keikka;
        }
        return null;
    }
    
    public function save() {
        $query = DB::connection()->prepare('INSERT INTO Keikka (yhtye_id, paikka_id, paivamaara, hinta) VALUES (:yhtye_id, :esiintymispaikka, :pvm, :hinta) RETURNING id');
        $yhtye = Yhtye::find($this->yhtye_id);
        $query->execute(array(
            'yhtye_id' => $this->yhtye_id,
            'esiintymispaikka' => $this->esiintymispaikka_id,
            'pvm' => $this->pvm,
            'hinta' => $this->hinta
        )); 
        
        $row = $query->fetch();
        $this->id = $row['id'];
    }
    
    public function delete() {
        $query = DB::connection()->prepare('DELETE FROM Keikka WHERE id = :id');
            $query->execute(array(
            'id' => $this->id,
        )); 
        
    }
}