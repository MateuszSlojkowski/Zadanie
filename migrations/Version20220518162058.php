<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220518162058 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE invoice_header ADD user_id INT NOT NULL, ADD sell_to_id INT DEFAULT NULL, ADD sell_from_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE invoice_header ADD CONSTRAINT FK_D5443592A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE invoice_header ADD CONSTRAINT FK_D5443592289D0639 FOREIGN KEY (sell_to_id) REFERENCES clients (id)');
        $this->addSql('ALTER TABLE invoice_header ADD CONSTRAINT FK_D544359211AADE40 FOREIGN KEY (sell_from_id) REFERENCES clients (id)');
        $this->addSql('CREATE INDEX IDX_D5443592A76ED395 ON invoice_header (user_id)');
        $this->addSql('CREATE INDEX IDX_D5443592289D0639 ON invoice_header (sell_to_id)');
        $this->addSql('CREATE INDEX IDX_D544359211AADE40 ON invoice_header (sell_from_id)');
        $this->addSql('ALTER TABLE invoice_lines ADD user_id INT NOT NULL');
        $this->addSql('ALTER TABLE invoice_lines ADD CONSTRAINT FK_72DBDC23A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_72DBDC23A76ED395 ON invoice_lines (user_id)');
        $this->addSql('ALTER TABLE user CHANGE roles roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\'');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE invoice_header DROP FOREIGN KEY FK_D5443592A76ED395');
        $this->addSql('ALTER TABLE invoice_header DROP FOREIGN KEY FK_D5443592289D0639');
        $this->addSql('ALTER TABLE invoice_header DROP FOREIGN KEY FK_D544359211AADE40');
        $this->addSql('DROP INDEX IDX_D5443592A76ED395 ON invoice_header');
        $this->addSql('DROP INDEX IDX_D5443592289D0639 ON invoice_header');
        $this->addSql('DROP INDEX IDX_D544359211AADE40 ON invoice_header');
        $this->addSql('ALTER TABLE invoice_header DROP user_id, DROP sell_to_id, DROP sell_from_id');
        $this->addSql('ALTER TABLE invoice_lines DROP FOREIGN KEY FK_72DBDC23A76ED395');
        $this->addSql('DROP INDEX IDX_72DBDC23A76ED395 ON invoice_lines');
        $this->addSql('ALTER TABLE invoice_lines DROP user_id');
        $this->addSql('ALTER TABLE user CHANGE roles roles LONGTEXT NOT NULL COLLATE `utf8mb4_bin`');
    }
}
