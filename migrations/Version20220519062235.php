<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220519062235 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE invoice_lines ADD product_type VARCHAR(255) NOT NULL, ADD product_name VARCHAR(255) NOT NULL, ADD product_vat DOUBLE PRECISION NOT NULL, ADD product_mpp_relevant TINYINT(1) NOT NULL, ADD product_ean INT DEFAULT NULL, ADD product_description VARCHAR(1023) DEFAULT NULL, ADD product_unit VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE invoice_lines DROP product_type, DROP product_name, DROP product_vat, DROP product_mpp_relevant, DROP product_ean, DROP product_description, DROP product_unit');
    }
}
