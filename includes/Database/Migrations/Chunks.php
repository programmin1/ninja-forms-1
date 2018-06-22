<?php if ( ! defined( 'ABSPATH' ) ) exit;

class NF_Database_Migrations_Chunks extends NF_Abstracts_Migration
{
    public function __construct()
    {
        parent::__construct(
            'nf3_chunks',
            'nf_migration_create_table_chunks'
        );
    }

    public function run()
    {
        $query = "CREATE TABLE IF NOT EXISTS {$this->table_name()} (
            `id` int NOT NULL AUTO_INCREMENT,
            `name` varchar(200),
            `value` longtext,
            UNIQUE KEY (`id`)
        ) {$this->charset_collate()};";

        dbDelta( $query );
    }

}
