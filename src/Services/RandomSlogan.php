<?php
namespace App\Services;

class RandomSlogan {

    function getSlogan() {
        $words = ['café', 'pâté', 'vendeur', 'magasin', 'saumon', 'poisson', 'jambon', 'ordinateur', 'chameau', 'carré', 'menteur', 'bureau'];
        return "Le meilleur " . $words[mt_rand(0, (sizeof($words)-1))] ." du " . $words[mt_rand(0, (sizeof($words)-1))];
    }
}