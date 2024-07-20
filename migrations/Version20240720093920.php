<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240720093920 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE reference_data.allergies_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE reference_data.cuisine_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE reference_data.diet_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE reference_data.recipe_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE reference_data.recipe_meta_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE "user_management"."user_id_seq" INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE reference_data.allergies (id INT NOT NULL, title VARCHAR(50) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE reference_data.cuisine (id INT NOT NULL, title VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE reference_data.diet (id INT NOT NULL, title VARCHAR(50) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE reference_data.recipe (id INT NOT NULL, title VARCHAR(255) NOT NULL, ready_in_minutes INT DEFAULT NULL, servings INT DEFAULT NULL, image VARCHAR(255) DEFAULT NULL, calories INT DEFAULT NULL, vegetarian BOOLEAN NOT NULL, vegan BOOLEAN NOT NULL, gluten_free BOOLEAN NOT NULL, dairy_free BOOLEAN NOT NULL, recipe_id INT NOT NULL, cuisines TEXT NOT NULL, dish_types TEXT NOT NULL, diets TEXT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN reference_data.recipe.cuisines IS \'(DC2Type:array)\'');
        $this->addSql('COMMENT ON COLUMN reference_data.recipe.dish_types IS \'(DC2Type:array)\'');
        $this->addSql('COMMENT ON COLUMN reference_data.recipe.diets IS \'(DC2Type:array)\'');
        $this->addSql('CREATE TABLE reference_data.recipe_meta (id INT NOT NULL, instructions TEXT NOT NULL, analysed_instructions JSON NOT NULL, health_score INT NOT NULL, ingredients JSON NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE "user_management"."user" (id INT NOT NULL, username VARCHAR(200) NOT NULL, profile_picture VARCHAR(512) DEFAULT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, last_login TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE user_diet (user_id INT NOT NULL, diet_id INT NOT NULL, PRIMARY KEY(user_id, diet_id))');
        $this->addSql('CREATE INDEX IDX_E76529E9A76ED395 ON user_diet (user_id)');
        $this->addSql('CREATE INDEX IDX_E76529E9E1E13ACE ON user_diet (diet_id)');
        $this->addSql('CREATE TABLE user_allergies (user_id INT NOT NULL, allergies_id INT NOT NULL, PRIMARY KEY(user_id, allergies_id))');
        $this->addSql('CREATE INDEX IDX_8DF932FFA76ED395 ON user_allergies (user_id)');
        $this->addSql('CREATE INDEX IDX_8DF932FF7104939B ON user_allergies (allergies_id)');
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
        $this->addSql('ALTER TABLE user_diet ADD CONSTRAINT FK_E76529E9A76ED395 FOREIGN KEY (user_id) REFERENCES "user_management"."user" (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE user_diet ADD CONSTRAINT FK_E76529E9E1E13ACE FOREIGN KEY (diet_id) REFERENCES reference_data.diet (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE user_allergies ADD CONSTRAINT FK_8DF932FFA76ED395 FOREIGN KEY (user_id) REFERENCES "user_management"."user" (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE user_allergies ADD CONSTRAINT FK_8DF932FF7104939B FOREIGN KEY (allergies_id) REFERENCES reference_data.allergies (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE reference_data.allergies_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE reference_data.cuisine_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE reference_data.diet_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE reference_data.recipe_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE reference_data.recipe_meta_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE "user_management"."user_id_seq" CASCADE');
        $this->addSql('ALTER TABLE user_diet DROP CONSTRAINT FK_E76529E9A76ED395');
        $this->addSql('ALTER TABLE user_diet DROP CONSTRAINT FK_E76529E9E1E13ACE');
        $this->addSql('ALTER TABLE user_allergies DROP CONSTRAINT FK_8DF932FFA76ED395');
        $this->addSql('ALTER TABLE user_allergies DROP CONSTRAINT FK_8DF932FF7104939B');
        $this->addSql('DROP TABLE reference_data.allergies');
        $this->addSql('DROP TABLE reference_data.cuisine');
        $this->addSql('DROP TABLE reference_data.diet');
        $this->addSql('DROP TABLE reference_data.recipe');
        $this->addSql('DROP TABLE reference_data.recipe_meta');
        $this->addSql('DROP TABLE "user_management"."user"');
        $this->addSql('DROP TABLE user_diet');
        $this->addSql('DROP TABLE user_allergies');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
