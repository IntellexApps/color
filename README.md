# Color manipulation for PHP

* Supports __RGB(A)__ and __CMY(K)__, with __super__ easy conversion.
* __Modify__ initialized color using the __available setters__.
* Output colors to __any format__, including every __CSS__ one.
* Ability to __parse__ colors from any __standard__ and __CSS__ notation.
* Extend parsing with your own __custom parsers__.
* Predefined list of __142 named__ web colors.
* __No__ additional __3rd party__ scripts.

Predefined colors
--------------------

The list of all 142 standardized HTML colors defined in `Predefined\RGBA` class:

```php
$chocolateColor = RGBA::Chocolate();
$mistyRoseColor = RGBA::MistyRose();
$navyColor = RGBA::Navy();
```

A couple of examples
--------------------

From hex to CSS:

```php
$color = ColorParser::parse('#781190');
echo $color->toCSS();
```

From CSS to GD color:

```php
$color = ColorParser::parse('rgb(80, 138, 99);');
$image = imageCreateTrueColor(200, 200);
$gdColor = $color->getRGBA()->toImageColorIdentifier($image)
```

From CMYK to RGBA:

```php
$color = ColorParser::parse('cmyk(20%, 40%, 60%, 20%');
echo $color->getRGBA()->toHexString();
```

Conversion
--------------------

When initialize a color will either be RGBA or CMYK. This can be done manually, or by parsing the string.

Note that some parameters (ie. alpha channel in RGBA), will simply be ignored during conversion.

Any color can be cast to another one:

```php
$rgba = new RGBA(190, 11, 32, 0.65);
$cmyk = $rgba->getCMYK(); 
```

Example with a [parser](#parsing-a-color).

```php
$rgba = ColorParser::parse($input)->getRGBA(); 
```

Output
--------------------

Options available for RGBA:

```php
$rgba->toImageColorIdentifier($image);
$rgba->toHexString($includeAlpha, $includeHashTag, $uppercase);
$rgba->toCSS();
$rgba->getCMYK();
```

Options available for CMYK:

```php
$cmyk->toCSS;
$cmyk->getRGBA;
```

Parsing a color
--------------------

Use `ColorParser::parse($input)`, which will try every registered parser.

If no parser is able to handle it, `ColorCannotBeParsed` will be thrown.

Default parsers support most (if not all) RGBA and CMYK formats, but you can create you [custom parsers](#custom-parsers) for your specific need.

Supported out of the box:

* __CMYK__ from array `[C, M, Y]` and `[C, M, Y, K]`
* __RGB(A)__ from array `[R, G, B]` and `[R, G, B, A]`
* __RGB(A)__ from string:
    * `RGB`
    * `ARGB`
    * `RRGGBB`
    * `AARRGGBB`
    * `#RGB`
    * `#ARGB`
    * `#RRGGBB`
    * `#AARRGGBB`
* __CSS__
    * `cmyk(c%, m%, y%)` and `cmyk(c%, m%, y%, k%)`
    * `rgb(r, b, g)` and `rgb(r, b, g, a)` 

Custom parsers
--------------------

Create and register a new parsers, that will ba included in the next parsing:

1. Create a class and implement `AbstractColorParser` interface.
2. When implementing method `parse($input`)
   * if input cannot be parsed -> throw `ColorCannotBeParsed` 
   * if input can be parsed return the `Color`
3. Register the parser with `ColorParser::registerParser(AbstractColorParser $parser)`.
4. Next time the `ColorParser::parse()` is called, your parser will be considered as well.

TODO
--------------------

1. Support for HSV.
2. Detect color name by finding the most similar color in the predefined list.

Credits
--------------------
Script has been written by the [Intellex](https://intellex.rs/en) team.
