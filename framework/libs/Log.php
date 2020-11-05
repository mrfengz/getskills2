<?php
namespace Kcloze\Bot;

use Exception;

class Log
{
	const LEVEL_TRACE = 'trace';
	const LEVEL_WARNING = 'warning';
	const LEVEL_ERROR = 'error';
	const LEVEL_INFO = 'info';
	const LEVEL_PROFILE = 'profile';
	const MAX_LOGS = 10000;

	public $rotateByCopy = true;//
	public $maxLogFiles = 5;
	public $maxFileSize = 100; //MB
	//单个log
	private $logs = [];
	private $logCount = 0;
	private $logPath = '';


	public function __construct($logPath)
	{
		$this->logPath = $logPath;
	}

	public function formatLogMessage($message, $level, $category, $time)
	{
		return @date('Y-m-d H:i:s', $time) . "[$level] [$category] $message\n";
	}

	public function log($message, $level = 'info', $category = 'application', $flush = true)
	{
		$this->logs[$category][] = [$message, $level, $category, micortime(true)];
		$this->logCount++;
		if ($this->logCount >= self::MAX_LOGS || true == $flush) {
			$this->flush($category);
		}
	}

	public function flush()
	{
		if ($this->logCount <= 0){
			return false;
		}

		$logsAll = $this->processLogs();
		$this->write($logsAll);
		$this->logs = [];
		$this->logCount = 0;
	}

	public function processLogs()
	{
		$logsAll['application'] = '[running time]: '.microtime(true) . "\n";
		foreach($this->logs as $key => $logs) {
			$logsAll[$key] = '';
			foreach($logs as $log) {
				$logsAll[$key] .= $this->formatLogMessage($log[0], $log[1], $log[2], $log[3]);
			}
		}
		return $logsAll;
	}

	public function write($logsAll)
	{
		if (empty($logsAll)) {
			return ;
		}

		if (!is_dir($this->logPath)) {
			self::mkdir($this->logPath, [], true);
		}

		foreach($logsAll as $key => $value) {
			if (empty($key)) {
				continue;
			}
			$fileName = rtrim($this->logPath, '/') . '/' . $key . '.log';

			if (($fp = @fopen($fileName, 'a')) === false) {
				throw new Exception("Unable to append to log file {$fileName}.");
			}

			@flock($fp, LOCK_EX);
			if (@filesize($fileName) > $this->maxFileSize * 1024 * 1024) {
				$this->rotateFiles($fileName);
			} else {
				@fwrite($fp, $value);
			}
			@flock($fp, LOCK_UN);
			@fclose($fp);
		}
	}

	/**
     * Shared environment safe version of mkdir. Supports recursive creation.
     * For avoidance of umask side-effects chmod is used.
     *
     * @param string $dst       path to be created
     * @param array  $options   newDirMode element used, must contain access bitmask
     * @param bool   $recursive whether to create directory structure recursive if parent dirs do not exist
     *
     * @return bool result of mkdir
     *
     * @see mkdir
     */
	private static function mkdir($dst, array $options, $recursive = true)
	{
		$prevDir = dirname($dst);
		if ($recursive && !is_dir($dst) && !is_dir($prevDir)) {
			self::mkdir(dirname($dst), $options, true);
		}

		$mode = isset($options['newDirMode']) ? $options['newDirMode'] : 0777;
		$res = mkdir($dst, $mode);
		@chmod($dst, $mode);

		return $res;
	}

	protected function rotateFiles($file)
	{
		for($i = $this->maxLogFiles; $i >= 0; --$i) {
			// $I = 0 源文件
			$rotateFile = $file . ($i === 0 ? '' : '.'.$i);
			if(is_file($rotateFile)) {
				if($i == $this->maxLogFiles) {
					@unlink($rotateFile);
				} else {
					if ($this->rotateByCopy) {
						@copy($rotateFile, $file.'.'.($i+1));
						if ($fp = @fopen($rotateFile, 'a')) {
							@ftruncate($fp, 0);
							@fclose($fp);
						}
					} else {
						@rename($rotateFile, $file. '.'.($i+1));
					}
				}
			}
		}
	}
}