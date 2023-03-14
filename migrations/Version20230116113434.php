<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230116113434 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user_friend_ship (id INT AUTO_INCREMENT NOT NULL, id_user1_id INT DEFAULT NULL, id_user2_id INT DEFAULT NULL, INDEX IDX_C951FE51675C81E (id_user1_id), INDEX IDX_C951FE5114C067F0 (id_user2_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user_friend_ship ADD CONSTRAINT FK_C951FE51675C81E FOREIGN KEY (id_user1_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user_friend_ship ADD CONSTRAINT FK_C951FE5114C067F0 FOREIGN KEY (id_user2_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user_friend_ship DROP FOREIGN KEY FK_C951FE51675C81E');
        $this->addSql('ALTER TABLE user_friend_ship DROP FOREIGN KEY FK_C951FE5114C067F0');
        $this->addSql('DROP TABLE user_friend_ship');
    }
}
