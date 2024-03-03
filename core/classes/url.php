<?php
/**
 * Class Url
 *
 * @property string $url
 * @property string $scheme
 * @property string $user
 * @property string $pass
 * @property string $host
 * @property string $port
 * @property string $path
 * @property string $query
 * @property string $fragment
 */
class url {

	/**
	 * Full URL.
	 *
	 * @var string
	 */
	protected $_url;

	/**
	 * URL scheme.
	 *
	 * @var string
	 */
	protected $_scheme;

	/**
	 * URL host.
	 *
	 * @var string
	 */
	protected $_host;

	/**
	 * URL username.
	 *
	 * @var string
	 */
	protected $_user;

	/**
	 * URL password.
	 *
	 * @var string
	 */
	protected $_pass;

	/**
	 * URL path.
	 *
	 * @var string
	 */
	protected $_path;

	/**
	 * URL port.
	 *
	 * @var string
	 */
	protected $_port;

	/**
	 * URL query string.
	 *
	 * @var string
	 */
	protected $_query;

	/**
	 * URL fragment.
	 *
	 * @var string
	 */
	protected $_fragment;

	/**
	 * Get the current URL.
	 *
	 * @return string
	 */
	public static function getCurrentUrl() {
		return self::getCurrentScheme() . '://' . getenv( 'HTTP_HOST' ) . getenv( 'REQUEST_URI' );
	}

	/**
	 * Get the current URL scheme.
	 *
	 * @return string
	 */
	public static function getCurrentScheme() {
		$is_ssl = (boolean) getenv( 'HTTPS' ) || '443' === getenv( 'SERVER_PORT' ) || 'https' === getenv( 'HTTP_X_FORWARDED_PROTO' );
		$scheme = $is_ssl ? 'https' : 'http';

		return $scheme;
	}

	/**
	 * Build a URL from its component parts.
	 *
	 * @param array $parts
	 *
	 * @return string
	 */
	public static function buildUrl( array $parts ) {
		$url = '';
		if ( ! empty( $parts['scheme'] ) ) {
			$url .= $parts['scheme'] . '://';
		}
		if ( ! empty( $parts['user'] ) ) {
			$url .= $parts['user'];
		}
		if ( ! empty( $parts['pass'] ) ) {
			$url .= ':' . $parts['pass'];
		}
		if ( ! empty( $parts['user'] ) || ! empty( $parts['pass'] ) ) {
			$url .= '@';
		}
		if ( ! empty( $parts['host'] ) ) {
			$url .= $parts['host'];
		}
		if ( ! empty( $parts['port'] ) ) {
			$url .= ':' . $parts['port'];
		}
		if ( ! empty( $parts['path'] ) ) {
			$url .= $parts['path'];
		}
		if ( ! empty( $parts['query'] ) ) {
			$url .= '?' . $parts['query'];
		}
		if ( ! empty( $parts['fragment'] ) ) {
			$url .= '#' . $parts['fragment'];
		}

		return $url;
	}

	/**
	 * Build a path from its component parts.
	 *
	 * @param array $segments
	 * @param bool  $trailing_slash
	 *
	 * @return string
	 */
	public static function buildPath( array $segments, $trailing_slash = false ) {
		$path = '';
		if ( ! empty( $segments ) ) {
			$path .= '/' . implode( '/', $segments );
		}
		if ( $trailing_slash ) {
			$path .= '/';
		}

		return $path;
	}

	/**
	 * Strip the query string from a URL.
	 *
	 * @param string $url
	 *
	 * @return string
	 */
	public static function stripQueryString( $url ) {
		$url        = new self( $url );
		$url->query = '';

		return $url->toString();
	}

	/**
	 * Create a new instance.
	 *
	 * @param string $url
	 */
	public function __construct( $url = '' ) {
		if ( empty( $url ) ) {
			$url = self::getCurrentUrl();
		}
		$this->parseUrl( $url );
	}

