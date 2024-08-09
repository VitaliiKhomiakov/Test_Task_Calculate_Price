<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240809195555 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add Coupon entity';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE coupon_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE coupon (id INT NOT NULL, code VARCHAR(50) NOT NULL, coupon_type SMALLINT NOT NULL, value NUMERIC(10, 2) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX coupon_code_unique ON coupon (code)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP SEQUENCE coupon_id_seq CASCADE');
        $this->addSql('DROP TABLE coupon');
    }
}
