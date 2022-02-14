<?php
/**
 * Created by PhpStorm.
 * User: paul
 * Date: 26.02.2020
 * Time: 13:16
 */

namespace App\allClass\helpers;



class Check {


    public static function iban ($iban) {
        if(strlen($iban) != 24){
            return false;
        }

        return true;
    }

    public static function cif ($cif_str) {
        /* Opreste scriptul daca stringul furnizat
           pentru CIF are 0 caractere ori mai mult de 10 */
        if ((strlen($cif_str) == 0) || (strlen($cif_str) > 10)) {
            return false;
        }

        // Pastreaza doar cifrele din CUI-ul furnizat de utilizator
        if(strpos($cif_str, 'RO') === 0) {
            $cif_str = substr($cif_str, 2);
        }

        // Creaza un array din stringul furnizat pentu CIF
        $cif_arr = str_split($cif_str, 1);

        // Numar de control
        $key_str = '753217532';

        // Array din numar de control
        $key_arr = str_split($key_str, 1);

        // Inversare array CIF
        $cif_rev_arr = array_reverse($cif_arr);

        // Inversare array numar de control
        $key_rev_arr = array_reverse($key_arr);

        $product = 0;

        if (!isset($cif_rev_arr[0]) || !is_numeric($cif_rev_arr[0])) {
            $cif_rev_arr[0] = 0;
        }
        foreach($key_rev_arr as $k => $v) {
            // Adauga un 0 in $cif_rev_arr
            if (!isset($cif_rev_arr[$k + 1]) || !is_numeric($cif_rev_arr[$k + 1])) {
                $cif_rev_arr[$k + 1] = 0;
            }
            // inmulteste membrii celor 2 array-uri 2 cate 2
            // si aduna produsele
            $product += $key_rev_arr[$k] * $cif_rev_arr[$k + 1];
        }

        $product = $product * 10;

        // cifra de verificare
        $rest = $product % 11;
        if ($rest == 10) $rest = 0;

        // cifra de control
        $ctrl_digit = $cif_rev_arr[0];

        // daca cifra de verificare este egala cu cifra de control
        // CIF-ul e valid
        if ($rest == $ctrl_digit) return true;

        return false;
    }

    public static function cnp($cnp) {
        if (strlen($cnp) == 6 && substr($cnp, 0, 2) == '00') {
            return true; # pentru straini, au un cod de 6 cifre cu 00 in fata
        }

        if (strlen($cnp) != 13) {
            return false;
        }

        $s = $cnp[0]*2  +  $cnp[1]*7 + $cnp[2]*9 + $cnp[3]*1 + $cnp[4]*4 + $cnp[5]*6 + $cnp[6]*3 + $cnp[7]*5 + $cnp[8]*8 + $cnp[9]*2 + $cnp[10]*7 + $cnp[11]*9;
        $rest = $s % 11;

        if ($rest == 10) {
            $rest = 1;
        }

        if ($cnp[12] == $rest) {
            return true;
        }
        else {
            return false;
        }
    }


}
