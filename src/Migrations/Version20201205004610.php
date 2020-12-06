<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201205004610 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE sale_type ADD imagen_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE sale_type ADD CONSTRAINT FK_309023CC763C8AA7 FOREIGN KEY (imagen_id) REFERENCES media_object (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_309023CC763C8AA7 ON sale_type (imagen_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE sale_type DROP FOREIGN KEY FK_309023CC763C8AA7');
        $this->addSql('DROP INDEX UNIQ_309023CC763C8AA7 ON sale_type');
        $this->addSql('ALTER TABLE sale_type DROP imagen_id');
    }
}
