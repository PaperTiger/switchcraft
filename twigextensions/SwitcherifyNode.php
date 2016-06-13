<?php
/**
 * Class SwitcherifyNode
 *
 * @author    Paper Tiger <info@papertiger.com>
 * @copyright Copyright (c) 2016, Paper Tiger, Inc.
 * @see       http://papertiger.com
 */

namespace Craft;

class SwitcherifyNode extends \Twig_Node
{
  /**
   * Construct
   * 
   * @param Integer              $currentIndex
   * @param Twig_Node_Expression $cases
   * @param Function             $line
   * @param String               $tag
   *
   * @return Mixed
   */
  public function __construct( $currentIndex, \Twig_NodeInterface $cases, $line, $tag = null )
  {
    parent::__construct( ['currentIndex' => $currentIndex], ['cases' => $cases], [], $line, $tag);
  }

  /**
   * Compile Nodes
   * 
   * @param  \Twig_Compiler $compiler
   * 
   * @return Null
   */
  public function compile( \Twig_Compiler $compiler )
  {

    $compiler
      ->addDebugInfo( $this )
      ->raw( '$defaultParams = [ \'firstItem\', \'lastItem\', \'oddItem\', \'evenItem\' ];' )
    ;

    foreach( $this->getAttribute( 'cases' ) as $case )
    {

      if( !$case->hasNode( 'body' ) || !$case->hasNode( 'type' ) ) continue;

      $type  = $case->getNode( 'type' );
      $body  = $case->getNode( 'body' );

      $compiler
        ->write( 'if( in_array(' )
        ->subcompile( $type ) 
        ->raw( ', $defaultParams) ) {' )
          ->indent()
          ->raw( 'switch(' )
          ->subcompile( $type )
          ->raw( ') {' )
          ->indent()
            ->raw( 'case \'firstItem\':' )
            ->indent()
              ->raw( 'if($context[\'loop\'][\'first\']) {' )
              ->indent()
                ->subcompile( $body )
              ->outdent()
              ->raw( '}' )
            ->outdent()
          ->raw( 'break;' )
          ->raw( 'case \'lastItem\':' )
          ->indent()
            ->raw( 'if($context[\'loop\'][\'index\'] == $context[\'loop\'][\'length\']) {')
            ->indent()
              ->subcompile( $body )
            ->outdent()
            ->raw( '}' )
          ->outdent()
          ->raw( 'break;' )
          ->raw( 'case \'oddItem\':' )
          ->indent()
            ->raw( 'if($context[\'loop\'][\'index\'] % 2 != 0) {' )
            ->indent()
              ->subcompile( $body )
            ->outdent()
            ->raw( '}' )
          ->raw( 'break;' )
          ->raw( 'case \'evenItem\':' )
          ->indent()
            ->raw( 'if($context[\'loop\'][\'index\'] % 2 == 0) {' )
            ->indent()
              ->subcompile( $body )
            ->outdent()
            ->raw ( '}' )
          ->outdent()
          ->raw( 'break;' )
        ->outdent()
        ->raw( '}' )
      ->outdent()
      ->raw( '} else {' )
        ->indent()
          ->raw( 'if(preg_match(\'/every(.*)Items/\',' )
          ->subcompile( $type )
          ->raw( ',$matches) && $matches[1]) {')
          ->indent()
            ->raw( 'if($context[\'loop\'][\'index\'] % $matches[1] == 0) {')
            ->indent()
              ->subcompile( $body )
            ->outdent()
            ->raw( '}' )
          ->outdent()
        ->outdent()
        ->raw( '}' )
      ->outdent()
      ->raw( '}' )
      ;
    }

  }
}