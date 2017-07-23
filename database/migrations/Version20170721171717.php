<?php

namespace Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170721171717 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('INSERT INTO `auto`.`mark` (`name`) VALUES (\'bmw\');
            INSERT INTO `auto`.`mark` (`name`) VALUES (\'audi\');
            INSERT INTO `auto`.`mark` (`name`) VALUES (\'ford\');
        ');
        $this->addSql('INSERT INTO `auto`.`model` (`mark_id`, `name`) VALUES (\'1\', \'302\');
            INSERT INTO `auto`.`model` (`mark_id`, `name`) VALUES (\'2\', \'A5\');
            INSERT INTO `auto`.`model` (`mark_id`, `name`) VALUES (\'3\', \'Mustang\');
        ');
        $this->addSql('INSERT INTO `auto`.`maintenance_type` (`name`) VALUES (\'oil change\');
            INSERT INTO `auto`.`maintenance_type` (`name`) VALUES (\'tire rotation\');
        ');
        $this->addSql('
            INSERT INTO `auto`.`car_type` (`type`) VALUES (\'electric\');
            INSERT INTO `auto`.`car_type` (`type`) VALUES (\'gas\');
            INSERT INTO `auto`.`car_type` (`type`) VALUES (\'diesel\');
        ');
        $this->addSql('INSERT INTO `auto`.`maintenance_rule` (`car_type_id`, `maintenance_type_id`, `km`) VALUES (\'1\', \'2\', \'120000\');
            INSERT INTO `auto`.`maintenance_rule` (`car_type_id`, `maintenance_type_id`, `km`) VALUES (\'2\', \'1\', \'12000\');
            INSERT INTO `auto`.`maintenance_rule` (`car_type_id`, `maintenance_type_id`, `km`) VALUES (\'2\', \'2\', \'80000\');
            INSERT INTO `auto`.`maintenance_rule` (`car_type_id`, `maintenance_type_id`, `km`) VALUES (\'3\', \'1\', \'7000\');
            INSERT INTO `auto`.`maintenance_rule` (`car_type_id`, `maintenance_type_id`, `km`) VALUES (\'3\', \'2\', \'50000\');
        ');
        $this->addSql('INSERT INTO `auto`.`car` (`car_type_id`, `model_id`, `vin`, `year`, `km`) VALUES (\'2\', \'1\', \'BWN-6006\', \'2013\', \'45230\');');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs

    }
}
