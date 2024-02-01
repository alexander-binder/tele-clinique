<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240125165719 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE test_resource ADD user_id INT NOT NULL');
        $this->addSql('ALTER TABLE test_resource ADD CONSTRAINT FK_29F2FF40A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_29F2FF40A76ED395 ON test_resource (user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE test_resource DROP FOREIGN KEY FK_29F2FF40A76ED395');
        $this->addSql('DROP INDEX IDX_29F2FF40A76ED395 ON test_resource');
        $this->addSql('ALTER TABLE test_resource DROP user_id');
    }
}
