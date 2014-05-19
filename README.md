# Nosto Tagging for JTLShop 3

## Description

The module integrates the Nosto marketing automation service, that can produce personalized product recommendations on
the site.

The module adds the needed data to the site through JTLShop's hook system. There are two types of data added by the
module; tagging blocks and nosto elements.

Tagging blocks are used to hold meta-data about products, categories, orders, shopping cart and customers on your site.
These types of blocks do not hold any visual elements, only meta-data. The meta-data is sent to the Nosto marketing
automation service when customers are browsing the site. The service then produces product recommendations based on the
information that is sent and displays the recommendations in the nosto elements.

Nosto elements are placeholders for the product recommendations coming from the Nosto marketing automation service. The
elements consist of only an empty div element that is populated with content from the Nosto marketing automation
service.

By default the module creates the following nosto elements:

* 3 elements for the product page
	* "Other Customers Were Interested In" ( nosto-page-product1 )
	* "You Might Also Like"  ( nosto-page-product2 )
	* "Most Popular Products In This Category"  ( nosto-page-product3 )
* 3 elements for the shopping cart page
	* "Customers Who Bought These Also Bought" ( nosto-page-cart1 )
	* "Products You Recently Viewed" ( nosto-page-cart2 )
	* "Most Popular Right Now" ( nosto-page-cart3 )
* 2 elements for the product category page, top and bottom
	* "Most Popular Products In This Category" ( nosto-page-category1 )
	* "Your Recent History" ( nosto-page-category2 )
* 2 elements for the search results page, top and bottom
	* "Customers who searched '{search term}' viewed" ( nosto-page-search1 )
	* "Your Recent History" ( nosto-page-search2 )
* 2 elements for the sidebars, 1 left and 1 right
	* "Popular Products" ( nosto-column-left )
	* "Products You Recently Viewed" ( nosto-column-right )
* 2 elements for all pages, top and bottom
	* "Products containing '{keywords}'" ( nosto-page-top )
	* "Products You Recently Viewed" ( nosto-page-footer )
	

Note that you can change what recommendations are shown in which nosto elements. You can also add additional elements
to the site by simply dropping in div elements of the following format:
'`<div class="nosto_element" id="{id of your choice}"></div>`'

## Installation

Please refer to the JTLShop documentation on how to get the module to appear in your installation admin section.

Once the module appears in your installation, you must install it into the store. Navigate to the "Modules" section and
locate the module, it will show up under the "Verfügbare (nicht installierte) Plugins" section. The installation is done simply by
selecting the plugin and clicking the "Installieren" button on the bottom of the list. Once installed, the plugin will appear in the "Installierte Plugins".

## Configuration

Once you have installed the module, you need to configure it. This is done by clicking the "Plugins" menu, choosing "Plugins" and clicking "Nosto". This will open a new page with two tabs that allows you to configure your plugin:

* The first tab is called "System-Einstellungen" which allows you to configure your account names. You should see an account name field for each language that you have enabled on your site. This allows you to use separate accounts for separate languages. If you'd like to use the same account for all languages, simply use the same account name in each field.
* Recommendations-Einstellungen: This tab allows you to configure your recommendation slots. You can disable the defaults or remove them entirely, if you want to add your own elements to your layout templates manually.
  * Shop-Seite: This is the type of page on which you would like the recommendation-slot to appear. Commonly used pages are "Startseite" (front-page), "Warenkorb" (shopping-cart), "Alle Seiten" (every page), "Artikeldetails" (product-page) and "Artikelliste" (for both the category-page and the search-results).
  * CSS-Selektor: This is the CSS selector of the element before or after which the recommendation-slot should appear. The CSS selector uses the same selector syntax as jQuery. 
  * pQuery-Methode: This field allows you to choose where you would like the recommendation to appear. Choosing "prepend" or "before" will cause your slot to appear before the selected element, while choosing "append" or "after" will cause the slot to appear after the selected element.
  * Recommendations-Slot-ID: This is the identifier of the recommendation-slot and should map to a slot defined in your Nosto account.
  * Aktiv: This drowdown field allows you to enable or disable your recommendation-slot. 
  * Aktion: These buttons "Speichern" and "Löschen" allow you to save or delete your slot respectively.

## License

Open Software License ("OSL") v. 3.0

## Dependencies

JTLShop version 3.x

## Changelog

* 1.0.0
	* Initial release
* 1.0.1
  * Minor fixes
* 1.0.2
  * Support for language-specific accounts
  * Added support for default recommendation slots.
