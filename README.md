# Silverstripe Realm-Category Module

A custom page type that either allows:

Mapping of topics (defined via config) to a CMS page

Or

Mapping of multiple topic categories to a page in the CMS that then
renders them (and their posts) into a template.

The page type also includes a $PaginatedChildren variable to allow
automatically breaking up larger product lists into smaller pages.

## Installation

The easiest way to install this module is via composer:

    # 
    
Otherwise install and download this module to the "cataloguepage" folder
in your project root.

## Requirements

* Silverstripe Framework 5.0
* Silverstripe CMS 5.0

### Recommended



### Custom Realm or Categories

To customise the Realm and Category objects that are used via this
page, you will need to change the **"realm_class"** and **"category_class"**
config variables on RealmCatPage.

It is important to be aware that RealmCatPage will attempt to hand over
the current request to a controller identified by the
**"base_product_controller"** config variable. You will need to ensure
that you create a conntroller that can render your product.

The easiest way to do this is to set it in your config.yml as below:

```
pdlussier\SilverStripe\RealmCat\Model\RealmCatPage:
  realm_class: 'Realm'
  topic_class: 'Category'
  base_product_controller: 'RealmController'
```

## Usage

Setup the catalogue as normal (add categories and then add products to
them).

Then add a catalogue page.

Once the page is created, you should have "Products" and "Categories"
tabs in the CMS, use this to add categories that will be displayed on
this page.


config.yml

    Catalogue:
      enable_frontend: false

_config.php
    
    Catalogue::config()->enable_frontend = false;


