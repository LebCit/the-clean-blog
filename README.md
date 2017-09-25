# The Clean Blog

![Screenshot](https://github.com/LebCit/the-clean-blog/raw/master/screenshot.png "The Clean Blog Screenshot")

Contributors: [LebCit](https://profiles.wordpress.org/lebcit)  
Tags: blog, custom-background, custom-menu, editor-style, featured-image-header, one-column, theme-options, threaded-comments, translation-ready

Requires at least: WordPress 4.7  
Tested up to: WordPress 4.8.2  
Stable tag: 17.09.25  
License: GPLv2 or later  
License URI: http://www.gnu.org/licenses/gpl-2.0.html

## Description

The Clean Blog is a carefully styled Bootstrap blog theme, **without sidebars**, that is perfect for personal or company blogs.  
The Clean Blog is **Fully Responsive**, with a **Modern Design** and a **Distraction Free** blog text optimized for legibility with a menu bar interface that conveniently appears when you scroll up !  
The **defined featured image of a post or page turns into a responsive full screen custom parallax header background image !**  
**Header's background image** is retrieved with AJAX to speed time's load !  
Galleries are displayed in a **responsive touch-friendly image lightbox** when images are linked to their respective media file.  
The **fixed/revealed footer** displays social links controlled by the Customizer, and a dynamic copyright information line, based on your Site Title and the year's date of your first and last posts.  
The **new** improved navigation with **one sub-menu depth**, can hold only 5 main items and 5 children items on desktop. No limitation of items on mobile.

## Installation

1. In your admin panel, go to Appearance > Themes and click the Add New button.
2. Click Upload and Choose File, then select the theme's .zip file. Click Install Now.
3. Click Activate to use your new theme right away.
4. Navigate to Appearance > Customize in your admin panel and customize to taste.

## Frequently Asked Questions

### Does this theme support any plugins?

The Clean Blog includes support for Jetpack's Infinite Scroll as well as other features.

### How to use the lightbox on galleries ?

1. Create a gallery in a post or a page.
2. In the **GALLERY SETTINGS**, set the **Link To** option to **Media File**.
3. Set your preferred **Size**, and press the **Update gallery** button.
4. If you want a caption under an image, set an alt text for this image.
5. Don't forget to press the **Update** button of the post or the page.
6. Go to your site and click on any image of the gallery. Enjoy !

### How to create a main item link ?

1. Go To Appearance > Menus.
2. Create a **Custom Link**
3. In _URL_ type **#0**
4. In _Link Text_ type the label of your choice.
5. That's it :)

### I can't see more than 5 main/children items !

This is the normal behaviour of the menu starting from 1024px.  
You can add as many main/children items as you want.  
But on desktop view, only the **First 5** will show up !

## Changelog

### 17.09.25 =
* Released: September 25, 2017
- Added BODY COLORS panel to Customizer
- Changed title's section from Background Image to Background Image/Color.
- Changed The Clean Blog Theme panel description.
- Changed all color controls type from 'color' to 'color-alpha'.
- Moved background_color control to background_image section.
- Removed Header text color setting.
- Removed section colors from Customizer.
- Updated .pot
- Updated theme tags
- Updated [readme.md](https://github.com/LebCit/the-clean-blog/blob/master/README.md)

### 17.06.26 =
* Released: June 26, 2017
- Changed screenshot.
- Corrected is_search_has_results() fuction.
- Corrected Menu Background Color In Customizer.
- Updated [readme.md](https://github.com/LebCit/the-clean-blog/blob/master/README.md)

### 17.06.19 =
* Released: June 19, 2017
- Corrected bootstrap handle.
- Generating Custom Search Forms.
- Replaced ... by &hellip;
- Targeting Header Search Form by NEW ID.
- Updated .pot
- Updated [readme.md](https://github.com/LebCit/the-clean-blog/blob/master/README.md)

### 17.06.14 =
* Released: June 14, 2017
- Added some missing translations.
- Fixed some translations output.
- Updated .pot
- Updated [readme.md](https://github.com/LebCit/the-clean-blog/blob/master/README.md)

### 17.06.13 =
* Released: June 13, 2017
- Adding Theme Copyright.
- Added missing translation.
- Added Prefix To google Fonts.
- Fixed Theme's Prefix.
- Integrated Kirki to theme.
- Modified excerpt_more filter.
- Modified Social Media Functions.
- Removed comment-list from add_theme_support( 'html5' ).
- Removed custom search form.
- Removed the REMOVE WP EMOJI ACTIONS.
- Removed wpcom.php
- Replaced ... by &hellip;
- Updated .pot
- Updated [readme.md](https://github.com/LebCit/the-clean-blog/blob/master/README.md)

### 17.05.22 =
* Released: May 22, 2017
- Added a WordPress check version function for theme activation.
- Added a menu callback function.
- Added Bounce Animation For Scroll Down Arrow with some improvements on scroll.
- Modified clean-blog-nav.js, process improvement for body events and bounce animation.
- Modified call order of Font Awesome Sources (iOS fix).
- Modified bg-header.php for Pages and Archive page.
- Modified some tags' styles.
- Removed site-branding.php
- Updated .pot
- Updated [readme.md](https://github.com/LebCit/the-clean-blog/blob/master/README.md)

### 17.05.18 =
* Released: May 18, 2017
- Added new logic to Header Search Dropdown on resize.
- Changed nicename to nickname in thecleanblog_posted_on().
- Remove default -webkit-tap-highlight-color.
- Some Code Formatting.
- Updated [readme.md](https://github.com/LebCit/the-clean-blog/blob/master/README.md)

### 17.05.13 =
* Released: May 13, 2017
- Added New Navigation.
- Made required changes after review for approval.
- Removed unneeded files and code from previous version after changes.
- Updated [readme.md](https://github.com/LebCit/the-clean-blog/blob/master/README.md)

### 17.03.12 =
* Released: March 12, 2017
- Ajaxified header's background image
- Localized hero.js
- Renamed localized arrays' keys
- Updated [readme.md](https://github.com/LebCit/the-clean-blog/blob/master/README.md)

### 17.02.20 =
* Released: February 20, 2017
- Added AJAX to contact form
- Added useful comments to contact-form.js
- Removed unnecessary code from contact-form.js and the-clean-blog-functions.php
- Updated [readme.md](https://github.com/LebCit/the-clean-blog/blob/master/README.md)

### 17.02.15 =
* Released: February 15, 2017
- Changed thecleanblog_posted_on() function
- Changed Theme URI
- Added Contact Form Template + validate, sanitize an escape data
- Added Contact Form Styles
- Added JS validation to contact form with [jquery.validate.js](https://github.com/jquery-validation/jquery-validation)
- Made lightbox scripts load only if gallery detected on post or page
- Moved lightbox effect script to a separate file, imagegallery.js
- Removed .updated:not(.published) in style.css
- Updated [readme.md](https://github.com/LebCit/the-clean-blog/blob/master/README.md)

### 17.01.31 =
* Released: January 31, 2017
- Changed $.scrollUp animation to remove Scroll-linked effects warning in Firefox
- Added lightbox effect to WordPress Galleries with [imageLightbox.js](https://github.com/osvaldasvalutis/imageLightbox.js)
- Updated [readme.md](https://github.com/LebCit/the-clean-blog/blob/master/README.md)

### 17.01.27 =
* Released: January 27, 2017
- Changed top.png to to-top.png icon for license compatibility
- Added social sharing icons to posts
- Updated [readme.md](https://github.com/LebCit/the-clean-blog/blob/master/README.md)

### 17.01.25 =
* Released: January 25, 2017
- Added escape on some functions to secure the output
- Corrected error in comments.php
- Updated [readme.md](https://github.com/LebCit/the-clean-blog/blob/master/README.md)

### 17.01.21 =
* Released: January 21, 2017
- Changed Theme URI
- Changed version logic from d.m.y to y.m.d
- Added automatic focus on the search field input
- Added original non-minified files along with the original enqueued minified files
- Added scroll to top functionality with [jQuery ScrollUp](https://github.com/markgoodyear/scrollup)
- Formated and fixed code to match WordPress coding standards
- Included Font Awesome inside the theme
- Putting some order in some files
- Removed unnecessary folders and files
- Updated description
- Updated [readme.md](https://github.com/LebCit/the-clean-blog/blob/master/README.md)

### 14.01.17 =
* Released: January 14, 2017
- Changed the description of the theme
- Added fixed/reveal effect to footer with [footer-reveal.js](https://github.com/IainAndrew/footer-reveal)
- Putting some order in some files
- Removed outline on multiple link

### 10.01.17 =
* Released: January 10, 2017

Initial release

## Copyright

* The Clean Blog WordPress Theme, Copyright 2017 [LebCit](https://profiles.wordpress.org/lebcit)
* The Clean Blog is distributed under the terms of the GNU GPL

## Credits

* Based on [Clean Blog](https://github.com/BlackrockDigital/startbootstrap-clean-blog), (C) 2013-2016 [Blackrock Digital](https://github.com/BlackrockDigital), LLC., [MIT](http://opensource.org/licenses/MIT)
* Based on [COMPONENTS](https://github.com/Automattic/theme-components/), (C) 2015-2016 [Automattic](https://automattic.com/), Inc., [GPLv2 or later](https://www.gnu.org/licenses/gpl-2.0.html)
* Based on [Bootstrap](https://github.com/twbs/bootstrap), (C) 2011-2017 [Bootstrap](https://github.com/twbs), [MIT](http://opensource.org/licenses/MIT)
* [normalize.css](http://necolas.github.io/normalize.css/), (C) 2012-2016 Nicolas Gallagher and Jonathan Neal, [MIT](http://opensource.org/licenses/MIT)
* [Font Awesome Icons](http://fontawesome.io/), (C) [Dave Gandy](https://twitter.com/davegandy), [SIL OFL 1.1](http://scripts.sil.org/OFL)
* Navigation Inspired By [Secondary Sliding Navigation](https://codyhouse.co/gem/secondary-sliding-navigation/), [Claudia Romano](https://twitter.com/romano_cla)
* [jQuery ScrollUp](https://github.com/markgoodyear/scrollup), (C) [Mark Goodyear](https://github.com/markgoodyear), [MIT](http://opensource.org/licenses/MIT)
* [footer-reveal.js](https://github.com/IainAndrew/footer-reveal), (C) [Iain Andrew](https://github.com/IainAndrew), [MIT](http://opensource.org/licenses/MIT)
* [imageLightbox.js](https://github.com/osvaldasvalutis/imageLightbox.js), (C) 2014-2016 [Osvaldas Valutis](https://github.com/osvaldasvalutis), [MIT](http://opensource.org/licenses/MIT)
* [jquery.validate.js](https://github.com/jquery-validation/jquery-validation), (C) 2013-2017 [Jörn Zaefferer](http://bassistance.de/), [MIT](http://opensource.org/licenses/MIT)
* Bundled header images :  
[404-hero.jpg](https://unsplash.com/search/search?photo=JuFcQxgCXwA), (C) [Samuel Zeller](https://unsplash.com/@samuelzeller), [CC0 1.0](https://creativecommons.org/publicdomain/zero/1.0/)  
[search-hero.jpg](https://unsplash.com/search/search?photo=azbZUNpu1Ag), (C) [Saeed Mhmdi](https://unsplash.com/@saeedanathema), [CC0 1.0](https://creativecommons.org/publicdomain/zero/1.0/)  
[default-hero.jpg](https://unsplash.com/search/desk?photo=mCg0ZgD7BgU), (C) [Aleksi Tappura](https://unsplash.com/@a), [CC0 1.0](https://creativecommons.org/publicdomain/zero/1.0/)
* Icon [to-top.png](http://fa2png.io/r/font-awesome/arrow-circle-up/), Generated with [FA2PNG](http://fa2png.io/), [SIL OFL](http://scripts.sil.org/OFL)
