<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Audit F-11 — elargit user.password pour accueillir bcrypt.
 *
 * La colonne etait en varchar(32) : exactement la taille d'une empreinte MD5.
 * Une empreinte bcrypt en fait 60. Ecrire du bcrypt dans cette colonne l'aurait
 * tronquee a 32 caracteres — et, le mode strict etant desactive dans 115
 * fichiers (audit F-13), MySQL l'aurait fait SANS erreur. Chaque membre du
 * personnel se serait retrouve avec une empreinte inverifiable, donc verrouille
 * dehors, sans le moindre message.
 *
 * Cette migration doit donc etre appliquee AVANT le passage a bcrypt.
 *
 * Les autres tables sont deja assez larges : customer_info (255),
 * admins (200), users (200), saas_admins (255).
 */
class Migration_Widen_user_password_for_bcrypt extends CI_Migration {

    public function up()
    {
        $this->dbforge->modify_column('user', [
            'password' => [
                'name'       => 'password',
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => FALSE,
            ],
        ]);
    }

    public function down()
    {
        // Volontairement non reversible : re-retrecir la colonne tronquerait
        // toutes les empreintes bcrypt deja ecrites, donc verrouillerait les
        // comptes migres. En cas de retour arriere, restaurer une sauvegarde.
        log_message('error', 'Migration widen_user_password : down() refuse — '
            . 'retrecir la colonne detruirait les empreintes bcrypt existantes.');
    }
}
