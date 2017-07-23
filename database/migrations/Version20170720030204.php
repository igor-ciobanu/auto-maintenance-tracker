<?php

namespace Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170720030204 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE maintenance_rule (id INT AUTO_INCREMENT NOT NULL, car_type_id INT DEFAULT NULL, maintenance_type_id INT DEFAULT NULL, km INT NOT NULL, INDEX index2 (car_type_id), INDEX index3 (maintenance_type_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE mark (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(45) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE model (id INT AUTO_INCREMENT NOT NULL, mark_id INT DEFAULT NULL, name VARCHAR(45) NOT NULL, INDEX index2 (mark_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE maintenance_history (id INT AUTO_INCREMENT NOT NULL, car_id INT DEFAULT NULL, maintenance_rule_id INT DEFAULT NULL, km INT NOT NULL, INDEX index2 (car_id), INDEX index3 (maintenance_rule_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE maintenance_type (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(45) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE car_type (id INT AUTO_INCREMENT NOT NULL, type VARCHAR(45) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE car (id INT AUTO_INCREMENT NOT NULL, car_type_id INT DEFAULT NULL, model_id INT DEFAULT NULL, vin VARCHAR(10) NOT NULL, year INT(4) NOT NULL, km INT NOT NULL, INDEX index2 (car_type_id), INDEX index3 (model_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE maintenance_rule ADD CONSTRAINT FK_89CBCC0096E7774F FOREIGN KEY (car_type_id) REFERENCES car_type (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE maintenance_rule ADD CONSTRAINT FK_89CBCC00BCBAC901 FOREIGN KEY (maintenance_type_id) REFERENCES maintenance_type (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE model ADD CONSTRAINT FK_D79572D94290F12B FOREIGN KEY (mark_id) REFERENCES mark (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE maintenance_history ADD CONSTRAINT FK_5E4C35D9C3C6F69F FOREIGN KEY (car_id) REFERENCES car (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE maintenance_history ADD CONSTRAINT FK_5E4C35D9DB846C3 FOREIGN KEY (maintenance_rule_id) REFERENCES maintenance_rule (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE car ADD CONSTRAINT FK_773DE69D96E7774F FOREIGN KEY (car_type_id) REFERENCES car_type (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE car ADD CONSTRAINT FK_773DE69D7975B7E7 FOREIGN KEY (model_id) REFERENCES model (id) ON DELETE CASCADE');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE maintenance_history DROP FOREIGN KEY FK_5E4C35D9DB846C3');
        $this->addSql('ALTER TABLE model DROP FOREIGN KEY FK_D79572D94290F12B');
        $this->addSql('ALTER TABLE car DROP FOREIGN KEY FK_773DE69D7975B7E7');
        $this->addSql('ALTER TABLE maintenance_rule DROP FOREIGN KEY FK_89CBCC00BCBAC901');
        $this->addSql('ALTER TABLE maintenance_rule DROP FOREIGN KEY FK_89CBCC0096E7774F');
        $this->addSql('ALTER TABLE car DROP FOREIGN KEY FK_773DE69D96E7774F');
        $this->addSql('ALTER TABLE maintenance_history DROP FOREIGN KEY FK_5E4C35D9C3C6F69F');
        $this->addSql('DROP TABLE maintenance_rule');
        $this->addSql('DROP TABLE mark');
        $this->addSql('DROP TABLE model');
        $this->addSql('DROP TABLE maintenance_history');
        $this->addSql('DROP TABLE maintenance_type');
        $this->addSql('DROP TABLE car_type');
        $this->addSql('DROP TABLE car');
    }
}
