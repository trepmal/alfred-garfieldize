<?php

// $word = $argv[1];
// render_word( $word );

/**
 *
 */
function render_word( $phrase) {
	$word_units = _split_str_by_whitespace( $phrase, 15 );

	$all_together = '';

	foreach ( $word_units as $word ) {

		$word = strtolower( $word );
		$letters = str_split( $word, 1 );

		foreach ( $letters as $k => $l ) {
			$letters[$k] = render_letter( $l );
		}
		
		// $paws
		$output = '';
		
		for ( $i=0; $i<5; $i++) {
			foreach ( $letters as $l ) {
				if ( $l ) {
					$output .= $l[$i];
				}
			}
			$output = preg_replace('/(:blank:)*?$/', '', $output );
			$output .= PHP_EOL;
		}

		$all_together .= $output;
	}
	
	return $all_together;
}



/**
 * @param string $l single letter
 * @return string Padded paw letter
 */
function render_letter( $l ) {
	$alphabet = get_alphabet();

	if ( ! isset( $alphabet[$l] ) ) {
		return;
	}
	$letter = $alphabet[ $l ];

	$width  = get_paw_letter_width( $letter );
	$height = get_paw_letter_height( $letter );

	$paw_letter = pad_paw_letter( $letter, $width, $height );

	$paw_letter = explode("\n", $paw_letter);

	return $paw_letter;

	// var_dump( $width, $height );
	// echo $letter;
}


/**
 * stole from https://github.com/WordPress/WordPress/blob/6.5/wp-includes/formatting.php#L3180
 */
function _split_str_by_whitespace( $text, $goal ) {
	$chunks = array();

	$string_nullspace = strtr( $text, "\r\n\t\v\f ", "\000\000\000\000\000\000" );

	while ( $goal < strlen( $string_nullspace ) ) {
		$pos = strrpos( substr( $string_nullspace, 0, $goal + 1 ), "\000" );

		if ( false === $pos ) {
			$pos = strpos( $string_nullspace, "\000", $goal + 1 );
			if ( false === $pos ) {
				break;
			}
		}

		$chunks[]         = substr( $text, 0, $pos + 1 );
		$text             = substr( $text, $pos + 1 );
		$string_nullspace = substr( $string_nullspace, $pos + 1 );
	}

	if ( $text ) {
		$chunks[] = $text;
	}

	return $chunks;
}

/**
 * @param string $l paw letter
 * @return int emoji width of widest part
 */
function get_paw_letter_width( $l ) {
	$_l = preg_replace( '/[^:\n]/', '', $l );
	$_l = array_map( 'strlen', explode( "\n", $_l ) );
	sort( $_l );
	$width = array_pop( $_l )/2;
	return $width;
}

/**
 * @param string $l paw letter
 * @return int emoji height
 */
function get_paw_letter_height( $l ) {
	return count( explode( "\n", $l ) );
}

/**
 * Pad paw letter to fill blank space with blank emoji
 *
 * @param string $l paw letter
 * @param int $width paw letter width
 * @param int $height paw letter height
 * @return string Padded letter
 */
function pad_paw_letter( $l, $width, $height ) {
	$_l = explode( "\n", $l );

	
	// pad width
	foreach ( $_l as $k => $ll ) {
		$len = substr_count( $ll, ':' )/2;
		$add = $width-$len;
		// var_dump( "$width, $len, $add" );
		for ( $i=0; $i<$add; $i++ ) {
			$_l[ $k ] .= ':blank:';
		}
	}

	//pad height
	$add = 5-$height;
	for ( $i=0; $i<$add; $i++ ) {
		array_unshift( $_l, str_repeat( ':blank:', $width ) );
	}
	return implode( "\n", $_l );
}


