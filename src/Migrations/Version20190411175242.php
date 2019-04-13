<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190411175242 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE user_preferences (id INT AUTO_INCREMENT NOT NULL, locale VARCHAR(8) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('DROP TABLE user_micro_post');
        $this->addSql('ALTER TABLE user ADD preferences_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D6497CCD6FB7 FOREIGN KEY (preferences_id) REFERENCES user_preferences (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D6497CCD6FB7 ON user (preferences_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D6497CCD6FB7');
        $this->addSql('CREATE TABLE user_micro_post (user_id INT NOT NULL, micro_post_id INT NOT NULL, INDEX IDX_8D8826FBA76ED395 (user_id), INDEX IDX_8D8826FB11E37CEA (micro_post_id), PRIMARY KEY(user_id, micro_post_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE user_micro_post ADD CONSTRAINT FK_8D8826FB11E37CEA FOREIGN KEY (micro_post_id) REFERENCES micro_post (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_micro_post ADD CONSTRAINT FK_8D8826FBA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE user_preferences');
        $this->addSql('DROP INDEX UNIQ_8D93D6497CCD6FB7 ON user');
        $this->addSql('ALTER TABLE user DROP preferences_id');
    }
}
