<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231124080208 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commentaire ADD trick_id SMALLINT DEFAULT NULL, DROP id_figure');
        $this->addSql('ALTER TABLE commentaire ADD CONSTRAINT FK_67F068BCB281BE2E FOREIGN KEY (trick_id) REFERENCES trick (id)');
        $this->addSql('CREATE INDEX IDX_67F068BCB281BE2E ON commentaire (trick_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commentaire DROP FOREIGN KEY FK_67F068BCB281BE2E');
        $this->addSql('DROP INDEX IDX_67F068BCB281BE2E ON commentaire');
        $this->addSql('ALTER TABLE commentaire ADD id_figure SMALLINT NOT NULL, DROP trick_id');
    }
}
