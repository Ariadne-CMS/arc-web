<?php

	/*
	 * This file is part of the Ariadne Component Library.
	 *
	 * (c) Muze <info@muze.nl>
	 *
	 * For the full copyright and license information, please view the LICENSE
	 * file that was distributed with this source code.
	 */

	namespace arc\grants;

	class GrantsConfiguration {
		protected $config = null;
		protected $id = null;
		protected $root = null;

		public function __construct( $config = null, $id = null, $root = '/' ) {
			$this->config = $config;
			$this->id = $id;
			$this->root = $root;
		}

		public function cd( $path ) {
			return new GrantsConfiguration( $this->config->cd( $path ), $this->id, $this->root );
		}

		public function root( $path ) {
			return new GrantsConfiguration( $this->config, $this->id, \arc\path::collapse( $path ) );
		}

		public function ls() {
			$index = 'grants';
			if ( $this->id ) {
				$index .= '.'.$this->id;
			}
			return $this->config->acquire( $index );
		}

		public function on( $id ) {
			return new GrantsConfiguration( $this->config, $id, $this->root );
		}

		public function set( $grants ) {
			$id = isset( $this->id) ? $this->id : 'public';
			// save as string with a leading and trailing space, for faster comparison in check()
			$this->config->configure( 'grants.'.$id, ' '.trim($grants).' ' );
		}

		public function check( $grant ) {
			// uses strpos since it is twice as fast as preg_match for the most common cases
			$id = isset( $this->id) ? $this->id : 'public';
			$grants = $this->config->acquire( 'grants.'.$id ); //, null, $this->root );
			if ( strpos( $grants, $grant.' ' ) === false ) { // exit early if no possible match is found
				return false;
			}
			if ( strpos( $grants, ' '.$grant.' ') !== false ) {	// usual case is checked first - simple grant
				return true;
			}
			if ( strpos( $grants, ' >'.$grant.' ') !== false ) { // less usual case, grants set only for children
				$grantsLocal = $this->config->getConfiguredValue( 'grants.'.$id, $this->path );
				return !isset($grantsLocal);
			}
			if ( strpos( $grants, ' ='.$grant.' ') !== false ) { // least usual case, grants set only for the configured path
				$grantsLocal = $this->config->getConfiguredValue( 'grants.'.$id, $this->path );
				return isset($grantsLocal);
			}
			return false;
		}

	}