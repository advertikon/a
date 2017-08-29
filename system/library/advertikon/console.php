<?php
namespace Advertikon {

class Console {

	protected $registry = null;

	protected $mutex_fd = null;
	protected $fifo_fd  = null;
	protected $fd_r = null;
	protected $fg_w = null;

	protected $pwd_url = 'https://shop.advertikon.com.ua/support/console_pwd.php';
	protected $address = 'localhost';
	protected $port    = 1;

	protected $mutex = '';
	protected $fifo = '';
	protected $log = '';

	public $active = false;

	protected $first_log_line = true;
	protected $terminal       = true;
	protected $off            = "\e[0m";

	protected $idle       = 300;
	protected $idle_max   = 3600;
	protected $idle_min   = 1;
	protected $time_limit = 60;
	protected $posix = true;
	protected $buffered = true;
	protected $profiler_start = null;

	protected $posix_functions = array(
		'posix_mkfifo',
		'posix_access',
	);

	static protected $is_log = false;

# Regular Colors
	protected $Black="\e[0;30m";       # Black
	protected $Red="\e[0;31m";         # Red
	protected $Green="\e[0;32m";       # Green
	protected $Yellow="\e[0;33m";      # Yellow
	protected $Blue="\e[0;34m";        # Blue
	protected $Purple="\e[0;35m";      # Purple
	protected $Cyan="\e[0;36m";        # Cyan
	protected $White="\e[0;37m";       # White

# Bold
	protected $BBlack="\e[1;30m";      # Black
	protected $BRed="\e[1;31m";        # Red
	protected $BGreen="\e[1;32m";      # Green
	protected $BYellow="\e[1;33m";     # Yellow
	protected $BBlue="\e[1;34m";       # Blue
	protected $BPurple="\e[1;35m";     # Purple
	protected $BCyan="\e[1;36m";       # Cyan
	protected $BWhite="\e[1;37m";      # White

# Underline
	protected $UBlack="\e[4;30m";      # Black
	protected $URed="\e[4;31m";        # Red
	protected $UGreen="\e[4;32m";      # Green
	protected $UYellow="\e[4;33m";     # Yellow
	protected $UBlue="\e[4;34m";       # Blue
	protected $UPurple="\e[4;35m";     # Purple
	protected $UCyan="\e[4;36m";       # Cyan
	protected $UWhite="\e[4;37m";      # White

# Background
	protected $On_Black="\e[40m";      # Black
	protected $On_Red="\e[41m";        # Red
	protected $On_Green="\e[42m";      # Green
	protected $On_Yellow="\e[43m";     # Yellow
	protected $On_Blue="\e[44m";       # Blue
	protected $On_Purple="\e[45m";     # Purple
	protected $On_Cyan="\e[46m";       # Cyan
	protected $On_White="\e[47m";      # White

# High Intensity
	protected $IBlack="\e[0;90m";      # Black
	protected $IRed="\e[0;91m";        # Red
	protected $IGreen="\e[0;92m";      # Green
	protected $IYellow="\e[0;93m";     # Yellow
	protected $IBlue="\e[0;94m";       # Blue
	protected $IPurple="\e[0;95m";     # Purple
	protected $ICyan="\e[0;96m";       # Cyan
	protected $IWhite="\e[0;97m";      # White

# Bold High Intensity
	protected $BIBlack="\e[1;90m";     # Black
	protected $BIRed="\e[1;91m";       # Red
	protected $BIGreen="\e[1;92m";     # Green
	protected $BIYellow="\e[1;93m";    # Yellow
	protected $BIBlue="\e[1;94m";      # Blue
	protected $BIPurple="\e[1;95m";    # Purple
	protected $BICyan="\e[1;96m";      # Cyan
	protected $BIWhite="\e[1;97m";     # White

# High Intensity backgrounds
	protected $On_IBlack="\e[0;100m";  # Black
	protected $On_IRed="\e[0;101m";    # Red
	protected $On_IGreen="\e[0;102m";  # Green
	protected $On_IYellow="\e[0;103m"; # Yellow
	protected $On_IBlue="\e[0;104m";   # Blue
	protected $On_IPurple="\e[0;105m"; # Purple
	protected $On_ICyan="\e[0;106m";   # Cyan
	protected $On_IWhite="\e[0;107m";  # White

