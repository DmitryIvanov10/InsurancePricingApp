<?php
declare(strict_types=1);

namespace App\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20200819201740 extends AbstractMigration
{
    public function getDescription() : string
    {
        return 'Initialize data';
    }

    public function up(Schema $schema) : void
    {
        $this->abortIf(
            $this->connection->getDatabasePlatform()->getName() !== 'mysql',
            'Migration can only be executed safely on \'mysql\'.'
        );

        $this->addSql('
            INSERT INTO age_factor 
                (type) 
            VALUES 
                (\'YOUNG\'), 
                (\'OLD\')
        ');
        $this->addSql('
            INSERT INTO insured_people_amount_factor 
                (type) 
            VALUES 
                (\'ALONE\'), 
                (\'GROUP\')
        ');
        $this->addSql('
            INSERT INTO district_code 
                (value) 
            VALUES 
                (\'ZU\'),
                (\'LU\'),
                (\'SG\')
        ');
        $this->addSql('
            INSERT INTO district 
                (zip, city, district_code_id) 
            VALUES 
                (8000, \'Zürich\', 1),
                (6000, \'Luzern\', 2),
                (9008, \'St. Gallen\', 3)
        ');
        $this->addSql('
            INSERT INTO district_factor 
                (district_code_id) 
            VALUES 
                (1),
                (2),
                (3)
        ');
        $this->addSql('
            INSERT INTO price_model 
                (district_factor_id, insured_people_factor_id, age_factor_id, price) 
            VALUES 
                (1, 1, 1, 12.43),
                (1, 1, 2, 8.5),
                (1, 2, 1, 23.3),
                (1, 2, 2, 9.1),
                (2, 1, 1, 7.4),
                (2, 1, 2, 89.12),
                (2, 2, 1, 78.6),
                (2, 2, 2, 21.5),
                (3, 1, 1, 37.4),
                (3, 1, 2, 15.4),
                (3, 2, 1, 8.7),
                (3, 2, 2, 1.6)
        ');
    }

    public function down(Schema $schema) : void
    {
        $this->abortIf(
            $this->connection->getDatabasePlatform()->getName() !== 'mysql',
            'Migration can only be executed safely on \'mysql\'.'
        );

        $this->addSql('SET FOREIGN_KEY_CHECKS = 0');
        $this->addSql('TRUNCATE TABLE insured_people_amount_factor');
        $this->addSql('TRUNCATE TABLE age_factor');
        $this->addSql('TRUNCATE TABLE district');
        $this->addSql('TRUNCATE TABLE district_factor');
        $this->addSql('TRUNCATE TABLE district_code');
        $this->addSql('TRUNCATE TABLE price_model');
        $this->addSql('SET FOREIGN_KEY_CHECKS = 1');
    }
}
