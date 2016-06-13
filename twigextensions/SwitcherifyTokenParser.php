<?php
/**
 * Class SwitcherifyTokenParser
 *
 * @author    Paper Tiger <info@papertiger.com>
 * @copyright Copyright (c) 2016, Paper Tiger, Inc.
 * @see       http://papertiger.com
 */

namespace Craft;

class SwitcherifyTokenParser extends \Twig_TokenParser
{
	/**
	 * Opening Tag Name
	 * 
	 * @return string
	 */
	public function getTag()
	{
		return 'switcherify';
	}

	/**
	 * Parses {% switcherify %}...{% switcherify %} tags.
	 *
	 * @param \Twig_Token $token
	 *
	 * @return Class
	 */
	public function parse( \Twig_Token $token )
	{
		/**
		 * Store Line, Stream and Cases 
		 * 
		 * @var Integer
		 * @var Object
		 * @var Array
		 */
		$lineno = $token->getLine();
		$stream = $this->parser->getStream();
		$cases  = [];

		/**
		 * Loop Number (eg : loop.index)
		 * 
		 * @var Integer
		 */
		$currentIndex  = $this->parser->getExpressionParser()->parseExpression();

		if( $stream->next()->getValue() == 'on' )
		{

			$type[] = $this->parser->getExpressionParser()->parsePrimaryExpression();

			if ( $stream->nextIf( \Twig_Token::BLOCK_END_TYPE ) ) 
			{

				$body    = $this->parser->subparse( array( $this, 'decideSwitcherifyEnd' ), true );
				$cases[] = new \Twig_Node( array(
								'type' => new \Twig_Node( $type ),
								'body' => $body
							));
			}

			$stream->expect( \Twig_Token::BLOCK_END_TYPE );

		} else {

			$end = false;

			while ($stream->getCurrent()->getType() == \Twig_Token::TEXT_TYPE && trim($stream->getCurrent()->getValue()) == '')
			{
				$stream->next();
			}

			$stream->next();

			while( !$end )
			{
				switch( $stream->getCurrent()->getValue() ) 
				{
					case 'on':
					{
						$stream->next();
						
						$type   = [];
						$type[] = $this->parser->getExpressionParser()->parseExpression();

						$stream->expect( \Twig_Token::BLOCK_END_TYPE );
						$body    = $this->parser->subparse( array( $this, 'decideSwitcherifyFork' ) );
						$cases[] = new \Twig_Node( array(
										'type' => new \Twig_Node( $type ),
										'body' => $body
									));
						break;

					}
					case 'endswitcherify':
					{	
						$stream->next();
						$stream->expect( \Twig_Token::BLOCK_END_TYPE );
						$end = true;
						break;
					}
					default:
					{
						throw new \Twig_Error_Syntax(sprintf('Unexpected end of template. Twig was looking for the following tags "on", or "endswitcherify" to close the "switcherify" block started at line %d)', $lineno), -1);
					}
				}
			}
		}

		return new SwitcherifyNode( $currentIndex, new \Twig_Node( $cases ), $lineno, $this->getTag() );
	}

	/**
	 * Decide if we are at the end of stream or continue the stream
	 * 
	 * @param $token
	 *
	 * @return mixed
	 */
	public function decideSwitcherifyFork( \Twig_Token $token )
	{
		return $token->test(array('on', 'endswitcherify'));
	}

	/**
	 * Decide if we are at the end of stream
	 * 
	 * @param \Twig_Token $token
	 *
	 * @return bool
	 */
	public function decideSwitcherifyEnd( \Twig_Token $token )
	{
		return $token->test('endswitcherify');
	}
}
