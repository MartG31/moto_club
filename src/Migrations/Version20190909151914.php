<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190909151914 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE articles CHANGE user_id user_id INT UNSIGNED DEFAULT NULL, CHANGE cat_id cat_id INT UNSIGNED DEFAULT NULL');
        $this->addSql('ALTER TABLE commentaires CHANGE art_id art_id INT UNSIGNED DEFAULT NULL, CHANGE user_id user_id INT UNSIGNED DEFAULT NULL');
        $this->addSql('ALTER TABLE comptes_rendus CHANGE id id INT UNSIGNED AUTO_INCREMENT NOT NULL, CHANGE reu_id reu_id INT UNSIGNED DEFAULT NULL');
        $this->addSql('ALTER TABLE membres_balades CHANGE user_id user_id INT UNSIGNED DEFAULT NULL, CHANGE bal_id bal_id INT UNSIGNED DEFAULT NULL');
        $this->addSql('ALTER TABLE photos CHANGE bal_id bal_id INT UNSIGNED DEFAULT NULL');
        $this->addSql('ALTER TABLE tokens CHANGE user_id user_id INT UNSIGNED DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE articles CHANGE cat_id cat_id INT UNSIGNED NOT NULL, CHANGE user_id user_id INT UNSIGNED NOT NULL');
        $this->addSql('ALTER TABLE commentaires CHANGE art_id art_id INT UNSIGNED NOT NULL, CHANGE user_id user_id INT UNSIGNED NOT NULL');
        $this->addSql('ALTER TABLE comptes_rendus CHANGE id id INT UNSIGNED NOT NULL, CHANGE reu_id reu_id INT UNSIGNED NOT NULL');
        $this->addSql('ALTER TABLE membres_balades CHANGE bal_id bal_id INT UNSIGNED NOT NULL, CHANGE user_id user_id INT UNSIGNED NOT NULL');
        $this->addSql('ALTER TABLE photos CHANGE bal_id bal_id INT UNSIGNED NOT NULL');
        $this->addSql('ALTER TABLE tokens CHANGE user_id user_id INT UNSIGNED NOT NULL');
    }
}
