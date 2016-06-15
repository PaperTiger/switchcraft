<?php
/**
 * Class SwitchcraftTwigExtension
 *
 * @author    Paper Tiger <info@papertiger.com>
 * @copyright Copyright (c) 2016, Paper Tiger, Inc.
 * @see       http://papertiger.com
 */

namespace Craft;

use Twig_Extension;
use Twig_Filter_Method;

require_once( 'SwitchcraftTokenParser.php' );
require_once( 'SwitchcraftNode.php' );

class SwitchcraftTwigExtension extends \Twig_Extension
{
	/**
	 * Default Parameters
	 * 
	 * @var Array
	 */
	private static $defaultParams = [ 'firstItem', 'lastItem', 'oddItem', 'evenItem' ];

	/**
	 * Extension Name
	 * 
	 * @return String
	 */
	public function getName()
	{
		return 'Switchcraft';
	}
	
	/**
	 * Token Parser
	 * 
	 * @return Array
	 */
	public function getTokenParsers() 
	{
		return [
			new SwitchcraftTokenParser(),
		];
	}

	/**
	 * Filter
	 * 
	 * @return Array
	 */
	public function getFilters()
	{
		return [
			'switchcraft' => new \Twig_Filter_Method( $this, 'switchcraftFilter', [ 'needs_context' => true ] )
		];
	}

	/**
	 * Add Switchcraft functionality into filter
	 *
	 * @param  Array  $context
	 * @param  Int    $currentIndex
	 * @param  Mixed  $cases
	 * @param  String $return
	 * 
	 * @return Mixed
	 */
	public function switchcraftFilter( $context, $currentIndex, $cases, $return = null ) 
	{
		if( is_array( $cases ) ) 
		{

			$output = [];

			foreach($cases as $key => $case) 
			{
				$output[] = $this->switchcraftCompiler( $context, $currentIndex, $key, $case );
			}

			return implode( $output , ' ');

		} else {

			return ( $return ) ? 
				$this->switchcraftCompiler( $context, $currentIndex, $cases, $return ) : 
				$this->switchcraftCompiler( $context, $currentIndex, $cases, $return, true ) ;
		}
	}

	/**
	 * Compile data and return
	 * 
	 * @param  Array     $context
	 * @param  String    $key
	 * @param  Mixed     $case
	 * @param  Booleam   $test
	 * 
	 * @return Mixed
	 */
	private function switchcraftCompiler( $context, $currentIndex, $key, $case, $test = false )
	{
		if( in_array( $key, self::$defaultParams ))
		{
			switch ( $key ) 
			{
				case 'firstItem':
					if( $context['loop']['first'] ) return $this->switchcraftDecider( $case, $test );
				break;
				case 'lastItem':
					if( $currentIndex == $context['loop']['length'] ) return $this->switchcraftDecider( $case, $test );
				break;
				case 'oddItem':
					if( $currentIndex % 2 != 0 ) return $this->switchcraftDecider( $case, $test );
				break;
				case 'evenItem':
					if( $currentIndex % 2 == 0 ) return $this->switchcraftDecider( $case, $test );
				break;
			}
		} else {
			if( preg_match( '/every(.*)Items/', $key, $matches ) && $matches[1] )
			{
				if( $currentIndex % $matches[1] == 0 ) return $this->switchcraftDecider( $case, $test );
			}
		}
	}

	/**
	 * Decide whether returning data or boolean
	 * 
	 * @param  Mixed   $case
	 * @param  Boolean $test
	 * 
	 * @return Mixed
	 */
	private function switchcraftDecider( $case, $test = false )
	{
		return ( $test ) ? true : $case ;
	}

}