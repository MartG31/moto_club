<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190912110023 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE articles CHANGE user_id user_id INT UNSIGNED DEFAULT NULL, CHANGE datetime_modif datetime_modif DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE balades CHANGE user_id user_id INT UNSIGNED DEFAULT NULL, CHANGE datetime_rdv datetime_rdv DATETIME DEFAULT NULL, CHANGE adresse_rdv adresse_rdv VARCHAR(120) DEFAULT NULL, CHANGE cp_rdv cp_rdv VARCHAR(10) DEFAULT NULL, CHANGE ville_rdv ville_rdv VARCHAR(50) DEFAULT NULL, CHANGE file_gps file_gps VARCHAR(80) DEFAULT NULL, CHANGE datetime_modif datetime_modif DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE comptes_rendus CHANGE reu_id reu_id INT UNSIGNED DEFAULT NULL, CHANGE user_id user_id INT UNSIGNED DEFAULT NULL, CHANGE datetime_modif datetime_modif DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE membres_balades CHANGE user_id user_id INT UNSIGNED DEFAULT NULL, CHANGE bal_id bal_id INT UNSIGNED DEFAULT NULL');
        $this->addSql('ALTER TABLE photos CHANGE bal_id bal_id INT UNSIGNED DEFAULT NULL, CHANGE legende legende VARCHAR(50) DEFAULT NULL');
        $this->addSql('ALTER TABLE reunions CHANGE user_id user_id INT UNSIGNED DEFAULT NULL');
        $this->addSql('ALTER TABLE tokens CHANGE user_id user_id INT UNSIGNED DEFAULT NULL');
        $this->addSql('ALTER TABLE utilisateurs CHANGE pseudo pseudo VARCHAR(50) DEFAULT NULL, CHANGE nom nom VARCHAR(50) DEFAULT NULL, CHANGE prenom prenom VARCHAR(50) DEFAULT NULL, CHANGE avatar avatar VARCHAR(120) DEFAULT NULL, CHANGE datetime_adhesion datetime_adhesion DATETIME DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE articles CHANGE user_id user_id INT UNSIGNED DEFAULT NULL, CHANGE datetime_modif datetime_modif DATETIME DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE balades CHANGE user_id user_id INT UNSIGNED DEFAULT NULL, CHANGE datetime_rdv datetime_rdv DATETIME DEFAULT \'NULL\', CHANGE adresse_rdv adresse_rdv VARCHAR(120) DEFAULT \'NULL\' COLLATE utf8_general_ci, CHANGE cp_rdv cp_rdv VARCHAR(10) DEFAULT \'NULL\' COLLATE utf8_general_ci, CHANGE ville_rdv ville_rdv VARCHAR(50) DEFAULT \'NULL\' COLLATE utf8_general_ci, CHANGE file_gps file_gps VARCHAR(80) DEFAULT \'NULL\' COLLATE utf8_general_ci, CHANGE datetime_modif datetime_modif DATETIME DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE comptes_rendus CHANGE reu_id reu_id INT UNSIGNED DEFAULT NULL, CHANGE user_id user_id INT UNSIGNED DEFAULT NULL, CHANGE datetime_modif datetime_modif DATETIME DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE membres_balades CHANGE bal_id bal_id INT UNSIGNED DEFAULT NULL, CHANGE user_id user_id INT UNSIGNED DEFAULT NULL');
        $this->addSql('ALTER TABLE photos CHANGE bal_id bal_id INT UNSIGNED DEFAULT NULL, CHANGE legende legende VARCHAR(50) DEFAULT \'NULL\' COLLATE utf8_general_ci');
        $this->addSql('ALTER TABLE reunions CHANGE user_id user_id INT UNSIGNED DEFAULT NULL');
        $this->addSql('ALTER TABLE tokens CHANGE user_id user_id INT UNSIGNED DEFAULT NULL');
        $this->addSql('ALTER TABLE utilisateurs CHANGE pseudo pseudo VARCHAR(50) DEFAULT \'NULL\' COLLATE utf8_general_ci, CHANGE nom nom VARCHAR(50) DEFAULT \'NULL\' COLLATE utf8_general_ci, CHANGE prenom prenom VARCHAR(50) DEFAULT \'NULL\' COLLATE utf8_general_ci, CHANGE avatar avatar VARCHAR(120) DEFAULT \'NULL\' COLLATE utf8_general_ci, CHANGE datetime_adhesion datetime_adhesion DATETIME DEFAULT \'NULL\'');
    }
}
