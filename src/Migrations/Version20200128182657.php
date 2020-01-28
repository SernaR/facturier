<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200128182657 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE accompte (id INT AUTO_INCREMENT NOT NULL, devis_id INT DEFAULT NULL, numero VARCHAR(255) NOT NULL, montant DOUBLE PRECISION NOT NULL, date DATETIME NOT NULL, UNIQUE INDEX UNIQ_BD09DAF741DEFADA (devis_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE avoir (id INT AUTO_INCREMENT NOT NULL, facture_id INT DEFAULT NULL, numero VARCHAR(255) DEFAULT NULL, date DATETIME NOT NULL, UNIQUE INDEX UNIQ_659B1A437F2DEE08 (facture_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE client (id INT AUTO_INCREMENT NOT NULL, zone_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, adresse VARCHAR(255) NOT NULL, societe VARCHAR(255) DEFAULT NULL, tva_intracommunautaire VARCHAR(255) NOT NULL, telephone VARCHAR(255) NOT NULL, mail VARCHAR(255) NOT NULL, INDEX IDX_C74404559F2C3FAB (zone_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE devis (id INT AUTO_INCREMENT NOT NULL, client_id INT DEFAULT NULL, accompte_id INT DEFAULT NULL, facture_id INT DEFAULT NULL, date DATETIME NOT NULL, envoi DATETIME DEFAULT NULL, annulation DATETIME DEFAULT NULL, validation DATETIME DEFAULT NULL, discount DOUBLE PRECISION NOT NULL, INDEX IDX_8B27C52B19EB6921 (client_id), UNIQUE INDEX UNIQ_8B27C52BD4C135E9 (accompte_id), UNIQUE INDEX UNIQ_8B27C52B7F2DEE08 (facture_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE facture (id INT AUTO_INCREMENT NOT NULL, devis_id INT DEFAULT NULL, avoir_id INT DEFAULT NULL, numero VARCHAR(255) DEFAULT NULL, date DATETIME NOT NULL, validation DATETIME DEFAULT NULL, livraison DATE DEFAULT NULL, payee TINYINT(1) NOT NULL, acompte DOUBLE PRECISION DEFAULT NULL, UNIQUE INDEX UNIQ_FE86641041DEFADA (devis_id), UNIQUE INDEX UNIQ_FE866410C36D46DB (avoir_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ligne_avoir (id INT AUTO_INCREMENT NOT NULL, avoir_id INT DEFAULT NULL, prestation_id INT DEFAULT NULL, quantite INT NOT NULL, INDEX IDX_6637F073C36D46DB (avoir_id), INDEX IDX_6637F0739E45C554 (prestation_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ligne_devis (id INT AUTO_INCREMENT NOT NULL, prestation_id INT DEFAULT NULL, devis_id INT DEFAULT NULL, quantite INT NOT NULL, INDEX IDX_888B2F1B9E45C554 (prestation_id), INDEX IDX_888B2F1B41DEFADA (devis_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ligne_facture (id INT AUTO_INCREMENT NOT NULL, prestation_id INT DEFAULT NULL, facture_id INT DEFAULT NULL, quantite INT NOT NULL, INDEX IDX_611F5A299E45C554 (prestation_id), INDEX IDX_611F5A297F2DEE08 (facture_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE prestation (id INT AUTO_INCREMENT NOT NULL, type_id INT DEFAULT NULL, code VARCHAR(255) NOT NULL, libelle VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, montant DOUBLE PRECISION NOT NULL, date_de_fin DATETIME DEFAULT NULL, INDEX IDX_51C88FADC54C8C93 (type_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE type_de_service (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(255) NOT NULL, username VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE zone_geographique (id INT AUTO_INCREMENT NOT NULL, zone VARCHAR(255) NOT NULL, texte_tva VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE accompte ADD CONSTRAINT FK_BD09DAF741DEFADA FOREIGN KEY (devis_id) REFERENCES devis (id)');
        $this->addSql('ALTER TABLE avoir ADD CONSTRAINT FK_659B1A437F2DEE08 FOREIGN KEY (facture_id) REFERENCES facture (id)');
        $this->addSql('ALTER TABLE client ADD CONSTRAINT FK_C74404559F2C3FAB FOREIGN KEY (zone_id) REFERENCES zone_geographique (id)');
        $this->addSql('ALTER TABLE devis ADD CONSTRAINT FK_8B27C52B19EB6921 FOREIGN KEY (client_id) REFERENCES client (id)');
        $this->addSql('ALTER TABLE devis ADD CONSTRAINT FK_8B27C52BD4C135E9 FOREIGN KEY (accompte_id) REFERENCES accompte (id)');
        $this->addSql('ALTER TABLE devis ADD CONSTRAINT FK_8B27C52B7F2DEE08 FOREIGN KEY (facture_id) REFERENCES facture (id)');
        $this->addSql('ALTER TABLE facture ADD CONSTRAINT FK_FE86641041DEFADA FOREIGN KEY (devis_id) REFERENCES devis (id)');
        $this->addSql('ALTER TABLE facture ADD CONSTRAINT FK_FE866410C36D46DB FOREIGN KEY (avoir_id) REFERENCES avoir (id)');
        $this->addSql('ALTER TABLE ligne_avoir ADD CONSTRAINT FK_6637F073C36D46DB FOREIGN KEY (avoir_id) REFERENCES avoir (id)');
        $this->addSql('ALTER TABLE ligne_avoir ADD CONSTRAINT FK_6637F0739E45C554 FOREIGN KEY (prestation_id) REFERENCES prestation (id)');
        $this->addSql('ALTER TABLE ligne_devis ADD CONSTRAINT FK_888B2F1B9E45C554 FOREIGN KEY (prestation_id) REFERENCES prestation (id)');
        $this->addSql('ALTER TABLE ligne_devis ADD CONSTRAINT FK_888B2F1B41DEFADA FOREIGN KEY (devis_id) REFERENCES devis (id)');
        $this->addSql('ALTER TABLE ligne_facture ADD CONSTRAINT FK_611F5A299E45C554 FOREIGN KEY (prestation_id) REFERENCES prestation (id)');
        $this->addSql('ALTER TABLE ligne_facture ADD CONSTRAINT FK_611F5A297F2DEE08 FOREIGN KEY (facture_id) REFERENCES facture (id)');
        $this->addSql('ALTER TABLE prestation ADD CONSTRAINT FK_51C88FADC54C8C93 FOREIGN KEY (type_id) REFERENCES type_de_service (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE devis DROP FOREIGN KEY FK_8B27C52BD4C135E9');
        $this->addSql('ALTER TABLE facture DROP FOREIGN KEY FK_FE866410C36D46DB');
        $this->addSql('ALTER TABLE ligne_avoir DROP FOREIGN KEY FK_6637F073C36D46DB');
        $this->addSql('ALTER TABLE devis DROP FOREIGN KEY FK_8B27C52B19EB6921');
        $this->addSql('ALTER TABLE accompte DROP FOREIGN KEY FK_BD09DAF741DEFADA');
        $this->addSql('ALTER TABLE facture DROP FOREIGN KEY FK_FE86641041DEFADA');
        $this->addSql('ALTER TABLE ligne_devis DROP FOREIGN KEY FK_888B2F1B41DEFADA');
        $this->addSql('ALTER TABLE avoir DROP FOREIGN KEY FK_659B1A437F2DEE08');
        $this->addSql('ALTER TABLE devis DROP FOREIGN KEY FK_8B27C52B7F2DEE08');
        $this->addSql('ALTER TABLE ligne_facture DROP FOREIGN KEY FK_611F5A297F2DEE08');
        $this->addSql('ALTER TABLE ligne_avoir DROP FOREIGN KEY FK_6637F0739E45C554');
        $this->addSql('ALTER TABLE ligne_devis DROP FOREIGN KEY FK_888B2F1B9E45C554');
        $this->addSql('ALTER TABLE ligne_facture DROP FOREIGN KEY FK_611F5A299E45C554');
        $this->addSql('ALTER TABLE prestation DROP FOREIGN KEY FK_51C88FADC54C8C93');
        $this->addSql('ALTER TABLE client DROP FOREIGN KEY FK_C74404559F2C3FAB');
        $this->addSql('DROP TABLE accompte');
        $this->addSql('DROP TABLE avoir');
        $this->addSql('DROP TABLE client');
        $this->addSql('DROP TABLE devis');
        $this->addSql('DROP TABLE facture');
        $this->addSql('DROP TABLE ligne_avoir');
        $this->addSql('DROP TABLE ligne_devis');
        $this->addSql('DROP TABLE ligne_facture');
        $this->addSql('DROP TABLE prestation');
        $this->addSql('DROP TABLE type_de_service');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE zone_geographique');
    }
}
