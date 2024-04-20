<?php
namespace MediaWiki\Extension\SpecialTemplate;

/**
 * Alexander Mashin © 2024
 */
class Special extends \SpecialPage {
	/**
	 * @param string $name
	 * @param string $restriction
	 * @param bool $listed
	 * @param bool $function
	 * @param string $file
	 * @param bool $includable
	 */
	public function __construct(
		$name = '', $restriction = '', $listed = true, $function = false, $file = '', $includable = false
	) {
		parent::__construct( 'Template', $restriction, $listed, $function, $file, $includable );
	}

	/**
	 * @param string|null $subpage
	 * @return void
	 * @throws \MWException
	 */
	public function execute( $subpage ) {
		$this->setHeaders();

		$params = $this->getRequest()->getValues() + self::parseSubpage( $subpage );
		$template = $params['_template'] ?? null;

		$output = $this->getOutput();
		if ( $template ) {
			$args = '';
			foreach ( $params as $param => $value ) {
				$args .= "|$param=$value";
			}
			$output->addWikiTextAsInterface( '{{' . $template . $args . '}}' );
		} else {
			$output->addWikiMsg( 'specialtemplate-no-template' );
			$template = $this->msg( 'template' )->parse();
		}
		$output->setPageTitle( strtr( $params['_title'] ?? $template, '_', ' ' ) );
	}

	/**
	 * @param string|null $subpage
	 * @return array
	 */
	public static function parseSubpage( ?string $subpage ): array {
		$parts = $subpage !== null ? explode( '/', $subpage ) : [];
		$count = count( $parts );
		$params = [ null ]; // make the array one-based.
		if ( $count > 0 && $parts[0] !== '' ) {
			$params['_template'] = $parts[0];
			if ( $count > 1 ) {
				// Numbered template parameters:
				array_shift( $parts );
				foreach ( $parts as $part ) {
					if ( strpos( $part, '=' ) !== false ) {
						[ $arg, $value ] = explode( '=', $part, 2 );
						$params[trim( $arg )] = trim( $value );
					} else {
						$params[] = trim( $part );
					}
				}
			}
		}
		unset( $params[0] ); // make the array one-based.
		return $params;
	}

	/**
	 * @return string
	 */
	protected function getGroupName(): string {
		return 'wiki';
	}
}
