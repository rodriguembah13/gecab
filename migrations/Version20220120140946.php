<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220120140946 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE clinique (id INT AUTO_INCREMENT NOT NULL, intitule VARCHAR(255) NOT NULL, telephone VARCHAR(255) DEFAULT NULL, ville VARCHAR(255) DEFAULT NULL, pays VARCHAR(255) DEFAULT NULL, responsable VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE famille_patient (id INT AUTO_INCREMENT NOT NULL, intitule VARCHAR(255) NOT NULL, telephone VARCHAR(255) DEFAULT NULL, responsable1 VARCHAR(255) DEFAULT NULL, responsable2 VARCHAR(255) DEFAULT NULL, ville VARCHAR(255) DEFAULT NULL, pays VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE patient ADD clinique_id INT DEFAULT NULL, ADD famille_id INT DEFAULT NULL, ADD groupsanguin VARCHAR(255) DEFAULT NULL, ADD poids DOUBLE PRECISION DEFAULT NULL, ADD taille DOUBLE PRECISION DEFAULT NULL, ADD nomgarde VARCHAR(255) DEFAULT NULL, ADD ville VARCHAR(255) DEFAULT NULL, ADD pin VARCHAR(255) DEFAULT NULL, ADD titre VARCHAR(255) DEFAULT NULL, ADD relactiongarde VARCHAR(255) DEFAULT NULL, ADD adressegarde VARCHAR(255) DEFAULT NULL, ADD villegarde VARCHAR(255) DEFAULT NULL, ADD regiongarde VARCHAR(255) DEFAULT NULL, ADD pingarde VARCHAR(255) DEFAULT NULL, ADD paysgarde VARCHAR(255) DEFAULT NULL, ADD telephonegarde VARCHAR(255) DEFAULT NULL, ADD photo VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE patient ADD CONSTRAINT FK_1ADAD7EB265183A3 FOREIGN KEY (clinique_id) REFERENCES clinique (id)');
        $this->addSql('ALTER TABLE patient ADD CONSTRAINT FK_1ADAD7EB97A77B84 FOREIGN KEY (famille_id) REFERENCES famille_patient (id)');
        $this->addSql('CREATE INDEX IDX_1ADAD7EB265183A3 ON patient (clinique_id)');
        $this->addSql('CREATE INDEX IDX_1ADAD7EB97A77B84 ON patient (famille_id)');
        $this->addSql('ALTER TABLE user ADD clinique_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649265183A3 FOREIGN KEY (clinique_id) REFERENCES clinique (id)');
        $this->addSql('CREATE INDEX IDX_8D93D649265183A3 ON user (clinique_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE patient DROP FOREIGN KEY FK_1ADAD7EB265183A3');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649265183A3');
        $this->addSql('ALTER TABLE patient DROP FOREIGN KEY FK_1ADAD7EB97A77B84');
        $this->addSql('DROP TABLE clinique');
        $this->addSql('DROP TABLE famille_patient');
        $this->addSql('DROP INDEX IDX_1ADAD7EB265183A3 ON patient');
        $this->addSql('DROP INDEX IDX_1ADAD7EB97A77B84 ON patient');
        $this->addSql('ALTER TABLE patient DROP clinique_id, DROP famille_id, DROP groupsanguin, DROP poids, DROP taille, DROP nomgarde, DROP ville, DROP pin, DROP titre, DROP relactiongarde, DROP adressegarde, DROP villegarde, DROP regiongarde, DROP pingarde, DROP paysgarde, DROP telephonegarde, DROP photo');
        $this->addSql('DROP INDEX IDX_8D93D649265183A3 ON user');
        $this->addSql('ALTER TABLE user DROP clinique_id');
    }
}
