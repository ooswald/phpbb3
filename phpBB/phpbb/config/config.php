<?php
/**
*
* @package phpBB3
* @copyright (c) 2010 phpBB Group
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

/**
* @ignore
*/
if (!defined('IN_PHPBB'))
{
	exit;
}

/**
* Configuration container class
* @package phpBB3
*/
class phpbb_config implements ArrayAccess, IteratorAggregate, Countable
{
	/**
	* The configuration data
	* @var array(string => string)
	*/
	protected $config;

	/**
	* Creates a configuration container with a default set of values
	*
	* @param array(string => string) $config The configuration data.
	*/
	public function __construct(array $config)
	{
		$this->config = $config;
	}

	/**
	* Retrieves an ArrayIterator over the configuration values.
	*
	* @return ArrayIterator An iterator over all config data
	*/
	public function getIterator()
	{
		return new ArrayIterator($this->config);
	}

	/**
	* Checks if the specified config value exists.
	*
	* @param  string $key The configuration option's name.
	* @return bool        Whether the configuration option exists.
	*/
	public function offsetExists($key)
	{
		return isset($this->config[$key]);
	}

	/**
	* Retrieves a configuration value.
	*
	* @param  string $key The configuration option's name.
	* @return string      The configuration value
	*/
	public function offsetGet($key)
	{
		return (isset($this->config[$key])) ? $this->config[$key] : '';
	}

	/**
	* Temporarily overwrites the value of a configuration variable.
	*
	* The configuration change will not persist. It will be lost
	* after the request.
	*
	* @param string $key   The configuration option's name.
	* @param string $value The temporary value.
	*/
	public function offsetSet($key, $value)
	{
		$this->config[$key] = $value;
	}

	/**
	* Called when deleting a configuration value directly, triggers an error.
	*
	* @param string $key The configuration option's name.
	*/
	public function offsetUnset($key)
	{
		trigger_error('Config values have to be deleted explicitly with the phpbb_config::delete($key) method.', E_USER_ERROR);
	}

	/**
	* Retrieves the number of configuration options currently set.
	*
	* @return int Number of config options
	*/
	public function count()
	{
		return count($this->config);
	}

	/**
	* Removes a configuration option
	*
	* @param  String $key       The configuration option's name
	* @param  bool   $use_cache Whether this variable should be cached or if it
	*                           changes too frequently to be efficiently cached
	* @return null
	*/
	public function delete($key, $use_cache = true)
	{
		unset($this->config[$key]);
	}

	/**
	* Sets a configuration option's value
	*
	* @param string $key       The configuration option's name
	* @param string $value     New configuration value
	* @param bool   $use_cache Whether this variable should be cached or if it
	*                          changes too frequently to be efficiently cached.
	*/
	public function set($key, $value, $use_cache = true)
	{
		$this->config[$key] = $value;
	}

	/**
	* Sets a configuration option's value only if the old_value matches the
	* current configuration value or the configuration value does not exist yet.
	*
	* @param  string $key       The configuration option's name
	* @param  string $old_value Current configuration value
	* @param  string $new_value New configuration value
	* @param  bool   $use_cache Whether this variable should be cached or if it
	*                           changes too frequently to be efficiently cached.
	* @return bool              True if the value was changed, false otherwise.
	*/
	public function set_atomic($key, $old_value, $new_value, $use_cache = true)
	{
		if (!isset($this->config[$key]) || $this->config[$key] == $old_value)
		{
			$this->config[$key] = $new_value;
			return true;
		}
		return false;
	}

	/**
	* Increments an integer configuration value.
	*
	* @param string $key       The configuration option's name
	* @param int    $increment Amount to increment by
	* @param bool   $use_cache Whether this variable should be cached or if it
	*                          changes too frequently to be efficiently cached.
	*/
	function increment($key, $increment, $use_cache = true)
	{
		if (!isset($this->config[$key]))
		{
			$this->config[$key] = 0;
		}

		$this->config[$key] += $increment;
	}
}
