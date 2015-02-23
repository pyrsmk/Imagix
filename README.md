Imagix 0.5.0
============

Imagix is a library, based on GD, that aims to simplify the use of effects on images. This project is born with two ideas in mind :

- we usually just want to apply some effects without headaches
- we sometimes do not have a full control on the hosting server and therefore cannot rely on other image manipulation PHP extensions than GD

Install
-------

You can install it with [Composer](https://getcomposer.org/) or import it in your project directly.

```json
{
    "require": {
        "pyrsmk/imagix": "~0.5"
    }
}
```

Instantiating
-------------

The simplest way to instantiate an image is with the `Imagix\Factory` class (it uses `Exif` PHP extension to guess which adapter to load) :

```php
$imagix=Imagix\Factory::forge('path/to/your/image/file.jpg');
```

It detects automatically the image type and loads the relevant adapter to use. But, if needed (and because it uses more resources), you can instantiate an image adapter by yourself :

```php
$adapter=new Imagix\Adapter\PNG('path/to/your/image/file.png');
$imagix=new Imagix($adapter);
```

Here's the available image adapters :

- `Imagix\Adapter\GIF`
- `Imagix\Adapter\JPEG`
- `Imagix\Adapter\PNG`

Applying effects
----------------

A quick example :

```php
// Convert image to grayscale
$imagix->grayscale();
// Resize the image to a maximum of 600x400 by keeping the ratio
$imagix->resize(600,400);
// Add a black border of 3px around the image
$imagix->border(3);
// Save the image
$imagix->save('mynewimage.jpg');
```

There's more than 30 sugar effects you can use. Some of them are only available when PHP has been compiled with the bundled version of GD. It's generally the case but not on Debian systems.

- `*` : only available with the GD bundle
- `#` : the effect is resource-hungry

- [*] addition(`$color`,`$opacity=100`) : add a color to the image; it takes an HTML color for the `$color` parameter
- [*] blur(`$method=SELECTIVE`) : blur the image; it supports `GAUSSIAN` and `SELECTIVE` blur methods
- border(`$thickness`,`$color='#000000'`,`$sides=ALL`) : draw a border around the image; support side constants are `ALL` (by default), `TOP`, `RIGHT`, `BOTTOM`, `LEFT`
- [*] brightness(`$level`) : adjust the brightness; the brightness level must be between `-255` and `255` (included)
- [#] channels(`$r`,`$g`,`$b`) : make some adjustments on RGB channels; each channel takes one of these constants : `NONE`, `RED`, `GREEN`, `BLUE`, `MINIMIZE`, `MAXIMIZE`
- [*] contrast(`$level`) : adjust the contrast of the image
- corner(`$size=10`,`$type=ROUNDED`,`$corners=ALL`) : apply a mask to each corner of the image to make them rounded or truncated (per example); the `$type` paramater supports `ROUNDED`, `BEVELLED` and `TRUNCATED` methods; the `$corners` parameter accepts `ALL`, `TOPLEFT`, `TOPRIGHT`, `BOTTOMRIGHT` and `BOTTOMLEFT` constants
- crop(`$x`,`$y`,`$width`,`$height`) : crop an image
- [#] duotone(`$r`,`$g`,`$b`) : apply a duotone effect; the RGB parameters are an amount that will be added to the RGB channels of the image
- [*] edge() : apply an edge effect
- [*] emboss(`$method=MATRIX`) : emboss the image; `MATRIX` and `FILTER` methods are supported
- enhance() : enhance an image
- gamma(`$input`,`$output`) : adjust the gamma correction
- [*] grayscale() : convert an image to grayscale
- [#] hsla(`$h`,`$s`,`$l`,`$a`) : modify the HSLA channels of an image
- [#] hsva(`$h`,`$s`,`$v`,`$a`) : modify the HSVA channels of an image
- interlace() : interlace the image
- line(`$x1`,`$y1`,`$x2`,`$y2`,`$thickness=1`,`$color='#000000'`) : draw a line on the image
- lines(`$direction=HORIZONTAL`,`$step=2`,`$thickness=1`,`$color='#000000'`) : draw several lines on the image; it supports `HORIZONTAL` and `VERTICAL` constants for the `$direction` parameter; the `$step` parameter is the size in pixels where a new line should be drawed
- [#] mask(`$mask`,`$x`,`$y`) : apply a mask on the image; the `$mask` parameter is a GD resource; the `$x` and `$y` parameters specify where the mask should be applied
- matrix(`$matrix`,`$color_offset`) : apply a matrix to the image; for further informations read the documentation of [`imageconvolution()`](http://php.net/manual/en/function.imageconvolution.php)
- merge(`$image`,`$method=NORMAL`,`$x1`,`$y1`,`$x2`,`$y2`,`$src_w`,`$src_h`,`$pct`) : merge two images; please read the [`imagecopymerge()`](http://php.net/manual/en/function.imagecopymerge.php) documentation to have further informations on how to set the parameters; the `$method` parameter takes either the `NORMAL` or `GRAYSCALE` constant
- [*] negate() : negate the image
- [#] noise(`$level=5`) : add noise to the image
- [*] pixelate(`$block_size=2`,`$advanced=true`) : pixelate the image 
- ratio(`$w_ratio`,`$h_ratio`,`$position=CENTERED`) : apply a ratio to the image; supports `CENTERED` (by default), `TOP`, `RIGHT`, `BOTTOM` and `LEFT` constants as position
- resize(`$width`,`$height`,`$keep_ratio=true`) : resize the image; if `$keep_ratio` is `true` it will consider the specified resolution as the maximum resolution to reach (explicitly, your image may not be of the size you specified)
- [*] rotate(`$angle`,`$background='#FFFFFF'`) : rotate the image by the specified angle
- [#] scatter(`$level=1`) : apply a scatter effect
- screen() : apply a screen effect
- [*] sepia() : apply a sepia effect
- [*] sharpen(`$method=MATRIX`) : apply a sharpen effect; supported constant methods are `MATRIX` (by default) and `FILTER`
- shift() : shift the image
- [*] smooth() : apply a smooth effect
- truecolor() : convert the image to true colors

Advanced image handling
-----------------------

The API of `Imagix\Image` :

- getAdapter() : get the used adapter
- getWidth() : get the width of the image
- getHeight() : get the height of the image
- save(`$path`,`$options`) : save the image

The API of all adapters :

- getResource() : get the GD resource of the image
- setResource(`$resource`) : set the resource of the image
- getPath() : get the path of the source image
- getContents() : get the image contents
- getMimetype() : get the MIME type

The `save()` method can take specific options for the image to save.

```php
// For the JPEG adapter
$imagix->save('image.jpg',array(
    // defaults to 80
    'quality' => 95
));
// For the PNG adapter
$imagix->save('image.jpg',array(
    // a value between 0 and 9 (by default)
    'quality' => 7,
    // for a better understanding on PNG filters, take a look at :
    // https://stackoverflow.com/questions/3048382/in-php-imagepng-accepts-a-filter-parameter-how-do-these-filters-affect-the-f
    'filters' => PNG_NO_FILTER
));
```

The GIF adapter, otherwise, takes no option.

If you want to export an image to another format :

```php
$png_adapter=new Imagix\Adapter\PNG('image.png');
$image=new Imagix\Image(new Imagix\Adapter\JPEG($png_adapter));
$image->save('image.jpg');
```

License
-------

Imagix is released under the [MIT license](http://dreamysource.mit-license.org).