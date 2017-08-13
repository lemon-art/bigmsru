<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

global $USER;
if( $_POST['ProductID'] && $_POST['ACTION'] == 'add' ){
      $ProductID = intval($_POST['ProductID']);
   
                     
      if(!$USER->IsAuthorized()){
        $arElements = unserialize($APPLICATION->get_cookie('favorites'));
        if(!in_array($ProductID, $arElements)) 
            $arElements[] = $ProductID;

        $APPLICATION->set_cookie("favorites",serialize($arElements));
      }
      else{
         $idUser = $USER->GetID();
         $rsUser = CUser::GetByID($idUser);
         $arUser = $rsUser->Fetch();
         $arElements = unserialize($arUser['UF_FAVORITES']);
        if(!in_array($ProductID, $arElements)) 
            $arElements[] = $ProductID;
         $USER->Update($idUser, Array("UF_FAVORITES"=>serialize($arElements)));
      }  
		
}
elseif ( $_POST['ProductID'] && $_POST['ACTION'] == 'delete' ){
	$ProductID = intval($_POST['ProductID']);
   
                     
      if(!$USER->IsAuthorized()){
        $arElements = unserialize($APPLICATION->get_cookie('favorites'));
        foreach ( $arElements as $key => $arElement){
			if ( $arElement == $ProductID ) {
				unset( $arElements[$key] );
			}
		}
        $APPLICATION->set_cookie("favorites",serialize($arElements));
      }
      else{
         $idUser = $USER->GetID();
         $rsUser = CUser::GetByID($idUser);
         $arUser = $rsUser->Fetch();
         $arElements = unserialize($arUser['UF_FAVORITES']);
        foreach ( $arElements as $key => $arElement){
			if ( $arElement == $ProductID ) {
				unset( $arElements[$key] );
			}
		}
         $USER->Update($idUser, Array("UF_FAVORITES"=>serialize($arElements)));
      }      
}

?>