	/**
	 * Parse a URL into its component parts.
	 *
	 * @param string $url
	 *
	 * @return $this
	 */
	public function parseUrl( $url ) {
		$this->_url      = $url;
		$this->_scheme   = (string) parse_url( $url, PHP_URL_SCHEME );
		$this->_user     = (string) parse_url( $url, PHP_URL_USER );
		$this->_pass     = (string) parse_url( $url, PHP_URL_PASS );
		$this->_host     = (string) parse_url( $url, PHP_URL_HOST );
		$this->_port     = (string) parse_url( $url, PHP_URL_PORT );
		$this->_path     = (string) parse_url( $url, PHP_URL_PATH );
		$this->_query    = (string) parse_url( $url, PHP_URL_QUERY );
		$this->_fragment = (string) parse_url( $url, PHP_URL_FRAGMENT );

		return $this;
	}

	/**
	 * Check if URL has a trailing slash.
	 *
	 * @return bool
	 */
	public function hasTrailingSlash() {
		return is_string( $this->path ) && '/' === substr( $this->path, - 1, 1 );
	}

	/**
	 * Get URL path segments.
	 *
	 * @return string[]
	 */
	public function getSegments() {
		return array_filter( explode( '/', trim( $this->_path, '/' ) ) );
	}

	/**
	 * Gat a URL path segment by index.
	 *
	 * @param int $index
	 *
	 * @return string|null
	 */
	public function getSegment( $index = 0 ) {
		$segments = $this->getSegments();

		return array_key_exists( $index, $segments ) ? $segments[ $index ] : null;
	}

	/**
	 * Add a query variable to the URL.
	 *
	 * @param string $name
	 * @param string $value
	 *
	 * @return string
	 */
	public function addQueryVar( $name, $value ) {
		$query_vars          = $this->getQueryVars();
		$query_vars[ $name ] = $value;
		$this->query         = http_build_query( $query_vars, '', '&' );

		return $this->toString();
	}

	/**
	 * Remove a query variable from the URL.
	 *
	 * @param string $name
	 *
	 * @return string
	 */
	public function removeQueryVar( $name ) {
		$query_vars = $this->getQueryVars();
		unset( $query_vars[ $name ] );
		$this->query = http_build_query( $query_vars );

		return $this->toString();
	}

	/**
	 * Get a query variable from the URL.
	 *
	 * @param string $name
	 *
	 * @return string|null
	 */
	public function getQueryVar( $name ) {
		$query_vars = $this->getQueryVars();

		return array_key_exists( $name, $query_vars ) ? $query_vars[ $name ] : null;
	}

	/**
	 * Get all the query variables from the URL.
	 *
	 * @return array
	 */
	public function getQueryVars() {
		$query_vars = array();
		parse_str( $this->_query, $query_vars );

		return $query_vars;
	}

	/**
	 * Add a fragment to the URL.
	 *
	 * @param string $value
	 *
	 * @return string
	 */
	public function addFragment( $value ) {
		$this->fragment = $value;

		return $this->toString();
	}

	/**
	 * Returns the URL as an array.
	 *
	 * @return array
	 */
	public function toArray() {
		return array(
			'scheme'   => $this->_scheme,
			'user'     => $this->_user,
			'pass'     => $this->_pass,
			'host'     => $this->_host,
			'port'     => $this->_port,
			'path'     => $this->_path,
			'query'    => $this->_query,
			'fragment' => $this->_fragment,
		);
	}

	/**
	 * Returns the URL as a string.
	 *
	 * @return string
	 */
	public function toString() {
		return $this->_url;
	}

	/**
	 * Magic method to output object as a string.
	 *
	 * @return string
	 */
	public function __toString() {
		return $this->toString();
	}

	/**
	 * Magic method for getting properties.
	 *
	 * @param string $name
	 *
	 * @return string|int|null
	 */
	public function __get( $name ) {
		$value    = null;
		$property = "_{$name}";
		if ( property_exists( $this, $property ) ) {
			$value = $this->{$property};
		}

		return $value;
	}

	/**
	 * Magic method for setting properties.
	 *
	 * @param string $name  Property name to set.
	 * @param string $value Property value to set.
	 *
	 * @return $this
	 */
	public function __set( $name, $value ) {
		$property = "_{$name}";
		if ( 'url' === $name ) {

			// If setting URL, parse and set all the URL parts
			$this->parseUrl( $value );

		} elseif ( property_exists( $this, $property ) ) {

			// If setting a URL part, build and set the full URL
			$this->$property = (string) $value;
			$this->_url      = self::buildUrl( $this->toArray() );

		}

		return $this;
	}

}
?>
