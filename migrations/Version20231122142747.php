<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231122142747 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__music AS SELECT id, album_id, title, duration FROM music');
        $this->addSql('DROP TABLE music');
        $this->addSql('CREATE TABLE music (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, album_id INTEGER NOT NULL, title VARCHAR(255) NOT NULL, duration DATETIME NOT NULL, CONSTRAINT FK_CD52224A1137ABCF FOREIGN KEY (album_id) REFERENCES album (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO music (id, album_id, title, duration) SELECT id, album_id, title, duration FROM __temp__music');
        $this->addSql('DROP TABLE __temp__music');
        $this->addSql('CREATE INDEX IDX_CD52224A1137ABCF ON music (album_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__music AS SELECT id, album_id, title, duration FROM music');
        $this->addSql('DROP TABLE music');
        $this->addSql('CREATE TABLE music (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, album_id INTEGER NOT NULL, title VARCHAR(255) NOT NULL, duration INTEGER NOT NULL, CONSTRAINT FK_CD52224A1137ABCF FOREIGN KEY (album_id) REFERENCES album (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO music (id, album_id, title, duration) SELECT id, album_id, title, duration FROM __temp__music');
        $this->addSql('DROP TABLE __temp__music');
        $this->addSql('CREATE INDEX IDX_CD52224A1137ABCF ON music (album_id)');
    }
}
