<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190724120303 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('INSERT INTO `gender` (`name`) VALUES (\'Femme\')');
        $this->addSql('INSERT INTO `county` (`name`) VALUES (\'Orléans\')');
        $this->addSql('INSERT INTO `user` (`email`, `roles`, `password`, `lastname`, `firstname`, `gender_id`, `knighted_at`, `entered_at`, `county_id`) VALUES (\'nawal.zakarya@gmail.com\', \'[\"ROLE_ADMIN\"]\', \'$argon2id$v=19$m=65536,t=6,p=1$KeQctlMlariZL/aRrKGjbA$0NfbplgL0SoToKXW4BZZ2X7SBLw1VJ0vbvujhHzadjY\', \'Zakarya\', \'Nawal\', \'1\', \'2012-01-01\', \'2010-01-01\', 1)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('TRUNCATE TABLE gender');
        $this->addSql('TRUNCATE TABLE county');
        $this->addSql('TRUNCATE TABLE user');
    }
}