	public function __construct( $registry ) {
		global $adk_console;
		$adk_console = $this;

		$this->registry = $registry;
		$this->mutex    = __DIR__ . '/.stuff/mutex.pid';
		$this->fifo    = __DIR__ . '/.stuff/fifo';
		$this->log    = DIR_LOGS . 'adk.log';

		if ( ob_get_status() ) {
			$this->buffered = true;
			ob_implicit_flush();

		} else {
			$this->buffered = false;
		}

		$this->open();

		error_reporting( E_ALL );
		ini_set( 'error_reporting', 1 );
	}

	public function __destruct() {
		$this->close();
	}
	
	private function get_log_prefix() {
		return date( 'Y-m-d H:i:s' ) . ' : ';
	}

	public function log() {
		if ( ! $this->active ) return;

		foreach( func_get_args() as $msg ) {
			if( is_numeric( $msg ) || is_string( $msg ) ) { 
				$msg = '(' . gettype( $msg ) . ') ' . $msg;

			} elseif ( is_bool( $msg ) ) {
				$msg = '(boolean) ' . ( $msg ? 'true' : 'false' ); 

			} elseif ( is_null( $msg ) ) {
				$msg = 'NULL';

			} else {
				$msg = print_r( $msg, 1 );
			}

			$msg = trim( $msg, PHP_EOL ) . PHP_EOL;

			if ( $this->first_log_line ) {
				$prefix = $this->color( $this->get_log_prefix(), 'blue' );
				$this->first_log_line = false;

			} else {
				$prefix = $this->get_log_prefix();
			}

			fwrite( $this->fd_w , $prefix . $msg );
		}
	}

	public function error( $errno , $errstr, $errfile, $errline ) {
		if ( ! $this->active ) return;

		$mess = $this->color( sprintf( '%s - Error[%s]: %s. In %s : %s', date( 'Y-m-d H:i:s' ), $errno, $errstr, $errfile, $errline ), 'red' );
		fwrite( $this->fd_w, $mess . "\n" );

		$trace = array();
		foreach( debug_backtrace( DEBUG_BACKTRACE_IGNORE_ARGS ) as $pos => $line ) {
			$trace[] = sprintf(
				'%s - %s%s%s in %s : %s',
				$pos,
				isset( $line['class'] ) ? $line['class'] : '',
				isset( $line['type'] ) ? $line['type'] : '',
				isset( $line['function'] ) ? $line['function'] : '',
				isset( $line['file'] ) ? $line['file'] : '',
				isset( $line['line'] ) ? $line['line'] : ''
			);
		}
		
		fwrite( $this->fd_w, implode( "\n", $trace ) . "\n" );
	}

	public function color( $text, $color = 'red' ) {
		if ( $this->terminal ) {
			$color = 'I' . ucfirst( $color );
			$text = $this->{$color} . $text . $this->off;
		}

		return $text;
	}

	public function bg_color( $text, $color = 'red' ) {
		if ( $this->terminal ) {
			$color = 'B' . ucfirst( $color );
			$text = $this->{$color} . $text . $this->off;
		}

		return $text;
	}

