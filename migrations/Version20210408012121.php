<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210408012121 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ordonnance ADD medecin_id INT DEFAULT NULL, ADD patient_id INT DEFAULT NULL, ADD status VARCHAR(255) NOT NULL, ADD created_at DATETIME NOT NULL');
        $this->addSql('ALTER TABLE ordonnance ADD CONSTRAINT FK_924B326C4F31A84 FOREIGN KEY (medecin_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE ordonnance ADD CONSTRAINT FK_924B326C6B899279 FOREIGN KEY (patient_id) REFERENCES patient (id)');
        $this->addSql('CREATE INDEX IDX_924B326C4F31A84 ON ordonnance (medecin_id)');
        $this->addSql('CREATE INDEX IDX_924B326C6B899279 ON ordonnance (patient_id)');
        $this->addSql('ALTER TABLE prescription ADD ordonance_id INT DEFAULT NULL, ADD medicament_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE prescription ADD CONSTRAINT FK_1FBFB8D94DBFB927 FOREIGN KEY (ordonance_id) REFERENCES ordonnance (id)');
        $this->addSql('ALTER TABLE prescription ADD CONSTRAINT FK_1FBFB8D9AB0D61F7 FOREIGN KEY (medicament_id) REFERENCES medicament (id)');
        $this->addSql('CREATE INDEX IDX_1FBFB8D94DBFB927 ON prescription (ordonance_id)');
        $this->addSql('CREATE INDEX IDX_1FBFB8D9AB0D61F7 ON prescription (medicament_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ordonnance DROP FOREIGN KEY FK_924B326C4F31A84');
        $this->addSql('ALTER TABLE ordonnance DROP FOREIGN KEY FK_924B326C6B899279');
        $this->addSql('DROP INDEX IDX_924B326C4F31A84 ON ordonnance');
        $this->addSql('DROP INDEX IDX_924B326C6B899279 ON ordonnance');
        $this->addSql('ALTER TABLE ordonnance DROP medecin_id, DROP patient_id, DROP status, DROP created_at');
        $this->addSql('ALTER TABLE prescription DROP FOREIGN KEY FK_1FBFB8D94DBFB927');
        $this->addSql('ALTER TABLE prescription DROP FOREIGN KEY FK_1FBFB8D9AB0D61F7');
        $this->addSql('DROP INDEX IDX_1FBFB8D94DBFB927 ON prescription');
        $this->addSql('DROP INDEX IDX_1FBFB8D9AB0D61F7 ON prescription');
        $this->addSql('ALTER TABLE prescription DROP ordonance_id, DROP medicament_id');
    }
}
