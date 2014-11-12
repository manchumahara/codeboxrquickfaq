=== Codeboxr Quick FAQ ===
Contributors: manchumahara, codeboxr
Donate link: http://codeboxr.com
Tags: faq,shortcodes,pages
Requires at least: 3.0
Tested up to: 4.0
Stable tag: 1.2.1
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

 Codeboxr Quick FAQ for wordpress

== Description ==

 Codeboxr Quick FAQ for wordpress

Codeboxr Quick FAQ  is a WordPress plugin that will help you  to create a nice faq page with minimum effort and maximum options;
You can show all posts of custom post type CB Quick FAQs ,posts of any specific category with category name ,post of some categories with cat id.
One can also type faqs directly in any post or page .

if you want to write faqs directly the short code is

[codeboxrquickfaqwrap allfaqclose="0/1"  showcredit="0/1" color='#000000']
      [codeboxrquickfaq titlecolor="#000000" faqborder="#e4e4e4" title="Here is an example Question 1"]Here is the example answer 1. [/codeboxrquickfaq]
      [codeboxrquickfaq titlecolor="#000000" faqborder="#e4e4e4" title="Here is an example Question 2"]Here is the example answer 2. [/codeboxrquickfaq]
      [codeboxrquickfaq titlecolor="#000000" faqborder="#e4e4e4" title="Here is an example Question 3"]Here is the example answer 3. [/codeboxrquickfaq]
[/codeboxrquickfaqwrap]

args:

allfaqclose (default 1):

value 1 : Will close all other faq when you click one and keep first one open when page loaded
value 0 :All close when page loads first time ,you can keep all faq open at a time

showcredit (default 1):

value 1 : Will show a msg to show credit to codeboxr

color ((default #000000):

can change text color

titlecolor ((default #000000):

can change individual header text color

faqborder ((default #ffffff):

can change individual faq border color



shortcode for listing  custom post type /any post type posts as faq

[codeboxrquickfaqpost faqborder='#ffffff' color='#000000' showcredit='1' type='codeboxrquickfaqs' limit=2 allfaqclose=0 order='DSC' orderby='ID' category='' category_ids='' /]

args:

color ((default #000000):

can change text color

faqborder ((default #ffffff):

can change faq border color

showcredit (default 1):

value 1 : Will show a msg to show credit to codeboxr

type (default codeboxrquickfaqs):

post type name

limit (default -1):

post number

order (default 'DSC'):

post order

order (default 'ID'):

post order by field name


category (default ''):
Any category name of your selected post type

category ids (default ''):
Comma separeted category ids of your selected post type

Features:

*   Display accordian style faqs
*   Custom faq post type with category selection options
*   Onae can set the order,post number ,show or hide first faq when loaded etc.
*   Select any post type including custom or default post type

See more details and usages guide here http://codeboxr.com/product/quick-faq-manager-for-wordpress


== Installation ==

How to install the plugin and get it working.


1. Upload `codeboxrquickfaq` folder  to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. From 'demo' link for short codes
4. Create faq items add place the shortcode in any post ,or you can write questions and answers in any posts or page with shortcode in given format


== Frequently Asked Questions ==

= Can anyone show it in a specific page only ? =

yes

= Does this can show one or more category ? =

yes

= Is it possible to close all faq while reading one ? =

yes.

== Screenshots ==

1. Backend
2. Front View


== Changelog ==

= 1.2.1 =
* First Release

