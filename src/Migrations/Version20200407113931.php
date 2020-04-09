<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200407113931 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE graduate (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, dni VARCHAR(255) DEFAULT NULL, cuit VARCHAR(255) DEFAULT NULL, cell_phone VARCHAR(255) DEFAULT NULL, email VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, work VARCHAR(255) DEFAULT NULL, position VARCHAR(255) DEFAULT NULL, continue_studing TINYINT(1) DEFAULT NULL, interest VARCHAR(255) DEFAULT NULL, want_to_link TINYINT(1) DEFAULT NULL, agreement_type VARCHAR(255) DEFAULT NULL, want_to_under_take TINYINT(1) DEFAULT NULL, comment VARCHAR(255) DEFAULT NULL, show_email TINYINT(1) DEFAULT NULL, born_date DATETIME DEFAULT NULL, facebook VARCHAR(255) DEFAULT NULL, instagram VARCHAR(255) DEFAULT NULL, twitter VARCHAR(255) DEFAULT NULL, personal_site VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE graduate_profession (graduate_id INT NOT NULL, profession_id INT NOT NULL, INDEX IDX_72DF31111B3F223B (graduate_id), INDEX IDX_72DF3111FDEF8996 (profession_id), PRIMARY KEY(graduate_id, profession_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE graduate_profession ADD CONSTRAINT FK_72DF31111B3F223B FOREIGN KEY (graduate_id) REFERENCES graduate (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE graduate_profession ADD CONSTRAINT FK_72DF3111FDEF8996 FOREIGN KEY (profession_id) REFERENCES profession (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE person DROP INDEX UNIQ_34DCD176A76ED395, ADD INDEX IDX_34DCD176A76ED395 (user_id)');
        $this->addSql('ALTER TABLE person_address DROP FOREIGN KEY FK_2FD0DC08217BBB47');
        $this->addSql('ALTER TABLE person_address DROP FOREIGN KEY FK_2FD0DC08F5B7AF75');
        $this->addSql('ALTER TABLE person_address ADD CONSTRAINT FK_2FD0DC08217BBB47 FOREIGN KEY (person_id) REFERENCES person (id)');
        $this->addSql('ALTER TABLE person_address ADD CONSTRAINT FK_2FD0DC08F5B7AF75 FOREIGN KEY (address_id) REFERENCES address (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE graduate_profession DROP FOREIGN KEY FK_72DF31111B3F223B');
        $this->addSql('DROP TABLE graduate');
        $this->addSql('DROP TABLE graduate_profession');
        $this->addSql('ALTER TABLE person DROP INDEX IDX_34DCD176A76ED395, ADD UNIQUE INDEX UNIQ_34DCD176A76ED395 (user_id)');
        $this->addSql('ALTER TABLE person_address DROP FOREIGN KEY FK_2FD0DC08217BBB47');
        $this->addSql('ALTER TABLE person_address DROP FOREIGN KEY FK_2FD0DC08F5B7AF75');
        $this->addSql('ALTER TABLE person_address ADD CONSTRAINT FK_2FD0DC08217BBB47 FOREIGN KEY (person_id) REFERENCES person (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE person_address ADD CONSTRAINT FK_2FD0DC08F5B7AF75 FOREIGN KEY (address_id) REFERENCES address (id) ON DELETE CASCADE');
    }
}
