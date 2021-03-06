<?php
/**
*
* @package migration
* @copyright (c) 2012 phpBB Group
* @license http://opensource.org/licenses/gpl-license.php GNU Public License v2
*
*/

class phpbb_db_migration_data_30x_3_0_10_rc1 extends phpbb_db_migration
{
	public function effectively_installed()
	{
		return version_compare($this->config['version'], '3.0.10-rc1', '>=');
	}

	static public function depends_on()
	{
		return array('phpbb_db_migration_data_30x_3_0_9');
	}

	public function update_data()
	{
		return array(
			array('config.add', array('email_max_chunk_size', 50)),

			array('config.update', array('version', '3.0.10-rc1')),
		);
	}
}
