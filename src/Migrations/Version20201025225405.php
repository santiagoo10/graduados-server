<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201025225405 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE graduate_address (graduate_id INT NOT NULL, address_id INT NOT NULL, INDEX IDX_8180848D1B3F223B (graduate_id), INDEX IDX_8180848DF5B7AF75 (address_id), PRIMARY KEY(graduate_id, address_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE graduate_address ADD CONSTRAINT FK_8180848D1B3F223B FOREIGN KEY (graduate_id) REFERENCES graduate (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE graduate_address ADD CONSTRAINT FK_8180848DF5B7AF75 FOREIGN KEY (address_id) REFERENCES address (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE graduate DROP FOREIGN KEY FK_89E6227F5B7AF75');
        $this->addSql('DROP INDEX UNIQ_89E6227F5B7AF75 ON graduate');
        $this->addSql('ALTER TABLE graduate DROP address_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE graduate_address');
        $this->addSql('ALTER TABLE graduate ADD address_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE graduate ADD CONSTRAINT FK_89E6227F5B7AF75 FOREIGN KEY (address_id) REFERENCES address (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_89E6227F5B7AF75 ON graduate (address_id)');
    }
}
