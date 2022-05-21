<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220518153837 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE clients (id INT AUTO_INCREMENT NOT NULL, type VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, post_code VARCHAR(255) NOT NULL, city VARCHAR(255) NOT NULL, street VARCHAR(255) NOT NULL, nr VARCHAR(255) NOT NULL, phone INT NOT NULL, bank_account_nr INT DEFAULT NULL, vat_registration_nr INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE invoice_header (id INT AUTO_INCREMENT NOT NULL, payment_code_id INT NOT NULL, type VARCHAR(255) NOT NULL, nr VARCHAR(255) NOT NULL, selling_date DATE NOT NULL, posting_date DATE NOT NULL, INDEX IDX_D54435923E93F0FD (payment_code_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE invoice_lines (id INT AUTO_INCREMENT NOT NULL, product_id_id INT NOT NULL, invoice_id_id INT NOT NULL, qty DOUBLE PRECISION NOT NULL, discount DOUBLE PRECISION NOT NULL, INDEX IDX_72DBDC23DE18E50B (product_id_id), INDEX IDX_72DBDC23429ECEE2 (invoice_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE payment_codes (id INT AUTO_INCREMENT NOT NULL, code VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, type VARCHAR(255) NOT NULL, due INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE products (id INT AUTO_INCREMENT NOT NULL, type VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, vat DOUBLE PRECISION NOT NULL, mpp_relevant TINYINT(1) NOT NULL, ean INT DEFAULT NULL, description VARCHAR(1023) DEFAULT NULL, unit VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, status TINYINT(1) DEFAULT NULL, email VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649F85E0677 (username), UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE invoice_header ADD CONSTRAINT FK_D54435923E93F0FD FOREIGN KEY (payment_code_id) REFERENCES payment_codes (id)');
        $this->addSql('ALTER TABLE invoice_lines ADD CONSTRAINT FK_72DBDC23DE18E50B FOREIGN KEY (product_id_id) REFERENCES products (id)');
        $this->addSql('ALTER TABLE invoice_lines ADD CONSTRAINT FK_72DBDC23429ECEE2 FOREIGN KEY (invoice_id_id) REFERENCES invoice_header (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE invoice_lines DROP FOREIGN KEY FK_72DBDC23429ECEE2');
        $this->addSql('ALTER TABLE invoice_header DROP FOREIGN KEY FK_D54435923E93F0FD');
        $this->addSql('ALTER TABLE invoice_lines DROP FOREIGN KEY FK_72DBDC23DE18E50B');
        $this->addSql('DROP TABLE clients');
        $this->addSql('DROP TABLE invoice_header');
        $this->addSql('DROP TABLE invoice_lines');
        $this->addSql('DROP TABLE payment_codes');
        $this->addSql('DROP TABLE products');
        $this->addSql('DROP TABLE user');
    }
}
