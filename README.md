
Ratavarg _(Gravatar backwards)_ is an alternative to [Gravatar.com](http://en.gravatar.com/).

The script uses PHP GD (PHP GIF Draw) to generate an image representing a grid of `5x5` cells, fifteen of the squares at the left side are filled randomly with colors and the remaining ten squares at the right are copied from the first ten squares of the left side generating a simetric graphic.

## Demo

A live demo is available in [here](https://cixtor.com/gravatar)

## Usage

Add a HTML tag referencing the PHP file as the source of the image, the script will respond with the data generated and an image header forcing the browser to consider the file as an image.

```
<img src="/avatar.php" width="300" height="300" />
```

Use this configuration in the `AccessFilename` of your project to change the format of the image generated, the script will automatically understand what extension was requested, supported formats are: jpeg, gif, and png.

```
<IfModule mod_rewrite.c>
    RewriteEngine on
    # RewriteBase /

    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteCond %{REQUEST_FILENAME} !-d

    RewriteRule ^avatar.(png|jpg|gif)$ avatar.php [L]
</IfModule>
```

## What is Gravatar?

According to [Gravatar.com - What is Gravatar](http://en.gravatar.com/support/what-is-gravatar/):

> An **avatar** is an image that represents a person online, basically a little picture that appears next to your name when you interact with websites. A **Gravatar** is a `Globally Recognized Avatar`. You upload it and create your profile just once, and then when you participate in any Gravatar-enabled site, your Gravatar image will automatically follow you there.
>
> Gravatar is a free service for site owners, developers, and users. It is automatically included in every **WordPress** account and is run and supported by [Automattic](http://automattic.com/).
