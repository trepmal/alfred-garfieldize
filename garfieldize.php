<?php

$query = $argv[1];
$style = '';

// support original <style>|text format
preg_match( "/^(?:([a-z0-9]*)\|)?(.*?)$/", $query, $matches );
$style = $matches[1];
$text  = $matches[2];


function convert_letters( $text, $style = 'garfieldize' ) {
	$text = trim( str_replace( '  ', ' ', $text ) );

	$text_length = strlen( $text );
	
	if ( $text_length < 3 ) {
		$flicker_modulo = 2;
	} elseif ( $text_length < 15 ) {
		$flicker_modulo = 3;
	} else {
		$flicker_modulo = 6;
	}

	if ( in_array( $style, [ 'boop', 'boop1', 'boop2', 'boop3' ] ) ) {

        require_once 'boop.php';
        $return_text = render_word( $text );
        if ( $style == 'boop2' ) {
                $return_text = str_replace('boop-1','boop-2', $return_text );
        }
        if ( $style == 'boop3' ) {
                $return_text = str_replace('boop-1','boop-3', $return_text );
        }

	} else {

		$letters = array_map( function( $i ) use ( $style, $flicker_modulo ) {
		
			switch ( $style ) {
				case 'yellow':
					if ( preg_match('/[a-z0-9\?#\!@]/i', $i ) ) {
						$i = str_replace(
							[ '?', '#', '!', '@'],
							[ 'question', 'hash', 'exclamation', 'at'],
							$i
						);
						$i = ":alphabet-yellow-$i:";
					}
				break;
				case 'white':
					if ( preg_match('/[a-z0-9\?#\!@]/i', $i ) ) {
						$i = str_replace(
							[ '?', '#', '!', '@'],
							[ 'question', 'hash', 'exclamation', 'at'],
							$i
						);
						$i = ":alphabet-white-$i:";
					}
				break;
				case 'comic':
					if ( preg_match('/[a-z0-9]/i', $i ) ) {
						$i = ":comicsans$i:";
					}
				break;
				case 'caps':
					if ( preg_match('/[a-z]/i', $i ) ) {
						$i = ":letters-cap-$i:";
					}
				break;
				case 'neon':
					if ( preg_match('/[a-z]/i', $i ) ) {
						$i = ":neon-$i:";
					}
				break;
				case 'flicker':
					if ( preg_match('/[a-z]/i', $i ) ) {
						$i = sprintf( ":neon-$i%s:", ( rand( 0, 100 ) % $flicker_modulo === 0 ? '-flicker' : '' ) );
						// $i = sprintf( "<img src='%s'/>", ( rand( 0, 100 ) % $flicker_modulo === 0 ? "flicker/neon-$i-flicker.gif" : "neon-$i.png" ) );
					}
				break;
				case 'janky':
					if ( preg_match('/[a-z0-9\?\!]/i', $i ) ) {
							$i = str_replace(
									[ '?', '!'],
									[ 'question-mark', 'exclamation-mark' ],
									$i
							);
							$i = ":janky-$i:";
					}
				break;
				case 'intense':
					if ( preg_match('/[a-z0-9]/i', $i ) ) {
						$i = ":garfield_$i-intensifies:";
					}
				break;
				case 'garfield':
				default:
					if ( preg_match('/[a-z0-9]/i', $i ) ) {
						$i = ":garfield_$i:";
					}
			}
		
			if ( ' ' === $i ) {
				$i = ":empty:";
			}
			return $i;
		}, str_split( $text, 1 ) );

		$return_text = implode( $letters );
	}

	return $return_text;
}


$response = [
	'items' => [
		[
			'title' => 'boop',
			'arg' => convert_letters( $text, 'boop' ),
			'subtitle' => 'alpha, some punctuation',
			'icon' => [
				'path' => 'icons/boop.png',
			],
		],
		[
			'title' => 'boop2',
			'arg' => convert_letters( $text, 'boop2' ),
			'subtitle' => 'alpha, some punctuation',
			'icon' => [
				'path' => 'icons/boop2.png',
			],
		],
		[
			'title' => 'boop3',
			'arg' => convert_letters( $text, 'boop3' ),
			'subtitle' => 'alpha, some punctuation',
			'icon' => [
				'path' => 'icons/boop3.png',
			],
		],
		[
			'title' => 'yellow',
			'arg' => convert_letters( $text, 'yellow' ),
			'subtitle' => 'alphanumeric, some punctuation',
			'icon' => [
				'path' => 'icons/yellow.png',
			],
		],
		[
			'title' => 'white',
			'arg' => convert_letters( $text, 'white' ),
			'subtitle' => 'alphanumeric, some punctuation',
			'icon' => [
				'path' => 'icons/white.png',
			],
		],
		[
			'title' => 'comic',
			'arg' => convert_letters( $text, 'comic' ),
			'subtitle' => 'alphanumeric',
			'icon' => [
				'path' => 'icons/comic.png',
			],
		],
		[
			'title' => 'caps',
			'arg' => convert_letters( $text, 'caps' ),
			'subtitle' => 'alpha',
			'icon' => [
				'path' => 'icons/caps.png',
			],
		],
		[
			'title' => 'neon',
			'arg' => convert_letters( $text, 'neon' ),
			'subtitle' => 'alpha',
			'icon' => [
				'path' => 'icons/neon.png',
			],
		],
		[
			'title' => 'flicker',
			'arg' => convert_letters( $text, 'flicker' ),
			'subtitle' => 'alpha',
			'icon' => [
				'path' => 'icons/flicker.gif',
			],
		],
		[
			'title' => 'janky',
			'arg' => convert_letters( $text, 'janky' ),
			'subtitle' => 'alphanumeric, some punctuation',
			'icon' => [
				'path' => 'icons/janky.png',
			],
		],
		[
			'title' => 'intense',
			'arg' => convert_letters( $text, 'intense' ),
			'subtitle' => 'alphanumeric',
			'icon' => [
				'path' => 'icons/intense.gif',
			],
		],
		[
			'title' => 'garfield',
			'arg' => convert_letters( $text, 'garfield' ),
			'subtitle' => 'alphanumeric',
			'icon' => [
				'path' => 'icons/garfield.png',
			],
		],
	]
];

if ( isset( $style ) ) {
	foreach( $response['items'] as $k => $i ) {
		if ( ! str_starts_with( $i['title'], $style ) ) {
			unset( $response['items'][$k] );
		}
	}
	$response['items'] = array_values( $response['items'] );
}

die( json_encode( $response ) );
