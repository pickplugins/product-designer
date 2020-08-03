jQuery(document).ready(function($){

    editorTabNavs = document.querySelectorAll('.editor-tab-navs .nav');
    tabsContent = document.querySelectorAll('.editor-tab-content');








    tools_tabs_switch();

    function tools_tabs_switch(activeTab = 0){

        i = 0;
        editorTabNavs.forEach((tabNav) => {
            content = tabsContent[i]

            tabNav.classList.remove("active");
            tabNav.classList.remove("inactive");

            content.classList.remove("active");
            content.classList.remove("inactive");


            if(i == activeTab){

                tabNav.classList.add("active");
                content.classList.add("active");
                content.style.display = 'block';

            }else{
                tabNav.classList.add("inactive");
                content.classList.add("inactive");
                content.style.display = 'none';
            }
            i++;
        });

    }


// Listen click event for tabs
//
    editorTabNavs.forEach((nav) => {
        nav.addEventListener('click', () => {

            dataId = nav.getAttribute('data-id');
            data_id_nav = 'data-id-'+dataId;

            editorTabNavs.forEach((navItem) => {
                navClasses = navItem.className;
                navItem.classList.remove("active");

                nav.classList.add("active");
            })

            tabsContent.forEach((tabContent) => {
                tabContentClasses = tabContent.className;

                if(tabContentClasses.indexOf(data_id_nav) < 0){
                    tabContent.style.display = 'none';
                }else{
                    tabContent.style.display = 'block';
                }

            });

        });
    });




















    $('.scrollbar').scrollbar();
    $('.product-designer .tabs').tabs();
    //alert('Hello');

    //console(typeof canvas);


    function product_designer_editor_busy(status, message, icon){

        if(status=='busy'){
            $('.product-designer .editor-busy').fadeIn();
            $('.product-designer .editor-busy .message').html(message);
            $('.product-designer .editor-busy .icon').html(icon);
        }
        else if(status=='ready'){

            $('.product-designer .editor-busy .message').html(message);
            $('.product-designer .editor-busy .icon').html(icon);

            setTimeout( function () {
                $('.product-designer .editor-busy').fadeOut();
            }, 300)
        }
    }


    function product_designer_editor_toast(icon, message){

        if(icon == "" || icon == null){
            icon = '<i class="fa fa-check"></i>';
        }

        $('.product-designer .toast').addClass("active");
        $('.product-designer .toast .message').html(message);
        $('.product-designer .toast .icon').html(icon);

        setTimeout( function () {
            $('.product-designer .toast').removeClass("active");
        }, 2000);


    }




    function product_designer_editor_save(){

        canvas.renderAll();

       ////console("Active side id:"+ current_side_id);

        if (typeof product_designer_editor.side_serialized_data[current_side_id] == "undefined")
            product_designer_editor.side_serialized_data[current_side_id] = ["{}"];




        json_stringify = JSON.stringify(canvas);
        json = canvas.toJSON();
        product_designer_editor.side_serialized_data[current_side_id] = json_stringify;
        product_designer_editor.side_json_data[current_side_id] = json;

        ////console(json);

        base_64 = canvas.toDataURL('png');



        //$('.product-designer .menu .loading').fadeIn();
        product_designer_get_object_list();


    }













    $(document).on('click','.side-list li',function(event){

        side_id = $(this).attr('side_id');
        $(".side-list li").removeClass("active");
        $(this).addClass("active");
        side_data = product_designer_editor.side_data;
        current_side_data = side_data[side_id];

        if (typeof product_designer_editor.side_serialized_data[current_side_id] == "undefined")
            product_designer_editor.side_serialized_data[current_side_id] = ["{}"];


        if (typeof current_side_data['background_fit_canvas_size'] != "undefined"){
            var background_fit_canvas_size = current_side_data['background_fit_canvas_size'];
        }

        if (typeof current_side_data['overlay_fit_canvas_size'] != "undefined"){
            var overlay_fit_canvas_size = current_side_data['overlay_fit_canvas_size'];
        }


        product_designer_editor_toast('','Side loaded.');

        json = JSON.stringify(canvas);
        product_designer_editor.side_serialized_data[current_side_id] = json;




        if(current_side_id != side_id){

            current_side_id = side_id;
            //product_designer_editor_save();
            if (typeof product_designer_editor.side_serialized_data[current_side_id] == "undefined"){
                product_designer_editor.side_serialized_data[current_side_id] = ["{}"];
                //canvas.clear();
                // Canvas default background images
                if(background_fit_canvas_size == 1){

                    canvas.setBackgroundImage(current_side_data['background'], canvas.renderAll.bind(canvas),{
                        // Needed to position backgroundImage at 0/0
                        originX: 'left',
                        originY: 'top',
                        width: canvas.width,
                        height: canvas.height,
                    });

                }
                else{

                    canvas.setBackgroundImage(current_side_data['background'], canvas.renderAll.bind(canvas),{
                        // Needed to position backgroundImage at 0/0
                        originX: 'left',
                        originY: 'top',
    //            width: canvas.width,
    //            height: canvas.height,
                    });

                }


                if(overlay_fit_canvas_size == 1){
                    canvas.setOverlayImage(current_side_data['overlay'], canvas.renderAll.bind(canvas), {
                        // Needed to position overlayImage at 0/0
                        originX: 'left',
                        originY: 'top',
                        width: canvas.width,
                        height: canvas.height, // canvas.height
                    });
                }
                else{
                    canvas.setOverlayImage(current_side_data['overlay'], canvas.renderAll.bind(canvas), {
                        // Needed to position overlayImage at 0/0
                        originX: 'left',
                        originY: 'top',
                        //width: canvas.width,
                        //height: 'auto', // canvas.height
                    });
                }

            }

        }




    canvas.renderAll();
    canvas.loadFromJSON(product_designer_editor.side_serialized_data[current_side_id], function () {
        //applyImageFilters();

        canvas.renderAll.bind(canvas);

        var multiplier = 1;

        var base_64 = canvas.toDataURL({format:'png'});
        var svg = "";

        //svg = canvas.toSVG();

        product_designer_editor['side_ids_preview_data'][current_side_id] = base_64;

        ////console(product_designer_editor['side_ids_preview_data']);


        //product_designer_editor_update_previews();

    });




    ////console(product_designer_editor.side_serialized_data[current_side_id]);



})

function product_designer_editor_update_previews(){

     var side_data_ids = product_designer_editor.side_data_ids;


    ////console(product_designer_editor.side_ids_preview_data);
    html = '';
    html_input = '';
    for(i=0; i<side_data_ids.length; i++){



        side_id = side_data_ids[i];
        if (typeof product_designer_editor.side_ids_preview_data[side_id] != "undefined"){

            html += '<div class="item" title="'+side_id+'">';
            html += '<div class="preview-object"> <img src="'+product_designer_editor.side_ids_preview_data[side_id]+'"></div>';

            html += '<div class="preview-name">Front side</div>';
            html += '<div class="inc-preview"><label><input class="inc_side_to_cart" type="checkbox" value="'+product_designer_editor.side_ids_preview_data[side_id]+'" >Include to cart</label></div>';
            html += '</div>';
           // html += '<input type="text" name="custom_design[]" value="'+product_designer_editor.side_ids_preview_data[side_id]+'" >';
        }




    }

    $('.output-side-items').html(html);




}

function product_designer_inc_attach_ids_to_cart(side_id, attach_id, attach_url, action){

    var side_serialized_data = product_designer_editor.side_serialized_data;
    var side_json_data =product_designer_editor.side_json_data;


    ////console(side_json_data);

    if(action=='add'){
        product_designer_editor.cart_attach_ids[side_id] = {'attach_id':attach_id, 'attach_url': attach_url };
        //product_designer_editor.cart_attach_ids[side_id]['attach_url'] = attach_url;
        cart_attach_ids = product_designer_editor.cart_attach_ids;

    }
    else if(action == 'remove'){
        delete product_designer_editor.cart_attach_ids[side_id];
        cart_attach_ids = product_designer_editor.cart_attach_ids;


    }



    html = '';
    html_json = '';

    for(var key in cart_attach_ids){


        attach_id = cart_attach_ids[key]['attach_id'];
        attach_url = cart_attach_ids[key]['attach_url'];

        html += '<input type="text" value="'+attach_id+'" name="product_designer_side_attach_ids['+key+']">';
        html_json += '<textarea  name="product_designer_side_ids_json['+key+']">'+side_serialized_data[key]+'</textarea>';


    }

    $('.output-side-items-attach-ids').html(html);
    $('.output-side-items-json').html(html_json);


    //console(cart_attach_ids);

    var total_side = 0;
    for(var i in cart_attach_ids) {
        total_side += 1;
    }





    if( total_side > 0 ){
        $('.pd-addtocart').addClass('active');
        $('.pd-save-template').addClass('active');


    }
    else{

        $('.pd-addtocart').removeClass('active');
        $('.pd-save-template').removeClass('active');

    }


}







$(document).on('click', ".pd-save-template", function(event) {

    event.preventDefault();
    var values = $('.product-designer .cart').serialize();
    product_designer_editor_busy('busy', 'Working...', '<i class="fa fa-spinner fa-spin"></i>');

    $.ajax(
        {
            type: 'POST',
            context: this,
            url:product_designer_ajax.product_designer_ajaxurl,
            data: {
                "action"		: "product_designer_ajax_save_as_template",
                "values"	: values,
            },
            success: function(response){

                var data = JSON.parse( response );
                var form_data	= data['form_data'];
                var msg	= data['msg'];
                //console(form_data);

                $('.product-designer-notice .notices').html(msg).fadeIn();
                $('.product-designer-notice').fadeIn();

                product_designer_editor_busy('ready', 'Ready...', '<i class="fa fa-check"></i>');

                //$(this).html( __HTML__ );
                // window.location.replace( data['cart_url'] );
            }
        });

})




$(document).on('submit', ".product-designer .cart", function(event) {

    event.preventDefault();
    product_designer_editor_busy('busy', 'Working...', '<i class="fa fa-spinner fa-spin"></i>');

    var values = $(this).serialize();
    //__HTML__ = $(this).html();
    //$(this).html( 'Adding...' );




    $.ajax(
        {
            type: 'POST',
            context: this,
            url:product_designer_ajax.product_designer_ajaxurl,
            data: {
                "action"		: "product_designer_ajax_add_to_cart",

                "product_id"	: product_id,
                "variation_id"	: variation_id,
                "values"	: values,
            },
            success: function(response){

                var data = JSON.parse( response );
                var form_data	= data['form_data'];
                var msg	= data['msg'];
                //console(form_data);

                $('.product-designer-notice .notices').html(msg).fadeIn();
                $('.product-designer-notice').fadeIn();

                product_designer_editor_busy('ready', 'Ready...', '<i class="fa fa-check"></i>');

                //$(this).html( __HTML__ );
               // window.location.replace( data['cart_url'] );
            }
        });

})









        $(document).on('click','.inc_side_to_cart',function(event){

            _this = this;
            base_64 = $(this).val();
            side_id = $(this).attr('side_id');

            if($(this).is(':checked')){

                product_designer_editor_busy('busy', 'Working...', '<i class="fa fa-spinner fa-spin"></i>');
                product_designer_editor_toast('<i class="fa fa-spinner fa-spin" ></i>','Please wait, adding to cart');

                $.ajax({
                    type: 'POST',
                    url: product_designer_ajax.product_designer_ajaxurl,
                    data: {"action": "product_designer_ajax_temp_save_side_output","product_id":product_id, "base_64":base_64},
                    success: function(response){

                        var data = JSON.parse( response );
                        attach_id = data['attach_id'];
                        attach_url = data['attach_url'];
                        //_this.setAttribute("attach_id", attach_id);
                        product_designer_inc_attach_ids_to_cart(side_id, attach_id, attach_url, 'add');

                        ////console('Temp Save done');

                        product_designer_editor_toast('<i class="fa fa-check" ></i>','Added to cart.');
                        product_designer_editor_busy('ready', 'Ready...', '<i class="fa fa-check"></i>');
                    }
                });

            }
            else{


                $.ajax({
                    type: 'POST',
                    url: product_designer_ajax.product_designer_ajaxurl,
                    data: {"action": "product_designer_ajax_delete_attach_id","attach_id":attach_id},
                    success: function(response){

                        var data = JSON.parse( response );
                        status = data['status'];

                        if(status == 'success'){
                            product_designer_inc_attach_ids_to_cart(side_id, attach_id, '', 'remove');
                            product_designer_editor_toast('<i class="fa fa-trash" ></i>','Removed from cart');
                        }
                        else{
                            product_designer_editor_toast('<i class="fa fa-spinner fa-spin" ></i>','Something went wrong.');
                        }




                    }
                });







            }



        })


$(document).on('click','.generate-side-output',function(event){

    event.preventDefault();
    var output_file_format = product_designer_editor.output_file_format;
    var side_serialized_data = product_designer_editor.side_serialized_data;
    var side_data_ids = product_designer_editor.side_data_ids;
    var side_data = product_designer_editor.side_data;

    var inc_preview_background = side_data[current_side_id].inc_preview_background;
    var inc_preview_overlay = side_data[current_side_id].inc_preview_overlay;

    console.log(output_file_format);


    product_designer_editor_busy('busy', 'Working...', '<i class="fa fa-spinner fa-spin"></i>');

    // Remove overlayImage
    if( inc_preview_overlay !=1 ){
        canvas.overlayImage = null;
    }

    // Remove backgroundImage
    if( inc_preview_background !=1 ){
        canvas.backgroundImage = null;
    }

    ////console(side_data_ids);
    ////console(side_serialized_data);
    ////console(side_data);

    ////console(side_serialized_data);

    $('.output-side-items').html('');



    function loop_through_sides(i){

        if(i > -1) {


            canvas.clear();


            setTimeout( function () {

                side_id = side_data_ids[i];

                ////console(i +':'+ side_id);
                console.log(side_serialized_data[side_id]);

                if (typeof side_serialized_data[side_id] != "undefined"){


                    canvas.loadFromJSON(product_designer_editor.side_serialized_data[side_id], function () {

                        if(output_file_format == 'png' || output_file_format == 'jpeg'){

                            canvas.renderAll();
                            base_64 = canvas.toDataURL({format: 'png'});

                            html = '';

                            html += '<div class="item" title="'+side_id+'">';
                            html += '<div class="preview-object"> <img src="'+base_64+'"></div>';
                            html += '<div class="preview-name">'+side_data[side_id]['name']+'</div>';
                            html += '<div class="inc-preview"><label><input class="inc_side_to_cart" type="checkbox" side_id="'+side_id+'" value="'+base_64+'" name="product_designer">Include to cart</label></div>';
                            html += '</div>';


                            $('.output-side-items').append(html);

                        }else if(output_file_format == 'svg' ){

                            canvas.renderAll();
                            var svg = canvas.toSVG();

                            html = '';

                            html += '<div class="item" title="'+side_id+'">';
                            html += '<div class="preview-object">'+svg+'</div>';
                            html += '<div class="preview-name">'+side_data[side_id]['name']+'</div>';
                            html += '<div class="inc-preview"><label><input class="inc_side_to_cart" type="checkbox" side_id="'+side_id+'" value="" name="product_designer">Include to cart</label></div>';
                            html += '</div>';


                            $('.output-side-items').append(html);

                        }

                        $('.output-side-items').fadeIn();

                    });

                }

                loop_through_sides(--i);

            }, 3000);

        }
        else{
            product_designer_editor_busy('ready', 'Ready...', '<i class="fa fa-check"></i>');

        }





    }


    var total_side_count = side_data_ids.length;
    loop_through_sides(total_side_count-1);


})









        $(document).on('click','.product-designer .editor-preview',function(){


            ////console(side_data[current_side_id]);

            var inc_preview_background = side_data[current_side_id].inc_preview_background;
            var inc_preview_overlay = side_data[current_side_id].inc_preview_overlay;
            var preview_file_format = product_designer_editor.preview_file_format;

            //console(preview_file_format);



            // Remove overlayImage
            if( inc_preview_overlay !=1 ){
                canvas.overlayImage = null;
            }

            // Remove backgroundImage
            if( inc_preview_background !=1 ){
                canvas.backgroundImage = null;
            }


            //product_designer_editor_save();



            canvas.renderAll();

            if(preview_file_format == 'png' || preview_file_format == 'jpeg'){

                base_64 = canvas.toDataURL({format: preview_file_format});

                $('.product-designer .preview-img .img').html('<img src="'+base_64+'">');
                $('.product-designer .preview').fadeIn();
            }
            else if(preview_file_format = 'svg'){

                var svg = canvas.toSVG();

                $('.product-designer .preview-img .img').html(svg);
                $('.product-designer .preview').fadeIn();

            }
            // //console(base_64);

        })


        $(document).on('click','.product-designer .preview-close',function(){

            $('.product-designer .preview').fadeOut();

            ////console(canvas.getObjects());


        })




        $(document).on('click','.product-designer .editor-download',function(event){

            event.preventDefault();

            var preview_file_format = product_designer_editor.preview_file_format;

            // base_64 = canvas.toDataURL({format: preview_file_format});
            //
            // //console(base_64);
            //
            // window.open(base_64, '_blank');

            if(preview_file_format == 'png' || preview_file_format == 'jpeg'){
                const dataURL = canvas.toDataURL({
                    width: canvas.width,
                    height: canvas.height,
                    left: 0,
                    top: 0,
                    format: preview_file_format,
                });
                const link = document.createElement('a');
                link.download = 'download.'+preview_file_format;
                link.href = dataURL;
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
            }else if(preview_file_format == 'svg'){


                var trsvg = canvas.toSVG();

                var dataUrl = 'data:image/svg+xml,'+encodeURIComponent(trsvg);

                //console(dataUrl);
                //window.open(trsvg, '_blank');

                var dl = document.createElement("a");
                document.body.appendChild(dl); // This line makes it work in Firefox.
                dl.setAttribute("href", dataUrl);
                dl.setAttribute("download", "download.svg");
                dl.click();

            }






        })




        $(document).on('change','#clipart-cat',function(){

            $('.product-designer .menu .loading').fadeIn();

            var cat = $(this).val();

            $.ajax(
                {
            type: 'POST',
            url: product_designer_ajax.product_designer_ajaxurl,
            data: {"action": "product_designer_ajax_get_clipart_list","cat":cat},
            success: function(data)
                {

                    var response 		= JSON.parse(data)
                    var clip_list 	= response['clip_list'];
                    var paginatioon 	= response['paginatioon'];

                    $('.clipart-list').html(clip_list);
                    $('.clipart-pagination').html(paginatioon);
                    $('.product-designer .menu .loading').fadeOut();

                }
            });

	})


	$(document).on('click','.clipart-pagination .page-numbers',function(event){

		event.preventDefault();
		cat = $('#clipart-cat').val();
		paged = $(this).text();

		$('.product-designer .menu .loading').fadeIn();

		$.ajax(
			{
		type: 'POST',
		url: product_designer_ajax.product_designer_ajaxurl,
		data: {"action": "product_designer_ajax_paged_clipart_list","paged":paged,"cat":cat},
		success: function(data)
				{

					var response 		= JSON.parse(data)
					var clip_list 	= response['clip_list'];
					var paginatioon 	= response['paginatioon'];

					$('.clipart-list').html(clip_list);
					$('.clipart-pagination').html(paginatioon);
					$('.product-designer .menu .loading').fadeOut();
				}
			});

		})

    window.addEventListener("keydown", function(e){
        /*
         * keyCode: 8
         * keyIdentifier: "U+0008"
        */
       // e.preventDefault();

        console.log(e.keyCode);
        console.log(e.shiftKey);

        if(e.keyCode == 46){
            var selected_object = canvas.getActiveObject();

            if(selected_object != null){
                selected_object.remove();
                product_designer_editor_toast('<i class="fa fa-trash-o"></i>','Selected item deleted.');
            }
            else{
                product_designer_editor_toast('<i class="fa fa-exclamation-circle"></i>','Please select item first.');
            }
        }


        if(e.shiftKey && e.keyCode == 46){
            canvas.clear();

            canvas.renderAll();

            json = JSON.stringify(canvas);

            product_designer_editor_toast('','Editor cleared.');

            product_designer_editor_save();
        }



    });


        $(document).on('touchstart click','.product-designer #editor-clear',function(e){

            e.preventDefault();
            var $this = $(this);

            canvas.clear();

            canvas.renderAll();

            json = JSON.stringify(canvas);

            product_designer_editor_toast('','Editor cleared.');

            product_designer_editor_save();

        })


        $(document).on('touchstart click','.product-designer #editor-show-grid',function(e){

            e.preventDefault();
            $(".product-designer .upper-canvas").toggleClass("canvas-grid");

            //console('Clear');



            product_designer_editor_save()
        })


        $(document).on('touchstart click','.product-designer #editor-delete-item',function(e){


            e.preventDefault();
            var selected_object = canvas.getActiveObject();

            //console(selected_object);

            if(selected_object != null){
                selected_object.remove();
                product_designer_editor_toast('<i class="fa fa-trash-o"></i>','Selected item deleted.');
            }
            else{
                product_designer_editor_toast('<i class="fa fa-exclamation-circle"></i>','Please select item first.');
            }




            product_designer_editor_save()


        })

        $(document).on('touchstart click','.product-designer #editor-clone-item',function(e){

            e.preventDefault();
            var selected_object = canvas.getActiveObject();

            if(selected_object != null){

                var new_object = fabric.util.object.clone(selected_object);
                new_object.set("top", new_object.top + 10);
                new_object.set("left", new_object.left + 10);
                canvas.add(new_object);

                product_designer_editor_toast('<i class="fa fa-clone"></i>','Selected item cloned.');
            }
            else{
                product_designer_editor_toast('<i class="fa fa-exclamation-circle"></i>','Please select item first.');
            }

            //canvas.getActiveObject().clone();
            canvas.renderAll();

            product_designer_editor_save()

            //console('delete');
        })



        $(document).on('touchstart click','.product-designer #editor-DrawingMode',function(e){

            var $this = $(this);

            if($this.hasClass('active')){
                $this.removeClass('active').addClass('inactive')
                //canvas.getActiveObject().set("flipY", false);

                canvas.isDrawingMode = false;
                product_designer_editor_toast('<i class="fa fa-pencil"></i>','Drawing mode disabled.');
            }else{
                $this.removeClass('inactive').addClass('active');
                //canvas.getActiveObject().set("flipY", true);
                canvas.isDrawingMode = true;

                product_designer_editor_toast('<i class="fa fa-pencil"></i>','Drawing mode enabled.');
            }
            product_designer_editor_save()
            //console('DrawingMode');

        })


        $(document).on('touchstart click','.product-designer #editor-zoomin',function(e){

            canvas.setZoom(canvas.getZoom() + 0.10 ) ;
            zoom_val = (canvas.getZoom() -1);

            product_designer_editor_toast('<i class="fa fa-search-plus"></i>', '+'+zoom_val.toFixed(2)*100+'% Zoom-in.');
            product_designer_editor_save()
        })



        $(document).on('touchstart click','.product-designer #editor-zoomout',function(e){

            canvas.setZoom(canvas.getZoom() - 0.10 ) ;
            zoom_val = (canvas.getZoom() -1);

            product_designer_editor_toast('<i class="fa fa-search-plus"></i>', zoom_val.toFixed(2)*100+'% Zoom-out.');
            product_designer_editor_save()
        })


        $(document).on('click','.product-designer #editor-pan',function(){

            var $this = $(this);
            var panning = false;

            if($this.hasClass('active')){
                $this.removeClass('active').addClass('inactive')
                //canvas.getActiveObject().set("lockMovementY", false);
                $(this).attr('title','Panning On');

                canvas.selection = true;

                product_designer_editor_toast('<i class="fa fa-hand-paper-o"></i>', 'Panning disabled.');


            }else{
                $this.removeClass('inactive').addClass('active');
                //canvas.getActiveObject().set("lockMovementY", true);
                $(this).attr('title','Panning On');

                canvas.selection = false;
                product_designer_editor_toast('<i class="fa fa-hand-paper-o"></i>', 'Panning enabled.');

                var panning = false;

                canvas.on('mouse:up', function (e) {

                    panning = false;
                });

                canvas.on('mouse:down', function (e) {
                    panning = true;

                });
                canvas.on('mouse:move', function (e) {
                    if (panning && e && e.e && canvas.selection==false) {
                        //debugger;
                        var units = 10;
                        var delta = new fabric.Point(e.e.movementX, e.e.movementY);
                        canvas.relativePan(delta);
                    }
                });






            }
            //val = $(this).val();


            //canvas.getActiveObject().setAngle(val);
            //canvas.getActiveObject().set("textDecoration", 'line-through');
            canvas.renderAll();
            ////console(val);
            product_designer_editor_save()
        })












        $(document).on('touchstart click','.product-designer #editor-item-bringForward',function(e){

            var selected_object = canvas.getActiveObject();

            if(selected_object != null){
                canvas.bringForward(selected_object);
                product_designer_editor_toast('<i class="cpd-icon-move-up"></i>', 'Selected item brought to forward.');
            }
            else{
                product_designer_editor_toast('<i class="fa fa-exclamation-circle"></i>','Please select item first.');
            }

            canvas.renderAll();
            product_designer_editor_save()
        })


        $(document).on('touchstart click','.product-designer #editor-item-sendBackwards',function(e){

            var selected_object = canvas.getActiveObject();

            if(selected_object != null){
                canvas.sendBackwards(selected_object);
                product_designer_editor_toast('<i class="cpd-icon-move-down"></i>', 'Selected item take backward.');
            }
            else{
                product_designer_editor_toast('<i class="fa fa-exclamation-circle"></i>','Please select item first.');
            }

            canvas.renderAll();
            product_designer_editor_save()
        })





        $(document).on('touchstart click','.product-designer #editor-flip-v',function(){

            var selected_object = canvas.getActiveObject();
            var $this = $(this);

            if(selected_object != null){

                if($this.hasClass('active')){
                    $this.removeClass('active').addClass('inactive')
                    selected_object.set("flipY", false);
                }else{
                    $this.removeClass('inactive').addClass('active');
                    selected_object.set("flipY", true);
                }

                product_designer_editor_toast('<i class="cpd-icon-flip-vertical"></i>', 'Selected item flipped vertically.');
            }
            else{
                product_designer_editor_toast('<i class="fa fa-exclamation-circle"></i>','Please select item first.');
            }




            canvas.renderAll();
            //console('flipY');
            product_designer_editor_save()

        })


        $(document).on('touchstart click','.product-designer #editor-flip-h',function(){

            var selected_object = canvas.getActiveObject();
            var $this = $(this);


            if(selected_object != null){
                if($this.hasClass('active')){
                    $this.removeClass('active').addClass('inactive')
                    selected_object.set("flipX", false);
                }else{
                    $this.removeClass('inactive').addClass('active');
                    selected_object.set("flipX", true);
                }
                product_designer_editor_toast('<i class="cpd-icon-flip-horizontal"></i>', 'Selected item flipped horizontally.');
            }
            else{
                product_designer_editor_toast('<i class="fa fa-exclamation-circle"></i>','Please select item first.');
            }

            canvas.renderAll();
            product_designer_editor_save()

        })


        $(document).on('touchstart click','.product-designer #editor-center-h',function(){

            var selected_object = canvas.getActiveObject();

            if(selected_object != null){
                selected_object.centerH();
                product_designer_editor_toast('<i class="cpd-icon-align-horizontal-middle"></i>','Selected item align horizontally middle');
            }
            else{
                product_designer_editor_toast('<i class="fa fa-exclamation-circle"></i>','Please select item first.');
            }

            canvas.renderAll();
            product_designer_editor_save()

        })


        $(document).on('touchstart click','.product-designer #editor-center-v',function(){

            var selected_object = canvas.getActiveObject();

            if(selected_object != null){

                selected_object.centerV();
                product_designer_editor_toast('<i class="cpd-icon-align-vertical-middle"></i>','Selected item align vertically middle.');
            }
            else{
                product_designer_editor_toast('<i class="fa fa-exclamation-circle"></i>','Please select item first.');
            }


            canvas.renderAll();
            product_designer_editor_save()

        })



        $(document).on('click','.product-designer #editor-lockMovementX',function(){

            var selected_object = canvas.getActiveObject();
            var $this = $(this);

            if(selected_object != null){
                if($this.hasClass('active')){
                    $this.removeClass('active').addClass('inactive')
                    selected_object.set("lockMovementX", false);
                    product_designer_editor_toast('<i class="fa fa-arrows-v" ></i>','Unlocked to move horizontally.');
                }else{
                    $this.removeClass('inactive').addClass('active');
                    selected_object.set("lockMovementX", true);
                    product_designer_editor_toast('<i class="fa fa-arrows-v" ></i>','Locked to move horizontally.');
                }
            }
            else{
                product_designer_editor_toast('<i class="fa fa-exclamation-circle"></i>','Please select item first.');
            }

            canvas.renderAll();
            product_designer_editor_save()
        })

        $(document).on('click','.product-designer #editor-lockMovementY',function(){

            var selected_object = canvas.getActiveObject();
            var $this = $(this);

            if(selected_object != null){

                if($this.hasClass('active')){
                    $this.removeClass('active').addClass('inactive')
                    selected_object.set("lockMovementY", false);
                    product_designer_editor_toast('<i class="fa fa-arrows-h" ></i>','Unlocked to move vertically.');
                }else{
                    $this.removeClass('inactive').addClass('active');
                    selected_object.set("lockMovementY", true);
                    product_designer_editor_toast('<i class="fa fa-arrows-h" ></i>','Locked to move vertically.');
                }
            }
            else{
                product_designer_editor_toast('<i class="fa fa-exclamation-circle"></i>','Please select item first.');
            }

            canvas.renderAll();
            product_designer_editor_save()
        })






        $(document).on('click','.product-designer #editor-lockRotation',function(){

            var selected_object = canvas.getActiveObject();
            var $this = $(this);

            if(selected_object != null){

                if($this.hasClass('active')){
                    $this.removeClass('active').addClass('inactive')
                    canvas.getActiveObject().set("lockRotation", false);
                    product_designer_editor_toast('<i class="fa fa-undo" ></i>','Rotation unlocked.');
                }else{
                    $this.removeClass('inactive').addClass('active');
                    canvas.getActiveObject().set("lockRotation", true);
                    product_designer_editor_toast('<i class="fa fa-undo" ></i>','Rotation locked.');
                }
            }
            else{
                product_designer_editor_toast('<i class="fa fa-exclamation-circle"></i>','Please select item first.');
            }

            canvas.renderAll();
            product_designer_editor_save()

        })




        $(document).on('click','.product-designer #editor-lockScalingX',function(){

            var selected_object = canvas.getActiveObject();
            var $this = $(this);


            if(selected_object != null){

                if($this.hasClass('active')){
                    $this.removeClass('active').addClass('inactive')
                    selected_object.set("lockScalingX", false);
                    product_designer_editor_toast('<i class="fa fa-expand" ></i>','Scaling horizontally unlocked.');
                }else{
                    $this.removeClass('inactive').addClass('active');
                    selected_object.set("lockScalingX", true);
                    product_designer_editor_toast('<i class="fa fa-expand" ></i>','Scaling horizontally locked.');
                }
            }
            else{
                product_designer_editor_toast('<i class="fa fa-exclamation-circle"></i>','Please select item first.');
            }

            canvas.renderAll();
            product_designer_editor_save()
        })



        $(document).on('click','.product-designer #editor-lockScalingY',function(){

            var selected_object = canvas.getActiveObject();
            var $this = $(this);


            if(selected_object != null){
                if($this.hasClass('active')){
                    $this.removeClass('active').addClass('inactive')
                    canvas.getActiveObject().set("lockScalingY", false);
                    product_designer_editor_toast('<i class="fa fa-expand" ></i>','Scaling vertically unlocked.');
                }else{
                    $this.removeClass('inactive').addClass('active');
                    canvas.getActiveObject().set("lockScalingY", true);
                    product_designer_editor_toast('<i class="fa fa-expand" ></i>','Scaling vertically locked.');
                }
            }
            else{
                product_designer_editor_toast('<i class="fa fa-exclamation-circle"></i>','Please select item first.');
            }

            canvas.renderAll();
            product_designer_editor_save()

        })



        $(document).on('click','.product-designer #editor-undo',function(){

           //console('Undo');

           undo();



        })

        $(document).on('click','.product-designer #editor-redo',function(){

            //console('Redo');
            redo();


        })









    function product_designer_get_object_list(){


        html = '';
        now = $.now();

        console.log(now);

        objectList_arr = [];
        var objectList = [];
        objectList = canvas.getObjects();


        length = objectList.length;

        objectName = '';
        objectId = '';

        for (var i = 0, len = length; i < len; i++) {


            type = objectList[i].type;
            id = objectList[i].id;


            objectList_arr[i] = {'id': objectList[i].id, 'type': objectList[i].type};


            //objectList_arr[i]['id'] = id;


            html += '<div class="layer" obj-id="'+i+'">';


            if(type=='text'){
                objectName = objectList[i].text;
                objectType = 'Text';
                objectName = objectName;



            }
            else if(type=='image'){
                objectType = 'Image';
            }
            else if(type=='curvedText'){
                objectName = objectList[i].text;
                objectType = 'Curved Text';
                objectName = objectName;
            }
            else if(type=='path'){
                objectType = 'Path';
            }

            else if(type=='rect'){
                objectType = 'Rect';
            }

            else if(type=='circle'){
                objectType = 'Circle';
            }
            else if(type=='triangle'){
                objectType = 'Triangle';
            }
            else if(type=='polygon'){
                objectType = 'Polygon';
            }
            else{
                objectType = 'Others';
            }


            html += '<span class="remove"><i class="fa fa-times" ></i></span>';
            //html += '<span class="hide"><i class="fa fa-eye" ></i></span>';
            //html += '<span class="lock"><i class="fa fa-lock" ></i></span>';
            //html += '<span class="selectLayer"><i class="fa fa-check" ></i></span>';

            html += '<span class="type ">'+objectType+'</span>';
            //html += '<span class="name">'+objectName+'</span>';

            ////console(objectList[i]);
            html += '</div>';


        }

        $('.layers-list').html(html);

        // return objectList_arr;

    }



    $(document).on('click','.product-designer .layers-list .layer',function(event){

        event.stopPropagation();
        event.preventDefault();
        //$('.layers-list .layer').removeClass('active');
        //
         obj_id = $(this).attr('obj-id');
         //canvas.setActiveObject(obj_id);
         canvas.setActiveObject(canvas.item(obj_id));
        //
         //console.log(obj_id);




        product_designer_editor_save();

        ////console(obj_id);
    })


    $(document).on('click','.product-designer .layers-list .layer .remove',function(event){

        event.preventDefault();

        $('.layers-list .layer').removeClass('active');


        obj_id = $(this).parent().attr('obj-id');
        //canvas.setActiveObject(obj_id);
        canvas.setActiveObject(canvas.item(obj_id));

        var selected_object = canvas.getActiveObject();

        selected_object.remove();

        product_designer_editor_save();

        //console(obj_id);
    })

    $(document).on('click','.product-designer .layers-list .layer .hide',function(event){


        event.preventDefault();
        event.stopPropagation();





        obj_id = $(this).parent().attr('obj-id');
        //canvas.setActiveObject(canvas.item(obj_id));
        var selected_object = canvas.getActiveObject();

        console.log(obj_id);


        if($(this).hasClass('active')){

            console.log('Has class');


        }else{

            $(this).addClass('active');

            console.log('No class');

        }






        product_designer_editor_save()

        //console(obj_id);
    })







    function onObjectSelected(e) {

        type = e.target.get('type')

        $('.edit-text').removeClass('active');
        $('.edit-img').removeClass('active');
        $('.edit-shape').removeClass('active');
        $('.edit-curvedText').removeClass('active');

        ActiveObject = canvas.getActiveObject();



        console.log(type);
        ////console(ActiveObject);


        if(type=='text'){

            $('.edit-text').addClass('active');

            val = canvas.getActiveObject().getText();
            $('.product-designer #text-content').val(val);

            }

        else if(type=='curvedText'){
            $('.edit-curvedText').addClass('active');

            val = canvas.getActiveObject().getText();
            $('.product-designer #curvedText-content').val(val);

        }

        else if(type=='image'){
            $('.edit-img').addClass('active');
            }

        else if(type=='circle' || type=='triangle' || type=='rect' || type=='polygon' || type=='path' ){
            $('.edit-shape').addClass('active');
            }

        //tools_tabs_switch(0);
        product_designer_editor_save();

    }

    canvas.on('object:selected', onObjectSelected);


    canvas.on('object:modified', onObjectModified);



    function onObjectModified(e) {

        type = e.target.get('type');

        //console.log(type);


        product_designer_editor_save();

    }

    $(document).on('change','#edit-assets-text',function(){

        event.preventDefault();



    })


    $(document).on('keyup','.product-designer #text-content',function(){






		val = $(this).val();

		//alert(val);
		canvas.getActiveObject().setText(val);
		canvas.renderAll();
		//console(val);

        product_designer_editor_save();


		})




	$(document).on('change','.product-designer #font-size',function(){

		val = $(this).val();

		//alert(val);
		canvas.getActiveObject().set("fontSize", val);
		canvas.renderAll();
		//console(val);
        product_designer_editor_save();
		})


	$(document).on('change','.product-designer #font-color',function(){

		val = $(this).val();

		//alert('Hello');
		canvas.getActiveObject().setColor(val);
		canvas.renderAll();
		//console(val);

        product_designer_editor_save();


		})


        $(document).on('change','.product-designer #stroke-size',function(){

            val = $(this).val();

            //alert('Hello');
            canvas.getActiveObject().set('strokeWidth',val);
            canvas.renderAll();
            //console(val);
            product_designer_editor_save();
        })

        $(document).on('change','.product-designer #stroke-color',function(){

            val = $(this).val();

            //alert('Hello');
            canvas.getActiveObject().set('stroke',val);
            canvas.renderAll();
            //console(val);
            product_designer_editor_save();
        })




        $(document).on('change','.product-designer #font-bg-color',function(){

            val = $(this).val();

            //alert('Hello');
            canvas.getActiveObject().set('backgroundColor',val);
            canvas.renderAll();
            //console(val);
            product_designer_editor_save();
        })















	$(document).on('change','.product-designer #font-family',function(){

		val = $(this).val();


        fill_color = canvas.getActiveObject().get('fill');


		canvas.getActiveObject().setFontFamily(val);
        canvas.getActiveObject().set({fill: fill_color});

		canvas.renderAll();
		//console(fill_color);
        product_designer_editor_save();
		})


	$(document).on('change','.product-designer #font-opacity',function(){

		val = $(this).val();

		//alert('Hello');
		canvas.getActiveObject().set("opacity", val);
		//canvas.getActiveObject().opacity(val);
		canvas.renderAll();
		//console(val);
        product_designer_editor_save();
		})







	$(document).on('click','.product-designer #text-bold',function(){

		var $this = $(this);

		 if($this.hasClass('active')){
		   $this.removeClass('active').addClass('inactive')
		   canvas.getActiveObject().set("fontWeight", 'normal');
		 }else{
		   $this.removeClass('inactive').addClass('active');
		   canvas.getActiveObject().set("fontWeight", 'bold');
		 }

		canvas.renderAll();
        product_designer_editor_save();
		})

	$(document).on('click','.product-designer #text-italic',function(){


		var $this = $(this);

		 if($this.hasClass('active')){
		   $this.removeClass('active').addClass('inactive')
		   canvas.getActiveObject().set("fontStyle", 'normal');
		 }else{
		   $this.removeClass('inactive').addClass('active');
		   canvas.getActiveObject().set("fontStyle", 'italic');
		 }

		//canvas.getActiveObject().set("fontStyle", 'italic');
		canvas.renderAll();
		////console(val);
        product_designer_editor_save();
		})


	$(document).on('click','.product-designer #text-underline',function(){

		var $this = $(this);

		 if($this.hasClass('active')){
		   $this.removeClass('active').addClass('inactive')
		   canvas.getActiveObject().set("textDecoration", 'normal');
		 }else{
		   $this.removeClass('inactive').addClass('active');
		   canvas.getActiveObject().set("textDecoration", 'underline');
		 }


		//canvas.getActiveObject().fontWeight('bold');
		//canvas.getActiveObject().set("textDecoration", 'underline');
		canvas.renderAll();
		////console(val);
        product_designer_editor_save();
		})

	$(document).on('click','.product-designer #text-strikethrough',function(){

		var $this = $(this);

		 if($this.hasClass('active')){
		   $this.removeClass('active').addClass('inactive')
		   canvas.getActiveObject().set("textDecoration", 'normal');
		 }else{
		   $this.removeClass('inactive').addClass('active');
		   canvas.getActiveObject().set("textDecoration", 'line-through');
		 }


		//canvas.getActiveObject().fontWeight('bold');
		//canvas.getActiveObject().set("textDecoration", 'line-through');
		canvas.renderAll();
		////console(val);
        product_designer_editor_save();
		})



	$(document).on('change','.product-designer #text-rot-left',function(){


		val = $(this).val();


		canvas.getActiveObject().setAngle(-val);
		//canvas.getActiveObject().set("textDecoration", 'line-through');
		canvas.renderAll();
		////console(val);

		})


	$(document).on('change','.product-designer #text-rot-right',function(){


		val = $(this).val();


		canvas.getActiveObject().setAngle(val);
		//canvas.getActiveObject().set("textDecoration", 'line-through');
		canvas.renderAll();
		////console(val);

		})




        $(document).on('click','.product-designer #text-curved-text',function(){



            //alert(val);
            old_text = canvas.getActiveObject().getText();
            canvas.getActiveObject().remove();
            var text = new fabric.CurvedText(old_text, {

                radius: 100,
                spacing: 20,
                fontSize: 30,
                fill: "red",
                top: 0,
                left:300,


            });
            canvas.add(text);

            canvas.renderAll();

            product_designer_editor_save();


            //console(text);
            $('.edit-curvedText').addClass('active');
            $('.edit-text').removeClass('active');

        })


        $(document).on('click','.product-designer #curvedText-plain-text',function(){



            //alert(val);
            old_text = canvas.getActiveObject().getText();
            //console(canvas.getActiveObject());
            canvas.getActiveObject().remove();

            var text = new fabric.Text(old_text, { left: 100, top: 100 });
            canvas.add(text);

            canvas.renderAll();

            product_designer_editor_save();


            //console(old_text);
            $('.edit-curvedText').removeClass('active');
            $('.edit-text').addClass('active');

        })







        $(document).on('click','.product-designer .menu .add-curvedText',function(){

            product_designer_editor_toast('','Curved text added.');
            text = $('.asset-text').val();

            var text = new fabric.CurvedText(text, {

                radius: 100,
                spacing: 20,
                fontSize: 30,
                fill: "red",
                top: 0,
                left:300,


            });
            canvas.add(text);
            canvas.renderAll();


            product_designer_editor_save()
            //var text = new fabric.Text(text, { left: 100, top: 100 });
            //canvas.add(text);

            ////console(JSON.stringify(canvas));

        })


        $(document).on('keyup','.product-designer #curvedText-content',function(){

            val = $(this).val();

            canvas.getActiveObject().setText(val);
            canvas.renderAll();

            product_designer_editor_save();

            //console(val);

        })


        $(document).on('change','.product-designer #curvedText-font-size',function(){

            val = $(this).val();
            canvas.getActiveObject().set("fontSize", val);
            canvas.renderAll();

            product_designer_editor_save();

            //console(val);

        })


        $(document).on('change','.product-designer #curvedText-radius',function(){

            val = $(this).val();
            canvas.getActiveObject().set("radius", val);
            canvas.renderAll();
            product_designer_editor_save();

            //console(val);

        })

        $(document).on('change','.product-designer #curvedText-spacing',function(){

            val = $(this).val();
            canvas.getActiveObject().set("spacing", val);
            canvas.renderAll();
            product_designer_editor_save();


            //console(val);

        })

        $(document).on('change','.product-designer #curvedText-font-color',function(){

            val = $(this).val();
            canvas.getActiveObject().setColor(val);
            canvas.renderAll();
            product_designer_editor_save();

            //console(val);

        })



        $(document).on('change','.product-designer #curvedText-font-family',function(){

            val = $(this).val();
            canvas.getActiveObject().setFontFamily(val);
            canvas.renderAll();
            product_designer_editor_save();


            //console(val);

        })


        $(document).on('change','.product-designer #curvedText-font-opacity',function(){

            val = $(this).val();
            canvas.getActiveObject().set("opacity", val);

            canvas.renderAll();
            ////console(val);
            product_designer_editor_save();
        })







        $(document).on('click','.product-designer #curvedText-bold',function(){

            var $this = $(this);

            if($this.hasClass('active')){
                $this.removeClass('active').addClass('inactive')
                canvas.getActiveObject().set("fontWeight", 'normal');
            }else{
                $this.removeClass('inactive').addClass('active');
                canvas.getActiveObject().set("fontWeight", 'bold');
            }

            canvas.renderAll();

            product_designer_editor_save();

        })

        $(document).on('click','.product-designer #curvedText-italic',function(){


            var $this = $(this);

            if($this.hasClass('active')){
                $this.removeClass('active').addClass('inactive')
                canvas.getActiveObject().set("fontStyle", 'normal');
            }else{
                $this.removeClass('inactive').addClass('active');
                canvas.getActiveObject().set("fontStyle", 'italic');
            }

            //canvas.getActiveObject().set("fontStyle", 'italic');
            canvas.renderAll();
            ////console(val);
            product_designer_editor_save();
        })


        $(document).on('click','.product-designer #curvedText-underline',function(){

            var $this = $(this);

            if($this.hasClass('active')){
                $this.removeClass('active').addClass('inactive')
                canvas.getActiveObject().set("textDecoration", 'normal');
            }else{
                $this.removeClass('inactive').addClass('active');
                canvas.getActiveObject().set("textDecoration", 'underline');
            }


            //canvas.getActiveObject().fontWeight('bold');
            //canvas.getActiveObject().set("textDecoration", 'underline');
            canvas.renderAll();
            ////console(val);
            product_designer_editor_save();
        })

        $(document).on('click','.product-designer #curvedText-strikethrough',function(){

            var $this = $(this);

            if($this.hasClass('active')){
                $this.removeClass('active').addClass('inactive')
                canvas.getActiveObject().set("textDecoration", 'normal');
            }else{
                $this.removeClass('inactive').addClass('active');
                canvas.getActiveObject().set("textDecoration", 'line-through');
            }


            //canvas.getActiveObject().fontWeight('bold');
            //canvas.getActiveObject().set("textDecoration", 'line-through');
            canvas.renderAll();
            ////console(val);
            product_designer_editor_save();
        })









        $(document).on('change','.product-designer #img-opacity',function(){

            val = $(this).val();

            //alert('Hello');
            canvas.getActiveObject().set("opacity", val);
            //canvas.getActiveObject().opacity(val);
            canvas.renderAll();
            //console(val);
            product_designer_editor_save();
        })






	$(document).on('change','.product-designer #img-filter-grayscale',function(){

        var selected_object = canvas.getActiveObject();
        filter = new fabric.Image.filters.Grayscale();
        toApply = $(this).is(':checked');
        arr_filters = ['grayscale', 'invert', 'remove-white', 'sepia', 'sepia2',
            'brightness', 'noise', 'gradient-transparency', 'pixelate',
            'blur', 'convolute'];

        var filter_index = jQuery.inArray(filter.type.toLowerCase(), arr_filters);

        if((selected_object != null) && (selected_object.type == "image")){
            if (toApply)
                selected_object.filters[filter_index] = filter;
            else
                selected_object.filters[filter_index] = false;

            selected_object.applyFilters(canvas.renderAll.bind(canvas));

        }

        product_designer_editor_save();


    })


        $(document).on('change','.product-designer #img-filter-invert',function(){

            var selected_object = canvas.getActiveObject();
            filter = new fabric.Image.filters.Invert();
            toApply = $(this).is(':checked');
            arr_filters = ['grayscale', 'invert', 'remove-white', 'sepia', 'sepia2',
                'brightness', 'noise', 'gradient-transparency', 'pixelate',
                'blur', 'convolute'];

            var filter_index = jQuery.inArray(filter.type.toLowerCase(), arr_filters);

            if((selected_object != null) && (selected_object.type == "image")){
                if (toApply)
                    selected_object.filters[filter_index] = filter;
                else
                    selected_object.filters[filter_index] = false;

                selected_object.applyFilters(canvas.renderAll.bind(canvas));

            }
            product_designer_editor_save();
        })


        $(document).on('change','.product-designer #img-filter-sepia',function(){

            var selected_object = canvas.getActiveObject();
            filter = new fabric.Image.filters.Sepia();
            toApply = $(this).is(':checked');
            arr_filters = ['grayscale', 'invert', 'remove-white', 'sepia', 'sepia2',
                'brightness', 'noise', 'gradient-transparency', 'pixelate',
                'blur', 'convolute'];

            var filter_index = jQuery.inArray(filter.type.toLowerCase(), arr_filters);

            if((selected_object != null) && (selected_object.type == "image")){
                if (toApply)
                    selected_object.filters[filter_index] = filter;
                else
                    selected_object.filters[filter_index] = false;

                selected_object.applyFilters(canvas.renderAll.bind(canvas));

            }
            product_designer_editor_save();
        })


        $(document).on('change','.product-designer #img-filter-blur',function(){

            var selected_object = canvas.getActiveObject();
            var filter = new fabric.Image.filters.Blur({
                blur: 0.5
            });
            toApply = $(this).is(':checked');
            arr_filters = ['grayscale', 'invert', 'remove-white', 'sepia', 'sepia2',
                'brightness', 'noise', 'gradient-transparency', 'pixelate',
                'blur', 'convolute'];

            var filter_index = jQuery.inArray(filter.type.toLowerCase(), arr_filters);

            if((selected_object != null) && (selected_object.type == "image")){
                if (toApply)
                    selected_object.filters[filter_index] = filter;
                else
                    selected_object.filters[filter_index] = false;

                selected_object.applyFilters(canvas.renderAll.bind(canvas));

            }
            product_designer_editor_save();
        })


        $(document).on('change','.product-designer #img-filter-pixelate',function(){

            var selected_object = canvas.getActiveObject();
            var filter = new fabric.Image.filters.Pixelate({
                blocksize: 8
            });
            toApply = $(this).is(':checked');
            arr_filters = ['grayscale', 'invert', 'remove-white', 'sepia', 'sepia2',
                'brightness', 'noise', 'gradient-transparency', 'pixelate',
                'blur', 'convolute'];

            var filter_index = jQuery.inArray(filter.type.toLowerCase(), arr_filters);

            if((selected_object != null) && (selected_object.type == "image")){
                if (toApply)
                    selected_object.filters[filter_index] = filter;
                else
                    selected_object.filters[filter_index] = false;

                selected_object.applyFilters(canvas.renderAll.bind(canvas));

            }
            product_designer_editor_save();
        })


        $(document).on('change','.product-designer #img-filter-noise',function(){

            var selected_object = canvas.getActiveObject();
            var filter = new fabric.Image.filters.Noise({
                noise: 700
            });
            toApply = $(this).is(':checked');
            arr_filters = ['grayscale', 'invert', 'remove-white', 'sepia', 'sepia2',
                'brightness', 'noise', 'gradient-transparency', 'pixelate',
                'blur', 'convolute'];

            var filter_index = jQuery.inArray(filter.type.toLowerCase(), arr_filters);

            if((selected_object != null) && (selected_object.type == "image")){
                if (toApply)
                    selected_object.filters[filter_index] = filter;
                else
                    selected_object.filters[filter_index] = false;

                selected_object.applyFilters(canvas.renderAll.bind(canvas));

            }
            product_designer_editor_save();
        })





	$(document).on('change','.product-designer #shape-color',function(){

		val = $(this).val();

		//alert('Hello');
		canvas.getActiveObject().setColor(val);
		canvas.renderAll();

        product_designer_editor_save();

		//console(val);

		})


        $(document).on('change','.product-designer #shape-opacity',function(){

            val = $(this).val();

            //alert('Hello');
            canvas.getActiveObject().set("opacity", val);
            //canvas.getActiveObject().opacity(val);
            canvas.renderAll();
            product_designer_editor_save();


            //console(val);

        })




        $(document).on('click','.product-designer .add-shape',function(){

            shape_type = $(this).attr('shape-type');

            if(shape_type =='rectangle'){
                var rectangle = new fabric.Rect({
                    width: 50, height: 50, fill: 'blue', left: 50, top: 50
                });
                canvas.add(rectangle);
                canvas.centerObject(rectangle);
                rectangle.setCoords();
                canvas.setActiveObject(rectangle);
                product_designer_editor_toast('','Rectangle added.');

            }

            else if(shape_type =='circle'){

                circle = new fabric.Circle({ radius: 30, fill: '#f55', top: 100, left: 100 })
                canvas.add(circle);
                canvas.centerObject(circle);
                circle.setCoords();
                canvas.setActiveObject(circle);
                product_designer_editor_toast('','Circle added.');
            }

            else if(shape_type =='triangle'){
                var triangle = new fabric.Triangle({
                    width: 50, height: 60, fill: 'blue', left: 50, top: 50
                });
                canvas.add(triangle);
                canvas.centerObject(triangle);
                triangle.setCoords();
                canvas.setActiveObject(triangle);
                product_designer_editor_toast('','Triangle added.');
            }
            else if(shape_type =='star-5'){

                startPoints = [];
                bg_color="blue";
                opacity=1;

                startPoints = [
                    {x: 46, y: 90},
                    {x: 58, y: 56},
                    {x: 93, y: 55},
                    {x: 65, y: 35},
                    {x: 77, y: 0},
                    {x: 48, y: 22},
                    {x: 19, y: 0},
                    {x: 30, y: 35},
                    {x: 0, y: 56},
                    {x: 37, y: 56}
                ];

                var clonedStartPoints = startPoints.map(function (o) {
                    return fabric.util.object.clone(o);
                });

                var star = new fabric.Polygon(clonedStartPoints, {
                    left: 100,
                    top: 50,
                    fill: bg_color,
                    opacity: opacity,
                    selectable: true
                });

                star.set("originX", "center");
                star.set("originY", "center");

                canvas.add(star);
                canvas.centerObject(star);
                star.setCoords();
                canvas.setActiveObject(star);
                product_designer_editor_toast('','Star added.');

            }

            else if(shape_type =='star-6'){


                startPoints = [];
                bg_color="blue";
                opacity=1;

                startPoints = [
                    {x: 40, y: 90},
                    {x: 54, y: 68},
                    {x: 79, y: 68},
                    {x: 66, y: 45},
                    {x: 79, y: 23},
                    {x: 53, y: 23},
                    {x: 40, y: 0},
                    {x: 26, y: 23},
                    {x: 0, y: 23},
                    {x: 14, y: 45},
                    {x: 0, y: 68},
                    {x: 26, y: 68}
                ];

                var clonedStartPoints = startPoints.map(function (o) {
                    return fabric.util.object.clone(o);
                });

                var star = new fabric.Polygon(clonedStartPoints, {
                    left: 100,
                    top: 50,
                    fill: bg_color,
                    opacity: opacity,
                    selectable: true
                });

                star.set("originX", "center");
                star.set("originY", "center");

                canvas.add(star);
                canvas.centerObject(star);
                star.setCoords();
                canvas.setActiveObject(star);
                product_designer_editor_toast('','Star added.');

            }

            else if(shape_type =='star-7'){

                startPoints = [];
                bg_color="blue";
                opacity=1;

                startPoints = [
                    {x: 49, y: 90},
                    {x: 57, y: 60},
                    {x: 87, y: 74},
                    {x: 64, y: 47},
                    {x: 91, y: 34},
                    {x: 64, y: 34},
                    {x: 71, y: 0},
                    {x: 47, y: 26},
                    {x: 25, y: 0},
                    {x: 31, y: 32},
                    {x: 0, y: 32},
                    {x: 31, y: 47},
                    {x: 7, y: 74},
                    {x: 39, y: 60}
                ];




                var clonedStartPoints = startPoints.map(function (o) {
                    return fabric.util.object.clone(o);
                });

                var star = new fabric.Polygon(clonedStartPoints, {
                    left: 100,
                    top: 50,
                    fill: bg_color,
                    opacity: opacity,
                    selectable: true
                });

                star.set("originX", "center");
                star.set("originY", "center");

                canvas.add(star);
                canvas.centerObject(star);
                star.setCoords();
                canvas.setActiveObject(star);
                product_designer_editor_toast('','Star added.');

            }


            else if(shape_type =='star-8'){


                startPoints = [];
                bg_color="blue";
                opacity=1;

                startPoints = [
                    {x: 46, y: 90},
                    {x: 52, y: 63},
                    {x: 77, y: 78},
                    {x: 61, y: 53},
                    {x: 89, y: 46},
                    {x: 61, y: 40},
                    {x: 77, y: 14},
                    {x: 52, y: 30},
                    {x: 46, y: 0},
                    {x: 37, y: 30},
                    {x: 14, y: 14},
                    {x: 27, y: 39},
                    {x: 0, y: 46},
                    {x: 27, y: 53},
                    {x: 13, y: 77},
                    {x: 37, y: 62}
                ];

                var clonedStartPoints = startPoints.map(function (o) {
                    return fabric.util.object.clone(o);
                });

                var star = new fabric.Polygon(clonedStartPoints, {
                    left: 100,
                    top: 50,
                    fill: bg_color,
                    opacity: opacity,
                    selectable: true
                });

                star.set("originX", "center");
                star.set("originY", "center");

                canvas.add(star);
                canvas.centerObject(star);
                star.setCoords();
                canvas.setActiveObject(star);
                product_designer_editor_toast('','Star added.');

            }

            else if(shape_type =='star-9'){


                startPoints = [];
                bg_color="blue";
                opacity=1;

                startPoints = [
                    {x: 45, y: 90},
                    {x: 56, y: 73},
                    {x: 74, y: 79},
                    {x: 71, y: 59},
                    {x: 88, y: 52},
                    {x: 74, y: 39},
                    {x: 84, y: 21},
                    {x: 65, y: 21},
                    {x: 61, y: 0},
                    {x: 45, y: 14},
                    {x: 30, y: 0},
                    {x: 26, y: 21},
                    {x: 7, y: 12},
                    {x: 16, y: 39},
                    {x: 0, y: 51},
                    {x: 18, y: 59},
                    {x: 16, y: 79},
                    {x: 34, y: 73}
                ];




                var clonedStartPoints = startPoints.map(function (o) {
                    return fabric.util.object.clone(o);
                });

                var star = new fabric.Polygon(clonedStartPoints, {
                    left: 100,
                    top: 50,
                    fill: bg_color,
                    opacity: opacity,
                    selectable: true
                });

                star.set("originX", "center");
                star.set("originY", "center");

                canvas.add(star);
                canvas.centerObject(star);
                star.setCoords();
                canvas.setActiveObject(star);
                product_designer_editor_toast('','Star added.');

            }

            else if(shape_type =='star-10'){


                startPoints = [];
                bg_color="blue";
                opacity=1;

                startPoints = [
                    {x: 35, y: 90},
                    {x: 50, y: 81},
                    {x: 63, y: 90},
                    {x: 69, y: 73},
                    {x: 88, y: 73},
                    {x: 82, y: 56},
                    {x: 96, y: 46},
                    {x: 82, y: 36},
                    {x: 87, y: 18},
                    {x: 70, y: 18},
                    {x: 63, y: 0},
                    {x: 49, y: 12},
                    {x: 35, y: 0},
                    {x: 28, y: 18},
                    {x: 11, y: 18},
                    {x: 17, y: 35},
                    {x: 0, y: 46},
                    {x: 17, y: 56},
                    {x: 11, y: 73},
                    {x: 28, y: 73}
                ];



                var clonedStartPoints = startPoints.map(function (o) {
                    return fabric.util.object.clone(o);
                });

                var star = new fabric.Polygon(clonedStartPoints, {
                    left: 100,
                    top: 50,
                    fill: bg_color,
                    opacity: opacity,
                    selectable: true
                });

                star.set("originX", "center");
                star.set("originY", "center");

                canvas.add(star);
                canvas.centerObject(polygon);
                polygon.setCoords();
                canvas.setActiveObject(polygon);
                product_designer_editor_toast('','Star added.');

            }
            else if(shape_type =='polygon-5'){


                bg_color="blue";
                opacity=1;


                startPoints = [
                    {x: 0, y: 50},
                    {x: 45, y: 80},
                    {x: 85, y: 50},
                    {x: 70, y: 0},
                    {x: 17, y: 0}
                ];




                var clonedStartPoints = startPoints.map(function (o) {
                    return fabric.util.object.clone(o);
                });

                var polygon = new fabric.Polygon(clonedStartPoints, {
                    left: 100,
                    top: 50,
                    fill: bg_color,
                    opacity: opacity,
                    selectable: true
                });

                polygon.set("originX", "center");
                polygon.set("originY", "center");

                canvas.add(polygon);
                canvas.centerObject(polygon);
                polygon.setCoords();
                canvas.setActiveObject(polygon);
                product_designer_editor_toast('','Polygon added.');

            }

            else if(shape_type =='polygon-5'){


                bg_color="blue";
                opacity=1;


                startPoints = [
                    {x: 0, y: 50},
                    {x: 45, y: 80},
                    {x: 85, y: 50},
                    {x: 70, y: 0},
                    {x: 17, y: 0}
                ];




                var clonedStartPoints = startPoints.map(function (o) {
                    return fabric.util.object.clone(o);
                });

                var polygon = new fabric.Polygon(clonedStartPoints, {
                    left: 100,
                    top: 50,
                    fill: bg_color,
                    opacity: opacity,
                    selectable: true
                });

                polygon.set("originX", "center");
                polygon.set("originY", "center");

                canvas.add(polygon);
                canvas.centerObject(polygon);
                polygon.setCoords();
                canvas.setActiveObject(polygon);
                product_designer_editor_toast('','Polygon added.');

            }


            else if(shape_type =='polygon-5'){


                bg_color="blue";
                opacity=1;
                startPoints = [
                    {x: 0, y: 50},
                    {x: 45, y: 80},
                    {x: 85, y: 50},
                    {x: 70, y: 0},
                    {x: 17, y: 0}
                ];

                var clonedStartPoints = startPoints.map(function (o) {
                    return fabric.util.object.clone(o);
                });

                var polygon = new fabric.Polygon(clonedStartPoints, {
                    left: 100,
                    top: 50,
                    fill: bg_color,
                    opacity: opacity,
                    selectable: true
                });

                polygon.set("originX", "center");
                polygon.set("originY", "center");

                canvas.add(polygon);
                canvas.centerObject(polygon);
                polygon.setCoords();
                canvas.setActiveObject(polygon);
                product_designer_editor_toast('','Polygon added.');

            }


            else if(shape_type =='polygon-6'){


                bg_color="blue";
                opacity=1;
                startPoints = [
                    {x: 45, y: 90},
                    {x: 90, y: 70},
                    {x: 90, y: 20},
                    {x: 45, y: 0},
                    {x: 0, y: 20},
                    {x: 0, y: 70}
                ];

                var clonedStartPoints = startPoints.map(function (o) {
                    return fabric.util.object.clone(o);
                });

                var polygon = new fabric.Polygon(clonedStartPoints, {
                    left: 100,
                    top: 50,
                    fill: bg_color,
                    opacity: opacity,
                    selectable: true
                });

                polygon.set("originX", "center");
                polygon.set("originY", "center");

                canvas.add(polygon);
                canvas.centerObject(polygon);
                polygon.setCoords();
                canvas.setActiveObject(polygon);
                product_designer_editor_toast('','Polygon added.');

            }


            else if(shape_type =='polygon-7'){


                bg_color="blue";
                opacity=1;


                startPoints = [
                    {x: 26, y: 90},
                    {x: 65, y: 90},
                    {x: 88, y: 57},
                    {x: 81, y: 18},
                    {x: 45, y: 0},
                    {x: 12, y: 18},
                    {x: 0, y: 58}
                ];

                var clonedStartPoints = startPoints.map(function (o) {
                    return fabric.util.object.clone(o);
                });

                var polygon = new fabric.Polygon(clonedStartPoints, {
                    left: 100,
                    top: 50,
                    fill: bg_color,
                    opacity: opacity,
                    selectable: true
                });

                polygon.set("originX", "center");
                polygon.set("originY", "center");

                canvas.add(polygon);
                canvas.centerObject(polygon);
                polygon.setCoords();
                canvas.setActiveObject(polygon);
                product_designer_editor_toast('','Polygon added.');

            }


            else if(shape_type =='polygon-8'){


                bg_color="blue";
                opacity=1;


                startPoints = [
                    {x: 28, y: 90},
                    {x: 63, y: 90},
                    {x: 90, y: 63},
                    {x: 90, y: 27},
                    {x: 63, y: 0},
                    {x: 28, y: 0},
                    {x: 0, y: 27},
                    {x: 0, y: 63}
                ];




                var clonedStartPoints = startPoints.map(function (o) {
                    return fabric.util.object.clone(o);
                });

                var polygon = new fabric.Polygon(clonedStartPoints, {
                    left: 100,
                    top: 50,
                    fill: bg_color,
                    opacity: opacity,
                    selectable: true
                });

                polygon.set("originX", "center");
                polygon.set("originY", "center");

                canvas.add(polygon);
                canvas.centerObject(polygon);
                polygon.setCoords();
                canvas.setActiveObject(polygon);
                product_designer_editor_toast('','Polygon added.');

            }

            else if(shape_type =='polygon-9'){


                bg_color="blue";
                opacity=1;
                startPoints = [
                    {x: 45, y: 90},
                    {x: 75, y: 80},
                    {x: 90, y: 52},
                    {x: 85, y: 20},
                    {x: 60, y: 0},
                    {x: 30, y: 0},
                    {x: 8, y: 20},
                    {x: 0, y: 53},
                    {x: 17, y: 78}
                ];



                var clonedStartPoints = startPoints.map(function (o) {
                    return fabric.util.object.clone(o);
                });

                var polygon = new fabric.Polygon(clonedStartPoints, {
                    left: 100,
                    top: 50,
                    fill: bg_color,
                    opacity: opacity,
                    selectable: true
                });

                polygon.set("originX", "center");
                polygon.set("originY", "center");

                canvas.add(polygon);
                canvas.centerObject(polygon);
                polygon.setCoords();
                canvas.setActiveObject(polygon);
                product_designer_editor_toast('','Polygon added.');

            }

            else if(shape_type =='polygon-10'){


                bg_color="blue";
                opacity=1;
                startPoints = [
                    {x: 35, y: 90},
                    {x: 63, y: 90},
                    {x: 86, y: 74},
                    {x: 95, y: 47},
                    {x: 86, y: 19},
                    {x: 63, y: 0},
                    {x: 35, y: 0},
                    {x: 11, y: 19},
                    {x: 0, y: 45},
                    {x: 11, y: 72}
                ];



                var clonedStartPoints = startPoints.map(function (o) {
                    return fabric.util.object.clone(o);
                });

                var polygon = new fabric.Polygon(clonedStartPoints, {
                    left: 100,
                    top: 50,
                    fill: bg_color,
                    opacity: opacity,
                    selectable: true
                });

                polygon.set("originX", "center");
                polygon.set("originY", "center");

                canvas.add(polygon);
                canvas.centerObject(polygon);
                polygon.setCoords();
                canvas.setActiveObject(polygon);
                product_designer_editor_toast('','Polygon added.');

            }


            else if(shape_type =='heart'){


                outline_width = 1;
                outline_color = 'blue';

                var heart = new fabric.Path('M 272.70141,238.71731 \
            C 206.46141,238.71731 152.70146,292.4773 152.70146,358.71731  \
            C 152.70146,493.47282 288.63461,528.80461 381.26391,662.02535 \
            C 468.83815,529.62199 609.82641,489.17075 609.82641,358.71731 \
            C 609.82641,292.47731 556.06651,238.7173 489.82641,238.71731  \
            C 441.77851,238.71731 400.42481,267.08774 381.26391,307.90481 \
            C 362.10311,267.08773 320.74941,238.7173 272.70141,238.71731  \
            z ');
                var scale = 100 / heart.width;

                heart.set({
                    left: 100,
                    top: 50,
                    scaleX: scale,
                    scaleY: scale,
                    fill: 'blue',
                    opacity: 1,
                    selectable: true
                });

                heart.set("originX", "center");
                heart.set("originY", "center");

                if (outline_width > 0)
                {
                    heart.set("strokeWidth", parseInt(outline_width));
                    heart.set("stroke", outline_color);
                }

                canvas.add(heart);
                canvas.centerObject(heart);
                heart.setCoords();
                canvas.setActiveObject(heart);
                product_designer_editor_toast('','Heart added.');



            }


            canvas.renderAll();

            product_designer_editor_save();
            tools_tabs_switch(0);



        })










	$(document).on('click','.product-designer .menu .add-text',function(){

        product_designer_editor_toast('','Text added.');
		text = $('.asset-text').val();


		////console(product_designer_editor.side_data);

		var text = new fabric.Text(text, { left: 100, top: 100 });

        text.id = $.now();
		canvas.add(text);
        canvas.centerObject(text);
        text.setCoords();
        canvas.setActiveObject(text);
        canvas.renderAll();
		////console($.now());

        product_designer_editor_save();

        tools_tabs_switch(0);
	})





$(document).on('click','.clipart-list img',function(){

    product_designer_editor_toast('','Clipart added.');
    src = jQuery(this).attr('src');
    var newImg = new Image();
    newImg.src = src;
    var height = newImg.height;
    var width = newImg.width;

    fabric.Image.fromURL(src, function(img){
        scale = 200 / img.width;
        img.set({
            scaleX: scale,
            scaleY: scale,
        });
        canvas.add(img);
        canvas.centerObject(img);
        img.setCoords();
        canvas.setActiveObject(img);
        canvas.renderAll();
        product_designer_editor_save()
    });


    tools_tabs_switch(0);

})





	$(document).on('click','.product-designer .menu .save',function(){

		$('.product-designer .menu .loading').fadeIn();

		canvas.renderAll();
		var convertToImage=function(){
		canvas.deactivateAll().renderAll();


		  base_64 = canvas.toDataURL('png');


			$.ajax(
				{
			type: 'POST',
			url: product_designer_ajax.product_designer_ajaxurl,
			data: {"action": "product_designer_ajax_base64_uplaod","current_side":current_side_id,"product_id":product_id,"base_64":base_64},
			success: function(data)
					{

					    ////console(data);
						$('.product-designer .menu .loading').fadeOut();

                        //location.reload();

					}
				});

		}
		convertToImage();

		})


	$(document).on('click','.product-designer .menu .finalize',function(){

        //location.reload();

		$('#designer').fadeOut();
		$('.menu').fadeOut();
		$('.editing').fadeOut();

		$('#final').fadeIn();


		})










	$(document).on('click','.product-designer .menu .export #export-new',function(){

		$('.product-designer .menu .loading').fadeIn();
		json = JSON.stringify(canvas);




		$.ajax({
			type: 'POST',
			url: product_designer_ajax.product_designer_ajaxurl,
			data: {"action": "product_designer_ajax_save_template","current_side":current_side_id,"product_id":product_id,"json":json},
			success: function(response){
                var data = JSON.parse( response );

                template_id = data['template_id'];
                side_id = data['side_id'];

                html = '<li class="template" side_id="'+side_id+'" t_id="'+template_id+'">'+template_id+'</li>';

                $('.template-list').append(html);
				$('.product-designer .menu .loading').fadeOut();
			}
		});


		})

        $(document).on('submit','#save_as_template',function(event){

            event.preventDefault();
            var form_data = $(this).serialize();

            $(this).children('.loading').fadeIn();
            //$(this)[0].reset();


            $('.product-designer .menu .loading').fadeIn();
            json = JSON.stringify(canvas);

            __this = this;

            $.ajax({
                type: 'POST',
                context: $(this),
                url: product_designer_ajax.product_designer_ajaxurl,
                data: {"action": "product_designer_ajax_create_template","form_data":form_data,"json":json},
                success: function(response){
                    var data = JSON.parse( response );

                    template_id = data['template_id'];
                    side_id = data['side_id'];
                    mgs = data['mgs'];

                    html = '<li class="template" side_id="'+side_id+'" t_id="'+template_id+'">'+template_id+'</li>';

                    $('.template-list').append(html);
                    $(__this).children('.loading').fadeOut();
                    $(__this).trigger("reset");

                    //console(data);

                }
            });

        })

        // $(document).on('submit','#template_save',function(event){
        //     event.preventDefault();
        //
        //     var values = $(this).serialize();
        //
        //     //console(values);
        //
        //
        //     $('.product-designer .menu .loading').fadeIn();
        //     json = JSON.stringify(canvas);
        //
        //     $.ajax(
        //         {
        //             type: 'POST',
        //             url: product_designer_ajax.product_designer_ajaxurl,
        //             data: {"action": "product_designer_ajax_update_template","current_side":current_side_id,"product_id":product_id,"json":json,"t_id":t_id},
        //             success: function(data)
        //             {
        //                 $('.product-designer .menu .loading').fadeOut();
        //             }
        //         });
        //
        //
        //
        //
        // })

	$(document).on('click','.product-designer .menu .export #export-update',function(){

		////console(t_id);

		$('.product-designer .menu .loading').fadeIn();
		json = JSON.stringify(canvas);

		$.ajax(
			{
		type: 'POST',
		url: product_designer_ajax.product_designer_ajaxurl,
		data: {"action": "product_designer_ajax_update_template","current_side":current_side_id,"product_id":product_id,"json":json,"t_id":t_id},
		success: function(data)
				{
					$('.product-designer .menu .loading').fadeOut();
				}
			});


		})



	$(document).on('click','.pre_templates  .pre-templates-list .template',function(){


        side_serialized_data = product_designer_editor.side_serialized_data;
        pd_template_id = product_designer_editor.pd_template_id;

        product_designer_editor_busy('busy', 'Working...', '<i class="fa fa-spinner fa-spin"></i>');
        product_designer_editor_toast('','Please wait.');

		$('.pre_templates  .pre-templates-list .template').removeClass('active');

		var $this = $(this);

		 if($this.hasClass('active')){
		   //$this.removeClass('active').addClass('inactive');
		 }else{
		   $this.removeClass('inactive').addClass('active');
		 }

        pre_template_id = $(this).attr('pre_template_id');

		$.ajax(
			{
		type: 'POST',
		url: product_designer_ajax.product_designer_ajaxurl,
		data: {"action": "product_designer_ajax_load_pre_template","pd_template_id":pd_template_id,"pre_template_id":pre_template_id},
		success: function(response){

                    var data = JSON.parse( response );
                    side_json_data = data['side_json_data'];

					//console(current_side_id);
                    product_designer_editor.side_serialized_data = side_json_data;
                    product_designer_editor.pre_template_id = pre_template_id;

                    canvas.loadFromJSON(product_designer_editor.side_serialized_data[current_side_id]);

                    product_designer_editor_busy('ready', 'Ready...', '<i class="fa fa-check"></i>');
                    product_designer_editor_toast('','Pre Template Loaded, Please go to <b>Sides</b> menu to navigate side.');

				}
			});

		//alert('Hello');

		})



        // ########################## Undo -Redo feature


        var _config = {
            canvasState             : [],
            currentStateIndex       : -1,
            undoStatus              : false,
            redoStatus              : false,
            undoFinishedStatus      : 1,
            redoFinishedStatus      : 1,
            undoButton              : document.getElementById('editor-undo'),
            redoButton              : document.getElementById('editor-redo'),
        };
        canvas.on(
            'object:modified', function(){
                updateCanvasState();
            }
        );

        canvas.on(
            'object:added', function(){
                updateCanvasState();
            }
        );

        var updateCanvasState = function() {
            if((_config.undoStatus == false && _config.redoStatus == false)){
                var jsonData        = canvas.toJSON();
                var canvasAsJson        = JSON.stringify(jsonData);
                if(_config.currentStateIndex < _config.canvasState.length-1){
                    var indexToBeInserted                  = _config.currentStateIndex+1;
                    _config.canvasState[indexToBeInserted] = canvasAsJson;
                    var numberOfElementsToRetain           = indexToBeInserted+1;
                    _config.canvasState                    = _config.canvasState.splice(0,numberOfElementsToRetain);
                }else{
                    _config.canvasState.push(canvasAsJson);
                }
                _config.currentStateIndex = _config.canvasState.length-1;

                ////console(_config.currentStateIndex);


                if((_config.currentStateIndex == _config.canvasState.length-1) && _config.currentStateIndex != -1){
                    _config.redoButton.disabled= "disabled";
                }
            }
        }



        var undo = function() {
            if(_config.undoFinishedStatus){
                if(_config.currentStateIndex == -1){
                    _config.undoStatus = false;
                }
                else{
                    if (_config.canvasState.length >= 1) {
                        _config.undoFinishedStatus = 0;
                        if(_config.currentStateIndex != 0){
                            _config.undoStatus = true;
                            canvas.loadFromJSON(_config.canvasState[_config.currentStateIndex-1],function(){
                                var jsonData = JSON.parse(_config.canvasState[_config.currentStateIndex-1]);
                                canvas.renderAll();
                                _config.undoStatus = false;
                                _config.currentStateIndex -= 1;
                                _config.undoButton.removeAttribute("disabled");
                                if(_config.currentStateIndex !== _config.canvasState.length-1){
                                    _config.redoButton.removeAttribute('disabled');
                                }
                                _config.undoFinishedStatus = 1;
                            });
                        }
                        else if(_config.currentStateIndex == 0){
                            canvas.clear();
                            _config.undoFinishedStatus = 1;
                            _config.undoButton.disabled= "disabled";
                            _config.redoButton.removeAttribute('disabled');
                            _config.currentStateIndex -= 1;
                        }
                    }
                }
            }
        }

        var redo = function() {
            if(_config.redoFinishedStatus){
                if((_config.currentStateIndex == _config.canvasState.length-1) && _config.currentStateIndex != -1){
                    _config.redoButton.disabled= "disabled";
                }else{
                    if (_config.canvasState.length > _config.currentStateIndex && _config.canvasState.length != 0){
                        _config.redoFinishedStatus = 0;
                        _config.redoStatus = true;
                        canvas.loadFromJSON(_config.canvasState[_config.currentStateIndex+1],function(){
                            var jsonData = JSON.parse(_config.canvasState[_config.currentStateIndex+1]);
                            canvas.renderAll();
                            _config.redoStatus = false;
                            _config.currentStateIndex += 1;
                            if(_config.currentStateIndex != -1){
                                _config.undoButton.removeAttribute('disabled');
                            }
                            _config.redoFinishedStatus = 1;
                            if((_config.currentStateIndex == _config.canvasState.length-1) && _config.currentStateIndex != -1){
                                _config.redoButton.disabled= "disabled";
                            }
                        });
                    }
                }
            }
        }











        //
        // var anno2 = new Anno([{
        //     target  : '.pd-guide-1', // second block of code
        //     position: 'right',
        //     content : '<h4>#1 Product Sides</h4> Click here to load side and ready for edit.',
        //     showOverlay: function(){$('.anno-overlay').css('display','none');},
        // }, {
        //     target  : '.pd-guide-2',
        //     position: 'right',
        //     content : "<h4>#2 Clipart & Assets</h4> You can add some clipart here also you can upload your own.",
        //     showOverlay: function(){$('.anno-overlay').css('display','none');},
        // }, {
        //     target  : '.pd-guide-3',
        //     position: 'right',
        //     content : "<h4>#3 Text</h4> You can add text from here, there also curved text available.",
        //     showOverlay: function(){$('.anno-overlay').css('display','none');},
        // }, {
        //     target  : '.pd-guide-4',
        //     position: 'right',
        //     className: 'anno-width-200', // 150,175,200,250 (default 300)
        //     content : '<h4>#4 Shapes</h4> Some exclusive shapes here, you can add them to your design.',
        //     showOverlay: function(){$('.anno-overlay').css('display','none');},
        // }, {
        //     target  : '.pd-guide-5',
        //     position: 'left',
        //     arrowPosition: 'right',
        //     content : '<h4>#5 Editor actions</h4>',
        //     showOverlay: function(){$('.anno-overlay').css('display','none');},
        // }, {
        //     target  : '.pd-guide-6',
        //     position: 'left',
        //     arrowPosition: 'right',
        //     content : '<h4>#5 Preview</h4> Click preview button to see current canvas preview.',
        //     showOverlay: function(){$('.anno-overlay').css('display','none');},
        // }
        //
        //
        // ])


        $(document).on('click','.product-designer .welcome-tour .start-tour',function(){

            $('.product-designer .welcome-tour').fadeOut();


           // anno2.show();
            //$('.anno-overlay').css('display','none');
        });

        //anno2.show();


// ##########Impromptu############## //


    var tourSubmitFunc = function(e,v,m,f){
        console.log(e);
        console.log(v);
        console.log(m);
        console.log(f);

        stateName = e.stateName;

        if(stateName == 3){
            tools_tabs_switch(0);
        }

            if(v === -1){
                $.prompt.prevState();
                return false;
            }
            else if(v === 1){
                $.prompt.nextState();
                return false;
            }
        };

    tourStates = [
        {
            title: '#1 Product Sides',
            html: 'Click here to load side and ready for edit.',
            buttons: { Next: 1 },
            focus: 1,
            position: { container: '.pd-guide-1', x: -350, y: 0, width: 300, arrow: 'rt' },
            submit: tourSubmitFunc
        },
        {
            title: '#2 Clipart & Assets',
            html: 'You can add some clipart here also you can upload your own.',
            buttons: { Prev: -1, Next: 1 },
            focus: 1,
            position: { container: '.pd-guide-2', x: -350, y: 0, width: 300, arrow: 'rt' },
            submit: tourSubmitFunc
        },
        {
            title: "#3 Text",
            html: 'You can add text from here, there also curved text available.',
            buttons: { Prev: -1, Next: 1 },
            focus: 1,
            position: { container: '.pd-guide-3', x: -350, y: 0, width: 300, arrow: 'rt' },
            submit: tourSubmitFunc
        },
        {
            title: '#4 Shapes',
            html: 'Some exclusive shapes here, you can add them to your design.',
            buttons: { Prev: -1, Next: 1 },
            focus: 1,
            position: { container: '.pd-guide-4', x: -350, y: 0, width: 300, arrow: 'rt' },
            submit: tourSubmitFunc
        },

        {
            title: '#5 Editor actions',
            html: 'Some exclusive shapes here, you can add them to your design.',
            buttons: { Prev: -1, Next: 1 },
            focus: 1,
            position: { container: '.pd-guide-5', x: -350, y: 0, width: 300, arrow: 'rt' },
            submit: tourSubmitFunc
        },

        {
            title: '#6 Preview',
            html: 'Click preview button to see current canvas preview.',
            buttons: { Prev: -1, Next: 1 },
            focus: 1,
            position: { container: '.pd-guide-6', x: -330, y: -10, width: 300, arrow: 'rt' },
            submit: tourSubmitFunc
        },

        {
            title: '#7 Download',
            html: 'Click download your customized design.',
            buttons: { Prev: -1, Next: 1 },
            focus: 1,
            position: { container: '.pd-guide-7', x: -330, y: -10, width: 300, arrow: 'rt' },
            submit: tourSubmitFunc
        },


        {
            title: '#8 Item list',
            html: 'Click to see object added on canvas for current view.',
            buttons: { Prev: -1, Next: 1 },
            focus: 1,
            position: { container: '.pd-guide-8', x: -330, y: -10, width: 300, arrow: 'rt' },
            submit: tourSubmitFunc
        },


        {
            title: '#9 Product info & Cart',
            html: 'After finishing the design you will see the preview and add them to cart and proceed to submit order.',
            buttons: { Prev: -1, Next: 1,  Done: 2 },
            focus: 1,
            position: { container: '.pd-guide-9', x: -330, y: -10, width: 300, arrow: 'rt' },
            submit: tourSubmitFunc
        },

    ];



    var tour_guide = product_designer_editor.tour_guide;
    var tour_enable = tour_guide.enable;
    var tour_complete = tour_guide.tour_complete;
    var tour_hide = tour_guide.tour_hide;

    var product_designer_tour = product_designer_getCookie('product_designer_tour');



    if(tour_enable == true){

        if(product_designer_tour != 'false'){

            //console(product_designer_editor.tour_guide);
            $('.product-designer .welcome-tour').addClass('active');
        }
        else{
            $('.product-designer .welcome-tour').removeClass('active');
        }

    }
    else{
        $('.product-designer .welcome-tour').removeClass('active');

    }



    $(document).on('click','.product-designer .welcome-tour .start-tour',function(){

        $('.product-designer .welcome-tour').fadeOut();
        tools_tabs_switch(1);

        console.log('Tour start');

        $.prompt(tourStates);

    });

    $(document).on('click','.product-designer .welcome-tour .end-tour',function(){

        $('.product-designer .welcome-tour').removeClass('active');

        product_designer_editor.tour_guide['enable'] = false;

        document.cookie = "product_designer_tour=false";

        console.log('Tour end');

        //$.prompt(tourStates);
        // anno2.show();
        //$('.anno-overlay').css('display','none');
    });




    function product_designer_getCookie(cname) {
        var name = cname + "=";
        var decodedCookie = decodeURIComponent(document.cookie);
        var ca = decodedCookie.split(';');
        for(var i = 0; i <ca.length; i++) {
            var c = ca[i];
            while (c.charAt(0) == ' ') {
                c = c.substring(1);
            }
            if (c.indexOf(name) == 0) {
                return c.substring(name.length, c.length);
            }
        }
        return "";
    }


    $(document).on('click','.product-designer .quote',function(){

        var quote = $(this).text();


        var text = new fabric.Text(quote, { left: 100, top: 100 });
        text.id = $.now();
        canvas.add(text);

        product_designer_editor_save();
        product_designer_editor_toast('','Quote added.', 2000);

        product_designer_get_object_list();



    })









    $(document).on('keyup','.product-designer .menu .qr-text',function(){

        text = $('.qr-text').val();
        size = $('.qr-size').val();
        bg_color = $('.qr-bg-color').val();
        fill_color = $('.qr-fill-color').val();
        radius = $('.qr-radius').val();

        //$('#qrcode').html('');

        //console(size);
        //console(bg_color);
        //console(fill_color);
        //console(radius);



        var qrcode = $('#qrcode').empty().qrcode({
            render: 'image',
            size: size,
            fill: fill_color,
            background: bg_color,
            text: text,
        });


        product_designer_editor_save();
        product_designer_editor_toast('','Text added.', 2000);

        product_designer_get_object_list();

    })


    $(document).on('click','.product-designer .menu .add-qr-code',function(){

        src = $('#qrcode img').attr('src');

        //src = jQuery(this).attr('src');
        var newImg = new Image();
        newImg.src = src;
        var height = newImg.height;
        var width = newImg.width;

        fabric.Image.fromURL(src, function(img){
            scale = 200 / img.width;
            img.set({
                scaleX: scale,
                scaleY: scale
            });
            img.id = $.now();
            //img.clipart_data = clipart_data;
            ////console(img);

            canvas.add(img);
            product_designer_editor_save();
            product_designer_get_object_list();
        });

        canvas.renderAll();

        product_designer_editor_toast('','QR added.', 2000);

    })


    $(document).on('keyup','.product-designer .menu .barcode-text',function(){

        text = $('.barcode-text').val();
        width = $('.barcode-width').val();
        height = $('.barcode-height').val();
        color = $('.barcode-color').val();

        //console(text);

        JsBarcode("#barcode", text, {
            format: "CODE128A",
            lineColor: color,
            width:width,
            height:height,
            displayValue: false
        });

        product_designer_editor_save();
        product_designer_editor_toast('','Text added.', 2000);

        product_designer_get_object_list();

    })

    $(document).on('click','.product-designer .menu .add-barcode',function(){

        src = $('img#barcode').attr('src');

        //src = jQuery(this).attr('src');
        var newImg = new Image();
        newImg.src = src;
        var height = newImg.height;
        var width = newImg.width;

        fabric.Image.fromURL(src, function(img){
            scale = 200 / img.width;
            img.set({
                scaleX: scale,
                scaleY: scale
            });
            img.id = $.now();
            //img.clipart_data = clipart_data;
            ////console(img);

            canvas.add(img);
            product_designer_editor_save();
            product_designer_get_object_list();
        });

        canvas.renderAll();

        product_designer_editor_toast('','Barcode added.', 2000);


    })








});







