<?php if ( ! defined( 'ABSPATH' ) ) exit;

class NF_Database_Migrations_Forms extends NF_Abstracts_Migration
{
    public function __construct()
    {
        parent::__construct(
            'nf3_forms',
            'nf_migration_create_table_forms'
        );
    }

    public function run()
    {
        $query = "CREATE TABLE IF NOT EXISTS {$this->table_name()} (
            `id` int NOT NULL AUTO_INCREMENT,
            `title` longtext,
            `created_at` TIMESTAMP,
            `updated_at` DATETIME,
            `form_title` longtext,
            `label_pos` varchar(15),
            `show_title` bit,
            `clear_complete` bit,
            `hide_complete` bit,
            `logged_in` bit,
            `seq_num` int,
            UNIQUE KEY (`id`)
        ) {$this->charset_collate()};";

        dbDelta( $query );
    }

}
