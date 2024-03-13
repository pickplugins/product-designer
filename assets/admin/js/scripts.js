jQuery(document).ready(function($){


    $(function() {
        $( ".side-list, .sortable" ).sortable({ handle: '.move' });
        //$( ".items-container" ).disableSelection();
    });

    $(document).on('mouseenter','.side .preview',function(){

        src = $(this).attr('src');


    })



    $(document).on('click','.side .remove',function(){

        $(this).parent().parent().remove();

    })


    $(document).on('click','.template .remove-pre-template',function(){

        pre_template_id = $(this).attr('pre_template_id');
        pd_template_id = $(this).attr('pd_template_id');

        //console.log(pd_template_id);
        //console.log(pre_template_id);

        __this = this;

        $.ajax(
            {
                type: 'POST',
                url: product_designer_ajax.product_designer_ajaxurl,
                data: {"action": "product_designer_ajax_remove_pre_template","pd_template_id":pd_template_id,"pre_template_id":pre_template_id},
                success: function(response){

                    var data = JSON.parse( response );


                    status = data['status'];

                    if(status === 'deleted'){

                        $(__this).parent().parent().remove();
                    }


                    //console.log(status);
                    //console.log(pre_templates);

                }
            });




    })







    $(document).on('click','.side .side-part-remove',function(){

        data_preview = $(this).attr('data-preview');

        //console.log(data_preview);
        $(this).prev().attr('src',data_preview);
        $(this).prev().prev().val('');
    })





    $(document).on('click','.upload_side',function(e){

        var side_uploader;

        this_ = $(this);
        //alert(target_input);

        e.preventDefault();

        //If the uploader object has already been created, reopen the dialog
        if (side_uploader) {
            side_uploader.open();
            return;
        }
        //Extend the wp.media object
        side_uploader = wp.media.frames.file_frame = wp.media({
            title: 'Choose Image',
            button: {
                text: 'Choose Image'
            },
            multiple: false
        });
        //When a file is selected, grab the URL and set it as the text field's value
        side_uploader.on('select', function() {
            attachment = side_uploader.state().get('selection').first().toJSON();

            src_url = attachment.url;
            //console.log(attachment);

            $(this_).prev().val(src_url);
            $(this_).attr('src',src_url)


            //$('input[name=' + target_input + ']').val(attachment.url);
            //jQuery('#product_designer_front_img_preview').attr("src",attachment.url);
        });

        //Open the uploader dialog
        side_uploader.open();

    })



    $(document).on('click','.side-list li',function(event){

    })
});







