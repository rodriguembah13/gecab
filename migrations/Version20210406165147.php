<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210406165147 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE salle_attente (id INT AUTO_INCREMENT NOT NULL, patient_id INT DEFAULT NULL, created_by_id INT DEFAULT NULL, created_at DATETIME NOT NULL, heure_arrive TIME NOT NULL, heure_fin TIME DEFAULT NULL, motif VARCHAR(255) NOT NULL, INDEX IDX_394035986B899279 (patient_id), INDEX IDX_39403598B03A8386 (created_by_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE salle_attente ADD CONSTRAINT FK_394035986B899279 FOREIGN KEY (patient_id) REFERENCES patient (id)');
        $this->addSql('ALTER TABLE salle_attente ADD CONSTRAINT FK_39403598B03A8386 FOREIGN KEY (created_by_id) REFERENCES user (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE salle_attente');
    }
}
