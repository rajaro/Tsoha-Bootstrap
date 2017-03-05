<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Keikka extends BaseModel {

    public $id, $paikka_id, $yhtye_id, $pvm, $hinta, $yhtyeet;

    public function __construct($attributes) {
        parent::__construct($attributes);
        $this->validators = array('validate_pvm', 'validate_hinta');
    }
    
    public function validate_pvm() {
        $errors = array();
        $pvm = DateTime::createFromFormat('d.m.Y', $this->pvm);
        $pvm_errors = DateTime::getLastErrors();
        if ($pvm_errors['warning_count'] + $pvm_errors['error_count'] > 0) {
            $errors[] = 'Päivämäärä ei ollut oikea!';
        }
        return $errors;
    }
    
    public function validate_hinta() {
        $errors = array();
        if (!is_numeric($this->hinta)) {
            $errors[] = 'Hinta ei ollut käypä!';
        } 
        return $errors;
    }

    public static function all() {
        $query = DB::connection()->prepare('SELECT * FROM Keikka');
        $query->execute();
        $rows = $query->fetchAll();
        $keikat = array();

        foreach ($rows as $row) {
            $keikat[] = new Keikka(array(
                'id' => $row['id'],
                'paikka_id' => $row['paikka_id'],
                'yhtye_id' => $row['yhtye_id'],
                'pvm' => $row['paivamaara'],
                'hinta' => $row['hinta']
            ));
        }
        return $keikat;
    }

    public static function find($id) {
        $query = DB::connection()->prepare('SELECT * FROM Keikka WHERE id = :id LIMIT 1');
        $query->execute(array('id' => $id));
        $row = $query->fetch();

        if ($row) {
            $keikka = new Keikka(array(
                'id' => $row['id'],
                'paikka_id' => $row['paikka_id'],
                'yhtye_id' => $row['yhtye_id'],
                'pvm' => $row['paivamaara'],
                'hinta' => $row['hinta']
            ));
            return $keikka;
        }
        return null;
    }

    public static function findBandit($id) {
        
        $query = DB::connection()->prepare('SELECT yhtye_id FROM BandienKeikat WHERE keikka_id = :id');
        $query->execute(array('id' => $id));
        $rows = $query->fetchAll();
        $bandienId = array();
        foreach ($rows as $row) {
            $bandienId[] = $row['yhtye_id'];
        }
        
           /*    $query = DB::connection()->prepare('SELECT Yhtye.nimi, Yhtye.kuvaus, BandienKeikat.yhtye_id, BandienKeikat.keikka_id'
                . ' FROM Yhtye INNER JOIN BandienKeikat '
                . 'ON Yhtye.id = BandienKeikat.yhtye_id');

        $query->execute();
        $rows = $query->fetchAll();
        $bandit = array();
        foreach ($rows as $row) {
            if ($row['keikka_id'] == $id) {
                $bandit[] = new Yhtye(array( 
                    'nimi' => $row['Yhtye.nimi'],
                    'kuvaus' => $row['Yhtye.kuvaus']
                ));
            }
        }
        return $bandit;*/
        return $bandienId;
    }

        
    public function save() {
        $query = DB::connection()->prepare('INSERT INTO Keikka (paikka_id, paivamaara, hinta) VALUES (:paikka_id, :pvm, :hinta) RETURNING id');
        $query->execute(array(
         /*   'yhtye_id' => $this->yhtye_id,*/
            'paikka_id' => $this->paikka_id,
            'pvm' => $this->pvm,
            'hinta' => $this->hinta
        ));

        $row = $query->fetch();
        $this->id = $row['id'];
        //lisätään keikka ja yhtye tauluun BandienKeikat
        foreach ($this->yhtyeet as $yhtye) {
        $query1 = DB::connection()->prepare('INSERT INTO BandienKeikat (yhtye_id, keikka_id) VALUES (:yhtye_id, :keikka_id)');
        $query1->execute(array(
            'keikka_id' => $this->id,
            'yhtye_id' => $yhtye
        ));
        }
    }

    public function delete() {
        $query1 = DB::connection()->prepare('DELETE FROM BandienKeikat WHERE keikka_id = :keikka_id');
        $query1->execute(array(
            'keikka_id' => $this->id
        )); //poistetaan ensin BandienKeikat taulusta rivi

        $query = DB::connection()->prepare('DELETE FROM Keikka WHERE id = :id');
        $query->execute(array(
            'id' => $this->id,
        ));
    }

    public function update() {
        $query = DB::connection()->prepare('UPDATE Keikka SET paivamaara = :pvm, hinta = :hinta where id = :id RETURNING id');
        $query->execute(array(
            'id' => $this->id,
            'pvm' => $this->pvm,
            'hinta' => $this->hinta
        ));

        $row = $query->fetch();
        $this->id = $row['id'];
    }

}
