/**
 * Created by KosiakMD on 20.06.16.
 *
 * catalogView
 * change View Width of Catalog
 * small / middle / large - Width
 **/
"use strict"
//
function catalogView( type ){
    // if type and not default #tabs width
    if(!type && type !== 0){
        // if storage and Setting is in
        // read from localStorage Setting
        console.log("catalogView EMPTY", type);
        if( storage && storage.catalogView ){
            if(storage.catalogView == 1 ) return;
            type = +storage.catalogView;
            // write the Setting into data for "toggleFunc" order
            $("#tabs").data('toggleStatus', type - 1);
            // console.log("not 1")
        }else{
            return false;
        }
    }
    /*( !type && type !== 1 && type !== 0) && (
     console.log("catalogView EMPTY", type),
     // read from localStorage Settings
     type = +storage.catalogView,
     // write the Setting into data for "toggleFunc" order
     $("#tabs").data('toggleStatus', type - 1),
     // change icon for change-size if full-width (#3)
     type === 3 && $(".resize_content").toggleClass('glyphicon-resize-full glyphicon-resize-small')
     );*/
    console.log("catalogView HANDLER", type);
    var width, marginLeft;
    switch (type){
        case 0 : width = '', marginLeft = '';
            break;
        case 2 : width = '75%', marginLeft = '12.5%';
            break;
        case 3 : width = '100%', marginLeft = '0%';//screen.width, marginLeft = '0';
            break;
        case 1 : width = '50%', marginLeft = '25%';
            break;
        default: throw new Error("unReg arg for catalogView");
            break;
    }
    // save Setting to localStorage if type != 0
    // '0' only fpr default CSS
    type && (storage.catalogView = type);
    // unify handler
    var action = (type === 0) ? ('css') : 'animate' ;
    $('#tabs')[action]({
        width: width,
        marginLeft: marginLeft
    }, adaptation.bind(null, true, true) );
};

$("body")
//ON click, .resize_content
    .on("click", ".resize_content", function(){
        $('#tabs').toggleFunc([
                function(){
                    catalogView(2);
                    // $(this).toggleClass('col-md-6 col-md-offset-3');
                },
                function(){
                    catalogView(3);
                    $(".resize_content").toggleClass('glyphicon-resize-full glyphicon-resize-small');
                },
                function(){
                    catalogView(1);
                    $(".resize_content").toggleClass('glyphicon-resize-full glyphicon-resize-small');
                    // $(this).toggleClass('col-md-6 col-md-offset-3');
                }],
            function(){
                // console.log('always')
                // slideCatalog();
                // $('#tabs').data('toggleStatus') === 2
            }
        );
        // $(".resize_content").toggleClass('glyphicon-resize-full glyphicon-resize-small');
    });

$( window ).on('orientationchange', function(e, data){
    console.log('orientationchange',e.from, '--->', e.to)
    e.to === "portrait" ? catalogView(0) : catalogView();
});

// -------------- Window Loaded
window.onload = function() {
    ($.getOrientation() === "landscape") && catalogView();
};