=== The Clean Blog ===

Contributors: lebcit
Tags:blog, custom-background, custom-menu, editor-style, featured-image-header, one-column, theme-options, threaded-comments, translation-ready

Requires at least: WordPress 4.7
Tested up to: WordPress 4.7.2
Stable tag: 17.02.20
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

== Description ==

The Clean Blog is a carefully styled Bootstrap blog theme, **without sidebars**, that is perfect for personal or company blogs.  
The Clean Blog is **Fully Responsive**, with a **Modern Design** and a **Distraction Free** blog text optimized for legibility with a menu bar interface that conveniently appears when you scroll up !  
The **defined featured image of a post or page turns into a responsive full screen custom parallax header background image !**  
**Subtitle** option for each post and page in the backend directly under the title !  
Galleries are displayed in a **responsive touch-friendly image lightbox** when images are linked to their respective media file.  
The **fixed/revealed footer** displays social links controlled by the Customizer, and a dynamic copyright information line, based on your Site Title and the year's date of your first and last posts.  
**Custom AJAX Contact Form** with HTML validation, JS validation and PHP validate/sanitize/escape data.

== Installation ==

1. In your admin panel, go to Appearance > Themes and click the Add New button.
2. Click Upload and Choose File, then select the theme's .zip file. Click Install Now.
3. Click Activate to use your new theme right away.
4. Navigate to Appearance > Customize in your admin panel and customize to taste.

== Frequently Asked Questions ==

= Does this theme support any plugins? =

Clean Blog includes support for Jetpack's Infinite Scroll as well as other features.

= How to use the lightbox on galleries ? =

1. Create a gallery in a post or a page.
2. In the **GALLERY SETTINGS**, set the **Link To** option to **Media File**.
3. Set your preferred **Size**, and press the **Update gallery** button.
4. If you want a caption under an image, set an alt text for this image.
5. Don't forget to press the **Update** button of the post or the page.
6. Go to your site and click on any image of the gallery. Enjoy !

= How to use the contact form ? =

1. Create a **page** and from the **Page Attributes** choose the **Contact Form** Template.
2. That's all folks !

== Changelog ==

= 17.02.20 =
* Released: February 20, 2017
- Added AJAX to contact form
- Added useful comments to contact-form.js
- Removed unnecessary code from contact-form.js and cleanblog-functions.php
- Updated readme.txt

= 17.02.15 =
* Released: February 15, 2017
- Changed cleanblog_posted_on() function
- Changed Theme URI
- Added Contact Form Template + validate, sanitize an escape data
- Added Contact Form Styles
- Added JS validation to contact form with jquery.validate.js
- Made lightbox scripts load only if gallery detected on post or page
- Moved lightbox effect script to a separate file, imagegallery.js
- Removed .updated:not(.published) in style.css
- Updated readme.txt

= 17.01.31 =
* Released: January 31, 2017
- Changed $.scrollUp animation to remove Scroll-linked effects warning in Firefox
- Added lightbox effect to WordPress Galleries with imageLightbox.js
- Updated readme.txt

= 17.01.27 =
* Released: January 27, 2017
- Changed top.png to to-top.png icon for license compatibility
- Added social sharing icons to posts
- Updated readme.txt

= 17.01.25 =
* Released: January 25, 2017
- Added escape on some functions to secure the output
- Corrected error in comments.php
- Updated readme.txt

= 17.01.21 =
* Released: January 21, 2017
- Changed Theme URI
- Changed version logic from d.m.y to y.m.d
- Added automatic focus on the search field input
- Added original non-minified files along with the original enqueued minified files
- Added scroll to top functionality with jquery.scrollUp.js
- Formated and fixed code to match WordPress coding standards
- Included Font Awesome inside the theme
- Putting some order in some files
- Removed unnecessary folders and files
- Updated description
- Updated readme.txt

= 14.01.17 =
* Released: January 14, 2017
- Changed the description of the theme
- Added fixed/reveal effect to footer with footer-reveal.js
- Putting some order in some files
- Removed outline on multiple link

= 10.01.17 =
* Released: January 10, 2017

Initial release

== Credits ==

* Based on [Clean Blog](https://github.com/BlackrockDigital/startbootstrap-clean-blog), (C) 2013-2016 [Blackrock Digital](https://github.com/BlackrockDigital), LLC., [MIT](http://opensource.org/licenses/MIT)
* Based on [COMPONENTS](https://github.com/Automattic/theme-components/), (C) 2015-2016 [Automattic](https://automattic.com/), Inc., [GPLv2 or later](https://www.gnu.org/licenses/gpl-2.0.html)
* [normalize.css](http://necolas.github.io/normalize.css/), (C) 2012-2016 Nicolas Gallagher and Jonathan Neal, [MIT](http://opensource.org/licenses/MIT)
* [Font Awesome Icons](http://fontawesome.io/), (C) [Dave Gandy](https://twitter.com/davegandy), [SIL OFL](http://scripts.sil.org/OFL)
* [jQuery scrollTo](https://github.com/flesler/jquery.scrollTo), (C) 2007-2015 [Ariel Flesler](https://github.com/flesler), [MIT](http://opensource.org/licenses/MIT)
* [jQuery ScrollUp](https://github.com/markgoodyear/scrollup), (C) [Mark Goodyear](https://github.com/markgoodyear), [MIT](http://opensource.org/licenses/MIT)
* [footer-reveal.js](https://github.com/IainAndrew/footer-reveal), (C) [Iain Andrew](https://github.com/IainAndrew), [MIT](http://opensource.org/licenses/MIT)
* [imageLightbox.js](https://github.com/osvaldasvalutis/imageLightbox.js), (C) 2014-2016 [Osvaldas Valutis](https://github.com/osvaldasvalutis), [MIT](http://opensource.org/licenses/MIT)
* [jquery.validate.js](https://github.com/jquery-validation/jquery-validation), (C) 2013-2017 [Jörn Zaefferer](http://bassistance.de/), [MIT](http://opensource.org/licenses/MIT)
* Bundled header images :  
[404-hero.jpg](https://unsplash.com/search/search?photo=JuFcQxgCXwA), (C) [Samuel Zeller](https://unsplash.com/@samuelzeller), [CC0 1.0](https://creativecommons.org/publicdomain/zero/1.0/)  
[search-hero.jpg](https://unsplash.com/search/search?photo=azbZUNpu1Ag), (C) [Saeed Mhmdi](https://unsplash.com/@saeedanathema), [CC0 1.0](https://creativecommons.org/publicdomain/zero/1.0/)  
[default-hero.jpg](https://unsplash.com/search/desk?photo=mCg0ZgD7BgU), (C) [Aleksi Tappura](https://unsplash.com/@a), [CC0 1.0](https://creativecommons.org/publicdomain/zero/1.0/)
* Icon [to-top.png](http://fa2png.io/r/font-awesome/arrow-circle-up/), Generated with [FA2PNG](http://fa2png.io/), [SIL OFL](http://scripts.sil.org/OFL)