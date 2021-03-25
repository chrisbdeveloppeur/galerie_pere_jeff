<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210325213355 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE oeuvre DROP FOREIGN KEY FK_35FE2EFE68A20D5');
        $this->addSql('ALTER TABLE oeuvre ADD CONSTRAINT FK_35FE2EFE68A20D5 FOREIGN KEY (year_directory_id) REFERENCES year_directory (id) ON DELETE SET NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE oeuvre DROP FOREIGN KEY FK_35FE2EFE68A20D5');
        $this->addSql('ALTER TABLE oeuvre ADD CONSTRAINT FK_35FE2EFE68A20D5 FOREIGN KEY (year_directory_id) REFERENCES year_directory (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
    }
}
