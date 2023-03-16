<?php

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

class Version20230315000000 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        // Create movie table
        $table = $schema->createTable('movie');
        $table->addColumn('id', 'integer', ['autoincrement' => true]);
        $table->addColumn('title', 'string', ['length' => 255]);
        $table->addColumn('duration', 'integer');
        $table->setPrimaryKey(['id']);
        $table->addOption('engine', 'InnoDB');

        // Create people table
        $table = $schema->createTable('people');
        $table->addColumn('id', 'integer', ['autoincrement' => true]);
        $table->addColumn('firstname', 'string', ['length' => 255]);
        $table->addColumn('lastname', 'string', ['length' => 255]);
        $table->addColumn('date_of_birth', 'date');
        $table->addColumn('nationality', 'string', ['length' => 255]);
        $table->setPrimaryKey(['id']);
        $table->addOption('engine', 'InnoDB');

        // Create movie_has_people table
        $table = $schema->createTable('movie_has_people');
        $table->addColumn('Movie_id', 'integer');
        $table->addColumn('People_id', 'integer');
        $table->addColumn('role', 'string', ['length' => 255]);
        $table->addColumn('significance', 'enum', ['values' => ['principal', 'secondaire'], 'notnull' => false]);
        $table->setPrimaryKey(['Movie_id', 'People_id']);
        $table->addForeignKeyConstraint('movie', ['Movie_id'], ['id'], ['onDelete' => 'CASCADE']);
        $table->addForeignKeyConstraint('people', ['People_id'], ['id'], ['onDelete' => 'CASCADE']);
        $table->addOption('engine', 'InnoDB');

         // Create the type table
        $typeTable = $schema->createTable('type');
        $typeTable->addColumn('id', 'integer', ['autoincrement' => true]);
        $typeTable->addColumn('name', 'string', ['length' => 255, 'notnull' => true]);
        $typeTable->setPrimaryKey(['id']);
        $typeTable->addOption('engine', 'InnoDB');

        // Create the movie_has_type table
        $movieHasTypeTable = $schema->createTable('movie_has_type');
        $movieHasTypeTable->addColumn('movie_id', 'integer', ['notnull' => true]);
        $movieHasTypeTable->addColumn('type_id', 'integer', ['notnull' => true]);
        $movieHasTypeTable->setPrimaryKey(['movie_id', 'type_id']);
        $movieHasTypeTable->addOption('engine', 'InnoDB');
        $movieHasTypeTable->addForeignKeyConstraint('movie', ['movie_id'], ['id'], ['onDelete' => 'CASCADE'], 'fk_Movie_has_Type_Movie1');
        $movieHasTypeTable->addForeignKeyConstraint('type', ['type_id'], ['id'], ['onDelete' => 'CASCADE'], 'fk_Movie_has_Type_Type1');
    }
function down(Schema $schema): void
    {
     // Drop the movie_has_type table
    $schema->dropTable('movie_has_type');

    // Drop the type table
    $schema->dropTable('type');

    // Drop the movie_has_people table
    $schema->dropTable('movie_has_people');

    // Drop the people table
    $schema->dropTable('people');

    // Drop the movie table
    $schema->dropTable('movie');
    }
}


