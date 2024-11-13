<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241113103154 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE invoice_item (id INT AUTO_INCREMENT NOT NULL, invoice_id INT NOT NULL, product_id INT NOT NULL, customer_id INT NOT NULL, quantity INT NOT NULL, discount NUMERIC(10, 2) NOT NULL, INDEX IDX_1DDE477B2989F1FD (invoice_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE invoice_item ADD CONSTRAINT FK_1DDE477B2989F1FD FOREIGN KEY (invoice_id) REFERENCES invoice (id)');
        $this->addSql('DROP TABLE cart');
        $this->addSql('ALTER TABLE invoice DROP customer, DROP tax, DROP final_amount, CHANGE product_id product_id INT NOT NULL, CHANGE payment_method payment_method VARCHAR(50) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE cart (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, price BIGINT NOT NULL, quantity INT NOT NULL, description VARCHAR(300) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, customer INT NOT NULL, status INT NOT NULL, total_amount BIGINT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE invoice_item DROP FOREIGN KEY FK_1DDE477B2989F1FD');
        $this->addSql('DROP TABLE invoice_item');
        $this->addSql('ALTER TABLE invoice ADD customer INT DEFAULT NULL, ADD tax INT DEFAULT NULL, ADD final_amount INT DEFAULT NULL, CHANGE product_id product_id INT DEFAULT NULL, CHANGE payment_method payment_method VARCHAR(50) DEFAULT NULL');
    }
}
