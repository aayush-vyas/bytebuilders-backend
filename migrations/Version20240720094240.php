<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240720094240 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user_management.user_diet (user_id INT NOT NULL, diet_id INT NOT NULL, PRIMARY KEY(user_id, diet_id))');
        $this->addSql('CREATE INDEX IDX_DCF06A54A76ED395 ON user_management.user_diet (user_id)');
        $this->addSql('CREATE INDEX IDX_DCF06A54E1E13ACE ON user_management.user_diet (diet_id)');
        $this->addSql('CREATE TABLE user_management.user_allergies (user_id INT NOT NULL, allergies_id INT NOT NULL, PRIMARY KEY(user_id, allergies_id))');
        $this->addSql('CREATE INDEX IDX_2B659CAAA76ED395 ON user_management.user_allergies (user_id)');
        $this->addSql('CREATE INDEX IDX_2B659CAA7104939B ON user_management.user_allergies (allergies_id)');
        $this->addSql('ALTER TABLE user_management.user_diet ADD CONSTRAINT FK_DCF06A54A76ED395 FOREIGN KEY (user_id) REFERENCES "user_management"."user" (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE user_management.user_diet ADD CONSTRAINT FK_DCF06A54E1E13ACE FOREIGN KEY (diet_id) REFERENCES reference_data.diet (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE user_management.user_allergies ADD CONSTRAINT FK_2B659CAAA76ED395 FOREIGN KEY (user_id) REFERENCES "user_management"."user" (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE user_management.user_allergies ADD CONSTRAINT FK_2B659CAA7104939B FOREIGN KEY (allergies_id) REFERENCES reference_data.allergies (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE user_diet DROP CONSTRAINT fk_e76529e9a76ed395');
        $this->addSql('ALTER TABLE user_diet DROP CONSTRAINT fk_e76529e9e1e13ace');
        $this->addSql('ALTER TABLE user_allergies DROP CONSTRAINT fk_8df932ffa76ed395');
        $this->addSql('ALTER TABLE user_allergies DROP CONSTRAINT fk_8df932ff7104939b');
        $this->addSql('DROP TABLE user_diet');
        $this->addSql('DROP TABLE user_allergies');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('CREATE TABLE user_diet (user_id INT NOT NULL, diet_id INT NOT NULL, PRIMARY KEY(user_id, diet_id))');
        $this->addSql('CREATE INDEX idx_e76529e9a76ed395 ON user_diet (user_id)');
        $this->addSql('CREATE INDEX idx_e76529e9e1e13ace ON user_diet (diet_id)');
        $this->addSql('CREATE TABLE user_allergies (user_id INT NOT NULL, allergies_id INT NOT NULL, PRIMARY KEY(user_id, allergies_id))');
        $this->addSql('CREATE INDEX idx_8df932ffa76ed395 ON user_allergies (user_id)');
        $this->addSql('CREATE INDEX idx_8df932ff7104939b ON user_allergies (allergies_id)');
        $this->addSql('ALTER TABLE user_diet ADD CONSTRAINT fk_e76529e9a76ed395 FOREIGN KEY (user_id) REFERENCES user_management."user" (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE user_diet ADD CONSTRAINT fk_e76529e9e1e13ace FOREIGN KEY (diet_id) REFERENCES reference_data.diet (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE user_allergies ADD CONSTRAINT fk_8df932ffa76ed395 FOREIGN KEY (user_id) REFERENCES user_management."user" (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE user_allergies ADD CONSTRAINT fk_8df932ff7104939b FOREIGN KEY (allergies_id) REFERENCES reference_data.allergies (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE user_management.user_diet DROP CONSTRAINT FK_DCF06A54A76ED395');
        $this->addSql('ALTER TABLE user_management.user_diet DROP CONSTRAINT FK_DCF06A54E1E13ACE');
        $this->addSql('ALTER TABLE user_management.user_allergies DROP CONSTRAINT FK_2B659CAAA76ED395');
        $this->addSql('ALTER TABLE user_management.user_allergies DROP CONSTRAINT FK_2B659CAA7104939B');
        $this->addSql('DROP TABLE user_management.user_diet');
        $this->addSql('DROP TABLE user_management.user_allergies');
    }
}
