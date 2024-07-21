<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240721035337 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reference_data.recipe ALTER cuisines TYPE TEXT');
        $this->addSql('ALTER TABLE reference_data.recipe ALTER cuisines DROP NOT NULL');
        $this->addSql('ALTER TABLE reference_data.recipe ALTER dish_types TYPE TEXT');
        $this->addSql('ALTER TABLE reference_data.recipe ALTER dish_types DROP NOT NULL');
        $this->addSql('ALTER TABLE reference_data.recipe ALTER diets TYPE TEXT');
        $this->addSql('ALTER TABLE reference_data.recipe ALTER diets DROP NOT NULL');
        $this->addSql('COMMENT ON COLUMN reference_data.recipe.cuisines IS NULL');
        $this->addSql('COMMENT ON COLUMN reference_data.recipe.dish_types IS NULL');
        $this->addSql('COMMENT ON COLUMN reference_data.recipe.diets IS NULL');
        $this->addSql('ALTER TABLE user_management.user_diet DROP CONSTRAINT FK_DCF06A54A76ED395');
        $this->addSql('ALTER TABLE user_management.user_diet ADD CONSTRAINT FK_DCF06A54A76ED395 FOREIGN KEY (user_id) REFERENCES "user_management"."user" (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE user_management.user_allergies DROP CONSTRAINT FK_2B659CAAA76ED395');
        $this->addSql('ALTER TABLE user_management.user_allergies ADD CONSTRAINT FK_2B659CAAA76ED395 FOREIGN KEY (user_id) REFERENCES "user_management"."user" (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE user_management.user_allergies DROP CONSTRAINT fk_2b659caaa76ed395');
        $this->addSql('ALTER TABLE user_management.user_allergies ADD CONSTRAINT fk_2b659caaa76ed395 FOREIGN KEY (user_id) REFERENCES user_management."user" (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE user_management.user_diet DROP CONSTRAINT fk_dcf06a54a76ed395');
        $this->addSql('ALTER TABLE user_management.user_diet ADD CONSTRAINT fk_dcf06a54a76ed395 FOREIGN KEY (user_id) REFERENCES user_management."user" (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE reference_data.recipe ALTER cuisines TYPE TEXT');
        $this->addSql('ALTER TABLE reference_data.recipe ALTER cuisines SET NOT NULL');
        $this->addSql('ALTER TABLE reference_data.recipe ALTER dish_types TYPE TEXT');
        $this->addSql('ALTER TABLE reference_data.recipe ALTER dish_types SET NOT NULL');
        $this->addSql('ALTER TABLE reference_data.recipe ALTER diets TYPE TEXT');
        $this->addSql('ALTER TABLE reference_data.recipe ALTER diets SET NOT NULL');
        $this->addSql('COMMENT ON COLUMN reference_data.recipe.cuisines IS \'(DC2Type:array)\'');
        $this->addSql('COMMENT ON COLUMN reference_data.recipe.dish_types IS \'(DC2Type:array)\'');
        $this->addSql('COMMENT ON COLUMN reference_data.recipe.diets IS \'(DC2Type:array)\'');
    }
}
