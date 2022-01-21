<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210413130700 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE hospitalisation (id INT AUTO_INCREMENT NOT NULL, patient_id INT DEFAULT NULL, date_begin DATE NOT NULL, date_end DATE DEFAULT NULL, INDEX IDX_67C059596B899279 (patient_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE hospitalisation ADD CONSTRAINT FK_67C059596B899279 FOREIGN KEY (patient_id) REFERENCES patient (id)');
        $this->addSql('ALTER TABLE facture ADD patient_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE facture ADD CONSTRAINT FK_FE8664106B899279 FOREIGN KEY (patient_id) REFERENCES patient (id)');
        $this->addSql('CREATE INDEX IDX_FE8664106B899279 ON facture (patient_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE hospitalisation');
        $this->addSql('ALTER TABLE facture DROP FOREIGN KEY FK_FE8664106B899279');
        $this->addSql('DROP INDEX IDX_FE8664106B899279 ON facture');
        $this->addSql('ALTER TABLE facture DROP patient_id');
    }
}
