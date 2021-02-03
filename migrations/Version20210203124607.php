<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210203124607 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE performance_category (performance_id INT NOT NULL, category_id INT NOT NULL, INDEX IDX_8D517DC3B91ADEEE (performance_id), INDEX IDX_8D517DC312469DE2 (category_id), PRIMARY KEY(performance_id, category_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE performance_category ADD CONSTRAINT FK_8D517DC3B91ADEEE FOREIGN KEY (performance_id) REFERENCES performance (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE performance_category ADD CONSTRAINT FK_8D517DC312469DE2 FOREIGN KEY (category_id) REFERENCES category (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE performance DROP FOREIGN KEY FK_82D7968112469DE2');
        $this->addSql('DROP INDEX IDX_82D7968112469DE2 ON performance');
        $this->addSql('ALTER TABLE performance DROP category_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE performance_category');
        $this->addSql('ALTER TABLE performance ADD category_id INT NOT NULL');
        $this->addSql('ALTER TABLE performance ADD CONSTRAINT FK_82D7968112469DE2 FOREIGN KEY (category_id) REFERENCES category (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_82D7968112469DE2 ON performance (category_id)');
    }
}
