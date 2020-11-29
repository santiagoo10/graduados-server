<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201128114107 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE store_owner');
        $this->addSql('ALTER TABLE store ADD owner_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE store ADD CONSTRAINT FK_FF5758777E3C61F9 FOREIGN KEY (owner_id) REFERENCES owner (id)');
        $this->addSql('CREATE INDEX IDX_FF5758777E3C61F9 ON store (owner_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE store_owner (store_id INT NOT NULL, owner_id INT NOT NULL, INDEX IDX_B35EB0657E3C61F9 (owner_id), INDEX IDX_B35EB065B092A811 (store_id), PRIMARY KEY(store_id, owner_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE store_owner ADD CONSTRAINT FK_B35EB0657E3C61F9 FOREIGN KEY (owner_id) REFERENCES owner (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE store_owner ADD CONSTRAINT FK_B35EB065B092A811 FOREIGN KEY (store_id) REFERENCES store (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE store DROP FOREIGN KEY FK_FF5758777E3C61F9');
        $this->addSql('DROP INDEX IDX_FF5758777E3C61F9 ON store');
        $this->addSql('ALTER TABLE store DROP owner_id');
    }
}
