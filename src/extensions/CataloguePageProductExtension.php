<?php

namespace ilateral\SilverStripe\CataloguePage\Extensions;

use SilverStripe\ORM\DataExtension;
use SilverStripe\Control\Controller;
use ilateral\SilverStripe\CataloguePage\Model\CataloguePage;

class CataloguePageProductExtension extends DataExtension
{
    
    public function updateRelativeLink($base, $action)
    {
        $page = null;

        // Try to find the current product's page
        if ($this->owner->CataloguePages()->exists()) {
            $page = $this->owner->CataloguePages()->first();
        } elseif ($category = $this->owner->Categories()->first()) {
            if($category->CataloguePages()->exists()) {
                $page = $category->CataloguePages()->first();
            }
        }
        
        // If no page has been found, revert to a default
        if (!$page) {
            $page = CataloguePage::get()->first();
        }

        if ($page) {
            $link = Controller::join_links(
                $page->RelativeLink("product"),
                $this->owner->URLSegment,
                $action
            );
            
            return $link;
        }
        return $base;
    }
    
    public function updateAncestors($ancestors, $include_parent)
    {
        
        // Check if there is a catalogue page with this product
        $page = CataloguePage::get()
            ->filter("Products.ID", $this->owner->ID)
            ->first();
        
        if(!$page) {
            // Else check we have a product in a category that matches
            $categories = $this->owner->Categories();
            $page = null;
            
            // Find the first category page we have mapped
            foreach($categories as $category) {
                if(!$page && $category->CataloguePages()->exists()) {
                    $page = $category->CataloguePages()->first();
                }
            }
        }
        
        if($page) {
            // Clear all ancestors
            foreach ($ancestors as $ancestor) {
                $ancestors->remove($ancestor);
            }
            
            if ($include_parent) {
                $ancestors->push($page);
            }
            
            while ($page = $page->getParent()) {
                $ancestors->push($page);
            }
        }
    }
    
}
