$(document).ready(function(){
    var editor = CKEDITOR.replace( 'editor1' );
    CKFinder.setupCKEditor( editor );
    
    $('form#FormEditor1').submit(function(e){
        e.preventDefault();
        
    });
});


function ValorCKEditor(){
    var value = CKEDITOR.instances['editor1'].getData()
    
    console.log(value);
}