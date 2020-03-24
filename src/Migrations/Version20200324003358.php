<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200324003358 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE sale ADD store_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE sale ADD CONSTRAINT FK_E54BC005B092A811 FOREIGN KEY (store_id) REFERENCES store (id)');
        $this->addSql('CREATE INDEX IDX_E54BC005B092A811 ON sale (store_id)');
        $this->addSql('ALTER TABLE store ADD address_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE store ADD CONSTRAINT FK_FF575877F5B7AF75 FOREIGN KEY (address_id) REFERENCES address (id)');
        $this->addSql('CREATE INDEX IDX_FF575877F5B7AF75 ON store (address_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE sale DROP FOREIGN KEY FK_E54BC005B092A811');
        $this->addSql('DROP INDEX IDX_E54BC005B092A811 ON sale');
        $this->addSql('ALTER TABLE sale DROP store_id');
        $this->addSql('ALTER TABLE store DROP FOREIGN KEY FK_FF575877F5B7AF75');
        $this->addSql('DROP INDEX IDX_FF575877F5B7AF75 ON store');
        $this->addSql('ALTER TABLE store DROP address_id');
    }
}
