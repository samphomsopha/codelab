$(function($){
    var assets = [];
    var myDropzone = new Dropzone("#profileForm", {url: "/services/profile/upload",
        paramName: 'image',
        previewsContainer : '.img-preview'});

    myDropzone.on("sending", function(file){
        $('.btn-submit').prop('disabled', true);
        $('#origImg').hide();
    });
    myDropzone.on("success", function(file, data){
        $('input:hidden[name=assetId]').val(data.data.asset.id),
        $('.btn-submit').prop('disabled', false);
    });
});