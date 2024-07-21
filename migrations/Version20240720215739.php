<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240720215739 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP SEQUENCE user_management.weekly_meal_planner_id_seq CASCADE');
        $this->addSql('CREATE SEQUENCE user_management.weekly_meal_plan_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE user_management.weekly_meal_plan (id INT NOT NULL, user_id_id INT NOT NULL, recipe_id INT NOT NULL, plan_date DATE NOT NULL, time_slot VARCHAR(15) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_69DEF2979D86650F ON user_management.weekly_meal_plan (user_id_id)');
        $this->addSql('CREATE INDEX IDX_69DEF29759D8A214 ON user_management.weekly_meal_plan (recipe_id)');
        $this->addSql('ALTER TABLE user_management.weekly_meal_plan ADD CONSTRAINT FK_69DEF2979D86650F FOREIGN KEY (user_id_id) REFERENCES "user_management"."user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE user_management.weekly_meal_plan ADD CONSTRAINT FK_69DEF29759D8A214 FOREIGN KEY (recipe_id) REFERENCES reference_data.recipe (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE user_management.weekly_meal_planner DROP CONSTRAINT fk_a434623a9d86650f');
        $this->addSql('ALTER TABLE user_management.weekly_meal_planner DROP CONSTRAINT fk_a434623a69574a48');
        $this->addSql('DROP TABLE user_management.weekly_meal_planner');
        $this->addSql('ALTER TABLE user_management.user_diet DROP CONSTRAINT FK_DCF06A54A76ED395');
        $this->addSql('ALTER TABLE user_management.user_diet ADD CONSTRAINT FK_DCF06A54A76ED395 FOREIGN KEY (user_id) REFERENCES "user_management"."user" (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE user_management.user_allergies DROP CONSTRAINT FK_2B659CAAA76ED395');
        $this->addSql('ALTER TABLE user_management.user_allergies ADD CONSTRAINT FK_2B659CAAA76ED395 FOREIGN KEY (user_id) REFERENCES "user_management"."user" (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE user_management.weekly_meal_plan_id_seq CASCADE');
        $this->addSql('CREATE SEQUENCE user_management.weekly_meal_planner_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE user_management.weekly_meal_planner (id INT NOT NULL, user_id_id INT NOT NULL, recipe_id_id INT NOT NULL, time_slot VARCHAR(10) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX idx_a434623a69574a48 ON user_management.weekly_meal_planner (recipe_id_id)');
        $this->addSql('CREATE INDEX idx_a434623a9d86650f ON user_management.weekly_meal_planner (user_id_id)');
        $this->addSql('ALTER TABLE user_management.weekly_meal_planner ADD CONSTRAINT fk_a434623a9d86650f FOREIGN KEY (user_id_id) REFERENCES user_management."user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE user_management.weekly_meal_planner ADD CONSTRAINT fk_a434623a69574a48 FOREIGN KEY (recipe_id_id) REFERENCES reference_data.recipe (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE user_management.weekly_meal_plan DROP CONSTRAINT FK_69DEF2979D86650F');
        $this->addSql('ALTER TABLE user_management.weekly_meal_plan DROP CONSTRAINT FK_69DEF29759D8A214');
        $this->addSql('DROP TABLE user_management.weekly_meal_plan');
        $this->addSql('ALTER TABLE user_management.user_allergies DROP CONSTRAINT fk_2b659caaa76ed395');
        $this->addSql('ALTER TABLE user_management.user_allergies ADD CONSTRAINT fk_2b659caaa76ed395 FOREIGN KEY (user_id) REFERENCES user_management."user" (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE user_management.user_diet DROP CONSTRAINT fk_dcf06a54a76ed395');
        $this->addSql('ALTER TABLE user_management.user_diet ADD CONSTRAINT fk_dcf06a54a76ed395 FOREIGN KEY (user_id) REFERENCES user_management."user" (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }
}
