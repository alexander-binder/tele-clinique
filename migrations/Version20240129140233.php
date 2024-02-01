<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240129140233 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE test_resource2 (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, public_data LONGTEXT NOT NULL, private_user_data LONGTEXT NOT NULL, admin_only_data LONGTEXT NOT NULL, INDEX IDX_6C200D62A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE test_resource2 ADD CONSTRAINT FK_6C200D62A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE test_resource2 DROP FOREIGN KEY FK_6C200D62A76ED395');
        $this->addSql('DROP TABLE test_resource2');
    }
}
