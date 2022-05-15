<?php

declare(strict_types=1);

namespace App\Acme\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220515111257 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE MoneyDeposit (
            id INT AUTO_INCREMENT NOT NULL, 
            amount INT NOT NULL, PRIMARY KEY(id)
        ) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');

        $this->addSql(<<<SQL
        INSERT INTO MoneyDeposit (amount)
        VALUES (10000), (15000)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE MoneyDeposit');
    }
}
