<?php
/**
 * Bootswatch build class.
 *
 * @package Bootswatch
 */

namespace Kadimi;

use \ZipArchive;

/**
 * BootswatchBuild
 */
class BootswatchBuild {

	/**
	 * Timer.
	 *
	 * @var float
	 */
	private $timer;

	/**
	 * Bootswatch theme version.
	 */
	private $theme_version;

	/**
	 * Ignored patterns.
	 *
	 * @var array
	 */
	private $ignored_patterns = [];

	/**
	 * Vendor ignored patterns.
	 *
	 * @var array
	 */
	private $vendor_ignored_patterns = [];

	/**
	 * When true, no deletions are made.
	 *
	 * @var boolean
	 */
	private $pretend = false;

	/**
	 * File list.
	 *
	 * @var array
	 */
	private $vendor_files = [];

	/**
	 * File list.
	 *
	 * @var array
	 */
	private $files = [];

	/**
	 * Bytes deleted.
	 *
	 * @var Integer
	 */
	private $bytes_deleted = 0;

	/**
	 * Constructor.
	 *
	 * Fires:
	 * - Cleaning vendors with `clean_vendor`
	 * - Clearing cache with `clear_cache`
	 *
	 * @param Array $data Data.
	 */
	public function __construct( $data ) {
		$this->timer = microtime( true );
		$this->theme_version = file_get_contents( '.version' );
		$this->ignored_patterns = $data['ignored_patterns'];
		$this->vendor_ignored_patterns = $data['vendor_ignored_patterns'];
		$this->update_readme();
		$this->check_readme();
		$this->create_style();
		$this->clean_vendor();
		$this->clear_cache();
		$this->package();
	}

	/**
	 * Destrictor.
	 */
	public function __destruct() {
		$this->log();
		$this->log( sprintf( 'Build process completed in %.2fs' , microtime( true ) - $this->timer ) );
		$this->log();
	}

	/**
	 * Create or recreates style.css.
	 */
	private function create_style() {

		if ( file_exists( 'style.css' ) ) {
			unlink( 'style.css' );
		}

		$variables = [
			'{{version}}' => $this->theme_version,
		];

		$parts = [
			'css/style.css',
			'css/wordpress-core.css',
			'css/wordpress-core-overrides.css',
			'css/wordpress-core-missing.css',
			'css/twentyseventeen-galleries.css',
			'css/twentyseventeen-galleries-missing-columns.css',
			'css/misc.css',
		];

		// Join files.
		$css = '';
		foreach ( $parts as $part ) {
			$css .= file_get_contents( $part ) . "\n";
		}

		// Replace variables.
		$css = str_replace( array_keys( $variables), array_values( $variables), $css );

		// Write file.
		file_put_contents( 'style.css', $css );
	}

	/**
	 * Check readme.txt.
	 */
	private function check_readme() {

		/**
		 * Check version section in changelog.
		 */
		$readme = file_get_contents( 'readme.txt' );
		$changelog_section_exists = strstr( $readme, sprintf( '= %s -', $this->theme_version ) );
		if ( ! $changelog_section_exists ) {
			echo "\033[31m\033[1mError:\033[0m\033[0m ";
			echo sprintf( 'Changelog section for version %s does not exist in readme.txt', $this->theme_version );
			die();
		}
	}

	/**
	 * Create/Update readme.txt.
	 */
	private function update_readme() {

		$variables = [
			'{{version}}'      => $this->theme_version,
			'{{changelog}}'    => file_get_contents( 'readme/changelog.txt'),
			'{{credits}}'      => file_get_contents( 'readme/credits.txt'),
			'{{description}}'  => file_get_contents( 'readme/description.txt'),
			'{{faq}}'          => file_get_contents( 'readme/faq.txt'),
			'{{installation}}' => file_get_contents( 'readme/installation.txt'),
		];

		$readme = file_get_contents( 'readme/readme.txt' );

		// Replace variables.
		$readme = str_replace( array_keys( $variables), array_values( $variables), $readme );

		// Write file.
		file_put_contents( 'readme.txt', $readme );
	}

	/**
	 * Updates the list of files `$vendor_files`.
	 *
	 * @return Array The updated list of files.
	 */
	private function update_vendor_files() {
		$this->vendor_files = $this->find( '.' );
		return $this->vendor_files;
	}

	/**
	 * Updates the list of files `$files`.
	 *
	 * @return Array The updated list of files.
	 */
	private function update_files() {
		$this->files = $this->find( '.' );
		return $this->files;
	}

	/**
	 * Clean vendor folder.
	 */
	private function clean_vendor() {
		chdir( 'vendor' );
		$this->update_vendor_files();
		foreach ( $this->vendor_ignored_patterns as $id => $pattern ) {
			$this->process_pattern( $pattern, $id );
		}
		$this->log();
		$this->log( sprintf( '[%s] Deleted %d bytes.'
			, $this->pretend ? 'Dry' : 'Live'
			, $this->bytes_deleted
		) );
		$this->log( '==================================================' );
		$this->log();
		chdir( '..' );
	}

