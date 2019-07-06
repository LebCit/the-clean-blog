=== The Clean Blog ===
Contributors: lebcit
Tags: blog, custom-background, custom-colors, custom-logo, custom-menu, editor-style, featured-image-header, full-width-template, one-column, theme-options, threaded-comments, translation-ready, two-columns
Requires at least: WordPress 4.7
Tested up to: WordPress 5.2.2
Requires PHP: 5.4
Stable tag: 19.07.06
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

== Description ==

The Clean Blog is a carefully styled Bootstrap blog theme, with or without sidebars, that is perfect for personal or company blogs.  
The Clean Blog is Fully Responsive, with a Modern Design and a Distraction Free blog text optimized for legibility with a menu bar interface that conveniently appears when you scroll up !  
The defined featured image of a post or page turns into a responsive full screen custom parallax header background image !  
Header's background image is retrieved with AJAX to speed time's load !  
Galleries are displayed in a responsive touch-friendly image lightbox when images are linked to their respective media file.  
The fixed/revealed footer displays social links controlled by the Customizer, and a dynamic copyright information line, based on your Site Title and the year's date of your first and last posts.  
The new improved navigation with one sub-menu depth, can hold only 5 main items and 5 children items on desktop. No limitation of items on mobile.  
Unslider slider is fully integrated to the theme with powerful and cool controls from the Customizer !  
A nice and stylish Preloader, 28 animations included, with tons of controls, allows you to provide your visitors a beautiful animation before loading the site.  
Here come the Sidebars !  
Infact, it's just one sidebar that you can choose to display on the right or the left of the content.  
BUT you can choose to display it on the whole site, or all the posts, or all the pages, directly from the Customizer by postMessage without refreshing the view !  
Also, you can choose a different layout on each part : site, posts and pages !  
Furthermore, you can choose a specific layout for a post or a page from the administration under the Post Attributes or the Pages Attributes as a Generic Template !

== Installation ==

1. In your admin panel, go to Appearance > Themes and click the Add New button.
2. Click Upload and Choose File, then select the theme's .zip file. Click Install Now.
3. Click Activate to use your new theme right away.
4. Navigate to Appearance > Customize in your admin panel and customize to taste.

== Frequently Asked Questions ==

= Does this theme support any plugins? =

KIS includes support for Jetpack's Infinite Scroll as well as other features.

= How to create a main item link ? =

1. Go To Appearance > Menus.
2. Create a Custom Link
3. In _URL_ type #0
4. In _Link Text_ type the label of your choice.
5. That's it :)

= I can't see more than 5 main/children items ! =

This is the normal behaviour of the menu starting from 1024px.  
You can add as many main/children items as you want.  
But on desktop view, only the First 5 will show up !

= Where can I activate the slider and the preloader ? =

Almost all of the theme controls are under The Clean Blog Theme panel in the Customizer.  
Head over and start customizing the theme to make it looks and behave as you want !

= Where is the Sidebar ?! =

In the Customizer, go from The Clean Blog Theme panel > to THEME'S LAYOUTS panel, and choose fom the provided section(s).  
Provided section(s) depends on the actual view of the site !  
Please note that if you set a Generic template for a post or page, no section/setting/control will be provided since it already has a particular template ! 

= How to change the site layout ? =

KIS uses <a href="https://wordpress.org/plugins/kirki/">Kirki</a> plugin to control some of the theme's options.  
So, to take full advantage of this theme's features in the Customizer, install Kirki and activate it.  
Then, in the Customizer, expand the Site Layout section, and choose the desired layout.  
Please, be aware that the fullwidth layout will remove the main sidebar !

== Changelog ==

= 19.07.06 =
* Released: July 06, 2019
- Escaping variables, made some rectifications.
- Updated version & readme

= 19.04.23 =
* Released: April 21, 2019
- Added Sidebar Widgets Colors Panel in Customizer.
- Modified Search Widget Proportions.
- Tested up to version 5.1.1 of WordPress.
- Updated .pot file with new strings.
- Updated <a href="https://github.com/LebCit/the-clean-blog/blob/master/README.md">readme.md</a>

