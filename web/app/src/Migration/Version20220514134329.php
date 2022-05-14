<?php

declare(strict_types=1);

namespace App\Acme\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20220514134329 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE User (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(255) NOT NULL, passwordHash VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');

        $pass1 = password_hash('pass1', null);
        $pass2 = password_hash('pass2', null);
        $pass3 = password_hash('pass3', null);

        $this->addSql(<<<SQL
        INSERT INTO User (username, passwordHash)
        VALUES ('user1', '$pass1'), ('user2', '$pass2'), ('user3', '$pass3')
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE User');
    }
}
