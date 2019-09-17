<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190917091811 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE adresses CHANGE bal_id bal_id INT UNSIGNED DEFAULT NULL');
        $this->addSql('ALTER TABLE articles CHANGE user_id user_id INT UNSIGNED DEFAULT NULL, CHANGE datetime_modif datetime_modif DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE balades DROP FOREIGN KEY FK_3ED88FFA76ED395');
        $this->addSql('ALTER TABLE balades CHANGE user_id user_id INT UNSIGNED DEFAULT NULL, CHANGE file_gps file_gps VARCHAR(80) DEFAULT NULL, CHANGE datetime_modif datetime_modif DATETIME DEFAULT NULL, CHANGE nb_max_pers nb_max_pers INT DEFAULT NULL');
        $this->addSql('ALTER TABLE balades ADD CONSTRAINT FK_3ED88FFA76ED395 FOREIGN KEY (user_id) REFERENCES utilisateurs (id)');
        $this->addSql('ALTER TABLE comptes_rendus CHANGE reu_id reu_id INT UNSIGNED DEFAULT NULL, CHANGE user_id user_id INT UNSIGNED DEFAULT NULL, CHANGE datetime_modif datetime_modif DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE membres_balades DROP FOREIGN KEY fk_mb_user_id');
        $this->addSql('ALTER TABLE membres_balades CHANGE user_id user_id INT UNSIGNED DEFAULT NULL, CHANGE bal_id bal_id INT UNSIGNED DEFAULT NULL');
        $this->addSql('ALTER TABLE membres_balades ADD CONSTRAINT FK_A602F006A76ED395 FOREIGN KEY (user_id) REFERENCES utilisateurs (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE photos CHANGE bal_id bal_id INT UNSIGNED DEFAULT NULL, CHANGE legende legende VARCHAR(50) DEFAULT NULL');
        $this->addSql('ALTER TABLE reunions CHANGE user_id user_id INT UNSIGNED DEFAULT NULL');
        $this->addSql('ALTER TABLE tokens CHANGE user_id user_id INT UNSIGNED DEFAULT NULL');
        $this->addSql('ALTER TABLE utilisateurs CHANGE pseudo pseudo VARCHAR(50) DEFAULT NULL, CHANGE nom nom VARCHAR(50) DEFAULT NULL, CHANGE prenom prenom VARCHAR(50) DEFAULT NULL, CHANGE avatar avatar VARCHAR(120) DEFAULT NULL, CHANGE datetime_adhesion datetime_adhesion DATETIME DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE adresses CHANGE bal_id bal_id INT UNSIGNED DEFAULT NULL');
        $this->addSql('ALTER TABLE articles CHANGE user_id user_id INT UNSIGNED DEFAULT NULL, CHANGE datetime_modif datetime_modif DATETIME DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE balades DROP FOREIGN KEY FK_3ED88FFA76ED395');
        $this->addSql('ALTER TABLE balades CHANGE user_id user_id INT UNSIGNED DEFAULT NULL, CHANGE file_gps file_gps VARCHAR(80) DEFAULT \'NULL\' COLLATE utf8_general_ci, CHANGE datetime_modif datetime_modif DATETIME DEFAULT \'NULL\', CHANGE nb_max_pers nb_max_pers INT DEFAULT NULL');
        $this->addSql('ALTER TABLE balades ADD CONSTRAINT FK_3ED88FFA76ED395 FOREIGN KEY (user_id) REFERENCES utilisateurs (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE comptes_rendus CHANGE reu_id reu_id INT UNSIGNED DEFAULT NULL, CHANGE user_id user_id INT UNSIGNED DEFAULT NULL, CHANGE datetime_modif datetime_modif DATETIME DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE membres_balades DROP FOREIGN KEY FK_A602F006A76ED395');
        $this->addSql('ALTER TABLE membres_balades CHANGE bal_id bal_id INT UNSIGNED DEFAULT NULL, CHANGE user_id user_id INT UNSIGNED DEFAULT NULL');
        $this->addSql('ALTER TABLE membres_balades ADD CONSTRAINT fk_mb_user_id FOREIGN KEY (user_id) REFERENCES utilisateurs (id)');
        $this->addSql('ALTER TABLE photos CHANGE bal_id bal_id INT UNSIGNED DEFAULT NULL, CHANGE legende legende VARCHAR(50) DEFAULT \'NULL\' COLLATE utf8_general_ci');
        $this->addSql('ALTER TABLE reunions CHANGE user_id user_id INT UNSIGNED DEFAULT NULL');
        $this->addSql('ALTER TABLE tokens CHANGE user_id user_id INT UNSIGNED DEFAULT NULL');
        $this->addSql('ALTER TABLE utilisateurs CHANGE pseudo pseudo VARCHAR(50) DEFAULT \'NULL\' COLLATE utf8_general_ci, CHANGE nom nom VARCHAR(50) DEFAULT \'NULL\' COLLATE utf8_general_ci, CHANGE prenom prenom VARCHAR(50) DEFAULT \'NULL\' COLLATE utf8_general_ci, CHANGE avatar avatar VARCHAR(120) DEFAULT \'NULL\' COLLATE utf8_general_ci, CHANGE datetime_adhesion datetime_adhesion DATETIME DEFAULT \'NULL\'');
    }
}
