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
	 * Bytes deleted.
	 *
	 * @var Integer
	 */
	private $bytes_deleted = 0;

	/**
	 * File list.
	 *
	 * @var array
	 */
	private $files = [];

	/**
	 * Ignored patterns.
	 *
	 * @var array
	 */
	private $ignored_patterns = [];

	/**
	 * Last error seen on the log.
	 *
	 * @var Boolean|String
	 */
	private $last_error = false;

	/**
	 * Regular expression string replacements.
	 *
	 * @var array
	 */
	private $preg_replacements = [];

	/**
	 * When true, no deletions are made.
	 *
	 * @var boolean
	 */
	private $pretend = false;

	/**
	 * Normal string replacements.
	 *
	 * @var array
	 */
	private $str_replacements = [];

	/**
	 * Timer.
	 *
	 * @var float
	 */
	private $timer;

	/**
	 * Bootswatch theme version.
	 *
	 * @var String
	 */
	private $theme_version;

	/**
	 * File list.
	 *
	 * @var array
	 */
	private $vendor_files = [];

	/**
	 * Vendor ignored patterns.
	 *
	 * @var array
	 */
	private $vendor_ignored_patterns = [];

	/**
	 * Constructor.
	 *
	 * Fires all tasks.
	 *
	 * @param Array $data Data.
	 */
	public function __construct( $data ) {
		$this->timer = microtime( true );
		$this->theme_version = file_get_contents( '.version' );

		$this->ignored_patterns        = $data['ignored_patterns'];
		$this->vendor_ignored_patterns = $data['vendor_ignored_patterns'];
		$this->preg_replacements       = $data['preg_replacements'];
		$this->str_replacements        = $data['str_replacements'];

		$this->task( [ $this, 'pot' ], 'Creating Languages File' );
		$this->task( [ $this, 'update_translations' ], 'Updating .pot and po Files' );
		$this->task( [ $this, 'update_readme' ], 'Updating `readme.txt`' );
		$this->task( [ $this, 'check_readme' ], 'Validating `readme.txt`' );
		$this->task( [ $this, 'create_style' ], 'Creating `style.css`' );
		$this->task( [ $this, 'clean_vendor' ], 'Cleaning Vendors Folder' );
		$this->task( [ $this, 'do_str_replace' ], 'Applying Normal String Replacements' );
		$this->task( [ $this, 'do_preg_replace' ], 'Applying Regular Expression String Replacements' );
		$this->task( [ $this, 'clear_cache' ], 'Clearing Cache' );
		$this->task( [ $this, 'package' ], 'Packaging' );
	}

	/**
	 * Destrictor.
	 */
	public function __destruct() {
		$duration = microtime( true ) - $this->timer;
		if ( ! $this->last_error ) {
			$this->log_title( sprintf( 'Build completed in %.2fs' , $duration ) );
		}
	}

	/**
	 * Create or recreates style.css.
	 */
	private function create_style() {

		if ( file_exists( 'style.css' ) ) {
			unlink( 'style.css' );
		}

		$variables = [
			'{{tags}}'    => str_replace( "\n", ',', file_get_contents( 'readme/tags.txt' ) ),
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
		$css = str_replace( array_keys( $variables ), array_values( $variables ), $css );

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
			echo $this->log_error( sprintf( 'Changelog section for version %s does not exist in readme.txt', $this->theme_version ) );
			die();
		}
	}

	/**
	 * Create/Update readme.txt.
	 */
	private function update_readme() {

		$variables = [
			'{{changelog}}'    => file_get_contents( 'readme/changelog.txt' ),
			'{{credits}}'      => file_get_contents( 'readme/credits.txt' ),
			'{{description}}'  => file_get_contents( 'readme/description.txt' ),
			'{{faq}}'          => file_get_contents( 'readme/faq.txt' ),
			'{{installation}}' => file_get_contents( 'readme/installation.txt' ),
			'{{tags}}'         => str_replace( "\n", ',', file_get_contents( 'readme/tags.txt' ) ),
			'{{version}}'      => $this->theme_version,
		];

		// Read.
		$readme = file_get_contents( 'readme/readme.txt' );

		// Replace variables.
		$readme = str_replace( array_keys( $variables ), array_values( $variables ), $readme );

		// Write.
		file_put_contents( 'readme.txt', $readme );
	}

	/**
	 * Get the updated list of files `$vendor_files`.
	 *
	 * @return Array The list of vendor files.
	 */
	private function get_vendor_files() {
		$this->vendor_files = $this->find( '.' );
		return $this->vendor_files;
	}

	/**
	 * An alias of `get_vendor_files`.
	 *
	 * @return Array The list of vendor files.
	 */
	private function update_vendor_files() {
		return 	$this->get_vendor_files();
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
		$this->get_vendor_files();
		foreach ( $this->vendor_ignored_patterns as $id => $pattern ) {
			$this->delete_vendor_files_by_pattern( $pattern, $id );
		}
		$this->log();
		$this->log( sprintf( '[%s] Deleted %d bytes.'
			, $this->pretend ? 'Dry' : 'Live'
			, $this->bytes_deleted
		) );
		chdir( '..' );
	}

	/**
	 * Apply normal string replacements.
	 */
	private function do_str_replace() {
		$this->log();
		foreach ( $this->str_replacements as $file => $replacements ) {
			/**
			 * Provide a version helper.
			 */
			$replacements['{{version}}'] = $this->theme_version;

			/**
			 * Replace.
			 */
			file_put_contents( $file,
				str_replace(
					array_keys( $replacements ),
					array_values( $replacements ),
					file_get_contents( $file ),
					$count
				)
			);

			/**
			 * Write to log.
			 */
			$this->log( sprintf( '%d replacements made in %s.'
				, $count
				, $file
			) );
		}
	}

	/**
	 * Apply regex string replacements.
	 */
	private function do_preg_replace() {
		$this->log();
		foreach ( $this->preg_replacements as $file => $replacements ) {
			$replacements['/\{\{version\}\}/'] = $this->theme_version;
			$count    = 0;
			$contents = file_get_contents( $file );
			foreach ( $replacements as $regex => $replacement ) {
				$contents = preg_replace( $regex, $replacement, $contents, -1, $sub_count );
				$count += $sub_count;
			}
			file_put_contents( $file, $contents );
			$this->log( sprintf( '%d replacements made in %s.'
				, $count
				, $file
			) );
		}
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
	}

	/**
	 * Deletes the cache folder.
	 */
	private function clear_cache() {
		$this->delete_element( 'cache' );
		$this->log();
		$this->log( 'Cache cleared.' );
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
	 * Deletes files and folders matching pattern in the vendor folder.
	 *
	 * @param  String $pattern The pattern without delimiters or flags.
	 * @param  string $id      An pattern ID.
	 */
	private function delete_vendor_files_by_pattern( $pattern, $id = '' ) {
		$this->update_vendor_files();
		$this->log();
		$this->log( 'Pattern     : ' . ( $id ? "$id ($pattern)" : $pattern ) );
		$this->log( 'Total Files : ' . $this->pattern_total_elements( $pattern, $this->vendor_files ) );
		$this->log( 'Total Size  : ' . $this->pattern_total_size( $pattern, $this->vendor_files ) );
		foreach ( $this->pattern_elements( $pattern, $this->vendor_files ) as $element ) {
			$this->log( ' - Deleting ' . $element . '...', false );
			$this->log( sprintf( '   => %s.',  $this->delete_element( $element ) ? 'Done' : 'Failed' ) );
		}
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
	 * @param  boolean $is_title        True to use special markup.
	 */
	protected function log( $message = '', $append_new_line = true, $is_title = false ) {
		if ( $is_title ) {
			$message = "\033[32m\033[1m$message\033[0m";
		}
		echo $message; // XSS OK.
		if ( $append_new_line ) {
			echo "\n";
		}
	}

	/**
	 * Helper function to show title in log.
	 *
	 * @param  String $title  The log title.
	 */
	protected function log_title( $title ) {
		$this->log();
		$this->log( $title, true, true );
	}

	/**
	 * Helper function to show error in log.
	 *
	 * @param  String $title  The log title.
	 */
	protected function log_error( $message ) {

		$this->last_error = $message;
		$this->log( "\033[31m\033[1mError: $message\033[0m", true, true );
		exit();
	}

	/**
	 * Runs a task.
	 */
	protected function task( callable $callback, $title ) {
		$this->log_title( $title . ' started.' );
		$timer = microtime( true );
		call_user_func( $callback );
		$duration = microtime( true ) - $timer;
		$this->log_title( sprintf( '%s completed in %.2fs' , $title, $duration ) );

	}

	protected function pot() {

		$this->log();

		if ( ! $this->shell_command_exists( 'xgettext' ) ) {
			$this->log_error( '`xgettext` command does not exist.' );
			exit;
		}

		$command = str_replace( "\n", '', '
			find -name "*.php"
				-not -path "./build/*"
				-not -path "./tests/*"
				-not -path "./vendor/*"
			|
			xargs xgettext
				--language=PHP
				--package-name=Bootswatch
				--package-version={{version}}
				--copyright-holder="Nabil Kadimi"
				--msgid-bugs-address="https://github.com/kadimi/bootswatch/issues/new"
				--from-code=UTF-8
				--keyword="__"
				--keyword="__ngettext:1,2"
				--keyword="__ngettext_noop:1,2"
				--keyword="_c,_nc:4c,1,2"
				--keyword="_e"
				--keyword="_ex:1,2c"
				--keyword="_n:1,2"
				--keyword="_n_noop:1,2"
				--keyword="_nx:4c,1,2"
				--keyword="_nx_noop:4c,1,2"
				--keyword="_x:1,2c"
				--keyword="esc_attr__"
				--keyword="esc_attr_e"
				--keyword="esc_attr_x:1,2c"
				--keyword="esc_html__"
				--keyword="esc_html_e"
				--keyword="esc_html_x:1,2c"
				--sort-by-file
				-o languages/bootswatch.pot
		');
		shell_exec( $command );
		$this->log( 'Language file created successfully.' );
	}

	protected function shell_command_exists( $command ) {
		$output = shell_exec( sprintf( 'which %s', escapeshellarg( $command ) ) );
		return ! empty( $output );
	}

	protected function update_translations() {

		$this->log();

		/**
		 * Check that the Transifex API token exists.
		 */
		if ( ! file_exists( '.transifex' ) ) {
			$this->log_error( 'Transifex API token not found, it should be saved in `.transifex`.' );
		}
		$transifex_api_token = file_get_contents( '.transifex' );

		$api_url = 'https://www.transifex.com/api/2/project/bootswatch/';
		$auth    = base64_encode( "api:$transifex_api_token" );

		/**
		 * Upload source file.
		 */
		$data = [
			'content' => file_get_contents( 'languages/bootswatch.pot' ),
		];
		$postdata = json_encode( $data );
		$context = stream_context_create( [
			'http' => [
				'header'  => "Content-type: application/json\r\nAuthorization: Basic $auth",
				'method'  => 'PUT',
				'content' => $postdata,
			],
		] );
		$languages_json = file_get_contents( 'https://www.transifex.com/api/2/project/bootswatch/resource/bootswatchpot/content/', false, $context );

		/**
		 * Download translations.
		 */
		$context = stream_context_create( [
			'http' => [
				'header' => "Authorization: Basic $auth",
			],
		] );
		$languages_json = file_get_contents( 'https://www.transifex.com/api/2/project/bootswatch/languages', false, $context );
		$languages = json_decode( $languages_json );
		foreach ( $languages as $language ) {
			$po = file_get_contents( $api_url . 'resource/bootswatchpot/translation/' . $language->language_code . '/?mode=reviewed&file', false, $context );
			file_put_contents( "languages/bootswatch-{$language->language_code}.po", $po );
			$this->log( sprintf( 'Downloaded `bootswatch-%s.po`.', $language->language_code ) );
		}
	}
}
