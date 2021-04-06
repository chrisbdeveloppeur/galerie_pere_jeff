<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210406193342 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE groupe_galeries (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE oeuvre ADD groupe_galeries_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE oeuvre ADD CONSTRAINT FK_35FE2EFE64988645 FOREIGN KEY (groupe_galeries_id) REFERENCES groupe_galeries (id)');
        $this->addSql('CREATE INDEX IDX_35FE2EFE64988645 ON oeuvre (groupe_galeries_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE oeuvre DROP FOREIGN KEY FK_35FE2EFE64988645');
        $this->addSql('DROP TABLE groupe_galeries');
        $this->addSql('DROP INDEX IDX_35FE2EFE64988645 ON oeuvre');
        $this->addSql('ALTER TABLE oeuvre DROP groupe_galeries_id');
    }
}
