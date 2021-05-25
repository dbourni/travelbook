<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210503141553 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE travel DROP FOREIGN KEY FK_2D0B6BCEF92F3E70');
        $this->addSql('DROP TABLE country');
        $this->addSql('DROP INDEX IDX_2D0B6BCEF92F3E70 ON travel');
        $this->addSql('ALTER TABLE travel ADD country VARCHAR(255) DEFAULT NULL, DROP country_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE country (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE travel ADD country_id INT DEFAULT NULL, DROP country');
        $this->addSql('ALTER TABLE travel ADD CONSTRAINT FK_2D0B6BCEF92F3E70 FOREIGN KEY (country_id) REFERENCES country (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_2D0B6BCEF92F3E70 ON travel (country_id)');
    }
}
