<?php 
 
class TOOLS {
     
  public function __construct(){}
 
  public static function trunc($phrase, $max_words) {
   $phrase_array = explode(' ',$phrase);
   if(count($phrase_array) > $max_words && $max_words > 0)
      $phrase = implode(' ',array_slice($phrase_array, -2, $max_words));
   return $phrase;
}  
}
 
?>