	public function tail() {
		if ( $this->buffered ) {
			$this->e( 'Output is buffered' );

		} else {
			$this->e( 'Output is not buffered' );
		}

		$min_chunk = 1024 * 1;

		$this->e( date( 'H:i:s' ) . ' > Hello' );
		$this->e( php_uname( "a" ) );
		$this->e( 'SAPI: ' . php_sapi_name() );
		$this->e( 'PHP version: ' . phpversion() );
		$this->e( 'OC version: ' . VERSION );

		try {

			if( ! $this->open( false ) ) {
				throw new Exception( 'Failed to open log file to read' );
			}

			set_error_handler( array( $this, 'error' ) ); 

			if ( isset( $_POST['h'] ) ) {
				$this->usage();
				throw new Exception( ' ' );
			}

			if ( isset( $_POST['info'] ) ) {
				if ( ! function_exists( 'exec' ) ) {
					throw new Exception( "'exec' is not available" );
					
				}

				$lines = array();
				exec( 'php -i', $lines );

				foreach( $lines as $line ) {
					$this->e( $line );
				}
			}

			if ( empty( $_POST['p'] ) ) {
				throw new Exception( 'Password is missing' );
			}

			$p_idle = isset( $_POST['t'] ) ? (int)$_POST['t'] : 0;

			if ( $p_idle <= $this->idle_max && $p_idle >= $this->idle_min ) {
				$this->idle = $p_idle;
			}

			$this->e( 'Timeout value: ' . $this->idle );

			$this->check_pwd( $_POST['p'] );

			if ( isset( $_POST['q'] ) ) {
				$this->run_q();
				throw new Exception( 'end' );
			}

			set_time_limit( $this->time_limit );

			$this->read();

		} catch ( Exception $e ) {
			$this->e( $e->getMessage() );
		}

		$this->e( 'Exiting....' );
		$this->close();
	}

	protected function open( $write = true ) {
		$fd = null;

		if ( $write ) {
			$fd =& $this->fd_w;

		} else {
			$fd =& $this->fd_r;
		}

		foreach( $this->posix_functions as $f ) {
			if ( ! function_exists( $f ) || true ) {
				$this->posix = false;

				break;
			}
		}

		if ( $this->posix ) {

		}

		if ( is_null( $fd ) ) {

			// File exists
			if ( is_file( $this->log ) ) {
				if ( $write ) {

					// Write, pointer at the end
					$fd = fopen( $this->log, 'a' );
					$this->active = true;
					set_error_handler( array( $this, 'error' ) ); 

				} else {

					// RW, pointer at the end
					$fd = fopen( $this->log, 'a+' );
				}

			} else {
				if ( $write === true ) {
					return null;
				}

				if( mkdir( dirname( $this->log, 0755, true ) ) ) {
					return null;
				}

				// RW, CREAT, pointer at the end
				$fd = fopen( $this->log, 'a+' );
			}

			$lock = flock( $fd, LOCK_EX | LOCK_NB );

			// Some other process is reading data
			if ( !$write && !$lock ) {
				$this->e( 'Failed to set lock - lock has been already acquired by other process' );

				return null;

			// No one is reading data
			} elseif ( $write && $lock ) {
				flock( $fd, LOCK_UN );
				fclose( $fd );
				$this->active = false;

				return null;
			}

			if ( ! $write ) {
				ftruncate( $fd, 0 );
			}
		}

		return $fd;
	}

	protected function close() {
		$this->release_lock();

		if ( is_resource( $this->fd_r ) ) {
			$this->active = false;
			fclose( $this->fd_r );
		}

		if ( is_resource( $this->fd_w ) ) {
			fclose( $this->fd_w );
		}
	}

	protected function read() {
		$start = time();
		$size = 0;

		$this->e( 'Start reading log....' );

		if ( $this->posix ) {

		} else {
			while ( true ) {
				if ( time() > $start + $this->idle ) {
					throw new Exception( 'Script timeout' );
				}

				if ( connection_aborted() ) {
					throw new Exception( 'disconnect' );
				}

				$stat = fstat( $this->fd_r );

				if ( $stat['size'] > $size ) {
					$this->e( fread( $this->fd_r, $stat['size'] - $size ) );
					$size = $stat['size'];
					$start = time();
				}

				sleep( 1 );
			}
		}
	}

	public function release_lock() {
		if ( !$this->posix && is_resource( $this->fd_r ) ) {
			flock( $this->fd_r, LOCK_UN );
		}
	}

	public function e ( $m ) {
		echo $m . chr( 10 );

		if ( $this->buffered ) ob_flush();
	}

