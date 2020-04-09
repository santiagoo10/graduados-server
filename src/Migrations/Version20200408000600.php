<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200408000600 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE academic_unit DROP FOREIGN KEY FK_406398456B505CA9');
        $this->addSql('DROP INDEX IDX_406398456B505CA9 ON academic_unit');
        $this->addSql('ALTER TABLE academic_unit DROP contacto_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE academic_unit ADD contacto_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE academic_unit ADD CONSTRAINT FK_406398456B505CA9 FOREIGN KEY (contacto_id) REFERENCES person (id)');
        $this->addSql('CREATE INDEX IDX_406398456B505CA9 ON academic_unit (contacto_id)');
    }
}
