<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180130145143 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE trade (trade_id INT NOT NULL, created_at DATE NOT NULL, product_id VARCHAR(20) NOT NULL, order_id VARCHAR(255) NOT NULL, user_id VARCHAR(255) NOT NULL, profile_id VARCHAR(255) NOT NULL, liquidity VARCHAR(255) NOT NULL, price NUMERIC(24, 8) NOT NULL, size NUMERIC(24, 8) NOT NULL, fee NUMERIC(24, 16) NOT NULL, side VARCHAR(255) NOT NULL, settled TINYINT(1) NOT NULL, PRIMARY KEY(trade_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE trade');
    }
}
