( function( $ ) {
    "use strict";

    $(document).ready(function(){
        $( '.codeless-image-sizes-admin-tabs a' ).on( 'click', function() {
            $( '.codeless-image-sizes-admin-tabs a' ).removeClass( 'nav-tab-active' );
            $(this).addClass( 'nav-tab-active' );
            var $hash = $( this ).attr( 'href' ).substring(1);
            $( '.codeless-image-sizes-admin-table tr' ).hide();
            $( '[data-codeless-section="'+ $hash +'"]' ).show();
            return false;
        } );
    });
   

    


} ) ( jQuery );