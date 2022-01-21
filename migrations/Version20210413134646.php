<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210413134646 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE acte_medical_patient (id INT AUTO_INCREMENT NOT NULL, patient_id INT DEFAULT NULL, acte_medical_id INT DEFAULT NULL, created_by_id INT DEFAULT NULL, amount DOUBLE PRECISION NOT NULL, quantity INT NOT NULL, status VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, INDEX IDX_55F2F136B899279 (patient_id), INDEX IDX_55F2F1347F0883A (acte_medical_id), INDEX IDX_55F2F13B03A8386 (created_by_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE acte_medical_patient ADD CONSTRAINT FK_55F2F136B899279 FOREIGN KEY (patient_id) REFERENCES patient (id)');
        $this->addSql('ALTER TABLE acte_medical_patient ADD CONSTRAINT FK_55F2F1347F0883A FOREIGN KEY (acte_medical_id) REFERENCES acte_medical (id)');
        $this->addSql('ALTER TABLE acte_medical_patient ADD CONSTRAINT FK_55F2F13B03A8386 FOREIGN KEY (created_by_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE facture_item DROP FOREIGN KEY FK_F91D09D2CF3FBA35');
        $this->addSql('DROP INDEX IDX_F91D09D2CF3FBA35 ON facture_item');
        $this->addSql('ALTER TABLE facture_item DROP actemedical_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE acte_medical_patient');
        $this->addSql('ALTER TABLE facture_item ADD actemedical_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE facture_item ADD CONSTRAINT FK_F91D09D2CF3FBA35 FOREIGN KEY (actemedical_id) REFERENCES acte_medical (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_F91D09D2CF3FBA35 ON facture_item (actemedical_id)');
    }
}
