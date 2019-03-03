# Color manipulation for PHP

* Supports __RGB(A)__ and __CMY(K)__, with super easy conversion.
* __Modify__ initialized color using the available setters.
* Output colors to __any format__, including every __CSS__ one.
* Ability to __parse__ colors from any standard and __CSS__ notation.
* Extend parsing with your own __custom parsers__.
* Predefined list of __142 named__ web colors.


##### Predefined lines

Find the list of all colors as methods in the <code>Predefined\RGBA</code> class.

##### Conversion

When initialize a color will either be RGBA or CMYK. This can be done manually, or by parsing the string.

Note that some parameters (ie. alpha channel in RGBA), will simply be ignored during conversion. 

Any color can be casted to another one:
<pre>
$rgba = new RGBA(190, 11, 32, 0.65);
$cmyk = $rgba->getCMYK(); 
</pre>

Example with a [parser](#parsing-a-color).
<pre>
$rgba = Parser::parse($input)->getRGBA(); 
</pre>

##### Output

Options available for RGBA:
<pre>
/**
 * Print the color as hexadecimal string, in format #AARRGGBB (# and AA are optional).
 *
 * @param bool $includeAlpha   True to include alpha channel in front.
 * @param bool $includeHashTag True to include the hash tag in front.
 * @param bool $uppercase      True to use uppercase, false to user lowercase.
 *
 * @return string The resulting hexadecimal string.
 */
$rgba->toHexString($includeAlpha, $includeHashTag, $uppercase);
</pre>

<pre>
/**
 * Output a color to a CSS string.
 *
 * @return string The CSS representation of this color, which always includes alpha.
 */
$rgba->toCSS();
</pre>

<pre>
/**
 * Allocate a color for an image.
 *
 * @param resource $image An image resource, returned by one of the image creation functions,
 *                        such as imagecreatetruecolor().
 *
 * @return resource|boolean A color identifier, or false if the allocation failed.
 */
$rgba->toImageColorIdentifier($image);
</pre>

Options available for CMYK:
<pre>
/**
 * Output a color to a CSS string.
 *
 * @return string The CSS representation of this color.
 */
$cmyk->toCSS;
</pre>

##### Parsing a color

Simply call <code>Parser::parse(string $input)</code>, which will try every parser.
If all fail, <code>ColorCannotBeParserException</code> will be thrown.

Default parsers support most (if not all) RGBA and CMYK formats, but you can create you [custom parsers](#custom-parsers) for your specific need. 

Supported out of the box:
* CMYK from array [C, M, Y, K] (K is optional)
* RGBA from array [R, G, B, A] (A is optional)
* RGB from string:
	* RGB
	*  ARGB
	*  RRGGBB
	*  AARRGGBB
	*  \#RGB
	*  \#ARGB
	*  \#RRGGBB
	*  \#AARRGGBB
* CSS
	* CMYK
	* RGBA
	* RGB

##### Custom parsers

Create and register a new parsers, that will ba included in the next parsing:
1. Create a class and implement <code>ColorParsing</code> interface.
2. Register the parser with <code>Parser::registerParser(:ColorParsing)</code>.
3. Next time the <code>Parser::parse()</code> is called, your parser will be considered as well.

Note that you parser should throw a <code>ColorCannotBeParsedException</code> if format is not recognized.
The <code>Parser::parse()</code> method will try the next parser and only throw <code>ColorCannotBeParsedException</code>, if none of the parsers resolve to a color.

TODO
--------------------
1. Support for HSV.
2. Detect color name by finding the most similar color in the predefined list.

Licence
--------------------
MIT License

Copyright (c) 2019 Intellex

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.

Credits
--------------------
Script has been written by the [Intellex](https://intellex.rs/en) team.