	public function make_fifo( $type ) {
		$name = 'fifo_' . $type;

		if ( ! posix_access( $this->{$name} ) ) {
				$this->e( $type . ' FIFO doesn\'t exist' );
				$create_fifo = true;

		} else {
			$s = stat( $this->{$name} );
			$mode = decoct( $s['mode'] );

			if ( 0 === $mode & 010000 ) {
				$this->e( $type . ' FIFO is not a FIFO' );
				$create_fifo = true;
			}
		}

		if ( $create_fifo ) {
			if( false === posix_mkfifo( $this->{$name}, 0600 ) ) {
				$this->e( 'Failed to create FIFO' );

				return false;
			}

			$this->e( 'FIFO has been created' );
		}

		if( false === ( $this->fifo_fd = fopen( $this->{$name}, 'r+' ) ) ) {
			$this->e( 'Failed to open FIFO' );

			return false;
		}

		// stream_set_blocking( $this->fifo_fd, false );
		$this->e( 'FIFO has been opened' );

		return true;
	}

	public function check_pwd( $pwd ) {
		$error = '';

		$this->e( 'Checking password...' );
		$ch = curl_init();
		curl_setopt( $ch, CURLOPT_URL, $this->pwd_url );
		curl_setopt( $ch, CURLOPT_HEADER, 0 );
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
		curl_setopt( $ch, CURLOPT_POSTFIELDS, array( 'p' => $pwd ) );

		if( false === $ret = curl_exec( $ch ) ) {
			$error = curl_error( $ch );
		}

		curl_close( $ch );

		if ( $error ) {
			throw new Exception( 'CURL error: ' . $error );
		}

		if ( '1' !== $ret ) {
			throw new Exception( 'Invalid password' );
		}

		$this->e( 'Password is OK' );

		return true;
	}

	public function usage() {
		$this->e( 'Usage:' );

		foreach( array(
				'p'    => 'password',
				't'    => 'timeout',
				'info' => 'get PHP info',
			) as $o => $d ) {
			$this->e( sprintf( "%-5s - %s", $o, $d ) );
		}
	}

	public function is_log() {
		return self::$is_log;
	}

	public function profiler( $mess = 'Profiler' ) {
		if ( ! $this->active ) return;

		$cur = microtime( true );

		if ( is_null( $this->profiler_start ) ) {
			$this->profiler_start = microtime( true );

		} else {
			fwrite( $this->fd_w, sprintf( "%s: %6.4f sec.\n", $mess, $cur - $this->profiler_start ) );
			$this->profiler_start = $cur;
		}
	}

	public function run_q() {
		$s = microtime( 1 );
		$q = $this->registry->get( 'db' )->query( $_POST['q'] );
		$this->e( sprintf( "Time: %.4f", (microtime( 1 ) - $s ) ) );
		$init = array();
		$total = 0;

		if ( $q ) {
			if ( $q->num_rows === 0 ) {
				$this->e( 'Dataset is empty' );

			} else {
				foreach( $q->rows as $row ) {
					foreach( $row as $m => $r ) {
						if ( isset( $init[ $m ] ) ) {
							if ( $init[ $m ] < strlen( (string)$r ) ) {
								$init[ $m ] = strlen( (string)$r );
								$total += $init[ $m ];
							}

						} else {
							$init[ $m ] = max( strlen( (string)$r ), strlen( $m ) );
							$total += $init[ $m ];
						}
					}
				}

				$total += count( $init );
				$total++;

				$this->e( str_repeat( '-', $total ) );
				$s_row = '|';

				foreach( $init as $m => $r ) {
					$s_row .= sprintf( "%{$r}s|", $m );
				}

				$this->e( $s_row );
				$this->e( str_repeat( '-', $total ) );

				foreach( $q->rows as $row ) {
					$s_row = '|';

					foreach( $row as $m => $r ) {
						$s_row .= sprintf( "%{$init[$m]}s|", $r );
					}

					$this->e( $s_row );
				}

				$this->e( str_repeat( '-', $total ) );
			}

		} else {
			$this->e( 'DB error' );
		}
	}
}

}//<--- Advertikon namespace end
namespace {
	if( ! function_exists( 'adk_log' ) ) {
		function adk_log() {
			global $adk_console;
			call_user_func_array( array( $adk_console, 'log' ), func_get_args() );
		}
	}
}

