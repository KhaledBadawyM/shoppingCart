<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190726002131 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE cart_contain_items (id INT AUTO_INCREMENT NOT NULL, cart_id INT NOT NULL, item_id INT NOT NULL, INDEX IDX_AA4270641AD5CDBF (cart_id), INDEX IDX_AA427064126F525E (item_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE cart_contain_items ADD CONSTRAINT FK_AA4270641AD5CDBF FOREIGN KEY (cart_id) REFERENCES cart (id)');
        $this->addSql('ALTER TABLE cart_contain_items ADD CONSTRAINT FK_AA427064126F525E FOREIGN KEY (item_id) REFERENCES item (id)');
        //$this->addSql('DROP TABLE cart_has_items');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE cart_has_items (id INT AUTO_INCREMENT NOT NULL, item_id INT NOT NULL, cart_id INT NOT NULL, quantity INT NOT NULL, INDEX IDX_C069DE6C1AD5CDBF (cart_id), INDEX IDX_C069DE6C126F525E (item_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE cart_has_items ADD CONSTRAINT FK_C069DE6C126F525E FOREIGN KEY (item_id) REFERENCES item (id)');
        $this->addSql('ALTER TABLE cart_has_items ADD CONSTRAINT FK_C069DE6C1AD5CDBF FOREIGN KEY (cart_id) REFERENCES cart (id)');
        $this->addSql('DROP TABLE cart_contain_items');
    }
}
