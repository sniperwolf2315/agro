<?php

// echo "si se conecto";
if( !function_exists('mime_type_check') ){
	function mime_type_check($path)
	{
		if( function_exists('mime_content_type') )
			return mime_content_type($path);
		else
			return 'undefined/unknown';
	}
}

if( !function_exists('file_owner') ){
	function file_owner($path)
	{
		if( function_exists('posix_getpwuid') )
			$u = posix_getpwuid(fileowner($path));
		else
			return 'unknown';
		return $u['name'];
	}
}

if( !function_exists('file_group') ){
	function file_group($path)
	{
		if( function_exists('posix_getgrgid') )
			$g = posix_getgrgid(fileowner($path));
		else
			return 'unknown';
		return $g['name'];
	}
}

if( !function_exists('Kfileperms') ){
	function Kfileperms($path)
	{
		$perms = @fileperms($path);

		if (($perms & 0xC000) == 0xC000) { // Socket
			$info = 's';
		} elseif (($perms & 0xA000) == 0xA000) { // Symbolic Link
			$info = 'l';
		} elseif (($perms & 0x8000) == 0x8000) { // Regular
			$info = '-';
		} elseif (($perms & 0x6000) == 0x6000) { // Block special
			$info = 'b';
		} elseif (($perms & 0x4000) == 0x4000) { // Directory
			$info = 'd';
		} elseif (($perms & 0x2000) == 0x2000) { // Character special
			$info = 'c';
		} elseif (($perms & 0x1000) == 0x1000) { // FIFO pipe
			$info = 'p';
		} else { // Unknown
			$info = 'u';
		}

		// Owner
		$info .= (($perms & 0x0100) ? 'r' : '-');
		$info .= (($perms & 0x0080) ? 'w' : '-');
		$info .= (($perms & 0x0040) ? (($perms & 0x0800) ? 's' : 'x' ) : (($perms & 0x0800) ? 'S' : '-'));

		// Group
		$info .= (($perms & 0x0020) ? 'r' : '-');
		$info .= (($perms & 0x0010) ? 'w' : '-');
		$info .= (($perms & 0x0008) ? (($perms & 0x0400) ? 's' : 'x' ) : (($perms & 0x0400) ? 'S' : '-'));

		// World
		$info .= (($perms & 0x0004) ? 'r' : '-');
		$info .= (($perms & 0x0002) ? 'w' : '-');
		$info .= (($perms & 0x0001) ? (($perms & 0x0200) ? 't' : 'x' ) : (($perms & 0x0200) ? 'T' : '-'));

		return $info;
	}
}

if( !function_exists('byteConvert') ){
	function byteConvert($bytes)
	{
		$s = array('B', 'KB', 'MB', 'GB', 'TB', 'PB');
		$e = floor(log($bytes)/log(1024));

		return @sprintf('%.2f '.$s[$e], ($bytes/pow(1024, floor($e))));
	}
}

function strToHex($string)
{
    $hex='';
    for ($i=0; $i < strlen($string); $i++)
        $hex .= dechex(ord($string[$i]));
    return $hex;
}

function hexToStr($hex)
{
    $string='';
    for ($i=0; $i < strlen($hex)-1; $i+=2)
        $string .= chr(hexdec($hex[$i].$hex[$i+1]));
    return $string;
}

function nametester($str)
{
	$res = Null;
	$hex = strToHex($str);
	$len = strlen($str); $hexalen = strlen($hex);
	$step = floor($hexalen/$len);
	for($i=0; $hexalen>=$i ;$i+=$step){
		$add = substr($hex, $i, $step);
		if( strlen($add)==0 ) break;
		$res .= ' 0x'.$add;
	}
	return $res;
}

class ssh2
{
	private $connection;
	private $sftp;
	private $host;

	public function __construct($host, $port=22)
	{
		$this->host = $host;

		if( !function_exists('ssh2_connect') ){
			throw new Exception("Your server is not supporting ssh2 extension");
		}

		$this->connection = @ssh2_connect($this->host, $port);
		if( !$this->connection ){
			throw new Exception("Could not connect to {$this->host} on port $port.");
		}
	}

	public function login($username, $password)
	{
		if( !@ssh2_auth_password($this->connection, $username, $password) ){
			throw new Exception("Could not authenticate with username $username " . "and password *******.");
		}
		return $this;
	}

	public function sftp()
	{
		$this->sftp = @ssh2_sftp($this->connection);
		if( !$this->sftp ){
			throw new Exception("Could not initialize SFTP subsystem.");
		} print("\nsftp: {$this->sftp}<br>\n\n");
		return $this;
	}

