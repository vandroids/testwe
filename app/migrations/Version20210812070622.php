<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210812070622 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(255) NOT NULL, `key` VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB;');
        $this->addSql('ALTER TABLE movie_has_people DROP FOREIGN KEY fk_Movie_has_People_Movie1');
        $this->addSql('ALTER TABLE movie_has_people DROP FOREIGN KEY fk_Movie_has_People_People1');
        $this->addSql('ALTER TABLE movie_has_people CHANGE significance significance ENUM(\'principal\', \'secondaire\') DEFAULT NULL COMMENT \'(DC2Type:significance)\'');
        $this->addSql('ALTER TABLE movie_has_people ADD CONSTRAINT FK_EDC40D818F93B6FC FOREIGN KEY (movie_id) REFERENCES movie (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE movie_has_people ADD CONSTRAINT FK_EDC40D813147C936 FOREIGN KEY (people_id) REFERENCES people (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE movie_has_people RENAME INDEX idx_edc40d8176e5d4aa TO IDX_EDC40D818F93B6FC');
        $this->addSql('ALTER TABLE movie_has_people RENAME INDEX fk_movie_has_people_people1 TO IDX_EDC40D813147C936');
        $this->addSql('ALTER TABLE movie_has_type DROP FOREIGN KEY fk_Movie_has_Type_Movie1');
        $this->addSql('ALTER TABLE movie_has_type DROP FOREIGN KEY fk_Movie_has_Type_Type1');
        $this->addSql('ALTER TABLE movie_has_type ADD CONSTRAINT FK_D7417FB8F93B6FC FOREIGN KEY (movie_id) REFERENCES movie (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE movie_has_type ADD CONSTRAINT FK_D7417FBC54C8C93 FOREIGN KEY (type_id) REFERENCES type (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE movie_has_type RENAME INDEX idx_d7417fb76e5d4aa TO IDX_D7417FB8F93B6FC');
        $this->addSql('ALTER TABLE movie_has_type RENAME INDEX fk_movie_has_type_type1 TO IDX_D7417FBC54C8C93');
        $this->addSql('ALTER TABLE people CHANGE date_of_birth date_of_birth DATETIME NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE user');
        $this->addSql('ALTER TABLE movie_has_people DROP FOREIGN KEY FK_EDC40D818F93B6FC');
        $this->addSql('ALTER TABLE movie_has_people DROP FOREIGN KEY FK_EDC40D813147C936');
        $this->addSql('ALTER TABLE movie_has_people CHANGE significance significance VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_0900_ai_ci`');
        $this->addSql('ALTER TABLE movie_has_people ADD CONSTRAINT fk_Movie_has_People_Movie1 FOREIGN KEY (Movie_id) REFERENCES movie (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE movie_has_people ADD CONSTRAINT fk_Movie_has_People_People1 FOREIGN KEY (People_id) REFERENCES people (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE movie_has_people RENAME INDEX idx_edc40d813147c936 TO fk_Movie_has_People_People1');
        $this->addSql('ALTER TABLE movie_has_people RENAME INDEX idx_edc40d818f93b6fc TO IDX_EDC40D8176E5D4AA');
        $this->addSql('ALTER TABLE movie_has_type DROP FOREIGN KEY FK_D7417FB8F93B6FC');
        $this->addSql('ALTER TABLE movie_has_type DROP FOREIGN KEY FK_D7417FBC54C8C93');
        $this->addSql('ALTER TABLE movie_has_type ADD CONSTRAINT fk_Movie_has_Type_Movie1 FOREIGN KEY (Movie_id) REFERENCES movie (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE movie_has_type ADD CONSTRAINT fk_Movie_has_Type_Type1 FOREIGN KEY (Type_id) REFERENCES type (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE movie_has_type RENAME INDEX idx_d7417fbc54c8c93 TO fk_Movie_has_Type_Type1');
        $this->addSql('ALTER TABLE movie_has_type RENAME INDEX idx_d7417fb8f93b6fc TO IDX_D7417FB76E5D4AA');
        $this->addSql('ALTER TABLE people CHANGE date_of_birth date_of_birth DATE NOT NULL');
    }
}
