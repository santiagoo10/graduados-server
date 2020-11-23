<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201025202706 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE graduate_profession');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE graduate_profession (graduate_id INT NOT NULL, profession_id INT NOT NULL, INDEX IDX_72DF31111B3F223B (graduate_id), INDEX IDX_72DF3111FDEF8996 (profession_id), PRIMARY KEY(graduate_id, profession_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE graduate_profession ADD CONSTRAINT FK_72DF31111B3F223B FOREIGN KEY (graduate_id) REFERENCES graduate (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE graduate_profession ADD CONSTRAINT FK_72DF3111FDEF8996 FOREIGN KEY (profession_id) REFERENCES profession (id) ON UPDATE NO ACTION ON DELETE CASCADE');
    }
}
