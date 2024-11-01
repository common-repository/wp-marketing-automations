<?php

class BWFAN_Table_Validation_Controller {

	public static $tables = [
		'bwfan_abandonedcarts',
		'bwfan_automation_complete_contact',
		'bwfan_automationmeta',
		'bwfan_automation_contact',
		'bwfan_automation_contact_trail',
		'bwfan_automation_events',
		'bwfan_automation_step',
		'bwfan_automations',
		'bwf_contact_fields',
		'bwfan_contact_note',
		'bwfan_conversions',
		'bwfan_engagement_tracking',
		'bwfan_engagement_trackingmeta',
		'bwfan_field_groups',
		'bwfan_fields',
		'bwfan_message',
		'bwfan_message_unsubscribe',
		'bwfan_templates',
		'bwfan_terms',
		'bwf_options',
		'bwf_actions',
		'bwf_action_claim',
		'bwf_contact',
		'bwf_contact_meta',
		'bwf_wc_customers',
	];

	public static $pro_tables = [
		'bwfan_api_keys',
		'bwfan_broadcast',
		'bwfan_bulk_action',
		'bwfan_form_feeds',
		'bwfan_import_export',
		'bwfan_link_triggers',
	];

	public static $v1_tables = [
		'bwfan_contact_automations',
		'bwfan_logs',
		'bwfan_logmeta',
		'bwfan_tasks',
		'bwfan_taskmeta',
		'bwfan_task_claim',
		'bwfan_automation_contact_claim'
	];

	public static $core_tables = [
		'bwf_actions',
		'bwf_action_claim',
		'bwf_contact',
		'bwf_contact_meta',
		'bwf_wc_customers',
	];

	/**
	 * Validate database tables and return missing ones
	 *
	 * @param array $tables
	 *
	 * @return array
	 */
	public static function bwfan_validate_db_tables( $tables ) {
		global $wpdb;

		$table_names = array_map( function ( $table ) use ( $wpdb ) {
			return $wpdb->prefix . $table;
		}, $tables );

		$placeholders    = implode( ',', array_fill( 0, count( $table_names ), '%s' ) );
		$query           = $wpdb->prepare( "SELECT TABLE_NAME FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = %s AND TABLE_NAME IN ($placeholders)", array_merge( [ $wpdb->dbname ], $table_names ) );
		$existing_tables = $wpdb->get_col( $query );

		$missing_tables = array_diff( $table_names, $existing_tables );

		return ! empty( $missing_tables ) ? array_map( function ( $table ) use ( $wpdb ) {
			return str_replace( $wpdb->prefix, '', $table );
		}, $missing_tables ) : [];
	}

	/**
	 * @param $missing_tables
	 *
	 * @return bool
	 */
	public static function create_missing_tables( $missing_tables ) {
		self::load_table_classes();
		$db_errors = [];
		global $wpdb;

		foreach ( $missing_tables as $table ) {

			/** Check for core tables */
			if ( in_array( $table, self::$core_tables ) ) {
				$method_name = 'create_' . $table;
				if ( ! method_exists( __CLASS__, $method_name ) ) {
					continue;
				}
				$sql    = call_user_func_array( [ __CLASS__, $method_name ], [] );
				$result = $wpdb->query( $sql );
				if ( $result === false ) {
					$db_errors[] = $wpdb->last_error;
				}
				continue;
			}

			$class_name = str_replace( [ 'bwf_', 'bwfan_' ], '', $table );
			$class_name = 'BWFAN_DB_Table_' . $class_name;
			if ( ! class_exists( $class_name ) ) {
				continue;
			}
			/** @var BWFAN_DB_Tables_Base $table_instance */
			$table_instance = new $class_name();
			$table_instance->create_table();

			if ( ! empty( $table_instance->db_errors ) ) {
				$db_errors[] = $table_instance->db_errors;
			}
		}
		if ( empty( $db_errors ) ) {
			bwf_options_update( 'bwfan_table_validation_error', 0 );

			return true;
		}

		BWFAN_Common::log_test_data( array( 'table validation logs ' => $db_errors ), 'base_table_validation', true );

		return false;
	}

	/**
	 * This function checks for any missing required database tables and returns their names in an array.
	 *
	 * @return array An array of missing table names.
	 */
	public static function check_missing_tables() {

		$missing_tables = self::bwfan_validate_db_tables( self::$tables );

		if ( BWFAN_Common::is_automation_v1_active() ) {
			$v1_tables      = self::bwfan_validate_db_tables( self::$v1_tables );
			$missing_tables = array_merge( $missing_tables, $v1_tables );
		}

		if ( bwfan_is_autonami_pro_active() ) {
			$pro_tables     = self::bwfan_validate_db_tables( self::$pro_tables );
			$missing_tables = array_merge( $missing_tables, $pro_tables );
		}

		return $missing_tables;
	}

	public static function load_table_classes() {
		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

		$dir = BWFAN_PLUGIN_DIR . '/includes/db/tables';

		/** Load base class of verify tables */
		include_once( $dir . "/bwfan-db-tables-base.php" );

		self::load_class_files( $dir );

		/** Load pro tables class files */

		if ( bwfan_is_autonami_pro_active() ) {
			$pro_dir = BWFAN_PRO_PLUGIN_DIR . '/includes/db/tables';
			self::load_class_files( $pro_dir );
		}
	}

