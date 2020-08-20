<?php
declare(strict_types=1);

namespace App\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20200819201301 extends AbstractMigration
{
    public function getDescription() : string
    {
        return 'Initialize structure';
    }

    public function up(Schema $schema) : void
    {
        $this->abortIf(
            $this->connection->getDatabasePlatform()->getName() !== 'mysql',
            'Migration can only be executed safely on \'mysql\'.'
        );

        $this->addSql('
            CREATE TABLE insured_people_amount_factor (
                id INT AUTO_INCREMENT NOT NULL, 
                type VARCHAR(20) NOT NULL, 
                UNIQUE INDEX type (type), 
                PRIMARY KEY(id)
            ) 
            DEFAULT CHARACTER SET utf8mb4 
            COLLATE `utf8mb4_unicode_ci` 
            ENGINE = InnoDB'
        );
        $this->addSql('
            CREATE TABLE price_model (
                id INT AUTO_INCREMENT NOT NULL, 
                district_factor_id INT NOT NULL, 
                insured_people_factor_id INT NOT NULL, 
                age_factor_id INT NOT NULL, 
                price NUMERIC(8, 2) NOT NULL, 
                INDEX age_factor_id (age_factor_id), 
                INDEX district_factor_id (district_factor_id), 
                INDEX insured_people_factor_id (insured_people_factor_id), 
                UNIQUE INDEX factors (age_factor_id, district_factor_id, insured_people_factor_id), 
                PRIMARY KEY(id)
            ) 
            DEFAULT CHARACTER SET utf8mb4 
            COLLATE `utf8mb4_unicode_ci` 
            ENGINE = InnoDB'
        );
        $this->addSql('
            CREATE TABLE age_factor (
                id INT AUTO_INCREMENT NOT NULL, 
                type VARCHAR(20) NOT NULL, 
                UNIQUE INDEX type (type), 
                PRIMARY KEY(id)
            ) 
            DEFAULT CHARACTER SET utf8mb4 
            COLLATE `utf8mb4_unicode_ci` 
            ENGINE = InnoDB'
        );
        $this->addSql('
            CREATE TABLE district (
                id INT AUTO_INCREMENT NOT NULL, 
                district_code_id INT NOT NULL, 
                zip INT NOT NULL, 
                city VARCHAR(50) NOT NULL, 
                INDEX district_code_id (district_code_id), 
                UNIQUE INDEX zip (zip), 
                UNIQUE INDEX zip_code (zip, district_code_id), 
                PRIMARY KEY(id)
            ) 
            DEFAULT CHARACTER SET utf8mb4 
            COLLATE `utf8mb4_unicode_ci` 
            ENGINE = InnoDB'
        );
        $this->addSql('
            CREATE TABLE district_code (
                id INT AUTO_INCREMENT NOT NULL, 
                value VARCHAR(2) NOT NULL, 
                UNIQUE INDEX value (value), 
                PRIMARY KEY(id)
            ) 
            DEFAULT CHARACTER SET utf8mb4 
            COLLATE `utf8mb4_unicode_ci` 
            ENGINE = InnoDB'
        );
        $this->addSql('
            CREATE TABLE district_factor (
                id INT AUTO_INCREMENT NOT NULL, 
                district_code_id INT NOT NULL, 
                UNIQUE INDEX UNIQ_5247CBB19B03022A (district_code_id), 
                INDEX district_code_id (district_code_id), 
                PRIMARY KEY(id)
            ) 
            DEFAULT CHARACTER SET utf8mb4 
            COLLATE `utf8mb4_unicode_ci` 
            ENGINE = InnoDB'
        );
        $this->addSql('
            ALTER TABLE price_model 
            ADD CONSTRAINT FK_FC5C7AB9626B8BF3 
            FOREIGN KEY (district_factor_id) 
            REFERENCES district_factor (id)
        ');
        $this->addSql('
            ALTER TABLE price_model 
            ADD CONSTRAINT FK_FC5C7AB955D4EE4E 
            FOREIGN KEY (insured_people_factor_id) 
            REFERENCES insured_people_amount_factor (id)
        ');
        $this->addSql('
            ALTER TABLE price_model 
            ADD CONSTRAINT FK_FC5C7AB9B3C6F26C 
            FOREIGN KEY (age_factor_id) 
            REFERENCES age_factor (id)
        ');
        $this->addSql('
            ALTER TABLE district 
            ADD CONSTRAINT FK_31C154879B03022A 
            FOREIGN KEY (district_code_id) 
            REFERENCES district_code (id)
        ');
        $this->addSql('
            ALTER TABLE district_factor 
            ADD CONSTRAINT FK_5247CBB19B03022A 
            FOREIGN KEY (district_code_id) 
            REFERENCES district_code (id)
        ');
    }

    public function down(Schema $schema) : void
    {
        $this->abortIf(
            $this->connection->getDatabasePlatform()->getName() !== 'mysql',
            'Migration can only be executed safely on \'mysql\'.'
        );

        $this->addSql('ALTER TABLE price_model DROP FOREIGN KEY FK_FC5C7AB955D4EE4E');
        $this->addSql('ALTER TABLE price_model DROP FOREIGN KEY FK_FC5C7AB9B3C6F26C');
        $this->addSql('ALTER TABLE district DROP FOREIGN KEY FK_31C154879B03022A');
        $this->addSql('ALTER TABLE district_factor DROP FOREIGN KEY FK_5247CBB19B03022A');
        $this->addSql('ALTER TABLE price_model DROP FOREIGN KEY FK_FC5C7AB9626B8BF3');
        $this->addSql('DROP TABLE insured_people_amount_factor');
        $this->addSql('DROP TABLE price_model');
        $this->addSql('DROP TABLE age_factor');
        $this->addSql('DROP TABLE district');
        $this->addSql('DROP TABLE district_code');
        $this->addSql('DROP TABLE district_factor');
    }
}
