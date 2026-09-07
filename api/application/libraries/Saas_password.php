<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Mots de passe des administrateurs SaaS.
 *
 * Ils etaient stockes en MD5 non sale. Pour une console qui gouverne les bases
 * de tous les clients, c'est insuffisant : MD5 se casse hors ligne en quelques
 * minutes, et l'absence de sel permet d'attaquer tous les comptes d'un coup —
 * deux administrateurs partageant le meme mot de passe avaient d'ailleurs la
 * meme empreinte, ce qui se voyait a l'oeil nu dans la table.
 *
 * La migration est TRANSPARENTE : les anciennes empreintes MD5 restent
 * acceptees a la connexion, et sont remplacees par du bcrypt au premier
 * succes. Personne n'a de mot de passe a changer, et aucune migration de
 * masse n'est necessaire — ce qui serait impossible de toute facon, puisque
 * MD5 ne permet pas de retrouver le mot de passe d'origine.
 */
class Saas_password
{
    /** Une empreinte MD5 : 32 caracteres hexadecimaux, et rien d'autre. */
    public static function est_ancienne(string $stocke): bool
    {
        return strlen($stocke) === 32 && ctype_xdigit($stocke);
    }

    /** Empreinte d'un mot de passe. bcrypt via PASSWORD_DEFAULT. */
    public static function hacher(string $clair): string
    {
        return password_hash($clair, PASSWORD_DEFAULT);
    }

    /**
     * Le mot de passe correspond-il a l'empreinte stockee ?
     *
     * Accepte les deux formats. `hash_equals` sur la branche MD5 evite de
     * laisser fuir l'empreinte par le temps de comparaison — `password_verify`
     * le fait deja de son cote.
     */
    public static function verifier(string $clair, ?string $stocke): bool
    {
        if (empty($stocke)) {
            return false;
        }

        if (self::est_ancienne($stocke)) {
            return hash_equals($stocke, md5($clair));
        }

        return password_verify($clair, $stocke);
    }

    /**
     * L'empreinte doit-elle etre reecrite ?
     *
     * Vrai pour tout ce qui est encore en MD5, et vrai aussi quand PHP releve
     * le cout de bcrypt d'une version a l'autre : les empreintes se remettent
     * alors a niveau toutes seules, a la connexion suivante.
     */
    public static function a_rehacher(string $stocke): bool
    {
        if (self::est_ancienne($stocke)) {
            return true;
        }

        return password_needs_rehash($stocke, PASSWORD_DEFAULT);
    }
}
