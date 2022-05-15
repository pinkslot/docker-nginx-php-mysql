<?php

declare(strict_types=1);

namespace App\Acme\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220515104901 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE BonusesPrize (
            id INT AUTO_INCREMENT NOT NULL,
            user_id INT DEFAULT NULL,
            amount INT NOT NULL,
            INDEX IDX_3177E621A76ED395 (user_id),
            PRIMARY KEY(id)
        ) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE MoneyPrize (
            id INT AUTO_INCREMENT NOT NULL,
            user_id INT DEFAULT NULL,
            amount INT NOT NULL,
            INDEX IDX_6DFD7409A76ED395 (user_id),
            PRIMARY KEY(id)
        ) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql(
            'ALTER TABLE BonusesPrize ADD CONSTRAINT FK_3177E621A76ED395 FOREIGN KEY (user_id) REFERENCES User (id)'
        );
        $this->addSql(
            'ALTER TABLE MoneyPrize ADD CONSTRAINT FK_6DFD7409A76ED395 FOREIGN KEY (user_id) REFERENCES User (id)'
        );
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE BonusesPrize');
        $this->addSql('DROP TABLE MoneyPrize');
    }
}
