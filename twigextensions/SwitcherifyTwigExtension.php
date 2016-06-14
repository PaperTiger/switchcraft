<?php
/**
 * Class SwitcherifyTwigExtension
 *
 * @author    Paper Tiger <info@papertiger.com>
 * @copyright Copyright (c) 2016, Paper Tiger, Inc.
 * @see       http://papertiger.com
 */

namespace Craft;

use Twig_Extension;
use Twig_Filter_Method;

require_once( 'SwitcherifyTokenParser.php' );
require_once( 'SwitcherifyNode.php' );

class SwitcherifyTwigExtension extends \Twig_Extension
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
		return 'Switcherify';
	}
	
	/**
	 * Token Parser
	 * 
	 * @return Array
	 */
	public function getTokenParsers() 
	{
		return [
			new SwitcherifyTokenParser(),
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
			'switcherify' => new \Twig_Filter_Method( $this, 'switcherifyFilter', [ 'needs_context' => true ] )
		];
	}

	/**
	 * Add Switcherify functionality into filter
	 *
	 * @param  Array  $context
	 * @param  Int    $currentIndex
	 * @param  Mixed  $cases
	 * @param  String $return
	 * 
	 * @return Mixed
	 */
	public function switcherifyFilter( $context, $currentIndex, $cases, $return = null ) 
	{
		if( is_array( $cases ) ) 
		{

			$output = [];

			foreach($cases as $key => $case) 
			{
				$output[] = $this->switcherifyCompiler( $context, $currentIndex, $key, $case );
			}

			return implode( $output , ' ');

		} else {

			return ( $return ) ? 
				$this->switcherifyCompiler( $context, $currentIndex, $cases, $return ) : 
				$this->switcherifyCompiler( $context, $currentIndex, $cases, $return, true ) ;
		
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
	private function switcherifyCompiler( $context, $currentIndex, $key, $case, $test = false )
	{
		if( in_array( $key, self::$defaultParams )) 
		{
			switch ( $key ) 
			{
				case 'firstItem':
					if( $context['loop']['first'] ) return $this->switcherifyDecider( $case, $test );
				break;
				case 'lastItem':
					if( $currentIndex == $context['loop']['length'] ) return $this->switcherifyDecider( $case, $test );
				break;
				case 'oddItem':
					if( $currentIndex % 2 != 0 ) return $this->switcherifyDecider( $case, $test );
				break;
				case 'evenItem':
					if( $currentIndex % 2 == 0 ) return $this->switcherifyDecider( $case, $test );
				break;
			}
		} else {
			if( preg_match( '/every(.*)Items/', $key, $matches ) && $matches[1] )
			{
				if( $currentIndex % $matches[1] == 0 ) return $this->switcherifyDecider( $case, $test );
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
	private function switcherifyDecider( $case, $test = false )
	{
		return ( $test ) ? true : $case ;
	}

}