	/**
	 * Build zip file.
	 */
	private function package() {

		$filename = 'bootswatch.zip';

		if ( file_exists( $filename ) ) {
			unlink( $filename );
		}

		/**
		 * Prepare a list without excluded files.
		 */
		$files = $this->update_files();
		foreach ( $this->ignored_patterns as $pattern ) {
			$files = array_diff( $files, $this->pattern_elements( $pattern, $files ) );
		}

		/**
		 * Create package.
		 */
		$zip = new ZipArchive();
		if ( $zip->open( $filename, ZipArchive::CREATE ) !== true ) {
			$this->log( 'cannot open <$filename>' );
			exit;
		}
		foreach ( $files as $file ) {
			if ( is_dir( $file ) ) {
				$zip->addEmptyDir( $file );
			} else {
				$zip->addFile( $file );
			}
		}
		$zip->close();

		$this->log();
		$this->log( 'Package created.' );
		$this->log();
	}

	/**
	 * Deletes the cache folder.
	 */
	private function clear_cache() {
		$this->delete_element( 'cache' );
		$this->log();
		$this->log( 'Cache cleared.' );
		$this->log();
	}

	/**
	 * Deletes files or folders recursively.
	 *
	 * @param  String $element A path.
	 * @return Boolean          True on success, otherwise false.
	 */
	private function delete_element( $element ) {
		if ( ! file_exists( $element ) ) {
			return true;
		}
		if ( is_dir( $element ) ) {
			foreach ( glob( $element . '/{,.}[!.,!..]*', GLOB_MARK | GLOB_BRACE ) as $e ) {
				$this->delete_element( $e );
			}
			return $this->pretend ? true : rmdir( $element );
		} else {
			$this->bytes_deleted += filesize( $element );
			return $this->pretend ? true : unlink( $element );
		}
		return true;
	}

	/**
	 * Deletes files and folders matching pattern.
	 *
	 * @param  String $pattern The pattern without delimiters or flags.
	 * @param  string $id      An option ID.
	 */
	private function process_pattern( $pattern, $id = '' ) {
		$this->log( 'Pattern     : ' . ( $id ? "$id ($pattern)" : $pattern ) );
		$this->log( 'Total Files : ' . $this->pattern_total_elements( $pattern, $this->update_vendor_files() ) );
		$this->log( 'Total Size  : ' . $this->pattern_total_size( $pattern, $this->update_vendor_files() ) );
		foreach ( $this->pattern_elements( $pattern, $this->vendor_files ) as $element ) {
			$this->log( ' - Deleting ' . $element . '...', false );
			$this->log( $this->delete_element( $element ) ? 'SUCCESS' : 'FAILURE' );
		}
		$this->log();
	}

	/**
	 * Count elements matching pattern.
	 *
	 * @param  String $pattern  The pattern.
	 * @param  Array  $files    The files list to match pattern against.
	 * @return Integer          The count.
	 */
	protected function pattern_total_elements( $pattern, $files ) {
		return count( $this->pattern_elements( $pattern, $files ) );
	}

	/**
	 * Get size of elements matching pattern.
	 *
	 * @param  String $pattern  The pattern.
	 * @param  Array  $files    The files list to match pattern against.
	 * @return Integer          The size.
	 */
	protected function pattern_total_size( $pattern, $files ) {
		$total_size = 0;
		$files = preg_grep( "#$pattern#", $files );
		foreach ( $files as $file ) {
			$total_size += filesize( $file );
		}
		return $total_size;
	}

	/**
	 * Works like shell find command.
	 *
	 * @param  Sting $pattern The pattern.
	 * @return Array          A list of files paths.
	 */
	protected function find( $pattern ) {

		$elements = [];

		/**
		 * All paths
		 */
		$paths = new \RecursiveIteratorIterator( new \RecursiveDirectoryIterator( $pattern ), \RecursiveIteratorIterator::SELF_FIRST );

		foreach ( $paths as $path => $unused ) {
			/**
			 * Skip non-matching.
			 */
			if ( ! preg_match( "/$pattern/", $path ) ) {
				continue;
			}
			/**
			 * Skip `.` and `..`.
			 */
			if ( preg_match( '/\/\.{1,2}$/', $path ) ) {
				continue;
			}
			/**
			 * Remove './';
			 */
			$path = preg_replace( '#^\./#', '', $path );

			/**
			 * Add `/` to directories.
			 */
			if ( is_dir( $path ) ) {
				$path .= '/';
			}

			$elements[] = $path;
		}
		sort( $elements );
		return $elements;
	}

	/**
	 * Get list of elements matching pattern.
	 *
	 * @param  Sting $pattern The pattern.
	 * @param  Array $files   The files list to match pattern against.
	 * @return Array          A list of files paths.
	 */
	protected function pattern_elements( $pattern, $files ) {
		return preg_grep( "#$pattern#", $files );
	}

	/**
	 * Simple logger function.
	 *
	 * @param  String  $message         The message.
	 * @param  boolean $append_new_line True to append a new line.
	 */
	protected function log( $message = '', $append_new_line = true ) {
		echo $message; // XSS OK.
		if ( $append_new_line ) {
			echo "\n";
		}
	}
}
