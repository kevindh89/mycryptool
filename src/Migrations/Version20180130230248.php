<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180130230248 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE trade_order (order_id VARCHAR(255) NOT NULL, order_created_at DATETIME NOT NULL, product_id VARCHAR(20) NOT NULL, price NUMERIC(24, 8) NOT NULL, size NUMERIC(24, 8) NOT NULL, side VARCHAR(255) NOT NULL, settled TINYINT(1) NOT NULL, fill_fees NUMERIC(24, 12) NOT NULL, stp VARCHAR(10) NOT NULL, type VARCHAR(255) NOT NULL, time_in_force VARCHAR(255) NOT NULL, filled_size NUMERIC(24, 8) NOT NULL, executed_value NUMERIC(24, 12) NOT NULL, status VARCHAR(255) NOT NULL, PRIMARY KEY(order_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE trade_order');
    }
}