function get_alphabet() {
	$alphabet = [];

	$alphabet['a'] = ':boop-1-left::boop-1-15-horizontal::boop-1-15-corner-top-right:
	:boop-1-15-corner-top-left::boop-1-right::boop-1-15:
	:boop-1-15-corner-bottom-left::boop-1-15-horizontal::boop-1-15-corner-bottom-right:';

	$alphabet['b'] = ':boop-1-1:
	:boop-1-15:
	:boop-1-15::boop-1-left::boop-1-15-corner-top-right:
	:boop-1-15::blank::boop-1-15:
	:boop-1-15-corner-bottom-left::boop-1-15-horizontal::boop-1-15-corner-bottom-right:';

	$alphabet['c'] = ':boop-1-15-corner-top-left::boop-1-15-horizontal::boop-1-right:
	:boop-1-15::blank:
	:boop-1-15-corner-bottom-left::boop-1-15-horizontal::boop-1-right:';

	$alphabet['d'] = ':blank::blank::boop-1-1:
	:blank::blank::boop-1-15:
	:boop-1-15-corner-top-left::boop-1-right::boop-1-15:
	:boop-1-15::blank::boop-1-15:
	:boop-1-15-corner-bottom-left::boop-1-15-horizontal::boop-1-15-corner-bottom-right:';

	$alphabet['e'] = ':boop-1-15-corner-top-left::boop-1-15-horizontal::boop-1-15-corner-top-right:
	:boop-1-15::boop-1-left::boop-1-15-corner-bottom-right:
	:boop-1-15-corner-bottom-left::boop-1-right:';

	$alphabet['f'] = ':blank::boop-1-15-corner-top-left::boop-1-right:
	:blank::boop-1-15:
	:boop-1-left::boop-1-15-intersect::boop-1-right:
	:blank::boop-1-15:
	:blank::boop-1-down:';

	$alphabet['g'] = ':boop-1-15-corner-top-left::boop-1-15-horizontal::boop-1-15-corner-top-right:
	:boop-1-15::blank::boop-1-15:
	:boop-1-15-corner-bottom-left::boop-1-right::boop-1-15:
	:boop-1-1::blank::boop-1-15:
	:boop-1-15-corner-bottom-left::boop-1-15-horizontal::boop-1-15-corner-bottom-right:';

	$alphabet['h'] = ':boop-1-1:
	:boop-1-15:
	:boop-1-15::boop-1-left::boop-1-15-corner-top-right:
	:boop-1-15::blank::boop-1-15:
	:boop-1-down::blank::boop-1-down:';

	$alphabet['i'] = ':boop-1-1:
	:boop-1-15:
	:boop-1-down:';

	$alphabet['j'] = ':blank::blank::boop-1-1:
	:blank::blank::boop-1-15:
	:blank::blank::boop-1-15:
	:boop-1-1::blank::boop-1-15:
	:boop-1-15-corner-bottom-left::boop-1-15-horizontal::boop-1-15-corner-bottom-right:';

	$alphabet['k'] = ':boop-1-1::blank::boop-1-1:
	:boop-1-15::boop-1-left::boop-1-15-corner-bottom-right:
	:boop-1-15::boop-1-left::boop-1-15-corner-top-right:
	:boop-1-15::blank::boop-1-15:
	:boop-1-down::blank::boop-1-down:';

	$alphabet['l'] = ':boop-1-1:
	:boop-1-15:
	:boop-1-15:
	:boop-1-15:
	:boop-1-down:';

	$alphabet['m'] = ':boop-1-15-corner-top-left::boop-1-15-horizontal::boop-1-15-corner-top-right:
	:boop-1-15::boop-1-1::boop-1-15:
	:boop-1-down::boop-1-down::boop-1-down:';

	$alphabet['n'] = ':boop-1-15-corner-top-left::boop-1-15-horizontal::boop-1-15-corner-top-right:
	:boop-1-15::blank::boop-1-15:
	:boop-1-down::blank::boop-1-down:';

	$alphabet['o'] = ':boop-1-15-corner-top-left::boop-1-15-horizontal::boop-1-15-corner-top-right:
	:boop-1-15::boop-1-1::boop-1-15:
	:boop-1-15-corner-bottom-left::boop-1-15-horizontal::boop-1-15-corner-bottom-right:';

	$alphabet['p'] = ':boop-1-15-corner-top-left::boop-1-15-horizontal::boop-1-15-corner-top-right:
	:boop-1-15::blank::boop-1-15:
	:boop-1-15::boop-1-left::boop-1-15-corner-bottom-right:
	:boop-1-15:
	:boop-1-down:';

	$alphabet['q'] = ':boop-1-15-corner-top-left::boop-1-15-horizontal::boop-1-15-corner-top-right:
	:boop-1-15::blank::boop-1-15:
	:boop-1-15-corner-bottom-left::boop-1-right::boop-1-15:
	:blank::blank::boop-1-15:
	:blank::blank::boop-1-down:';

	$alphabet['r'] = ':boop-1-15-corner-top-left::boop-1-right:
	:boop-1-15:
	:boop-1-down:';

	$alphabet['s'] = ':boop-1-15-corner-top-left::boop-1-15-horizontal::boop-1-right:
	:boop-1-15-corner-bottom-left::boop-1-15-horizontal::boop-1-15-corner-top-right:
	:boop-1-left::boop-1-15-horizontal::boop-1-15-corner-bottom-right:';

	$alphabet['t'] = ':blank::boop-1-1:
	:boop-1-left::boop-1-15-intersect::boop-1-right:
	:blank::boop-1-15:
	:blank::boop-1-15:
	:blank::boop-1-15-corner-bottom-left::boop-1-right:';

	$alphabet['u'] = ':boop-1-1::blank::boop-1-1:
	:boop-1-15::blank::boop-1-15:
	:boop-1-15-corner-bottom-left::boop-1-15-horizontal::boop-1-15-corner-bottom-right:';

	$alphabet['v'] = ':boop-1-1::blank::boop-1-1:
	:boop-1-15::blank::boop-1-15:
	:boop-1-15::boop-1-15-corner-top-left::boop-1-15-corner-bottom-right:
	:boop-1-15-corner-bottom-left::boop-1-15-corner-bottom-right:';

	$alphabet['w'] = ':boop-1-1::boop-1-1::boop-1-1:
	:boop-1-15::boop-1-down::boop-1-15:
	:boop-1-15-corner-bottom-left::boop-1-15-horizontal::boop-1-15-corner-bottom-right:';

	$alphabet['x'] = ':boop-1-1::blank::boop-1-1:
	:boop-1-15-corner-bottom-left::boop-1-15-horizontal::boop-1-15-corner-top-right:
	:boop-1-down::blank::boop-1-down:';

	$alphabet['y'] = ':boop-1-1::blank::boop-1-1:
	:boop-1-15-corner-bottom-left::boop-1-15-corner-top-right::boop-1-15-corner-bottom-right:
	:blank::boop-1-down:';

	$alphabet['z'] = ':boop-1-left::boop-1-15-horizontal::boop-1-15-corner-top-right:
	:boop-1-15-corner-top-left::boop-1-15-horizontal::boop-1-15-corner-bottom-right:
	:boop-1-15-corner-bottom-left::boop-1-15-horizontal::boop-1-right::blank:';

	$alphabet[' '] = ':blank::blank:';

	$alphabet['!'] = ':boop-1-1:
	:boop-1-15:
	:boop-1-down:
	:blank:
	:boop-1-down:';

	$alphabet['?'] = ':boop-1-15-corner-top-left::boop-1-15-horizontal::boop-1-15-corner-top-right:
	:boop-1-down::boop-1-15-corner-top-left::boop-1-15-corner-bottom-right:
	:blank::boop-1-down:
	:blank:
	:blank::boop-1-down:';

	$alphabet['.'] = ':boop-1-down:';

	$alphabet['-'] = ':boop-1-left::boop-1-right:
	:blank:
	:blank:';

	$alphabet['\''] = ':boop-1-1:
	:boop-1-down:
	:blank:
	:blank:';

	$alphabet = array_map( function( $i ) {
		return str_replace("\t", '', $i );
	}, $alphabet );

	return $alphabet;
}
