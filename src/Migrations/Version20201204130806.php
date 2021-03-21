<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201204130806 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE academic_unit (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, phone VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE address (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, street VARCHAR(255) NOT NULL, number INT DEFAULT NULL, latitude DOUBLE PRECISION DEFAULT NULL, longitude DOUBLE PRECISION DEFAULT NULL, phone_number VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `admin` (id INT NOT NULL, name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, dni VARCHAR(255) NOT NULL, cuit VARCHAR(255) NOT NULL, cell_phone VARCHAR(255) NOT NULL, position VARCHAR(255) DEFAULT NULL, job VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE city (id INT AUTO_INCREMENT NOT NULL, province_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_2D5B0234E946114A (province_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE country (id INT AUTO_INCREMENT NOT NULL, code VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE graduate (id INT NOT NULL, work VARCHAR(255) DEFAULT NULL, position VARCHAR(255) DEFAULT NULL, continue_studing TINYINT(1) DEFAULT NULL, interest VARCHAR(255) DEFAULT NULL, want_to_link TINYINT(1) DEFAULT NULL, agreement_type VARCHAR(255) DEFAULT NULL, want_to_under_take TINYINT(1) DEFAULT NULL, comment VARCHAR(255) DEFAULT NULL, show_email TINYINT(1) DEFAULT NULL, born_date DATETIME DEFAULT NULL, facebook VARCHAR(255) DEFAULT NULL, instagram VARCHAR(255) DEFAULT NULL, twitter VARCHAR(255) DEFAULT NULL, personal_site VARCHAR(255) DEFAULT NULL, name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, dni VARCHAR(255) NOT NULL, cuit VARCHAR(255) NOT NULL, cell_phone VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_89E62277F8F253B (dni), UNIQUE INDEX UNIQ_89E6227B9BA4881 (cuit), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE graduate_address (graduate_id INT NOT NULL, address_id INT NOT NULL, INDEX IDX_8180848D1B3F223B (graduate_id), INDEX IDX_8180848DF5B7AF75 (address_id), PRIMARY KEY(graduate_id, address_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE media_object (id INT AUTO_INCREMENT NOT NULL, file_path VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE owner (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE profession (id INT AUTO_INCREMENT NOT NULL, academic_unit_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, type VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_BA930D697D33BAAB (academic_unit_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE province (id INT AUTO_INCREMENT NOT NULL, country_id INT DEFAULT NULL, code VARCHAR(255) DEFAULT NULL, name VARCHAR(255) NOT NULL, abbreviation VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_4ADAD40BF92F3E70 (country_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sale (id INT AUTO_INCREMENT NOT NULL, sale_type_id INT DEFAULT NULL, store_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, date_publication DATETIME DEFAULT NULL, date_expiration DATETIME DEFAULT NULL, revised TINYINT(1) DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_E54BC005B0524E01 (sale_type_id), INDEX IDX_E54BC005B092A811 (store_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sale_media_object (sale_id INT NOT NULL, media_object_id INT NOT NULL, INDEX IDX_27A660064A7E4868 (sale_id), INDEX IDX_27A6600664DE5A5 (media_object_id), PRIMARY KEY(sale_id, media_object_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sale_type (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sale_type_media_object (sale_type_id INT NOT NULL, media_object_id INT NOT NULL, INDEX IDX_179924B8B0524E01 (sale_type_id), INDEX IDX_179924B864DE5A5 (media_object_id), PRIMARY KEY(sale_type_id, media_object_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE store (id INT AUTO_INCREMENT NOT NULL, address_id INT DEFAULT NULL, owner_id INT NOT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, phone VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, UNIQUE INDEX UNIQ_FF575877F5B7AF75 (address_id), INDEX IDX_FF5758777E3C61F9 (owner_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');


        $this->addSql('
                CREATE TABLE user (
                    id INT AUTO_INCREMENT NOT NULL, 
                    email VARCHAR(191) NOT NULL, 
                    roles JSON NOT NULL, 
                    password VARCHAR(255) DEFAULT NULL, 
                    username VARCHAR(191) NOT NULL, 
                    is_active TINYINT(1) NOT NULL, 
                    api_token VARCHAR(255) DEFAULT NULL, 
                    id_firebase VARCHAR(255) DEFAULT NULL, 
                    discr VARCHAR(255) NOT NULL, 
                    password_change_date INT DEFAULT NULL,
                    created_at DATETIME NOT NULL default CURRENT_TIMESTAMP , 
                    updated_at DATETIME NOT NULL default CURRENT_TIMESTAMP, 
                    UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), 
                    UNIQUE INDEX UNIQ_8D93D649F85E0677 (username), 
                    PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');


        $this->addSql('CREATE TABLE zone (id INT AUTO_INCREMENT NOT NULL, city_id INT DEFAULT NULL, code VARCHAR(255) DEFAULT NULL, name VARCHAR(255) NOT NULL, type VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_A0EBC0078BAC62AF (city_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE `admin` ADD CONSTRAINT FK_880E0D76BF396750 FOREIGN KEY (id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE city ADD CONSTRAINT FK_2D5B0234E946114A FOREIGN KEY (province_id) REFERENCES province (id)');
        $this->addSql('ALTER TABLE graduate ADD CONSTRAINT FK_89E6227BF396750 FOREIGN KEY (id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE graduate_address ADD CONSTRAINT FK_8180848D1B3F223B FOREIGN KEY (graduate_id) REFERENCES graduate (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE graduate_address ADD CONSTRAINT FK_8180848DF5B7AF75 FOREIGN KEY (address_id) REFERENCES address (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE profession ADD CONSTRAINT FK_BA930D697D33BAAB FOREIGN KEY (academic_unit_id) REFERENCES academic_unit (id)');
        $this->addSql('ALTER TABLE province ADD CONSTRAINT FK_4ADAD40BF92F3E70 FOREIGN KEY (country_id) REFERENCES country (id)');
        $this->addSql('ALTER TABLE sale ADD CONSTRAINT FK_E54BC005B0524E01 FOREIGN KEY (sale_type_id) REFERENCES sale_type (id)');
        $this->addSql('ALTER TABLE sale ADD CONSTRAINT FK_E54BC005B092A811 FOREIGN KEY (store_id) REFERENCES store (id)');
        $this->addSql('ALTER TABLE sale_media_object ADD CONSTRAINT FK_27A660064A7E4868 FOREIGN KEY (sale_id) REFERENCES sale (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE sale_media_object ADD CONSTRAINT FK_27A6600664DE5A5 FOREIGN KEY (media_object_id) REFERENCES media_object (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE sale_type_media_object ADD CONSTRAINT FK_179924B8B0524E01 FOREIGN KEY (sale_type_id) REFERENCES sale_type (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE sale_type_media_object ADD CONSTRAINT FK_179924B864DE5A5 FOREIGN KEY (media_object_id) REFERENCES media_object (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE store ADD CONSTRAINT FK_FF575877F5B7AF75 FOREIGN KEY (address_id) REFERENCES address (id)');
        $this->addSql('ALTER TABLE store ADD CONSTRAINT FK_FF5758777E3C61F9 FOREIGN KEY (owner_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE zone ADD CONSTRAINT FK_A0EBC0078BAC62AF FOREIGN KEY (city_id) REFERENCES city (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE profession DROP FOREIGN KEY FK_BA930D697D33BAAB');
        $this->addSql('ALTER TABLE graduate_address DROP FOREIGN KEY FK_8180848DF5B7AF75');
        $this->addSql('ALTER TABLE store DROP FOREIGN KEY FK_FF575877F5B7AF75');
        $this->addSql('ALTER TABLE zone DROP FOREIGN KEY FK_A0EBC0078BAC62AF');
        $this->addSql('ALTER TABLE province DROP FOREIGN KEY FK_4ADAD40BF92F3E70');
        $this->addSql('ALTER TABLE graduate_address DROP FOREIGN KEY FK_8180848D1B3F223B');
        $this->addSql('ALTER TABLE sale_media_object DROP FOREIGN KEY FK_27A6600664DE5A5');
        $this->addSql('ALTER TABLE sale_type_media_object DROP FOREIGN KEY FK_179924B864DE5A5');
        $this->addSql('ALTER TABLE city DROP FOREIGN KEY FK_2D5B0234E946114A');
        $this->addSql('ALTER TABLE sale_media_object DROP FOREIGN KEY FK_27A660064A7E4868');
        $this->addSql('ALTER TABLE sale DROP FOREIGN KEY FK_E54BC005B0524E01');
        $this->addSql('ALTER TABLE sale_type_media_object DROP FOREIGN KEY FK_179924B8B0524E01');
        $this->addSql('ALTER TABLE sale DROP FOREIGN KEY FK_E54BC005B092A811');
        $this->addSql('ALTER TABLE `admin` DROP FOREIGN KEY FK_880E0D76BF396750');
        $this->addSql('ALTER TABLE graduate DROP FOREIGN KEY FK_89E6227BF396750');
        $this->addSql('ALTER TABLE store DROP FOREIGN KEY FK_FF5758777E3C61F9');
        $this->addSql('DROP TABLE academic_unit');
        $this->addSql('DROP TABLE address');
        $this->addSql('DROP TABLE `admin`');
        $this->addSql('DROP TABLE city');
        $this->addSql('DROP TABLE country');
        $this->addSql('DROP TABLE graduate');
        $this->addSql('DROP TABLE graduate_address');
        $this->addSql('DROP TABLE media_object');
        $this->addSql('DROP TABLE owner');
        $this->addSql('DROP TABLE profession');
        $this->addSql('DROP TABLE province');
        $this->addSql('DROP TABLE sale');
        $this->addSql('DROP TABLE sale_media_object');
        $this->addSql('DROP TABLE sale_type');
        $this->addSql('DROP TABLE sale_type_media_object');
        $this->addSql('DROP TABLE store');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE zone');
    }
}
