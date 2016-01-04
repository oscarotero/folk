# icona

1 svg + 1 css = multiple icons

Icona is an icon library with just one svg:

```xml
<svg viewBox="0 0 16 16">
	<line x1="0" x2="14" y1="0" y2="0"/>
	<line x1="0" x2="14" y1="0" y2="0"/>
	<line x1="0" x2="14" y1="0" y2="0"/>
	<circle cx="6.5" cy="6.5" r="4.5"/>
</svg>
```

and a css file to generate all icons just with these four elements (3 lines and 1 circle).

## Why?

* The library is minimal enought to put inline, instead an external svg file (one less request)
* Because all icons use the same svg, you can play with css transitions to animate between an icon to another
* Customize your own icons, changing the colors, stroke width, size, etc, using only css.

There are two subsets of icons, one that uses a 12x12 grid (better for sizes like 12px, 24px, 48px, etc) and other that uses a 16x16 grid (and, obviously, for sizes like 16px, 32px, 64px...)

## How it works?

* Import the css file in your html. Choose between 12 or 16 grid.
  ```html
  <link rel="stylesheet" type="text/css" href="ia-16.css">
  ```
* Put the svg code. If you want use the 12 based grid, the code is:
  ```xml
  <svg viewBox="0 0 12 12" class="ia-12">
  	<line x1="0" x2="10" y1="0" y2="0"/>
  	<line x1="0" x2="10" y1="0" y2="0"/>
  	<line x1="0" x2="10" y1="0" y2="0"/>
  	<circle cx="5" cy="5" r="4"/>
  </svg>
  ```

  If you prefer the 16 based grid:
  ```xml
  <svg viewBox="0 0 16 16" class="ia-16">
	<line x1="0" x2="14" y1="0" y2="0"/>
	<line x1="0" x2="14" y1="0" y2="0"/>
	<line x1="0" x2="14" y1="0" y2="0"/>
	<circle cx="6.5" cy="6.5" r="4.5"/>
  </svg>
  ```

* Add the `ia-*` class to the svg with the icon name. The available icons are:

  * `ia-cross`
  * `ia-menu`
  * `ia-minus`
  * `ia-plus`
  * `ia-right`
  * `ia-left`
  * `ia-top`
  * `ia-bottom`
  * `ia-search`
  * `ia-check`
  * `ia-tright`
  * `ia-tleft`
  * `ia-ttop`
  * `ia-tbottom`

## Show me the demo

Of course, a demo is available: http://oscarotero.com/icona