= 18.12.11 =
* Released: December 11, 2018
- Bumped version number, new upload to WordPress.

= 18.12.09 =
* Released: December 09, 2018
- Added Placeholder Texts For Texts Fields in Customizer.
- Added Selective Refresh to Site Title & Description.
- Changed File Name & Code, customize-preview.js
- Corrected CSS Target & Code of search_results_page_text
- Corrected CSS Target of error404_header_background_image
- Corrected Header Background Image Code.
- Moved Init Code, Changed File Name & Code, customize-controls.js
- Removed Core 'Menus' Panel From Customizer.
- Updated .pot file with new strings.
- Updated <a href="https://github.com/LebCit/the-clean-blog/blob/master/README.md">readme.md</a>

= 18.11.13 =
* Released: November 13, 2018
- Adjusted arrow position in menu widget for Chrome.
- DRY implementation of sidebar.
- Modified linear-gradient to work in IE and Edge.
- Updated <a href="https://github.com/LebCit/the-clean-blog/blob/master/README.md">readme.md</a>

= 18.11.09 =
* Released: November 09, 2018
- Added main header part for main files.
- Added page templates.
- Added Pages Layouts Section and Control.
- Added Posts Layouts Section and Control.
- Added Site Layouts Section and Control.
- Added Theme's Layout Panel.
- Live View for Site, Posts and Pages Layouts.
- Modified thecleanblog_customize_preview_js() function.
- postMessage for Site, Posts and Pages Layouts.
- Register, create and display a widget area.
- Removed selective_refresh from 'blogname' and 'blogdescription'.
- Styles for the Sidebar and some widgets.
- Updated <a href="https://github.com/LebCit/the-clean-blog/blob/master/README.md">readme.md</a>

= 18.10.23 =
* Released: October 23, 2018
- PHP Code Formatting using phpcs and phpcbf.
- Updated <a href="https://github.com/LebCit/the-clean-blog/blob/master/README.md">readme.md</a>

= 18.05.09 =
* Released: May 09, 2018
- Added .bounce class to arrow-down icon on search and 404 pages.
- Changed default-hero image.
- Changed default screenshot.
- Corrected #masthead responsiveness.
- Corrected slider behaviour on resize.
- Modified Preloader Control for homepage.
- Modified the-clean-blog-nav.js
- Some Code Formatting.
- Updated <a href="https://github.com/LebCit/the-clean-blog/blob/master/README.md">readme.md</a>

= 18.04.15 =
* Released: April 15, 2018
- Added active_callback to Slider Section.
- Added New Controls to the preloader.
- Modified the-clean-blog-nav.js
- Updated theme's description in style.css
- Updated .pot file with new strings.
- Updated <a href="https://github.com/LebCit/the-clean-blog/blob/master/README.md">readme.md</a>

= 18.04.09 =
* Released: April 09, 2018
- Added RTL support on the horizontal animation of the slider.
- Updated theme's description in style.css
- Updated .pot file with new strings.
- Updated <a href="https://github.com/LebCit/the-clean-blog/blob/master/README.md">readme.md</a>

