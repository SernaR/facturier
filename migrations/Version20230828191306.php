<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230828191306 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE accompte_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE avoir_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE client_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE devis_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE facture_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE ligne_avoir_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE ligne_devis_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE ligne_facture_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE prestation_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE type_de_service_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE user_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE zone_geographique_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE accompte (id INT NOT NULL, devis_id INT DEFAULT NULL, numero VARCHAR(255) NOT NULL, montant DOUBLE PRECISION NOT NULL, date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_BD09DAF741DEFADA ON accompte (devis_id)');
        $this->addSql('CREATE TABLE avoir (id INT NOT NULL, facture_id INT DEFAULT NULL, numero VARCHAR(255) DEFAULT NULL, date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_659B1A437F2DEE08 ON avoir (facture_id)');
        $this->addSql('CREATE TABLE client (id INT NOT NULL, zone_id INT NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, adresse TEXT NOT NULL, societe VARCHAR(255) DEFAULT NULL, tva_intracommunautaire VARCHAR(255) DEFAULT NULL, telephone VARCHAR(255) NOT NULL, mail VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_C74404559F2C3FAB ON client (zone_id)');
        $this->addSql('CREATE TABLE devis (id INT NOT NULL, client_id INT NOT NULL, accompte_id INT DEFAULT NULL, facture_id INT DEFAULT NULL, date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, envoi TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, annulation TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, validation TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, discount DOUBLE PRECISION NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_8B27C52B19EB6921 ON devis (client_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8B27C52BD4C135E9 ON devis (accompte_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8B27C52B7F2DEE08 ON devis (facture_id)');
        $this->addSql('CREATE TABLE facture (id INT NOT NULL, devis_id INT DEFAULT NULL, avoir_id INT DEFAULT NULL, numero VARCHAR(255) DEFAULT NULL, date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, validation TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, livraison DATE DEFAULT NULL, payee BOOLEAN NOT NULL, fin_prestation DATE DEFAULT NULL, mensuel BOOLEAN NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_FE86641041DEFADA ON facture (devis_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_FE866410C36D46DB ON facture (avoir_id)');
        $this->addSql('CREATE TABLE ligne_avoir (id INT NOT NULL, avoir_id INT NOT NULL, prestation_id INT NOT NULL, quantite INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_6637F073C36D46DB ON ligne_avoir (avoir_id)');
        $this->addSql('CREATE INDEX IDX_6637F0739E45C554 ON ligne_avoir (prestation_id)');
        $this->addSql('CREATE TABLE ligne_devis (id INT NOT NULL, prestation_id INT NOT NULL, devis_id INT NOT NULL, quantite INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_888B2F1B9E45C554 ON ligne_devis (prestation_id)');
        $this->addSql('CREATE INDEX IDX_888B2F1B41DEFADA ON ligne_devis (devis_id)');
        $this->addSql('CREATE TABLE ligne_facture (id INT NOT NULL, prestation_id INT NOT NULL, facture_id INT NOT NULL, quantite INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_611F5A299E45C554 ON ligne_facture (prestation_id)');
        $this->addSql('CREATE INDEX IDX_611F5A297F2DEE08 ON ligne_facture (facture_id)');
        $this->addSql('CREATE TABLE prestation (id INT NOT NULL, type_id INT NOT NULL, code VARCHAR(255) NOT NULL, libelle VARCHAR(255) NOT NULL, description TEXT NOT NULL, montant DOUBLE PRECISION NOT NULL, date_de_fin TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_51C88FADC54C8C93 ON prestation (type_id)');
        $this->addSql('CREATE TABLE type_de_service (id INT NOT NULL, nom VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE "user" (id INT NOT NULL, email VARCHAR(180) NOT NULL, username VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, roles JSON NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649E7927C74 ON "user" (email)');
        $this->addSql('CREATE TABLE zone_geographique (id INT NOT NULL, zone VARCHAR(255) NOT NULL, texte_tva VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE messenger_messages (id BIGSERIAL NOT NULL, body TEXT NOT NULL, headers TEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, available_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, delivered_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_75EA56E0FB7336F0 ON messenger_messages (queue_name)');
        $this->addSql('CREATE INDEX IDX_75EA56E0E3BD61CE ON messenger_messages (available_at)');
        $this->addSql('CREATE INDEX IDX_75EA56E016BA31DB ON messenger_messages (delivered_at)');
        $this->addSql('COMMENT ON COLUMN messenger_messages.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN messenger_messages.available_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN messenger_messages.delivered_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE OR REPLACE FUNCTION notify_messenger_messages() RETURNS TRIGGER AS $$
            BEGIN
                PERFORM pg_notify(\'messenger_messages\', NEW.queue_name::text);
                RETURN NEW;
            END;
        $$ LANGUAGE plpgsql;');
        $this->addSql('DROP TRIGGER IF EXISTS notify_trigger ON messenger_messages;');
        $this->addSql('CREATE TRIGGER notify_trigger AFTER INSERT OR UPDATE ON messenger_messages FOR EACH ROW EXECUTE PROCEDURE notify_messenger_messages();');
        $this->addSql('ALTER TABLE accompte ADD CONSTRAINT FK_BD09DAF741DEFADA FOREIGN KEY (devis_id) REFERENCES devis (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE avoir ADD CONSTRAINT FK_659B1A437F2DEE08 FOREIGN KEY (facture_id) REFERENCES facture (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE client ADD CONSTRAINT FK_C74404559F2C3FAB FOREIGN KEY (zone_id) REFERENCES zone_geographique (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE devis ADD CONSTRAINT FK_8B27C52B19EB6921 FOREIGN KEY (client_id) REFERENCES client (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE devis ADD CONSTRAINT FK_8B27C52BD4C135E9 FOREIGN KEY (accompte_id) REFERENCES accompte (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE devis ADD CONSTRAINT FK_8B27C52B7F2DEE08 FOREIGN KEY (facture_id) REFERENCES facture (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE facture ADD CONSTRAINT FK_FE86641041DEFADA FOREIGN KEY (devis_id) REFERENCES devis (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE facture ADD CONSTRAINT FK_FE866410C36D46DB FOREIGN KEY (avoir_id) REFERENCES avoir (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE ligne_avoir ADD CONSTRAINT FK_6637F073C36D46DB FOREIGN KEY (avoir_id) REFERENCES avoir (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE ligne_avoir ADD CONSTRAINT FK_6637F0739E45C554 FOREIGN KEY (prestation_id) REFERENCES prestation (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE ligne_devis ADD CONSTRAINT FK_888B2F1B9E45C554 FOREIGN KEY (prestation_id) REFERENCES prestation (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE ligne_devis ADD CONSTRAINT FK_888B2F1B41DEFADA FOREIGN KEY (devis_id) REFERENCES devis (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE ligne_facture ADD CONSTRAINT FK_611F5A299E45C554 FOREIGN KEY (prestation_id) REFERENCES prestation (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE ligne_facture ADD CONSTRAINT FK_611F5A297F2DEE08 FOREIGN KEY (facture_id) REFERENCES facture (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE prestation ADD CONSTRAINT FK_51C88FADC54C8C93 FOREIGN KEY (type_id) REFERENCES type_de_service (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE accompte_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE avoir_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE client_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE devis_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE facture_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE ligne_avoir_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE ligne_devis_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE ligne_facture_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE prestation_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE type_de_service_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE user_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE zone_geographique_id_seq CASCADE');
        $this->addSql('ALTER TABLE accompte DROP CONSTRAINT FK_BD09DAF741DEFADA');
        $this->addSql('ALTER TABLE avoir DROP CONSTRAINT FK_659B1A437F2DEE08');
        $this->addSql('ALTER TABLE client DROP CONSTRAINT FK_C74404559F2C3FAB');
        $this->addSql('ALTER TABLE devis DROP CONSTRAINT FK_8B27C52B19EB6921');
        $this->addSql('ALTER TABLE devis DROP CONSTRAINT FK_8B27C52BD4C135E9');
        $this->addSql('ALTER TABLE devis DROP CONSTRAINT FK_8B27C52B7F2DEE08');
        $this->addSql('ALTER TABLE facture DROP CONSTRAINT FK_FE86641041DEFADA');
        $this->addSql('ALTER TABLE facture DROP CONSTRAINT FK_FE866410C36D46DB');
        $this->addSql('ALTER TABLE ligne_avoir DROP CONSTRAINT FK_6637F073C36D46DB');
        $this->addSql('ALTER TABLE ligne_avoir DROP CONSTRAINT FK_6637F0739E45C554');
        $this->addSql('ALTER TABLE ligne_devis DROP CONSTRAINT FK_888B2F1B9E45C554');
        $this->addSql('ALTER TABLE ligne_devis DROP CONSTRAINT FK_888B2F1B41DEFADA');
        $this->addSql('ALTER TABLE ligne_facture DROP CONSTRAINT FK_611F5A299E45C554');
        $this->addSql('ALTER TABLE ligne_facture DROP CONSTRAINT FK_611F5A297F2DEE08');
        $this->addSql('ALTER TABLE prestation DROP CONSTRAINT FK_51C88FADC54C8C93');
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
        $this->addSql('DROP TABLE "user"');
        $this->addSql('DROP TABLE zone_geographique');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
