<?php

namespace Faker\Provider;

class Color extends Base {
	protected static $safeColorNames = [
		'black',
		'maroon',
		'green',
		'navy',
		'olive',
		'purple',
		'teal',
		'lime',
		'blue',
		'silver',
		'gray',
		'yellow',
		'fuchsia',
		'aqua',
		'white',
	];

	protected static $allColorNames = [
		'AliceBlue',
		'AntiqueWhite',
		'Aqua',
		'Aquamarine',
		'Azure',
		'Beige',
		'Bisque',
		'Black',
		'BlanchedAlmond',
		'Blue',
		'BlueViolet',
		'Brown',
		'BurlyWood',
		'CadetBlue',
		'Chartreuse',
		'Chocolate',
		'Coral',
		'CornflowerBlue',
		'Cornsilk',
		'Crimson',
		'Cyan',
		'DarkBlue',
		'DarkCyan',
		'DarkGoldenRod',
		'DarkGray',
		'DarkGreen',
		'DarkKhaki',
		'DarkMagenta',
		'DarkOliveGreen',
		'Darkorange',
		'DarkOrchid',
		'DarkRed',
		'DarkSalmon',
		'DarkSeaGreen',
		'DarkSlateBlue',
		'DarkSlateGray',
		'DarkTurquoise',
		'DarkViolet',
		'DeepPink',
		'DeepSkyBlue',
		'DimGray',
		'DimGrey',
		'DodgerBlue',
		'FireBrick',
		'FloralWhite',
		'ForestGreen',
		'Fuchsia',
		'Gainsboro',
		'GhostWhite',
		'Gold',
		'GoldenRod',
		'Gray',
		'Green',
		'GreenYellow',
		'HoneyDew',
		'HotPink',
		'IndianRed',
		'Indigo',
		'Ivory',
		'Khaki',
		'Lavender',
		'LavenderBlush',
		'LawnGreen',
		'LemonChiffon',
		'LightBlue',
		'LightCoral',
		'LightCyan',
		'LightGoldenRodYellow',
		'LightGray',
		'LightGreen',
		'LightPink',
		'LightSalmon',
		'LightSeaGreen',
		'LightSkyBlue',
		'LightSlateGray',
		'LightSteelBlue',
		'LightYellow',
		'Lime',
		'LimeGreen',
		'Linen',
		'Magenta',
		'Maroon',
		'MediumAquaMarine',
		'MediumBlue',
		'MediumOrchid',
		'MediumPurple',
		'MediumSeaGreen',
		'MediumSlateBlue',
		'MediumSpringGreen',
		'MediumTurquoise',
		'MediumVioletRed',
		'MidnightBlue',
		'MintCream',
		'MistyRose',
		'Moccasin',
		'NavajoWhite',
		'Navy',
		'OldLace',
		'Olive',
		'OliveDrab',
		'Orange',
		'OrangeRed',
		'Orchid',
		'PaleGoldenRod',
		'PaleGreen',
		'PaleTurquoise',
		'PaleVioletRed',
		'PapayaWhip',
		'PeachPuff',
		'Peru',
		'Pink',
		'Plum',
		'PowderBlue',
		'Purple',
		'Red',
		'RosyBrown',
		'RoyalBlue',
		'SaddleBrown',
		'Salmon',
		'SandyBrown',
		'SeaGreen',
		'SeaShell',
		'Sienna',
		'Silver',
		'SkyBlue',
		'SlateBlue',
		'SlateGray',
		'Snow',
		'SpringGreen',
		'SteelBlue',
		'Tan',
		'Teal',
		'Thistle',
		'Tomato',
		'Turquoise',
		'Violet',
		'Wheat',
		'White',
		'WhiteSmoke',
		'Yellow',
		'YellowGreen',
	];

	/**
	 * @return string
	 * @example '#fa3cc2'
	 *
	 */
	public static function hexColor() {
		return '#' . str_pad( dechex( self::numberBetween( 1, 16777215 ) ), 6, '0', STR_PAD_LEFT );
	}

	/**
	 * @return string
	 * @example '#ff0044'
	 *
	 */
	public static function safeHexColor() {
		$color = str_pad( dechex( self::numberBetween( 0, 255 ) ), 3, '0', STR_PAD_LEFT );

		return '#' . $color[0] . $color[0] . $color[1] . $color[1] . $color[2] . $color[2];
	}

	/**
	 * @return array
	 * @example 'array(0,255,122)'
	 *
	 */
	public static function rgbColorAsArray() {
		$color = static::hexColor();

		return [
			hexdec( substr( $color, 1, 2 ) ),
			hexdec( substr( $color, 3, 2 ) ),
			hexdec( substr( $color, 5, 2 ) ),
		];
	}

	/**
	 * @return string
	 * @example '0,255,122'
	 *
	 */
	public static function rgbColor() {
		return implode( ',', static::rgbColorAsArray() );
	}

	/**
	 * @return string
	 * @example 'rgb(0,255,122)'
	 *
	 */
	public static function rgbCssColor() {
		return 'rgb(' . static::rgbColor() . ')';
	}

	/**
	 * @return string
	 * @example 'rgba(0,255,122,0.8)'
	 *
	 */
	public static function rgbaCssColor() {
		return 'rgba(' . static::rgbColor() . ',' . static::randomFloat( 1, 0, 1 ) . ')';
	}

	/**
	 * @return string
	 * @example 'blue'
	 *
	 */
	public static function safeColorName() {
		return static::randomElement( static::$safeColorNames );
	}

	/**
	 * @return string
	 * @example 'NavajoWhite'
	 *
	 */
	public static function colorName() {
		return static::randomElement( static::$allColorNames );
	}

	/**
	 * @return string
	 * @example '340,50,20'
	 *
	 */
	public static function hslColor() {
		return sprintf(
			'%s,%s,%s',
			self::numberBetween( 0, 360 ),
			self::numberBetween( 0, 100 ),
			self::numberBetween( 0, 100 ),
		);
	}

	/**
	 * @return array
	 * @example array(340, 50, 20)
	 *
	 */
	public static function hslColorAsArray() {
		return [
			self::numberBetween( 0, 360 ),
			self::numberBetween( 0, 100 ),
			self::numberBetween( 0, 100 ),
		];
	}
}
