<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201114105139 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE sale_type_media_object (sale_type_id INT NOT NULL, media_object_id INT NOT NULL, INDEX IDX_179924B8B0524E01 (sale_type_id), INDEX IDX_179924B864DE5A5 (media_object_id), PRIMARY KEY(sale_type_id, media_object_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE sale_type_media_object ADD CONSTRAINT FK_179924B8B0524E01 FOREIGN KEY (sale_type_id) REFERENCES sale_type (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE sale_type_media_object ADD CONSTRAINT FK_179924B864DE5A5 FOREIGN KEY (media_object_id) REFERENCES media_object (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE sale_type DROP FOREIGN KEY FK_309023CC3DA5256D');
        $this->addSql('DROP INDEX IDX_309023CC3DA5256D ON sale_type');
        $this->addSql('ALTER TABLE sale_type DROP image_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE sale_type_media_object');
        $this->addSql('ALTER TABLE sale_type ADD image_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE sale_type ADD CONSTRAINT FK_309023CC3DA5256D FOREIGN KEY (image_id) REFERENCES media_object (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_309023CC3DA5256D ON sale_type (image_id)');
    }
}
