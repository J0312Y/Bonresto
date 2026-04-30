<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PhoneValidator {
    // Préfixes valides pour RC
    private static $VALID_PREFIXES = [
        'Airtel' => ['04', '05', '+24204', '+24205'],
        'MTN' => ['06', '+24206']
    ];

    // Valider un numéro de téléphone pour un opérateur spécifique
    public static function validate($phone, $operator) {
        // Nettoyer le numéro
        $phone = self::cleanPhoneNumber($phone);
        
        // Vérifier la longueur
        if (!self::checkLength($phone)) {
            return [
                'isValid' => false,
                'message' => 'Le numéro doit contenir 9 chiffres (sans préfixe)'
            ];
        }

        // Vérifier le préfixe pour l'opérateur
        if (!self::checkPrefix($phone, $operator)) {
            return [
                'isValid' => false,
                'message' => "Ce numéro n'est pas un numéro $operator valide"
            ];
        }

        // Format international
        $formattedNumber = self::formatInternational($phone);

        return [
            'isValid' => true,
            'formattedNumber' => $formattedNumber,
            'operator' => $operator
        ];
    }

    private static function cleanPhoneNumber($phone) {
        // Supprimer tous les caractères non numériques sauf +
        return preg_replace('/[^0-9+]/', '', $phone);
    }

    private static function checkLength($phone) {
        // Retirer le préfixe international si présent
        $number = preg_replace('/^\+242/', '', $phone);
        // Retirer le 0 initial si présent
        $number = preg_replace('/^0/', '', $number);
        
        return strlen($number) === 9;
    }

    private static function checkPrefix($phone, $operator) {
        if (!isset(self::$VALID_PREFIXES[$operator])) {
            return false;
        }

        foreach (self::$VALID_PREFIXES[$operator] as $prefix) {
            if (strpos($phone, $prefix) === 0) {
                return true;
            }
        }

        return false;
    }

    private static function formatInternational($phone) {
        // Si le numéro commence par +242, le garder tel quel
        if (strpos($phone, '+242') === 0) {
            return $phone;
        }

        // Si le numéro commence par 0, le remplacer par +243
        if (strpos($phone, '0') === 0) {
            return '+242' . substr($phone, 1);
        }

        // Sinon, ajouter +242
        return '+242' . $phone;
    }
}