= 18.04.08 =
* Released: April 08, 2018
- Added preloader with 28 animations taken from [loaders.css](https://github.com/ConnorAtherton/loaders.css).
- Added slider to the theme with [unslider](https://github.com/idiot/unslider).
- Localized the-clean-blog.js to pass php variables to JS.
- Modified resizeH1() function and bouncing logic to work with the slider.
- Updated .pot file with new strings.
- Updated theme tags.
- Updated <a href="https://github.com/LebCit/the-clean-blog/blob/master/README.md">readme.md</a>

= 18.03.15 =
* Released: March 15, 2018
- Added Visible Edit Shortcuts in the Customizer Preview for blogname and blogdescription.
- Corrected bootstrap wp_enqueue_style line.
- Updated <a href="https://github.com/LebCit/the-clean-blog/blob/master/README.md">readme.md</a>

= 17.09.25 =
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
- Updated <a href="https://github.com/LebCit/the-clean-blog/blob/master/README.md">readme.md</a>

= 17.06.26 =
* Released: June 26, 2017
- Changed screenshot.
- Corrected is_search_has_results() fuction.
- Corrected Menu Background Color In Customizer.
- Updated <a href="https://github.com/LebCit/the-clean-blog/blob/master/README.md">readme.md</a>

= 17.06.19 =
* Released: June 19, 2017
- Corrected bootstrap handle.
- Generating Custom Search Forms.
- Replaced ... by &hellip;
- Targeting Header Search Form by NEW ID.
- Updated .pot
- Updated <a href="https://github.com/LebCit/the-clean-blog/blob/master/README.md">readme.md</a>

= 17.06.14 =
* Released: June 14, 2017
- Added some missing translations.
- Fixed some translations output.
- Updated .pot
- Updated <a href="https://github.com/LebCit/the-clean-blog/blob/master/README.md">readme.md</a>

= 17.06.13 =
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
- Updated <a href="https://github.com/LebCit/the-clean-blog/blob/master/README.md">readme.md</a>

= 17.05.22 =
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
- Updated <a href="https://github.com/LebCit/the-clean-blog/blob/master/README.md">readme.md</a>

= 17.05.18 =
* Released: May 18, 2017
- Added new logic to Header Search Dropdown on resize.
- Changed nicename to nickname in thecleanblog_posted_on().
- Remove default -webkit-tap-highlight-color.
- Some Code Formatting.
- Updated <a href="https://github.com/LebCit/the-clean-blog/blob/master/README.md">readme.md</a>

= 17.05.13 =
* Released: May 13, 2017
- Added New Navigation.
- Made required changes after review for approval.
- Removed unneeded files and code from previous version after changes.
- Updated <a href="https://github.com/LebCit/the-clean-blog/blob/master/README.md">readme.md</a>

= 17.03.12 =
* Released: March 12, 2017
- Ajaxified header's background image
- Localized hero.js
- Renamed localized arrays' keys
- Updated <a href="https://github.com/LebCit/the-clean-blog/blob/master/README.md">readme.md</a>

= 17.02.20 =
* Released: February 20, 2017
- Added AJAX to contact form
- Added useful comments to contact-form.js
- Removed unnecessary code from contact-form.js and the-clean-blog-functions.php
- Updated <a href="https://github.com/LebCit/the-clean-blog/blob/master/README.md">readme.md</a>

= 17.02.15 =
* Released: February 15, 2017
- Changed thecleanblog_posted_on() function
- Changed Theme URI
- Added Contact Form Template + validate, sanitize an escape data
- Added Contact Form Styles
- Added JS validation to contact form with [jquery.validate.js](https://github.com/jquery-validation/jquery-validation)
- Made lightbox scripts load only if gallery detected on post or page
- Moved lightbox effect script to a separate file, imagegallery.js
- Removed .updated:not(.published) in style.css
- Updated <a href="https://github.com/LebCit/the-clean-blog/blob/master/README.md">readme.md</a>

= 17.01.31 =
* Released: January 31, 2017
- Changed $.scrollUp animation to remove Scroll-linked effects warning in Firefox
- Added lightbox effect to WordPress Galleries with [imageLightbox.js](https://github.com/osvaldasvalutis/imageLightbox.js)
- Updated <a href="https://github.com/LebCit/the-clean-blog/blob/master/README.md">readme.md</a>

= 17.01.27 =
* Released: January 27, 2017
- Changed top.png to to-top.png icon for license compatibility
- Added social sharing icons to posts
- Updated <a href="https://github.com/LebCit/the-clean-blog/blob/master/README.md">readme.md</a>

= 17.01.25 =
* Released: January 25, 2017
- Added escape on some functions to secure the output
- Corrected error in comments.php
- Updated <a href="https://github.com/LebCit/the-clean-blog/blob/master/README.md">readme.md</a>

= 17.01.21 =
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
- Updated <a href="https://github.com/LebCit/the-clean-blog/blob/master/README.md">readme.md</a>

= 14.01.17 =
* Released: January 14, 2017
- Changed the description of the theme
- Added fixed/reveal effect to footer with [footer-reveal.js](https://github.com/IainAndrew/footer-reveal)
- Putting some order in some files
- Removed outline on multiple link

= 10.01.17 =
* Released: January 10, 2017

Initial release

== Copyright ==

* The Clean Blog WordPress Theme, Copyright 2017 <a href="https://profiles.wordpress.org/lebcit">LebCit</a>
* The Clean Blog is distributed under the terms of the GNU GPLv2 or later

== Credits ==

* Based on <a href="https://github.com/BlackrockDigital/startbootstrap-clean-blog">Clean Blog</a>, © 2013-2016 <a href="https://github.com/BlackrockDigital">Blackrock Digital</a>, LLC., <a href="http://opensource.org/licenses/MIT">MIT</a>
* Based on <a href="https://github.com/Automattic/theme-components/">COMPONENTS</a>, © 2015-2016 <a href="https://automattic.com/">Automattic</a>, Inc., <a href="https://www.gnu.org/licenses/gpl-2.0.html">GPLv2 or later</a>
* Based on <a href="https://github.com/twbs/bootstrap">Bootstrap</a>, © 2011-2017 <a href="https://github.com/twbs">Bootstrap</a>, <a href="http://opensource.org/licenses/MIT">MIT</a>
* <a href="http://necolas.github.io/normalize.css/">normalize.css</a>, © 2012-2016 Nicolas Gallagher and Jonathan Neal, <a href="http://opensource.org/licenses/MIT">MIT</a>
* <a href="http://fontawesome.io/">Font Awesome Icons</a>, © <a href="https://twitter.com/davegandy">Dave Gandy</a>, <a href="http://scripts.sil.org/OFL">SIL OFL 1.1</a>
* Navigation Inspired By <a href="https://codyhouse.co/gem/secondary-sliding-navigation/">Secondary Sliding Navigation</a>, <a href="https://twitter.com/romano_cla">Claudia Romano</a>
* <a href="https://github.com/markgoodyear/scrollup">jQuery ScrollUp</a>, © <a href="https://github.com/markgoodyear">Mark Goodyear</a>, <a href="http://opensource.org/licenses/MIT">MIT</a>
* <a href="https://github.com/IainAndrew/footer-reveal">footer-reveal.js</a>, © <a href="https://github.com/IainAndrew">Iain Andrew</a>, <a href="http://opensource.org/licenses/MIT">MIT</a>
* <a href="https://github.com/osvaldasvalutis/imageLightbox.js">imageLightbox.js</a>, © 2014-2016 <a href="https://github.com/osvaldasvalutis">Osvaldas Valutis</a>, <a href="http://opensource.org/licenses/MIT">MIT</a>
* <a href="https://github.com/ConnorAtherton/loaders.css">loaders.css</a>, © 2016-2018 <a href="https://connoratherton.com/">Connor Atherton</a>, <a href="http://opensource.org/licenses/MIT">MIT</a>
* <a href="https://github.com/idiot/unslider">Unslider</a>, © 2012-2018 <a href="http://visualidiot.com">Charlotte Swift</a>, <a href="http://www.wtfpl.net/">WTFPL</a>
* Bundled header images :<br>
<a href="https://unsplash.com/search/search?photo=JuFcQxgCXwA">404-hero.jpg</a>, © <a href="https://unsplash.com/@samuelzeller">Samuel Zeller</a>, <a href="https://creativecommons.org/publicdomain/zero/1.0/">CC0 1.0</a><br>
<a href="https://unsplash.com/search/search?photo=azbZUNpu1Ag">search-hero.jpg</a>, © <a href="https://unsplash.com/@saeedanathema">Saeed Mhmdi</a>, <a href="https://creativecommons.org/publicdomain/zero/1.0/">CC0 1.0</a><br>
<a href="https://pixabay.com/en/people-adult-two-one-women-3142549/">default-hero.jpg</a>, © <a href="https://pixabay.com/en/users/melissaflor-7788859/">Melissa Angela Flor</a>, <a href="https://creativecommons.org/publicdomain/zero/1.0/">CC0 1.0</a>
* <a href="http://fa2png.io/r/font-awesome/arrow-circle-up/">to-top.png</a>, Generated with <a href="http://fa2png.io/">FA2PNG</a>, <a href="http://scripts.sil.org/OFL">SIL OFL</a>
