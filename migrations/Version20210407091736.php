<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210407091736 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE consultation ADD patient_id INT DEFAULT NULL, ADD medecin_id INT DEFAULT NULL, ADD created_by_id INT DEFAULT NULL, ADD dianostique TINYTEXT NOT NULL, ADD created_at DATETIME NOT NULL, ADD status VARCHAR(255) NOT NULL, CHANGE motif motif TINYTEXT NOT NULL');
        $this->addSql('ALTER TABLE consultation ADD CONSTRAINT FK_964685A66B899279 FOREIGN KEY (patient_id) REFERENCES patient (id)');
        $this->addSql('ALTER TABLE consultation ADD CONSTRAINT FK_964685A64F31A84 FOREIGN KEY (medecin_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE consultation ADD CONSTRAINT FK_964685A6B03A8386 FOREIGN KEY (created_by_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_964685A66B899279 ON consultation (patient_id)');
        $this->addSql('CREATE INDEX IDX_964685A64F31A84 ON consultation (medecin_id)');
        $this->addSql('CREATE INDEX IDX_964685A6B03A8386 ON consultation (created_by_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE consultation DROP FOREIGN KEY FK_964685A66B899279');
        $this->addSql('ALTER TABLE consultation DROP FOREIGN KEY FK_964685A64F31A84');
        $this->addSql('ALTER TABLE consultation DROP FOREIGN KEY FK_964685A6B03A8386');
        $this->addSql('DROP INDEX IDX_964685A66B899279 ON consultation');
        $this->addSql('DROP INDEX IDX_964685A64F31A84 ON consultation');
        $this->addSql('DROP INDEX IDX_964685A6B03A8386 ON consultation');
        $this->addSql('ALTER TABLE consultation DROP patient_id, DROP medecin_id, DROP created_by_id, DROP dianostique, DROP created_at, DROP status, CHANGE motif motif VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
