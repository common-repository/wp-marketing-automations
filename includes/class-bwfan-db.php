<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Class BWFAN_DB
 * @package Autonami
 * @author XlPlugins
 */
#[AllowDynamicProperties]
class BWFAN_DB {
	private static $ins = null;

	protected $tables_created = false;
	protected $method_run = [];

	/**
	 * BWFAN_DB constructor.
	 */
	public function __construct() {
		global $wpdb;
		$wpdb->bwfan_abandonedcarts      = $wpdb->prefix . 'bwfan_abandonedcarts';
		$wpdb->bwfan_automations         = $wpdb->prefix . 'bwfan_automations';
		$wpdb->bwfan_automationmeta      = $wpdb->prefix . 'bwfan_automationmeta';
		$wpdb->bwfan_tasks               = $wpdb->prefix . 'bwfan_tasks';
		$wpdb->bwfan_taskmeta            = $wpdb->prefix . 'bwfan_taskmeta';
		$wpdb->bwfan_task_claim          = $wpdb->prefix . 'bwfan_task_claim';
		$wpdb->bwfan_logs                = $wpdb->prefix . 'bwfan_logs';
		$wpdb->bwfan_logmeta             = $wpdb->prefix . 'bwfan_logmeta';
		$wpdb->bwfan_message_unsubscribe = $wpdb->prefix . 'bwfan_message_unsubscribe';
		$wpdb->bwfan_contact_automations = $wpdb->prefix . 'bwfan_contact_automations';

		/** v2 */
		$wpdb->bwfan_automation_contact          = $wpdb->prefix . 'bwfan_automation_contact';
		$wpdb->bwfan_automation_contact_claim    = $wpdb->prefix . 'bwfan_automation_contact_claim';
		$wpdb->bwfan_automation_contact_trail    = $wpdb->prefix . 'bwfan_automation_contact_trail';
		$wpdb->bwfan_automation_complete_contact = $wpdb->prefix . 'bwfan_automation_complete_contact';
		$wpdb->bwfan_automation_step             = $wpdb->prefix . 'bwfan_automation_step';

		/** Engagement tables */
		$wpdb->bwfan_conversions             = $wpdb->prefix . 'bwfan_conversions';
		$wpdb->bwfan_engagement_tracking     = $wpdb->prefix . 'bwfan_engagement_tracking';
		$wpdb->bwfan_engagement_trackingmeta = $wpdb->prefix . 'bwfan_engagement_trackingmeta';

		add_action( 'plugins_loaded', [ $this, 'load_db_classes' ], 8 );

		add_action( 'admin_init', [ $this, 'version_1_0_0' ], 10 );
		add_action( 'admin_init', [ $this, 'db_update' ], 11 );
	}

	/**
	 * Return the object of current class
	 *
	 * @return null|BWFAN_DB
	 */
	public static function get_instance() {
		if ( null === self::$ins ) {
			self::$ins = new self();
		}

		return self::$ins;
	}

