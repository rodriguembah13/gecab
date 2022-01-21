<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210408121154 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE rendezvous ADD medecin_id INT DEFAULT NULL, ADD patient_id INT DEFAULT NULL, ADD description LONGTEXT DEFAULT NULL, ADD status VARCHAR(255) NOT NULL, ADD created_at DATETIME NOT NULL');
        $this->addSql('ALTER TABLE rendezvous ADD CONSTRAINT FK_C09A9BA84F31A84 FOREIGN KEY (medecin_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE rendezvous ADD CONSTRAINT FK_C09A9BA86B899279 FOREIGN KEY (patient_id) REFERENCES patient (id)');
        $this->addSql('CREATE INDEX IDX_C09A9BA84F31A84 ON rendezvous (medecin_id)');
        $this->addSql('CREATE INDEX IDX_C09A9BA86B899279 ON rendezvous (patient_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE rendezvous DROP FOREIGN KEY FK_C09A9BA84F31A84');
        $this->addSql('ALTER TABLE rendezvous DROP FOREIGN KEY FK_C09A9BA86B899279');
        $this->addSql('DROP INDEX IDX_C09A9BA84F31A84 ON rendezvous');
        $this->addSql('DROP INDEX IDX_C09A9BA86B899279 ON rendezvous');
        $this->addSql('ALTER TABLE rendezvous DROP medecin_id, DROP patient_id, DROP description, DROP status, DROP created_at');
    }
}
