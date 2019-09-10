<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190910100508 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE articles (id INT UNSIGNED AUTO_INCREMENT NOT NULL, user_id INT UNSIGNED DEFAULT NULL, titre VARCHAR(80) NOT NULL, contenu TEXT NOT NULL, datetime_post DATETIME NOT NULL, datetime_modif DATETIME DEFAULT \'NULL\', INDEX fk_art_user_id (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE balades (id INT UNSIGNED AUTO_INCREMENT NOT NULL, user_id INT UNSIGNED DEFAULT NULL, titre VARCHAR(120) NOT NULL, contenu TEXT NOT NULL, date_debut DATE NOT NULL, date_fin DATE NOT NULL, datetime_rdv DATETIME DEFAULT \'NULL\', adresse_rdv VARCHAR(120) DEFAULT \'NULL\', cp_rdv VARCHAR(10) DEFAULT \'NULL\', ville_rdv VARCHAR(50) DEFAULT \'NULL\', file_gps VARCHAR(80) DEFAULT \'\'NULL\'\', datetime_post DATETIME NOT NULL, datetime_modif DATETIME DEFAULT \'NULL\', INDEX fk_bal_user_id (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE comptes_rendus (id INT UNSIGNED AUTO_INCREMENT NOT NULL, reu_id INT UNSIGNED DEFAULT NULL, user_id INT UNSIGNED DEFAULT NULL, titre VARCHAR(80) NOT NULL, contenu TEXT NOT NULL, datetime_post DATETIME NOT NULL, datetime_modif DATETIME DEFAULT \'NULL\', INDEX fk_cr_user_id (user_id), INDEX fk_cr_reu_id (reu_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE membres_balades (id INT AUTO_INCREMENT NOT NULL, bal_id INT UNSIGNED DEFAULT NULL, user_id INT UNSIGNED DEFAULT NULL, INDEX fk_mb_user_id (user_id), INDEX fk_mb_bal_id (bal_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE photos (id INT UNSIGNED AUTO_INCREMENT NOT NULL, bal_id INT UNSIGNED DEFAULT NULL, file_name VARCHAR(80) NOT NULL, legende VARCHAR(50) DEFAULT \'NULL\', datetime_post DATETIME NOT NULL, INDEX fk_photos_bal_id (bal_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reunions (id INT UNSIGNED AUTO_INCREMENT NOT NULL, user_id INT UNSIGNED DEFAULT NULL, titre VARCHAR(80) NOT NULL, contenu TEXT NOT NULL, datetime_reu DATETIME NOT NULL, lieu_reu VARCHAR(80) NOT NULL, type_reu VARCHAR(30) NOT NULL, datetime_post DATETIME NOT NULL, INDEX fk_reu_user_id (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tokens (id INT UNSIGNED AUTO_INCREMENT NOT NULL, user_id INT UNSIGNED DEFAULT NULL, token VARCHAR(160) NOT NULL, datetime_token DATETIME NOT NULL, INDEX fk_tok_user_id (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE utilisateurs (id INT UNSIGNED AUTO_INCREMENT NOT NULL, email VARCHAR(50) NOT NULL, pwd VARCHAR(80) NOT NULL, acces INT NOT NULL, pseudo VARCHAR(50) DEFAULT \'NULL\', nom VARCHAR(50) DEFAULT \'NULL\', prenom VARCHAR(50) DEFAULT \'NULL\', avatar VARCHAR(120) DEFAULT \'NULL\', datetime_inscription DATETIME NOT NULL, datetime_adhesion DATETIME DEFAULT \'NULL\', UNIQUE INDEX unique_email (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE articles ADD CONSTRAINT FK_BFDD3168A76ED395 FOREIGN KEY (user_id) REFERENCES utilisateurs (id)');
        $this->addSql('ALTER TABLE balades ADD CONSTRAINT FK_3ED88FFA76ED395 FOREIGN KEY (user_id) REFERENCES utilisateurs (id)');
        $this->addSql('ALTER TABLE comptes_rendus ADD CONSTRAINT FK_46141761631BB9D8 FOREIGN KEY (reu_id) REFERENCES reunions (id)');
        $this->addSql('ALTER TABLE comptes_rendus ADD CONSTRAINT FK_46141761A76ED395 FOREIGN KEY (user_id) REFERENCES utilisateurs (id)');
        $this->addSql('ALTER TABLE membres_balades ADD CONSTRAINT FK_A602F006B85C0596 FOREIGN KEY (bal_id) REFERENCES balades (id)');
        $this->addSql('ALTER TABLE membres_balades ADD CONSTRAINT FK_A602F006A76ED395 FOREIGN KEY (user_id) REFERENCES utilisateurs (id)');
        $this->addSql('ALTER TABLE photos ADD CONSTRAINT FK_876E0D9B85C0596 FOREIGN KEY (bal_id) REFERENCES balades (id)');
        $this->addSql('ALTER TABLE reunions ADD CONSTRAINT FK_18E32DA3A76ED395 FOREIGN KEY (user_id) REFERENCES utilisateurs (id)');
        $this->addSql('ALTER TABLE tokens ADD CONSTRAINT FK_AA5A118EA76ED395 FOREIGN KEY (user_id) REFERENCES utilisateurs (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE membres_balades DROP FOREIGN KEY FK_A602F006B85C0596');
        $this->addSql('ALTER TABLE photos DROP FOREIGN KEY FK_876E0D9B85C0596');
        $this->addSql('ALTER TABLE comptes_rendus DROP FOREIGN KEY FK_46141761631BB9D8');
        $this->addSql('ALTER TABLE articles DROP FOREIGN KEY FK_BFDD3168A76ED395');
        $this->addSql('ALTER TABLE balades DROP FOREIGN KEY FK_3ED88FFA76ED395');
        $this->addSql('ALTER TABLE comptes_rendus DROP FOREIGN KEY FK_46141761A76ED395');
        $this->addSql('ALTER TABLE membres_balades DROP FOREIGN KEY FK_A602F006A76ED395');
        $this->addSql('ALTER TABLE reunions DROP FOREIGN KEY FK_18E32DA3A76ED395');
        $this->addSql('ALTER TABLE tokens DROP FOREIGN KEY FK_AA5A118EA76ED395');
        $this->addSql('DROP TABLE articles');
        $this->addSql('DROP TABLE balades');
        $this->addSql('DROP TABLE comptes_rendus');
        $this->addSql('DROP TABLE membres_balades');
        $this->addSql('DROP TABLE photos');
        $this->addSql('DROP TABLE reunions');
        $this->addSql('DROP TABLE tokens');
        $this->addSql('DROP TABLE utilisateurs');
    }
}