	/**
	 * Include all the DB Table files
	 */
	public static function load_db_classes() {
		self::load_class_files( __DIR__ . '/db' );
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

	/**
	 * loading table related classes
	 *
	 * @return void
	 */
	public static function load_table_classes() {
		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

		$dir = __DIR__ . '/db/tables';
		/** Load base class of verify tables */
		include_once( $dir . "/bwfan-db-tables-base.php" );

		self::load_class_files( $dir );
	}

	/**
	 * Version 1.0 update
	 */
	public function version_1_0_0() {
		if ( false !== get_option( 'bwfan_ver_1_0', false ) ) {
			return;
		}

		self::load_table_classes();

		$table_instance = new BWFAN_DB_Table_Options();
		$table_instance->create_table();
		if ( ! empty( $table_instance->db_errors ) ) {
			$db_errors[] = $table_instance->db_errors;
		}

		$table_instance = new BWFAN_DB_Table_Automations();
		$table_instance->create_table();
		if ( ! empty( $table_instance->db_errors ) ) {
			$db_errors[] = $table_instance->db_errors;
		}

		$table_instance = new BWFAN_DB_Table_Automationmeta();
		$table_instance->create_table();
		if ( ! empty( $table_instance->db_errors ) ) {
			$db_errors[] = $table_instance->db_errors;
		}

		$table_instance = new BWFAN_DB_Table_Message_Unsubscribe();
		$table_instance->create_table();
		if ( ! empty( $table_instance->db_errors ) ) {
			$db_errors[] = $table_instance->db_errors;
		}

		$table_instance = new BWFAN_DB_Table_AbandonedCarts();
		$table_instance->create_table();
		if ( ! empty( $table_instance->db_errors ) ) {
			$db_errors[] = $table_instance->db_errors;
		}

		$table_instance = new BWFAN_DB_Table_Automation_Events();
		$table_instance->create_table();
		if ( ! empty( $table_instance->db_errors ) ) {
			$db_errors[] = $table_instance->db_errors;
		}

		$this->tables_created = true;

		$this->method_run[] = '1.0.0';

		do_action( 'bwfan_db_1_0_tables_created' );

		update_option( 'bwfan_ver_1_0', date( 'Y-m-d' ), true );
		update_option( 'bwfan_new_user', 'yes', true );

		/** Unique key to share in rest calls */
		$unique_key = md5( time() );
		update_option( 'bwfan_u_key', $unique_key, true );

		/** Update v1 automation status */
		update_option( 'bwfan_automation_v1', '0', true );

		/** Scheduling actions one-time */
		$this->schedule_actions();

		/** Auto global settings */
		if ( BWFAN_Plugin_Dependency::woocommerce_active_check() ) {
			$global_option = get_option( 'bwfan_global_settings', array() );

			$global_option['bwfan_ab_enable'] = true;
			update_option( 'bwfan_global_settings', $global_option, true );
		}

		/** Cache handling */
		if ( class_exists( 'BWF_JSON_Cache' ) && method_exists( 'BWF_JSON_Cache', 'run_json_endpoints_cache_handling' ) ) {
			BWF_JSON_Cache::run_json_endpoints_cache_handling();
		}

		/** Updated block editor default values */
		update_option( 'bwf_global_block_editor_setting', BWFAN_Common::get_block_editor_default_setting() );

		/** set default settings for email notification */
		BWFAN_Notification_Email::set_bwfan_settings();

		/** Log if any mysql errors */
		if ( ! empty( $db_errors ) ) {
			BWFAN_Common::log_test_data( array_merge( [ __FUNCTION__ ], $db_errors ), 'db-creation-errors' );
		}
	}

	protected function schedule_actions() {
		$ins = BWFAN_Admin::get_instance();
		$ins->maybe_set_as_ct_worker();
		$ins->schedule_abandoned_cart_cron();
	}

	/**
	 * Create v1 automation related tables
	 *
	 * @return void
	 */
	public function db_create_v1_automation_tables() {
		self::load_table_classes();

		$table_instance = new BWFAN_DB_Table_Tasks();
		$table_instance->create_table();
		if ( ! empty( $table_instance->db_errors ) ) {
			$db_errors[] = $table_instance->db_errors;
		}

		$table_instance = new BWFAN_DB_Table_Taskmeta();
		$table_instance->create_table();
		if ( ! empty( $table_instance->db_errors ) ) {
			$db_errors[] = $table_instance->db_errors;
		}

		$table_instance = new BWFAN_DB_Table_Task_Claim();
		$table_instance->create_table();
		if ( ! empty( $table_instance->db_errors ) ) {
			$db_errors[] = $table_instance->db_errors;
		}

		$table_instance = new BWFAN_DB_Table_Logs();
		$table_instance->create_table();
		if ( ! empty( $table_instance->db_errors ) ) {
			$db_errors[] = $table_instance->db_errors;
		}

		$table_instance = new BWFAN_DB_Table_Logmeta();
		$table_instance->create_table();
		if ( ! empty( $table_instance->db_errors ) ) {
			$db_errors[] = $table_instance->db_errors;
		}

		$table_instance = new BWFAN_DB_Table_Contact_Automations();
		$table_instance->create_table();
		if ( ! empty( $table_instance->db_errors ) ) {
			$db_errors[] = $table_instance->db_errors;
		}

		/** Update v1 automation status */
		update_option( 'bwfan_automation_v1', '1', true );

		/** Log if any mysql errors */
		if ( ! empty( $db_errors ) ) {
			BWFAN_Common::log_test_data( array_merge( [ __FUNCTION__ ], $db_errors ), 'db-creation-errors' );
		}
	}

	/**
	 * Perform DB updates or once occurring updates
	 */
	public function db_update() {
		$db_changes = array(
			'2.0.10.1' => '2_0_10_1',
			'2.0.10.2' => '2_0_10_2',
			'2.0.10.3' => '2_0_10_3',
			'2.0.10.4' => '2_0_10_4',
			'2.0.10.5' => '2_0_10_5',
			'2.0.10.6' => '2_0_10_6',
			'2.0.10.7' => '2_0_10_7',
			'2.0.10.8' => '2_0_10_8',
			'2.4.2'    => '2_4_2',
			'2.4.4'    => '2_4_4',
			'2.6.1'    => '2_6_1',
			'2.6.2'    => '2_6_2',
			'2.6.3'    => '2_6_3',
			'2.7.0'    => '2_7_0',
			'2.8.0'    => '2_8_0',
			'2.8.4'    => '2_8_4',
			'3.0.0'    => '3_0_0',
			'3.0.1'    => '3_0_1',
			'3.0.1.1'  => '3_0_1_1',
			'3.0.4'    => '3_0_4',
			'3.0.5'    => '3_0_5',
			'3.2.1'    => '3_2_1',
			'3.2.2'    => '3_2_2',
		);
		$db_version = get_option( 'bwfan_db', '2.0' );

		foreach ( $db_changes as $version_key => $version_value ) {
			if ( version_compare( $db_version, $version_key, '<' ) ) {
				self::load_table_classes();

				$function_name = 'db_update_' . $version_value;
				$this->$function_name( $version_key );
			}
		}
	}

	/**
	 * @param $version_key
	 *
	 * @return void
	 */
	public function db_update_2_0_10_1( $version_key ) {
		global $wpdb;
		$db_errors = [];

		if ( ! is_array( $this->method_run ) || ! in_array( '1.0.0', $this->method_run, true ) ) {
			$column_exists = $wpdb->query( "SHOW COLUMNS FROM {$wpdb->prefix}bwfan_automations LIKE 'start'" );
			if ( empty( $column_exists ) ) {
				/** Add new columns in bwfan_automations table */
				$query = "ALTER TABLE {$wpdb->prefix}bwfan_automations
				ADD COLUMN `start` bigint(10) UNSIGNED NOT NULL,
				ADD COLUMN `v` tinyint(1) UNSIGNED NOT NULL default 1,
				ADD COLUMN `benchmark` varchar(150) NOT NULL,
				ADD COLUMN `title` varchar(255) NULL;";
				$wpdb->query( $query );
				if ( ! empty( $wpdb->last_error ) ) {
					$db_errors[] = 'bwfan_automations alter table - ' . $wpdb->last_error;
				}
			}
		}

		$table_instance = new BWFAN_DB_Table_Automation_Step();
		$table_instance->create_table();
		if ( ! empty( $table_instance->db_errors ) ) {
			$db_errors[] = $table_instance->db_errors;
		}

		$table_instance = new BWFAN_DB_Table_Automation_Contact();
		$table_instance->create_table();
		if ( ! empty( $table_instance->db_errors ) ) {
			$db_errors[] = $table_instance->db_errors;
		}

		$table_instance = new BWFAN_DB_Table_Automation_Complete_Contact();
		$table_instance->create_table();
		if ( ! empty( $table_instance->db_errors ) ) {
			$db_errors[] = $table_instance->db_errors;
		}

		$table_instance = new BWFAN_DB_Table_Automation_Contact_Claim();
		$table_instance->create_table();
		if ( ! empty( $table_instance->db_errors ) ) {
			$db_errors[] = $table_instance->db_errors;
		}

		$table_instance = new BWFAN_DB_Table_Automation_Contact_Trail();
		$table_instance->create_table();
		if ( ! empty( $table_instance->db_errors ) ) {
			$db_errors[] = $table_instance->db_errors;
		}

		/** Create v2 tables */
		$this->v2_tables();
		$this->method_run[] = $version_key;

		/** Updating version key */
		update_option( 'bwfan_db', $version_key, true );

		$db_update    = new BWFAN_DB_Update();
		$db_changes   = array_keys( $db_update->db_changes );
		$last_version = end( $db_changes );
		update_option( 'bwfan_db_update', [ $last_version => 0 ], true );

		/** Log if any mysql errors */
		if ( ! empty( $db_errors ) ) {
			BWFAN_Common::log_test_data( array_merge( [ __FUNCTION__ ], $db_errors ), 'db-creation-errors' );
		}
	}

	/**
	 * Create v2 tables
	 *
	 * @return void
	 */
	public function v2_tables() {

		$table_instance = new BWFAN_DB_Table_Contact_Fields();
		if ( ! $table_instance->is_exists() ) {
			$table_instance->create_table();
			if ( ! empty( $table_instance->db_errors ) ) {
				$db_errors[] = $table_instance->db_errors;
			}
		}

		$table_instance = new BWFAN_DB_Table_Contact_Note();
		if ( ! $table_instance->is_exists() ) {
			$table_instance->create_table();
			if ( ! empty( $table_instance->db_errors ) ) {
				$db_errors[] = $table_instance->db_errors;
			}
		}

		$table_instance = new BWFAN_DB_Table_Fields();
		if ( ! $table_instance->is_exists() ) {
			$table_instance->create_table();
			if ( ! empty( $table_instance->db_errors ) ) {
				$db_errors[] = $table_instance->db_errors;
			}
		}

		$table_instance = new BWFAN_DB_Table_Field_Groups();
		if ( ! $table_instance->is_exists() ) {
			$table_instance->create_table();
			if ( ! empty( $table_instance->db_errors ) ) {
				$db_errors[] = $table_instance->db_errors;
			}
		}

		$table_instance = new BWFAN_DB_Table_Terms();
		if ( ! $table_instance->is_exists() ) {
			$table_instance->create_table();
			if ( ! empty( $table_instance->db_errors ) ) {
				$db_errors[] = $table_instance->db_errors;
			}
		}

		$table_instance = new BWFAN_DB_Table_Conversions();
		if ( ! $table_instance->is_exists() ) {
			$table_instance->create_table();
			if ( ! empty( $table_instance->db_errors ) ) {
				$db_errors[] = $table_instance->db_errors;
			}
		}

		$table_instance = new BWFAN_DB_Table_Engagement_Tracking();
		if ( ! $table_instance->is_exists() ) {
			$table_instance->create_table();
			if ( ! empty( $table_instance->db_errors ) ) {
				$db_errors[] = $table_instance->db_errors;
			}
		}

		$table_instance = new BWFAN_DB_Table_Engagement_Trackingmeta();
		if ( ! $table_instance->is_exists() ) {
			$table_instance->create_table();
			if ( ! empty( $table_instance->db_errors ) ) {
				$db_errors[] = $table_instance->db_errors;
			}
		}

		$table_instance = new BWFAN_DB_Table_Templates();
		$table_instance->create_table();
		if ( ! empty( $table_instance->db_errors ) ) {
			$db_errors[] = $table_instance->db_errors;
		}

		$table_instance = new BWFAN_DB_Table_Message();
		$table_instance->create_table();
		if ( ! empty( $table_instance->db_errors ) ) {
			$db_errors[] = $table_instance->db_errors;
		}

		/** Creating default contact fields */
		BWFAN_Common::insert_default_crm_fields();

		BWFCRM_Fields::add_field( 'Last Login', BWFCRM_Fields::$TYPE_DATE, array(), '', 2, 2, 1, 0, 2 );
		BWFCRM_Fields::add_field( 'Last Open', BWFCRM_Fields::$TYPE_DATE, array(), '', 2, 2, 1, 0, 2 );
		BWFCRM_Fields::add_field( 'Last Click', BWFCRM_Fields::$TYPE_DATE, array(), '', 2, 2, 1, 0, 2 );

		/** Log if any mysql errors */
		if ( ! empty( $db_errors ) ) {
			BWFAN_Common::log_test_data( array_merge( [ __FUNCTION__ ], $db_errors ), 'db-creation-errors' );
		}
	}

	/**
	 * @param $version_key
	 *
	 * @return void
	 */
	public function db_update_2_0_10_2( $version_key ) {
		if ( is_array( $this->method_run ) && in_array( '2.0.10.1', $this->method_run, true ) ) {
			update_option( 'bwfan_db', $version_key, true );
			$this->method_run[] = $version_key;

			return;
		}

		global $wpdb;
		$db_errors = [];

		/** Check if 'next' column exists before attempting to drop it */
		$column_exists = $wpdb->query( "SHOW COLUMNS FROM {$wpdb->prefix}bwfan_automation_contact LIKE 'next'" );
		if ( $column_exists ) {
			/** Drop next column */
			$drop_col = "ALTER TABLE {$wpdb->prefix}bwfan_automation_contact DROP COLUMN `next`";
			$wpdb->query( $drop_col );
			if ( ! empty( $wpdb->last_error ) ) {
				$db_errors[] = 'bwfan_automation_contact drop call - ' . $wpdb->last_error;
			}
		}

		$table_instance = new BWFAN_DB_Table_Automation_Contact();
		$table_instance->create_table();
		if ( ! empty( $table_instance->db_errors ) ) {
			$db_errors[] = $table_instance->db_errors;
		}

		$table_instance = new BWFAN_DB_Table_Automation_Complete_Contact();
		$table_instance->create_table();
		if ( ! empty( $table_instance->db_errors ) ) {
			$db_errors[] = $table_instance->db_errors;
		}

		$this->method_run[] = $version_key;

		/** Updating version key */
		update_option( 'bwfan_db', $version_key, true );

		/** Log if any mysql errors */
		if ( ! empty( $db_errors ) ) {
			BWFAN_Common::log_test_data( array_merge( [ __FUNCTION__ ], $db_errors ), 'db-creation-errors' );
		}
	}

	/**
	 * @param $version_key
	 *
	 * @return void
	 */
	public function db_update_2_0_10_3( $version_key ) {
		if ( is_array( $this->method_run ) && in_array( '2.0.10.1', $this->method_run, true ) ) {
			update_option( 'bwfan_db', $version_key, true );
			$this->method_run[] = $version_key;

			return;
		}

		global $wpdb;

		$db_errors = [];

		if ( ! is_array( $this->method_run ) || ! in_array( '2.0.10.2', $this->method_run, true ) ) {
			/** Alter bwfan_automation_complete_contact table */
			$column_exists = $wpdb->query( "SHOW COLUMNS FROM {$wpdb->prefix}bwfan_automation_complete_contact LIKE 'event'" );
			if ( empty( $column_exists ) ) {
				$query = "ALTER TABLE {$wpdb->prefix}bwfan_automation_complete_contact
    			CHANGE `trail` `trail` VARCHAR(40) NULL COMMENT 'Trail ID',
		    	ADD COLUMN `event` varchar(120) NOT NULL;";
				$wpdb->query( $query );
				if ( ! empty( $wpdb->last_error ) ) {
					$db_errors[] = 'bwfan_automation_complete_contact alter table - ' . $wpdb->last_error;
				}
			}

			/** Alter bwfan_automation_contact table */
			$column_exists = $wpdb->query( "SHOW COLUMNS FROM {$wpdb->prefix}bwfan_automation_contact LIKE 'last_time'" );
			if ( empty( $column_exists ) ) {
				$query = "ALTER TABLE {$wpdb->prefix}bwfan_automation_contact
    			CHANGE `trail` `trail` VARCHAR(40) NULL COMMENT 'Trail ID',
		    	ADD COLUMN `last_time` bigint(12) UNSIGNED NOT NULL;";
				$wpdb->query( $query );
				if ( ! empty( $wpdb->last_error ) ) {
					$db_errors[] = 'bwfan_automation_contact alter table - ' . $wpdb->last_error;
				}
			}
		}

		$table_instance = new BWFAN_DB_Table_Automation_Contact_Trail();
		$table_instance->create_table();
		if ( ! empty( $table_instance->db_errors ) ) {
			$db_errors[] = $table_instance->db_errors;
		}

		$this->method_run[] = $version_key;

		/** Updating version key */
		update_option( 'bwfan_db', $version_key, true );

		/** Log if any mysql errors */
		if ( ! empty( $db_errors ) ) {
			BWFAN_Common::log_test_data( array_merge( [ __FUNCTION__ ], $db_errors ), 'db-creation-errors' );
		}
	}

	/**
	 * @param $version_key
	 *
	 * @return void
	 */
	public function db_update_2_0_10_4( $version_key ) {
		if ( is_array( $this->method_run ) && in_array( '2.0.10.1', $this->method_run, true ) ) {
			update_option( 'bwfan_db', $version_key, true );
			$this->method_run[] = $version_key;

			return;
		}

		/** Marking option key autoload false */
		$global_option             = get_option( 'bwfan_global_settings', array() );
		$global_option['2_0_10_4'] = 1;
		update_option( 'bwfan_global_settings', $global_option, true );

		$this->method_run[] = $version_key;

		/** Updating version key */
		update_option( 'bwfan_db', $version_key, true );
	}

	/**
	 * @param $version_key
	 *
	 * @return void
	 */
	public function db_update_2_0_10_5( $version_key ) {
		if ( ( is_array( $this->method_run ) && in_array( '2.0.10.1', $this->method_run, true ) ) || ! class_exists( 'BWFCRM_Contact' ) ) {
			update_option( 'bwfan_db', $version_key, true );
			$this->method_run[] = $version_key;

			return;
		}

		global $wpdb;

		/** Automation complete contact */
		$query = "SELECT MAX(`ID`) FROM `{$wpdb->prefix}bwfan_automation_complete_contact`";

		$max_completed_aid = $wpdb->get_var( $query );
		if ( intval( $max_completed_aid ) > 0 ) {
			update_option( 'bwfan_max_automation_completed', $max_completed_aid );
			if ( ! bwf_has_action_scheduled( 'bwfan_store_automation_completed_ids' ) ) {
				bwf_schedule_recurring_action( time() + 60, 120, 'bwfan_store_automation_completed_ids' );
			}
		}

		/** Automation contact */
		$query = "SELECT MAX(`ID`) FROM `{$wpdb->prefix}bwfan_automation_contact`";

		$max_active_aid = $wpdb->get_var( $query );
		if ( intval( $max_active_aid ) > 0 ) {
			update_option( 'bwfan_max_active_automation', $max_active_aid );
			if ( ! bwf_has_action_scheduled( 'bwfan_store_automation_active_ids' ) ) {
				bwf_schedule_recurring_action( time(), 120, 'bwfan_store_automation_active_ids' );
			}
		}

		/** Updating version key */
		update_option( 'bwfan_db', $version_key, true );
	}

	/**
	 * @param $version_key
	 *
	 * @return void
	 */
	public function db_update_2_0_10_6( $version_key ) {
		if ( is_array( $this->method_run ) && in_array( '1.0.0', $this->method_run, true ) ) {
			update_option( 'bwfan_db', $version_key, true );
			$this->method_run[] = $version_key;

			return;
		}

		global $wpdb;
		$db_errors = [];

		/** Automation contact */
		$query = $wpdb->prepare( "SELECT MIN(`ID`) FROM `{$wpdb->prefix}bwfan_automations` WHERE `v` = %d", 1 );

		$automation_v1 = $wpdb->get_var( $query );
		$automation_v1 = ( 0 === intval( $automation_v1 ) ) ? '0' : '1';
		update_option( 'bwfan_automation_v1', $automation_v1, true );

		/** Updating version key */
		update_option( 'bwfan_db', $version_key, true );

		/** Log if any mysql errors */
		if ( ! empty( $db_errors ) ) {
			BWFAN_Common::log_test_data( array_merge( [ __FUNCTION__ ], $db_errors ), 'db-creation-errors' );
		}
	}

	/**
	 * @param $version_key
	 *
	 * @return void
	 */
	public function db_update_2_0_10_7( $version_key ) {
		BWFAN_Recipe_Loader::get_recipes_array( true );

		/** Updating version key */
		update_option( 'bwfan_db', $version_key, true );
	}

	/**
	 * @param $version_key
	 *
	 * @return void
	 */
	public function db_update_2_0_10_8( $version_key ) {
		if ( is_array( $this->method_run ) && in_array( '1.0.0', $this->method_run, true ) ) {
			update_option( 'bwfan_db', $version_key, true );
			$this->method_run[] = $version_key;

			return;
		}

		/**
		 * Check if table exists and no column is missing
		 */
		$table_instance = new BWFAN_DB_Table_Message_Unsubscribe();
		if ( $table_instance->is_exists() ) {
			$missing_columns = $table_instance->check_missing_columns();
			if ( empty( $missing_columns ) ) {
				update_option( 'bwfan_db', $version_key, true );
				$this->method_run[] = $version_key;

				return;
			}
		}

		/** Create missing columns in a table */

		$db_errors = [];

		$table_instance->create_table();
		if ( ! empty( $table_instance->db_errors ) ) {
			$db_errors[] = $table_instance->db_errors;
		}

		/** Updating version key */
		update_option( 'bwfan_db', $version_key, true );

		/** Log if any mysql errors */
		if ( ! empty( $db_errors ) ) {
			BWFAN_Common::log_test_data( array_merge( [ __FUNCTION__ ], $db_errors ), 'db-creation-errors' );
		}
	}

	public function db_update_2_4_2( $version_key ) {
		if ( is_array( $this->method_run ) && in_array( '1.0.0', $this->method_run, true ) ) {
			update_option( 'bwfan_db', $version_key, true );
			$this->method_run[] = $version_key;

			return;
		}

		global $wpdb;

		/** Automation steps meta data normalize */
		$query  = "SELECT MIN(`ID`) as `ID` FROM `{$wpdb->prefix}bwfan_automations` WHERE `v` = 2 LIMIT 0, 1";
		$min_id = $wpdb->get_var( $query ); // phpcs:disable WordPress.DB.PreparedSQL
		if ( $min_id > 0 ) {
			/** schedule recurring event */
			bwf_schedule_recurring_action( time(), ( 5 * MINUTE_IN_SECONDS ), 'bwfan_update_meta_automations_v2' );

			update_option( 'bwfan_automation_v2_meta_normalize', $min_id, false );
		}

		/** Delete some repetitive actions to delete duplicated actions */
		$query  = "SELECT count(*) AS `count` FROM `{$wpdb->prefix}bwf_actions` WHERE `hook` IN ('bwfan_run_midnight_cron', 'bwfan_5_minute_worker', 'bwfan_run_midnight_connectors_sync')";
		$result = $wpdb->get_var( $query ); // phpcs:disable WordPress.DB.PreparedSQL
		if ( ! empty( $result ) ) {
			/** Delete the rows */
			$query = "DELETE FROM `{$wpdb->prefix}bwf_actions` WHERE `hook` IN ('bwfan_run_midnight_cron', 'bwfan_5_minute_worker', 'bwfan_run_midnight_connectors_sync')";
			$wpdb->query( $query );
		}

		$this->method_run[] = $version_key;

		/** Updating version key */
		update_option( 'bwfan_db', $version_key, true );
	}

	public function db_update_2_4_4( $version_key ) {
		if ( is_array( $this->method_run ) && in_array( '1.0.0', $this->method_run, true ) ) {
			update_option( 'bwfan_db', $version_key, true );
			$this->method_run[] = $version_key;

			return;
		}

		$table_instance = new BWFAN_DB_Table_Options();
		if ( $table_instance->is_exists() ) {
			update_option( 'bwfan_db', $version_key, true );
			$this->method_run[] = $version_key;

			return;
		}

		$db_errors = [];

		/** Create options table */
		$table_instance->create_table();
		if ( ! empty( $table_instance->db_errors ) ) {
			$db_errors[] = $table_instance->db_errors;
		}

		/** Updating version key */
		update_option( 'bwfan_db', $version_key, true );

		/** Log if any mysql errors */
		if ( ! empty( $db_errors ) ) {
			BWFAN_Common::log_test_data( array_merge( [ __FUNCTION__ ], $db_errors ), 'db-creation-errors' );
		}
	}

	public function db_update_2_6_1( $version_key ) {
		if ( is_array( $this->method_run ) && in_array( '1.0.0', $this->method_run, true ) ) {
			update_option( 'bwfan_db', $version_key, true );
			$this->method_run[] = $version_key;

			return;
		}

		global $wpdb;
		$query = "TRUNCATE TABLE `{$wpdb->prefix}bwf_actions`";
		$wpdb->query( $query );

		/** Scheduling Broadcast action */
		if ( true === bwfan_is_autonami_pro_active() && ! bwf_has_action_scheduled( 'bwfcrm_broadcast_run_queue' ) ) {
			bwf_schedule_recurring_action( time(), 60, 'bwfcrm_broadcast_run_queue', array(), 'bwfcrm' );

			BWFAN_PRO_Common::run_midnight_cron();
		}

		/** Updating version key */
		update_option( 'bwfan_db', $version_key, true );
	}

	public function db_update_2_6_2( $version_key ) {
		if ( is_array( $this->method_run ) && in_array( '1.0.0', $this->method_run, true ) ) {
			update_option( 'bwfan_db', $version_key, true );
			$this->method_run[] = $version_key;

			return;
		}

		global $wpdb;
		$query = "ALTER TABLE {$wpdb->prefix}bwfan_automations
    			CHANGE `benchmark` `benchmark` longtext;";
		$wpdb->query( $query );
		$db_errors = [];
		if ( ! empty( $wpdb->last_error ) ) {
			$db_errors[] = 'bwfan_automations alter table - ' . $wpdb->last_error;
		}

		/** Log if any mysql errors */
		if ( ! empty( $db_errors ) ) {
			BWFAN_Common::log_test_data( array_merge( [ __FUNCTION__ ], $db_errors ), 'db-creation-errors' );
		}

		/** Updating version key */
		update_option( 'bwfan_db', $version_key, true );
	}

	public function db_update_2_6_3( $version_key ) {
		if ( is_array( $this->method_run ) && in_array( '1.0.0', $this->method_run, true ) ) {
			update_option( 'bwfan_db', $version_key, true );
			$this->method_run[] = $version_key;

			return;
		}

		/** Cache handling */
		if ( class_exists( 'BWF_JSON_Cache' ) && method_exists( 'BWF_JSON_Cache', 'run_json_endpoints_cache_handling' ) ) {
			BWF_JSON_Cache::run_json_endpoints_cache_handling();
		}

		global $wpdb;
		$query = "SELECT COUNT(ct.ID) FROM `{$wpdb->prefix}bwfan_automation_contact_trail` AS ct JOIN `{$wpdb->prefix}bwfan_automation_complete_contact` AS cc ON ct.tid = cc.trail WHERE ct.status = 2 LIMIT 0,1";

		if ( intval( $wpdb->get_var( $query ) > 0 ) ) {
			/** Scheduling recurring action */
			bwf_schedule_recurring_action( time(), 300, 'bwfan_update_contact_trail', array(), 'bwfan' );
		}

		/** Updating version key */
		update_option( 'bwfan_db', $version_key, true );
	}

	public function db_update_2_7_0( $version_key ) {
		if ( is_array( $this->method_run ) && in_array( '1.0.0', $this->method_run, true ) ) {
			update_option( 'bwfan_db', $version_key, true );
			$this->method_run[] = $version_key;

			return;
		}

		/** Cache handling */
		if ( class_exists( 'BWF_JSON_Cache' ) && method_exists( 'BWF_JSON_Cache', 'run_json_endpoints_cache_handling' ) ) {
			BWF_JSON_Cache::run_json_endpoints_cache_handling();
		}

		/** Save main option settings as autoload true */
		$global_settings = get_option( 'bwfan_global_settings', array() );
		if ( ! empty( $global_settings ) ) {
			delete_option( 'bwfan_global_settings' );
			update_option( 'bwfan_global_settings', $global_settings, true );
		}

		/** Updating version key */
		update_option( 'bwfan_db', $version_key, true );
	}

	public function db_update_2_8_0( $version_key ) {
		if ( is_array( $this->method_run ) && in_array( '1.0.0', $this->method_run, true ) ) {
			update_option( 'bwfan_db', $version_key, true );
			$this->method_run[] = $version_key;

			return;
		}

		/** Reset logs clear action */
		if ( BWFAN_Common::bwf_has_action_scheduled( 'bwfan_delete_logs' ) ) {
			/** Un-schedule action */
			bwf_unschedule_actions( "bwfan_delete_logs" );

			$store_time = BWFAN_Common::get_store_time( 4 );
			bwf_schedule_recurring_action( $store_time, DAY_IN_SECONDS, 'bwfan_delete_logs' );
		}

		/** Updating version key */
		update_option( 'bwfan_db', $version_key, true );
	}


	public function db_update_2_8_4( $version_key ) {
		if ( is_array( $this->method_run ) && in_array( '1.0.0', $this->method_run, true ) ) {
			update_option( 'bwfan_db', $version_key, true );
			$this->method_run[] = $version_key;

			return;
		}

		$table_instance = new BWFAN_DB_Table_Automation_Events();
		$table_instance->create_table();
		$db_errors = [];
		if ( ! empty( $table_instance->db_errors ) ) {
			$db_errors[] = $table_instance->db_errors;
		}

		/** Log if any mysql errors */
		if ( ! empty( $db_errors ) ) {
			BWFAN_Common::log_test_data( array_merge( [ __FUNCTION__ ], $db_errors ), 'db-creation-errors' );
		}

		/** Updating version key */
		update_option( 'bwfan_db', $version_key, true );
	}

	public function db_update_3_0_0( $version_key ) {
		if ( is_array( $this->method_run ) && in_array( '1.0.0', $this->method_run, true ) ) {
			update_option( 'bwfan_db', $version_key, true );
			$this->method_run[] = $version_key;

			return;
		}

		update_option( 'bwf_global_block_editor_setting', BWFAN_Common::get_block_editor_default_setting() );
		$this->update_user_contact_preference_data();
		/** Updating version key */
		update_option( 'bwfan_db', $version_key, true );
	}

	/**
	 * Update user contact preference data
	 * @return void
	 */
	public function update_user_contact_preference_data() {
		$args = array(
			'meta_key' => '_bwfan_contact_columns_v2',
		);

		$user_query = new WP_User_Query( $args );
		$users      = $user_query->get_results();

		if ( ! empty( $users ) ) {
			foreach ( $users as $user ) {
				$col_data = get_user_meta( $user->ID, '_bwfan_contact_columns_v2', true );
				if ( ! is_array( $col_data ) ) {
					continue;
				}
				$col_data = array_filter( $col_data, function ( $field ) {
					if ( ( isset( $field['email'] ) && $field['email'] == 'Email' ) || isset( $field['creation_date'] ) && $field['creation_date'] == 'Creation Date' ) {
						return false;
					}

					return true;
				} );
				update_user_meta( $user->ID, '_bwfan_contact_columns_v2', array_values( $col_data ) );
			}
		}
	}

	public function db_update_3_0_1( $version_key ) {
		if ( is_array( $this->method_run ) && in_array( '2.0.10.1', $this->method_run, true ) ) {
			update_option( 'bwfan_db', $version_key, true );
			$this->method_run[] = $version_key;

			return;
		}

		if ( bwfan_is_autonami_pro_active() && version_compare( BWFAN_PRO_VERSION, '3.0', '<=' ) ) {
			update_option( 'bwfan_db', $version_key, true );

			return;
		}

		$this->v2_tables();

		/** Updating version key */
		update_option( 'bwfan_db', $version_key, true );
	}

	public function db_update_3_0_1_1( $version_key ) {
		if ( is_array( $this->method_run ) && ( in_array( '1.0.0', $this->method_run, true ) || in_array( '2.8.4', $this->method_run, true ) ) ) {
			update_option( 'bwfan_db', $version_key, true );
			$this->method_run[] = $version_key;

			return;
		}

		$table_instance = new BWFAN_DB_Table_Automation_Events();
		$table_instance->create_table();
		$db_errors = [];
		if ( ! empty( $table_instance->db_errors ) ) {
			$db_errors[] = $table_instance->db_errors;
		}

		/** Log if any mysql errors */
		if ( ! empty( $db_errors ) ) {
			BWFAN_Common::log_test_data( array_merge( [ __FUNCTION__ ], $db_errors ), 'db-creation-errors' );
		}

		/** Updating version key */
		update_option( 'bwfan_db', $version_key, true );
	}

	public function db_update_3_0_4( $version_key ) {
		if ( is_array( $this->method_run ) && in_array( '1.0.0', $this->method_run, true ) ) {
			update_option( 'bwfan_db', $version_key, true );
			$this->method_run[] = $version_key;

			return;
		}

		/** Cache handling */
		if ( class_exists( 'BWF_JSON_Cache' ) && method_exists( 'BWF_JSON_Cache', 'run_json_endpoints_cache_handling' ) ) {
			BWF_JSON_Cache::run_json_endpoints_cache_handling();
		}

		/** Updating version key */
		update_option( 'bwfan_db', $version_key, true );
	}

	public function db_update_3_0_5( $version_key ) {
		if ( is_array( $this->method_run ) && in_array( '1.0.0', $this->method_run, true ) ) {
			update_option( 'bwfan_db', $version_key, true );
			$this->method_run[] = $version_key;

			return;
		}
		global $wpdb;

		$query = "ALTER TABLE {$wpdb->prefix}bwfan_message ADD data longtext;";
		$wpdb->query( $query );
		if ( ! empty( $wpdb->last_error ) ) {
			$db_errors[] = 'bwfan_message alter table - ' . $wpdb->last_error;
		}

		$columns       = [ 'f_open', 'f_click', 'day', 'hour' ];
		$index_queries = [];
		foreach ( $columns as $column ) {
			$query      = "SHOW COLUMNS FROM `{$wpdb->prefix}bwfan_engagement_tracking` LIKE '$column'";
			$sid_exists = $wpdb->get_row( $query, ARRAY_A );
			if ( empty( $sid_exists['Key'] ) ) {
				$index_queries[] = "ADD KEY `$column`(`$column`)";
			}
		}

		if ( ! empty( $index_queries ) ) {
			$index_queries = implode( ', ', $index_queries );
			$wpdb->query( "ALTER TABLE `{$wpdb->prefix}bwfan_engagement_tracking` $index_queries" );
			if ( ! empty( $wpdb->last_error ) ) {
				$db_errors[] = 'bwfan_engagement_tracking alter table - ' . $wpdb->last_error;
			}
		}

		/** Log if any mysql errors */
		if ( ! empty( $db_errors ) ) {
			BWFAN_Common::log_test_data( array_merge( [ __FUNCTION__ ], $db_errors ), 'db-creation-errors' );
		}

		/** Updating version key */
		update_option( 'bwfan_db', $version_key, true );
	}

	/**
	 * Set notification email default settings
	 *
	 * @param $version_key
	 *
	 * @return void
	 */
	public function db_update_3_2_2( $version_key ) {
		if ( is_array( $this->method_run ) && in_array( '1.0.0', $this->method_run, true ) ) {
			update_option( 'bwfan_db', $version_key, true );
			$this->method_run[] = $version_key;

			return;
		}

		/** set default settings for email notification */
		BWFAN_Notification_Email::set_bwfan_settings();

		/** Updating version key */
		update_option( 'bwfan_db', $version_key, true );
	}

	public function db_update_3_2_1( $version_key ) {
		if ( is_array( $this->method_run ) && in_array( '1.0.0', $this->method_run, true ) ) {
			update_option( 'bwfan_db', $version_key, true );
			$this->method_run[] = $version_key;

			return;
		}

		/** Check for merge tags */
		$this->recheck_merge_tags();

		/** Check cart */
		$this->check_cart();

		/** Check bounce */
		$this->check_bounce();

		/** Updating version key */
		update_option( 'bwfan_db', $version_key, true );
	}

	protected function recheck_merge_tags() {
		global $wpdb;

		try {
			$settings = BWFAN_Common::get_global_settings();

			/** Fetch some merge tag values from the engagements meta table */
			$query = $wpdb->prepare( "SELECT `ID` FROM `{table_name}` WHERE `created_at` < %s AND `c_status` = %d ORDER BY `created_at` DESC LIMIT 0,1;", '2024-10-22 00:00:01', 2 );
			$id    = BWFAN_Model_Engagement_Tracking::get_var( $query );
			if ( empty( $id ) ) {
				return;
			}
			$query = $wpdb->prepare( "SELECT `meta_value` FROM `{table_name}` WHERE `eid` < %d AND `meta_key` LIKE 'merge_tags' AND `meta_value` LIKE '%{{business_name}}%' LIMIT 0,100;", $id );
			$rows  = BWFAN_Model_Engagement_Trackingmeta::get_results( $query );
			if ( empty( $rows ) || ! is_array( $rows ) || 0 === count( $rows ) ) {
				return;
			}
			$business_name    = '';
			$business_address = '';
			$unsubscribe_url  = '';

			$rows = array_column( $rows, 'meta_value' );
			foreach ( $rows as $row ) {
				$row = json_decode( $row, true );
				if ( empty( $business_name ) && isset( $row['{{business_name}}'] ) && ! empty( $row['{{business_name}}'] ) ) {
					$business_name = $row['{{business_name}}'];
				}
				if ( empty( $business_address ) && isset( $row['{{business_address}}'] ) && ! empty( $row['{{business_address}}'] ) ) {
					$business_address = $row['{{business_address}}'];
				}
				if ( empty( $unsubscribe_url ) && isset( $row['{{unsubscribe_link}}'] ) && ! empty( $row['{{unsubscribe_link}}'] ) ) {
					$unsubscribe_url = strpos( $row['{{unsubscribe_link}}'], '?bwfan-action=unsubscribe' ) !== false ? $row['{{unsubscribe_link}}'] : '';
					if ( ! empty( $unsubscribe_url ) ) {
						$unsubscribe_url = $this->get_the_unsubscribe_page_id( $unsubscribe_url );
					}
				}

				if ( ! empty( $business_name ) && ! empty( $business_address ) && ! empty( $unsubscribe_url ) ) {
					break;
				}
			}

			if ( ! empty( $business_name ) ) {
				$settings['bwfan_setting_business_name'] = $business_name;
			}
			if ( ! empty( $business_address ) ) {
				$settings['bwfan_setting_business_address'] = $business_address;
			}
			if ( ! empty( $unsubscribe_url ) ) {
				$settings['bwfan_unsubscribe_page'] = $unsubscribe_url;
			}

			update_option( 'bwfan_global_settings', $settings );
		} catch ( Exception $e ) {
			return;
		} catch ( Error $e ) {
			return;
		}
	}

	protected function check_cart() {
		if ( ! bwfan_is_woocommerce_active() ) {
			return;
		}

		$settings = BWFAN_Common::get_global_settings();
		if ( ! empty( $settings['bwfan_ab_enable'] ) ) {
			return;
		}
		global $wpdb;

		try {
			$query = $wpdb->prepare( "SELECT `ID` FROM `{table_name}` WHERE `created_time` > %s LIMIT 0,1;", '2024-10-01 00:00:01' );
			$found = BWFAN_Model_Abandonedcarts::get_var( $query );
			if ( empty( $found ) ) {
				return;
			}
			$settings['bwfan_ab_enable'] = true;
			update_option( 'bwfan_global_settings', $settings );
		} catch ( Exception $e ) {
			return;
		} catch ( Error $e ) {
			return;
		}
	}

	protected function check_bounce() {
		$settings = BWFAN_Common::get_global_settings();
		if ( ! empty( $settings['bwfan_enable_bounce_handling'] ) ) {
			return;
		}

		/** offload ses */
		if ( class_exists( 'DeliciousBrains\WP_Offload_SES\WP_Offload_SES' ) ) {
			$settings['bwfan_enable_bounce_handling'] = true;
			$settings['bwfan_bounce_select']          = 'amazon ses';
			update_option( 'bwfan_global_settings', $settings );

			return;
		}

		/** elastic email */
		if ( class_exists( 'eemail' ) ) {
			$settings['bwfan_enable_bounce_handling'] = true;
			$settings['bwfan_bounce_select']          = 'elastic email';
			update_option( 'bwfan_global_settings', $settings );

			return;
		}

		/** postmark */
		if ( class_exists( 'Postmark_Mail' ) ) {
			$settings['bwfan_enable_bounce_handling'] = true;
			$settings['bwfan_bounce_select']          = 'postmark';
			update_option( 'bwfan_global_settings', $settings );

			return;
		}

		/** wp mail smtp */
		if ( defined( 'WPMS_PLUGIN_VER' ) ) {
			$option = get_option( 'wp_mail_smtp', false );
			if ( $option && isset( $option['mail'] ) && isset( $option['mail']['mailer'] ) ) {
				$settings['bwfan_enable_bounce_handling'] = true;
				switch ( $option['mail']['mailer'] ) {
					case 'postmark':
						$settings['bwfan_bounce_select'] = 'postmark';
						break;
					case 'amazonses':
						$settings['bwfan_bounce_select'] = 'amazon ses';
						break;
					case 'sendinblue':
						$settings['bwfan_bounce_select'] = 'brevo (formerly sendinblue)';
						break;
					case 'sparkpost':
						$settings['bwfan_bounce_select'] = 'sparkpost';
						break;
					case 'mailgun':
						$settings['bwfan_bounce_select'] = 'mailgun';
						break;
					case 'sendgrid':
						$settings['bwfan_bounce_select'] = 'sendgrid';
						break;
				}
				update_option( 'bwfan_global_settings', $settings );

				return;
			}
		}

		/** easy wp smtp */
		if ( class_exists( 'EasyWPSMTP' ) ) {
			$option = get_option( 'easy_wp_smtp', false );
			if ( $option && isset( $option['mail'] ) && isset( $option['mail']['mailer'] ) ) {
				$settings['bwfan_enable_bounce_handling'] = true;
				switch ( $option['mail']['mailer'] ) {
					case 'postmark':
						$settings['bwfan_bounce_select'] = 'postmark';
						break;
					case 'amazonses':
						$settings['bwfan_bounce_select'] = 'amazon ses';
						break;
					case 'sendinblue':
						$settings['bwfan_bounce_select'] = 'brevo (formerly sendinblue)';
						break;
					case 'sparkpost':
						$settings['bwfan_bounce_select'] = 'sparkpost';
						break;
					case 'mailgun':
						$settings['bwfan_bounce_select'] = 'mailgun';
						break;
					case 'sendgrid':
						$settings['bwfan_bounce_select'] = 'sendgrid';
						break;
				}
				update_option( 'bwfan_global_settings', $settings );

				return;
			}
		}

		/** fluent smtp */
		if ( defined( 'FLUENTMAIL_PLUGIN_FILE' ) ) {
			$settings = get_option( 'fluentmail-settings', false );
			if ( ! empty( $settings ) && isset( $settings['misc'] ) && isset( $settings['misc']['default_connection'] ) && isset( $settings['connections'] ) ) {
				$default_connection = $settings['misc']['default_connection'];
				if ( isset( $settings['connections'][ $default_connection ] ) && isset( $settings['connections'][ $default_connection ]['provider'] ) ) {
					$settings['bwfan_enable_bounce_handling'] = true;
					switch ( $settings['connections'][ $default_connection ]['provider'] ) {
						case 'postmark':
							$settings['bwfan_bounce_select'] = 'postmark';
							break;
						case 'amazonses':
							$settings['bwfan_bounce_select'] = 'amazon ses';
							break;
						case 'sendinblue':
							$settings['bwfan_bounce_select'] = 'brevo (formerly sendinblue)';
							break;
						case 'sparkpost':
							$settings['bwfan_bounce_select'] = 'sparkpost';
							break;
						case 'mailgun':
							$settings['bwfan_bounce_select'] = 'mailgun';
							break;
						case 'sendgrid':
							$settings['bwfan_bounce_select'] = 'sendgrid';
							break;
						case 'elasticmail':
							$settings['bwfan_bounce_select'] = 'elastic email';
							break;
						case 'pepipost':
							$settings['bwfan_bounce_select'] = 'pepipost';
							break;
					}
					update_option( 'bwfan_global_settings', $settings );

					return;
				}
			}
		}

		/** post smtp */
		if ( class_exists( 'Postman' ) ) {
			$settings = get_option( 'postman_options', false );
			if ( ! empty( $settings ) && isset( $settings['transport_type'] ) ) {
				$settings['bwfan_enable_bounce_handling'] = true;
				switch ( $settings['transport_type'] ) {
					case 'postmark_api':
						$settings['bwfan_bounce_select'] = 'postmark';
						break;
					case 'aws_ses_api':
						$settings['bwfan_bounce_select'] = 'amazon ses';
						break;
					case 'sendinblue_api':
						$settings['bwfan_bounce_select'] = 'brevo (formerly sendinblue)';
						break;
					case 'sparkpost_api':
						$settings['bwfan_bounce_select'] = 'sparkpost';
						break;
					case 'mailgun_api':
						$settings['bwfan_bounce_select'] = 'mailgun';
						break;
					case 'sendgrid_api':
						$settings['bwfan_bounce_select'] = 'sendgrid';
						break;
					case 'elasticemail_api':
						$settings['bwfan_bounce_select'] = 'elastic email';
						break;
					case 'mailjet_api':
						$settings['bwfan_bounce_select'] = 'mailjet';
						break;
				}
				update_option( 'bwfan_global_settings', $settings );

				return;
			}
		}
	}

	/**
	 * Helper method
	 *
	 * @param $url
	 *
	 * @return int|string
	 */
	protected function get_the_unsubscribe_page_id( $url = '' ) {
		if ( empty( $url ) ) {
			return '';
		}

		/** Parse the URL to get just the path component */
		$path = parse_url( $url, PHP_URL_PATH );

		/** Remove leading and trailing slashes */
		$slug = trim( $path, '/' );

		/** If the slug has multiple segments, get the last one */
		$path_segments = explode( '/', $slug );
		$final_slug    = end( $path_segments );

		/** Get the page using the slug */
		$page = get_posts( [
			'name'           => $final_slug,
			'post_type'      => 'page',
			'posts_per_page' => 1
		] );

		return ! empty( $page ) ? strval( $page[0]->ID ) : 0;
	}
}

if ( class_exists( 'BWFAN_DB' ) ) {
	BWFAN_Core::register( 'db', 'BWFAN_DB' );
}
