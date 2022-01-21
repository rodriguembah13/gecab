<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210412055200 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE facture (id INT AUTO_INCREMENT NOT NULL, created_by_id INT DEFAULT NULL, amount DOUBLE PRECISION NOT NULL, amount_due DOUBLE PRECISION NOT NULL, INDEX IDX_FE866410B03A8386 (created_by_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE facture_item (id INT AUTO_INCREMENT NOT NULL, facture_id INT DEFAULT NULL, actemedical_id INT DEFAULT NULL, amount DOUBLE PRECISION NOT NULL, quantity INT NOT NULL, INDEX IDX_F91D09D27F2DEE08 (facture_id), INDEX IDX_F91D09D2CF3FBA35 (actemedical_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE facture ADD CONSTRAINT FK_FE866410B03A8386 FOREIGN KEY (created_by_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE facture_item ADD CONSTRAINT FK_F91D09D27F2DEE08 FOREIGN KEY (facture_id) REFERENCES facture (id)');
        $this->addSql('ALTER TABLE facture_item ADD CONSTRAINT FK_F91D09D2CF3FBA35 FOREIGN KEY (actemedical_id) REFERENCES acte_medical (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE facture_item DROP FOREIGN KEY FK_F91D09D27F2DEE08');
        $this->addSql('DROP TABLE facture');
        $this->addSql('DROP TABLE facture_item');
    }
}
