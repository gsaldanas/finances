<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240520084709 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE betaling (id INT AUTO_INCREMENT NOT NULL, crediteur_id INT DEFAULT NULL, debiteur_id INT DEFAULT NULL, referentie VARCHAR(255) DEFAULT NULL, datum DATETIME DEFAULT NULL, bedrag NUMERIC(10, 2) DEFAULT NULL, rek_nr VARCHAR(255) DEFAULT NULL, INDEX IDX_4DD000152A846F2 (crediteur_id), INDEX IDX_4DD0001286FF88B (debiteur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE crediteur (id INT AUTO_INCREMENT NOT NULL, voornaam VARCHAR(255) DEFAULT NULL, naam VARCHAR(255) DEFAULT NULL, tel VARCHAR(255) DEFAULT NULL, email VARCHAR(255) DEFAULT NULL, straat_nr VARCHAR(255) DEFAULT NULL, postcode VARCHAR(255) DEFAULT NULL, gemeente VARCHAR(255) DEFAULT NULL, land VARCHAR(255) DEFAULT NULL, btw_nr VARCHAR(255) DEFAULT NULL, rek_nr VARCHAR(255) DEFAULT NULL, updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE creditnota (id INT AUTO_INCREMENT NOT NULL, crediteur_id INT DEFAULT NULL, debiteur_id INT DEFAULT NULL, referentie VARCHAR(255) DEFAULT NULL, datum DATETIME DEFAULT NULL, bedrag NUMERIC(10, 2) DEFAULT NULL, INDEX IDX_2AC003F352A846F2 (crediteur_id), INDEX IDX_2AC003F3286FF88B (debiteur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE debiteur (id INT AUTO_INCREMENT NOT NULL, voornaam VARCHAR(255) DEFAULT NULL, naam VARCHAR(255) DEFAULT NULL, tel VARCHAR(255) DEFAULT NULL, email VARCHAR(255) DEFAULT NULL, straat_nr VARCHAR(255) DEFAULT NULL, postcode VARCHAR(255) DEFAULT NULL, gemeente VARCHAR(255) DEFAULT NULL, land VARCHAR(255) DEFAULT NULL, btw_nr VARCHAR(255) DEFAULT NULL, rek_nr VARCHAR(255) DEFAULT NULL, updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE factuur (id INT AUTO_INCREMENT NOT NULL, crediteur_id INT DEFAULT NULL, debiteur_id INT DEFAULT NULL, referentie VARCHAR(255) DEFAULT NULL, datum DATETIME DEFAULT NULL, verval_datum DATETIME DEFAULT NULL, bedrag NUMERIC(10, 2) DEFAULT NULL, is_betaald TINYINT(1) NOT NULL, INDEX IDX_3214771052A846F2 (crediteur_id), INDEX IDX_32147710286FF88B (debiteur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE betaling ADD CONSTRAINT FK_4DD000152A846F2 FOREIGN KEY (crediteur_id) REFERENCES crediteur (id)');
        $this->addSql('ALTER TABLE betaling ADD CONSTRAINT FK_4DD0001286FF88B FOREIGN KEY (debiteur_id) REFERENCES debiteur (id)');
        $this->addSql('ALTER TABLE creditnota ADD CONSTRAINT FK_2AC003F352A846F2 FOREIGN KEY (crediteur_id) REFERENCES crediteur (id)');
        $this->addSql('ALTER TABLE creditnota ADD CONSTRAINT FK_2AC003F3286FF88B FOREIGN KEY (debiteur_id) REFERENCES debiteur (id)');
        $this->addSql('ALTER TABLE factuur ADD CONSTRAINT FK_3214771052A846F2 FOREIGN KEY (crediteur_id) REFERENCES crediteur (id)');
        $this->addSql('ALTER TABLE factuur ADD CONSTRAINT FK_32147710286FF88B FOREIGN KEY (debiteur_id) REFERENCES debiteur (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE betaling DROP FOREIGN KEY FK_4DD000152A846F2');
        $this->addSql('ALTER TABLE betaling DROP FOREIGN KEY FK_4DD0001286FF88B');
        $this->addSql('ALTER TABLE creditnota DROP FOREIGN KEY FK_2AC003F352A846F2');
        $this->addSql('ALTER TABLE creditnota DROP FOREIGN KEY FK_2AC003F3286FF88B');
        $this->addSql('ALTER TABLE factuur DROP FOREIGN KEY FK_3214771052A846F2');
        $this->addSql('ALTER TABLE factuur DROP FOREIGN KEY FK_32147710286FF88B');
        $this->addSql('DROP TABLE betaling');
        $this->addSql('DROP TABLE crediteur');
        $this->addSql('DROP TABLE creditnota');
        $this->addSql('DROP TABLE debiteur');
        $this->addSql('DROP TABLE factuur');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
