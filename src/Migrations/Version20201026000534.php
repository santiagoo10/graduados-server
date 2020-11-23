<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201026000534 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE store_address (store_id INT NOT NULL, address_id INT NOT NULL, INDEX IDX_14464E66B092A811 (store_id), INDEX IDX_14464E66F5B7AF75 (address_id), PRIMARY KEY(store_id, address_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE store_owner (store_id INT NOT NULL, owner_id INT NOT NULL, INDEX IDX_B35EB065B092A811 (store_id), INDEX IDX_B35EB0657E3C61F9 (owner_id), PRIMARY KEY(store_id, owner_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE store_address ADD CONSTRAINT FK_14464E66B092A811 FOREIGN KEY (store_id) REFERENCES store (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE store_address ADD CONSTRAINT FK_14464E66F5B7AF75 FOREIGN KEY (address_id) REFERENCES address (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE store_owner ADD CONSTRAINT FK_B35EB065B092A811 FOREIGN KEY (store_id) REFERENCES store (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE store_owner ADD CONSTRAINT FK_B35EB0657E3C61F9 FOREIGN KEY (owner_id) REFERENCES owner (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE owner ADD id_firebase VARCHAR(255) NOT NULL, DROP uid_firebase');
        $this->addSql('ALTER TABLE store DROP FOREIGN KEY FK_FF5758777E3C61F9');
        $this->addSql('ALTER TABLE store DROP FOREIGN KEY FK_FF575877F5B7AF75');
        $this->addSql('DROP INDEX IDX_FF5758777E3C61F9 ON store');
        $this->addSql('DROP INDEX IDX_FF575877F5B7AF75 ON store');
        $this->addSql('ALTER TABLE store DROP address_id, DROP owner_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE store_address');
        $this->addSql('DROP TABLE store_owner');
        $this->addSql('ALTER TABLE owner ADD uid_firebase VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, DROP id_firebase');
        $this->addSql('ALTER TABLE store ADD address_id INT DEFAULT NULL, ADD owner_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE store ADD CONSTRAINT FK_FF5758777E3C61F9 FOREIGN KEY (owner_id) REFERENCES owner (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE store ADD CONSTRAINT FK_FF575877F5B7AF75 FOREIGN KEY (address_id) REFERENCES address (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_FF5758777E3C61F9 ON store (owner_id)');
        $this->addSql('CREATE INDEX IDX_FF575877F5B7AF75 ON store (address_id)');
    }
}
