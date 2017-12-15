<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20171215111802 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE products (id VARCHAR(255) NOT NULL, code VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, price NUMERIC(10, 2) NOT NULL, UNIQUE INDEX product_code_unique (code), UNIQUE INDEX product_name_unique (name), UNIQUE INDEX product_price_unique (price), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE orders (id VARCHAR(255) NOT NULL, customer_id VARCHAR(255) DEFAULT NULL, number INT NOT NULL, issued_at DATETIME NOT NULL, total NUMERIC(10, 2) NOT NULL, UNIQUE INDEX UNIQ_E52FFDEE9395C3F3 (customer_id), UNIQUE INDEX order_number_unique (number), UNIQUE INDEX order_issued_at_unique (issued_at), UNIQUE INDEX order_total_unique (total), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE order_products (id VARCHAR(255) NOT NULL, order_id VARCHAR(255) DEFAULT NULL, product_id VARCHAR(255) DEFAULT NULL, quantity DOUBLE PRECISION NOT NULL, price NUMERIC(10, 2) NOT NULL, discount DOUBLE PRECISION NOT NULL, total NUMERIC(10, 2) NOT NULL, UNIQUE INDEX UNIQ_5242B8EB8D9F6D38 (order_id), UNIQUE INDEX UNIQ_5242B8EB4584665A (product_id), UNIQUE INDEX order_product_quantity_unique (quantity), UNIQUE INDEX order_product_price_unique (price), UNIQUE INDEX order_product_discount_unique (discount), UNIQUE INDEX order_product_total_unique (total), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE customers (id VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, born_at DATE NOT NULL, UNIQUE INDEX customer_name_unique (name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE orders ADD CONSTRAINT FK_E52FFDEE9395C3F3 FOREIGN KEY (customer_id) REFERENCES customers (id)');
        $this->addSql('ALTER TABLE order_products ADD CONSTRAINT FK_5242B8EB8D9F6D38 FOREIGN KEY (order_id) REFERENCES orders (id)');
        $this->addSql('ALTER TABLE order_products ADD CONSTRAINT FK_5242B8EB4584665A FOREIGN KEY (product_id) REFERENCES products (id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE order_products DROP FOREIGN KEY FK_5242B8EB4584665A');
        $this->addSql('ALTER TABLE order_products DROP FOREIGN KEY FK_5242B8EB8D9F6D38');
        $this->addSql('ALTER TABLE orders DROP FOREIGN KEY FK_E52FFDEE9395C3F3');
        $this->addSql('DROP TABLE products');
        $this->addSql('DROP TABLE orders');
        $this->addSql('DROP TABLE order_products');
        $this->addSql('DROP TABLE customers');
    }
}
