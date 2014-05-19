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

| Page           | Rec Slot                   | Description                                    | Position |
|----------------|----------------------------|------------------------------------------------|----------|
| Warenkorb      | `cartpage-nosto-1`         | Customers Who Bought These Also Bought         | Bottom   |
| Warenkorb      | `cartpage-nosto-2`         | Products You Recently Viewed                   | Bottom   |
| Warenkorb      | `cartpage-nosto-3`         | Most Popular Right Now                         | Bottom   |
| Startseite     | `frontpage-nosto-1`        | Items you considered                           | Middle   |
| Startseite     | `frontpage-nosto-2`        | What other customers are looking at right now  | Middle   |
| Startseite     | `frontpage-nosto-3`        | Related to your past interests                 | Middle   |
| Startseite     | `frontpage-nosto-4`        | Hot sellers                                    | Middle   |
| Alle Seiten    | `pagetemplate-nosto-1`     | Your Recent History                            | Bottom   |
| Alle Seiten    | `pagetemplate-nosto-2`     | Items related to your interest                 | Bottom   |
| Artikelliste   | `productcategory-nosto-1`  | Most Popular Products In This Category         | Top      |
| Artikelliste   | `productcategory-nosto-2`  | Your Recent History                            | Top      |
| Artikeldetails | `productpage-nosto-2`      | You Might Also Like                            | Bottom   |
| Artikeldetails | `productpage-nosto-3`      | Most Popular Products In This Category         | Bottom   |
| Artikelliste   | `searchpage-nosto-1`       | Customers who searched "$searchTerm" viewed    | Top      |

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

![Imgur](http://i.imgur.com/8lMC4yS)

* Recommendations-Einstellungen: This tab allows you to configure your recommendation slots. You can disable the defaults or remove them entirely, if you want to add your own elements to your layout templates manually.
  * Shop-Seite: This is the type of page on which you would like the recommendation-slot to appear. Commonly used pages are "Startseite" (front-page), "Warenkorb" (shopping-cart), "Alle Seiten" (every page), "Artikeldetails" (product-page) and "Artikelliste" (for both the category-page and the search-results).
  * CSS-Selektor: This is the CSS selector of the element before or after which the recommendation-slot should appear. The CSS selector uses the same selector syntax as jQuery. 
  * pQuery-Methode: This field allows you to choose where you would like the recommendation to appear. Choosing "prepend" or "before" will cause your slot to appear before the selected element, while choosing "append" or "after" will cause the slot to appear after the selected element.
  * Recommendations-Slot-ID: This is the identifier of the recommendation-slot and should map to a slot defined in your Nosto account.
  * Aktiv: This drowdown field allows you to enable or disable your recommendation-slot. 
  * Aktion: These buttons "Speichern" and "Löschen" allow you to save or delete your slot respectively.

![Imgur](http://i.imgur.com/1rKuFG3) 
  

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
