<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200306004550 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE academic_unit ADD contacto_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE academic_unit ADD CONSTRAINT FK_406398456B505CA9 FOREIGN KEY (contacto_id) REFERENCES person (id)');
        $this->addSql('CREATE INDEX IDX_406398456B505CA9 ON academic_unit (contacto_id)');
        $this->addSql('ALTER TABLE profession ADD academic_unit_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE profession ADD CONSTRAINT FK_BA930D697D33BAAB FOREIGN KEY (academic_unit_id) REFERENCES academic_unit (id)');
        $this->addSql('CREATE INDEX IDX_BA930D697D33BAAB ON profession (academic_unit_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE user');
        $this->addSql('ALTER TABLE academic_unit DROP FOREIGN KEY FK_406398456B505CA9');
        $this->addSql('DROP INDEX IDX_406398456B505CA9 ON academic_unit');
        $this->addSql('ALTER TABLE academic_unit DROP contacto_id');
        $this->addSql('ALTER TABLE profession DROP FOREIGN KEY FK_BA930D697D33BAAB');
        $this->addSql('DROP INDEX IDX_BA930D697D33BAAB ON profession');
        $this->addSql('ALTER TABLE profession DROP academic_unit_id');
    }
}