	public static function load_class_files( $dir ) {
		foreach ( glob( $dir . '/class-*.php' ) as $_field_filename ) {
			$file_data = pathinfo( $_field_filename );

			if ( isset( $file_data['basename'] ) && 'index.php' === $file_data['basename'] ) {
				continue;
			}
			require_once( $_field_filename );
		}
	}

	public static function get_collation() {

		global $wpdb;
		$collate = '';
		if ( $wpdb->has_cap( 'collation' ) ) {
			$collate = $wpdb->get_charset_collate();
		}

		return $collate;
	}

	/**
	 * This function validates if any required tables are missing and updates the option accordingly.
	 *
	 * @return int Returns 1 if there are missing tables, 0 otherwise.
	 */
	public static function get_table_validate_option() {
		if ( bwf_options_get( 'bwfan_table_validation_error' ) ) {
			return bwf_options_get( 'bwfan_table_validation_error' );
		}

		$missing_tables = self::check_missing_tables();

		$table_validate = ! empty( $missing_tables ) ? 1 : 0;

		bwf_options_update( 'bwfan_table_validation_error', $table_validate );

		return $table_validate;
	}

	public static function create_bwf_contact() {
		global $wpdb;
		$collate = self::get_collation();

		return "CREATE TABLE `{$wpdb->prefix}bwf_contact` (
					`id` int(12) unsigned NOT NULL AUTO_INCREMENT,
					`wpid` int(12) NOT NULL,
					`uid` varchar(35) NOT NULL DEFAULT '',
					`email` varchar(100) NOT NULL,
					`f_name` varchar(100),
					`l_name` varchar(100),
					`contact_no` varchar(20),
					`country` char(2),
					`state` varchar(100),
					`timezone` varchar(50) DEFAULT '',
					`type` varchar(20) DEFAULT 'lead',
					`source` varchar(100) DEFAULT '',
					`points` bigint(20) unsigned NOT NULL DEFAULT '0', 
					`tags` longtext,
					`lists` longtext,
					`last_modified` DateTime NOT NULL,
					`creation_date` DateTime NOT NULL,
					`status` int(2) NOT NULL DEFAULT 1,
					PRIMARY KEY (`id`),
					KEY `id` (`id`),
					KEY `wpid` (`wpid`),
					KEY `uid` (`uid`),
					UNIQUE KEY (`email`)
	                )$collate;";
	}

	public static function create_bwf_contact_meta() {
		global $wpdb;
		$collate = self::get_collation();

		return "CREATE TABLE `{$wpdb->prefix}bwf_contact_meta` (
					`meta_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
					`contact_id` bigint(20) unsigned NOT NULL DEFAULT '0',
					`meta_key` varchar(50) DEFAULT NULL,    
					`meta_value` longtext,
					PRIMARY KEY (`meta_id`)
		            ) $collate;";
	}

	public static function create_bwf_actions() {
		global $wpdb;
		$collate = self::get_collation();

		return "CREATE TABLE `{$wpdb->prefix}bwf_actions` (
					 id bigint(20) unsigned NOT NULL auto_increment,
			          c_date datetime NOT NULL default '0000-00-00 00:00:00',
			          e_time int(12) NOT NULL default 0,
			          hook varchar(255) not null,
			          args longtext null,
			          status int(1) not null default 0 COMMENT '0 - Pending | 1 - Running',
			          recurring_interval int(10) not null default 0,
			          group_slug varchar(255) not null default 'woofunnels',
			          claim_id bigint(20) unsigned NOT NULL default 0,
					  PRIMARY KEY (id),
					  KEY id (id),
					  KEY e_time (e_time),
					  KEY hook (hook(191)),
					  KEY status (status),
					  KEY group_slug (group_slug(191)),
					  KEY claim_id (claim_id)
					) $collate;";
	}

	public static function create_bwf_action_claim() {
		global $wpdb;
		$collate = self::get_collation();

		return "CREATE TABLE `{$wpdb->prefix}bwf_action_claim` (
					id bigint(20) unsigned NOT NULL auto_increment,
					  date datetime NOT NULL default '0000-00-00 00:00:00',
					  PRIMARY KEY (id),
					  KEY date (date)
					) $collate;";
	}

	public static function create_bwf_wc_customers() {
		global $wpdb;
		$collate = self::get_collation();

		return "CREATE TABLE `{$wpdb->prefix}bwf_wc_customers` (
					`id` int(12) unsigned NOT NULL AUTO_INCREMENT,
	                `cid` int(12) NOT NULL,
	                `l_order_date` DateTime NOT NULL,
	                `f_order_date` DateTime NOT NULL,
	                `total_order_count` int(7) NOT NULL,
	                `total_order_value` double NOT NULL,
	                `aov` double NOT NULL,
	                `purchased_products` longtext,
	                `purchased_products_cats` longtext,
	                `purchased_products_tags` longtext,
	                `used_coupons` longtext,
	                PRIMARY KEY (`id`),
	                KEY `id` (`id`),
	                UNIQUE KEY`cid` (`cid`)               
	                ) $collate;";
	}
}