	public function upload($local_file, $remote_file)
	{
		$this->rm($remote_file);
		$stream = @fopen("ssh2.sftp://{$this->sftp}{$remote_file}", 'a');
		if( !$stream ){
			throw new Exception("Could not open remote file for writing: $remote_file");
		}

		$local = @fopen($local_file, 'r');
		if( !$local ){
			throw new Exception("Could not open local file: $local_file.");
		}
		while( !feof($local) ){
			fwrite($stream, fgets($local));
		}

		@fclose($local);
		@fclose($stream);

		return $this;
	}

	function scan($remote_file)
	{
		$dir = "ssh2.sftp://{$this->sftp}{$remote_file}"; print($dir.'<br>');

		$dirs = array();
		$files = array();
		$handle = opendir($dir);
		while( false !== ( $file = readdir($handle) ) ){
			if( substr("$file", 0, 1) != "." ){

// 				print("\n<hr>File: $file | ".nametester($file)." <br>\n");
// 				print("\n{$file}<br>\n");
				if( is_dir($dir.'/'.$file) ){
					// $dirs[$file] = $this->scanFilesystem("$dir/$file");
					$dirs[$file] = array();
				} else{
					$mime_type = mime_type_check($dir.'/'.$file);
					$sftp_stats = ssh2_sftp_stat($this->sftp, $remote_file.'/'.$file);
					$guid =($this->host == 'localhost'?array(
						'owner' => current(posix_getpwuid($sftp_stats['uid'])),
						'group' => current(posix_getgrgid($sftp_stats['gid'])), ):array());
					$files[$file] = array_merge($guid, array(
							'mode' => $sftp_stats['mode'],
							'size' => byteConvert($sftp_stats['size']),
							'active' => date("H:i m.d.Y", $sftp_stats['atime']),
							'modify' => date("H:i m.d.Y", $sftp_stats['mtime']),
							'mime' => $mime_type,
							'perm' => Kfileperms($dir.'/'.$file),
							'image' => (eregi("^image/", $mime_type)?getimagesize($dir.'/'.$file):FALSE), ));
				}
			}
		}
		@closedir($handle);

		return(array('folders'=>$dirs, 'files' =>$files));
	}

	public function download($remote_file, $local_file)
	{
		$stream = @fopen("ssh2.sftp://{$this->sftp}{$remote_file}", 'r');
		if( !$stream ){
			throw new Exception("Could not open file: $remote_file");
		}

		@unlink($local_file);
		$local = @fopen($local_file, 'a');
		if( !$local ){
			throw new Exception("Could not open local file for writing: $local_file.");
		}
		while( !feof($stream) ){
			fwrite($local, fgets($stream));
		}

		@fclose($local);
		@fclose($stream);

		return $this;
	}

	public function rm($remote_file)
	{
		if( !@is_dir("ssh2.sftp://{$this->sftp}{$remote_file}") ){
			if( !@ssh2_sftp_unlink($this->sftp, $remote_file) ){
				throw new Exception("Could not delete file: $remote_file");
			}
		}
		else{
			if( !@ssh2_sftp_rmdir($remote_file) ){
				throw new Exception("Could not delete folder: $remote_file");
			}
		}
	}

	public function ssh2_sftp_mkdir($folder)
	{
		if( !@ssh2_sftp_rmdir($sftp, $folder) ){
				throw new Exception("Could not create folder: $folder ");
		}
	}

	public function exec($command)
	{
		$shell = ssh2_shell($this->connection,"bash");
		$cmd = "echo '[start]';$command;echo '[end]'";
		$output = $this->userExec($shell, $cmd);
		@fclose($shell);

		$stream = @ssh2_exec($this->connection, $cmd);
  		if( !@stream_set_blocking($stream, true) ){
			throw new Exception("Could not set blocking on command");
		}
  		return @stream_get_contents($stream);
	}

	private function userExec($shell, $cmd)
	{
		fwrite($shell, $cmd."\n");
		$output = "";
		$start = false;
		$start_time = time();
		$max_time = 2; //time in seconds
		while( ((time()-$start_time) < $max_time) ){
			$line = fgets($shell);
			if(!strstr($line,$cmd)) {
				if(preg_match('/\[start\]/',$line)) {
					$start = true;
				} elseif(preg_match('/\[end\]/',$line)) {
					return $output;
				} elseif($start){
					$output[] = $line;
				}
			}
		}
		return($output);
	}
}

?>