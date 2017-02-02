<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Keikka extends BaseModel{
    
    
    public $id, $esiintymispaikka_id, $yhtye_id, $pvm;
    
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
                'keikka_id' => $row['esiintymispaikka_id'],
                'yhtye_id' => $row['yhtye_id'],
                'pvm' => $row['pvm']
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
                'esiintymispaikka_id' => $row['esiintymispaikka_id'],
                'yhtye_id' => $row['yhtye_id'],
                'pvm' => $row['pvm']
            ));
            return $keikka;
        }
        return null;
    }
}