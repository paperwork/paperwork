<?php namespace Extensions;

class PaperworkCollection extends \Illuminate\Database\Eloquent\Collection {
   public function toApiArray($type = null) {
      $collection = parent::toArray();
      $collectionCount = count($collection);

      for($i = 0; $i < $collectionCount; $i++) {
         switch($type) {
            case 'notebooks':

            break;
         }
      }

      return $collection;
   }
}