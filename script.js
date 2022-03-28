(function($){
    
    $(document).ready(function() {

        //Multiple choyce button

        switch ($("#hidden-search-method-button").val()) {

            case "Price":
                $("#option-1").val("Sustainability");
                $("#option-2").val("Reviews");   
            break;

            case "Reviews":
                $("#option-1").val("Price");
                $("#option-2").val("Sustainability");
            break;
        
            default:
                $("#option-1").val("Reviews");
                $("#option-2").val("Price");
            break;
        }

        $('.search-type-option').on( 'click', function () {

            let holder = $("#hidden-search-method-button").val();

            $("#search-method-button").val($(this).val());
            $("#hidden-search-method-button").val($(this).val());

            $(this).val(holder);

            $('#submit-glist-button').trigger('click');            

        });

        //klick to change search method

        let flipflop = 0;
        let searchForThese = [];
        let theNumbers = [];

        $("#single-submit-button").attr('disabled', true);

        $('#search-type-button').on( 'click', function () {
            switch (flipflop) {

                case 1 :
                        $("#search-type-button").val("Single");
                        $("#hidden-search-type-button").val("Single");
                        $('.grocery').remove();
                        $('#submit-glist-button').remove();
                        flipflop = 0;

                        searchForThese = [];
                        $('#search-for-these').val(searchForThese);

                        theNumbers = [];
                        $('#the-numbers').val(theNumbers);

                break;
            
                default:
                        $("#search-type-button").val("Bulk");
                        $("#hidden-search-type-button").val("Bulk");
                        $("#single-submit-button").attr('disabled', true);
                        flipflop = 1;

                        if ($('#search-for').val() != "") {

                            if (theNumbers.length < 1) {
            
                                $('#submit-glist').append('<div><button id="submit-glist-button" type="submit" form="searchfunctionality-form">submit</button></div>');                        
                            }
            
                            $("#grocerylist").append('<div class="grocery"><input type="number" value="1" min="1" class="amount-of-g"><input class="the-grocery" type="text" value="'+$('#search-for').val()+'"><button class="delete-grocery" type="button">x</button></div>');
            
                            searchForThese.push($('#search-for').val().toString());
                            $('#search-for-these').val(searchForThese);
            
                            theNumbers.push(1);
                            $('#the-numbers').val(theNumbers);
            
                            $('#search-for').val("");
                        }
                break;
            }
        });

        $('#search-for').keyup(function () {
            if (flipflop==0){
                $("#single-submit-button").attr('disabled', false);
            }
        });

        //grocerylist

        if($('#search-for-these').val().length > 0){

            $("#search-type-button").val("Bulk");
            $("#hidden-search-type-button").val("Bulk");
            $("#single-submit-button").attr('disabled', true);
            flipflop = 1;

            let ProductList = $('#search-for-these').val().split(',');
            let NumbersList = $('#the-numbers').val().split(',');

            for (let i = 0; i < ProductList.length; i++) {

                $("#grocerylist").append('<div class="grocery"><input type="number" value="'+NumbersList[i]+'" min="1" class="amount-of-g"><input class="the-grocery" type="text" value="'+ProductList[i]+'"><button class="delete-grocery" type="button">x</button></div>');
                
                theNumbers.push(NumbersList[i]);
                searchForThese.push(ProductList[i]);
            }

            $('#submit-glist').append('<div><button id="submit-glist-button" type="submit" form="searchfunctionality-form">submit</button></div>');
        }

        $('#search-for').keypress(function(event) {

            if (event.keyCode == 13 && $('#search-type-button').val() == "Bulk" && $('#search-for').val() != "") {

                if (theNumbers.length < 1) {

                    $('#submit-glist').append('<div><button id="submit-glist-button" type="submit" form="searchfunctionality-form">submit</button></div>');                        
                }

                $("#grocerylist").append('<div class="grocery"><input type="number" value="1" min="1" class="amount-of-g"><input class="the-grocery" type="text" value="'+$('#search-for').val()+'"><button class="delete-grocery" type="button">x</button></div>');

                searchForThese.push($('#search-for').val().toString());
                $('#search-for-these').val(searchForThese);

                theNumbers.push(1);
                $('#the-numbers').val(theNumbers);

                $('#search-for').val("");                   
            }
        });
        
        $('#grocerylist').on('click', '.delete-grocery', function () {

            let newArray = [];
            let newNumArray = [];

            for (let i = 0; i < searchForThese.length; i++) {
                
                if(searchForThese[i] != $(this).parent().children('.the-grocery').val().toString())
                {
                    newArray.push(searchForThese[i]);
                    newNumArray.push(theNumbers[i]);


                }            
            }
            searchForThese = newArray;
            $('#search-for-these').val(searchForThese);

            theNumbers = newNumArray;
            $('#the-numbers').val(theNumbers);

            $(this).parent().remove();

            if(theNumbers.length == 0){
                $('#submit-glist').remove();
            }
        });

        $('#grocerylist').on( "change", '.amount-of-g', function () { 

            let i= 0;
            let Continue = true;

            while (Continue == true) {
                
                if(searchForThese[i] == $(this).parent().children('.the-grocery').val().toString()){

                    theNumbers[i] = $(this).val();
                    $('#the-numbers').val(theNumbers);

                    Continue = false;
                }

                i++;
            }
        });

        $('#grocerylist').on('focusin', '.the-grocery', function(){

            $(this).data('val', $(this).val());

        }).on('change','.the-grocery', function(){

            let i= 0;
            let Continue = true;

            while (Continue == true) {
                
                if(searchForThese[i] == $(this).data('val')){

                    searchForThese[i] = $(this).val();
                    $('#search-for-these').val(searchForThese);

                    Continue = false;
                }
                i++;
            }             
        });

        //single price search

        if($("#hidden-search-method-button").val() == "Price" && $('#search-type-button').val() == 'Single')
        {
            try {

                //omfformaterar jsonen

                let chosen = JSON.parse($('#result-json').val());
                let priceLeaderboard = [];

                Object.keys(chosen).forEach(element => {

                    let prodProp = [];

                    Object.values(chosen[element]["prods"]).forEach(i => {
                        prodProp.push(i);
                    });

                    prodProp.sort((a,b) => a['price'] - b['price']);

                    chosen[element]["prods"] = prodProp;

                    priceLeaderboard.push(chosen[element]);
                });

                priceLeaderboard.sort((a,b) => a['prods'][0]['price'] - b['prods'][0]['price']);

                //return and insert the posts

                let resultString = '<div class="results-container">';

                priceLeaderboard.forEach(customer => {
                    
                    resultString += '<form class="company-container" action="'+customer["permalink"]+'" method="get"><input type="submit" class="accountingsubmit"><input type="hidden" name="add-a-transaction" value="something"><div class="comp-info">';

                        resultString += '<div class="the_logo_thumbnail"><img src="'+customer["logo"]+'"></div>';
                        resultString += '<div class="right-data"><h5>esg</h5><h3 class="value-field">'+customer["esg"]+'</h3></div>';
                        resultString += customer["stars"];

                        resultString +='</div><div class="lable-named-products"><h4 class="the-actual-lable">Products</h4><div class="products-container">';

                            customer['prods'].forEach(product => {

                                resultString +='<a class="the-product-container" href="'+product['prodlink']+'">';

                                    resultString += '<div class="the_product_thumbnail"><img src="'+product["img"]+'"></div>';
                                    resultString += '<div class="right-data-2"><h5>'+product['name']+'</h5><h3 class="value-field">'+product['price']+' kr</h3></div>';
                                    resultString += product['avail'];

                                resultString += '</a>';
                            });

                        resultString += '</div></div>';

                    resultString +='</form>';
                });

                $('#apendix').append(resultString);
                
            } catch (error) {
                alert(error);
            }
        }

        //Bulk price search

        if($("#hidden-search-method-button").val() == "Price" && $('#search-type-button').val() == 'Bulk'){

            try {

                //omfformaterar jsonen

                let chosen = JSON.parse($('#result-json').val());
                let priceLeaderboard = [];
                let ads = [];

                // Test bilder:'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTv96Kb4DnMgQJcUWO-slC4Qbqt12luhdy2Gw&usqp=CAU','https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQxhaPI7uQK3mUMJmvlwPJc1F3rhGUD3c8orQ&usqp=CAU','https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSKaO2BZO_FQGNQQm-bbrejrdq19o4MWz7oUw&usqp=CAU','https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQjHaiRXae-0_yLKs2lobDSGhNao9Kd-S-zyA&usqp=CAU','https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRcHSkgu8O36e-H4we7AmKDTQv-IynfsH0A9g&usqp=CAU'

                Object.values(chosen).forEach(element => {

                    let index = 0;

                    element["prods"].forEach(i => {

                        //offer algoritm

                        for (let jndex = 0; jndex < i.length; jndex++) {

                            if(i[jndex]["if"] == theNumbers[index])
                            {
                                i[jndex]["price"] = i[jndex]["thisif"];
                            }

                            if(i[jndex]["thisifimg"] != null)
                            {
                                ads.push(i[jndex]["thisifimg"]);
                            }
                        }

                        i.sort((a,b) => a['price'] - b['price']);
                        element["totprice"] += i[0]['price']*theNumbers[index];
                        index++;
                    });
                    priceLeaderboard.push(element);
                });

                priceLeaderboard.sort((a,b) => a["totprice"]-b["totprice"]);

                //return and insert the posts

                let resultString = '<div class="results-container">';

                priceLeaderboard.forEach(customer => {
                    
                    resultString += '<form class="company-container" action="'+customer["permalink"]+'" method="get"><input type="submit" class="accountingsubmit"><input type="hidden" name="add-a-transaction" value="something"><div class="comp-info">';

                        resultString += '<div class="the_logo_thumbnail"><img src="'+customer["logo"]+'"></div>';
                        resultString += '<div class="right-data"><h5>esg</h5><h3 class="value-field">'+customer["esg"]+'</h3></div>';
                        resultString += customer["stars"];

                        resultString +='</div><div class="lable-named-products"><h4 class="the-actual-lable">Products</h4><div class="products-container">';

                            customer['prods'].forEach(types => {
                            
                                types.forEach(product => {

                                    resultString +='<a class="the-product-container" href="'+product['prodlink']+'">';

                                        resultString += '<div class="the_product_thumbnail"><img src="'+product["img"]+'"></div>';
                                        resultString += '<div class="right-data-2"><h5>'+product['name']+'</h5><h3 class="value-field">'+product['price']+' kr</h3></div>';
                                        resultString += product['avail'];

                                    resultString += '</a>';
                                });
                            });

                        resultString += '</div></div>';

                    resultString +='</form>';
                });

                $('#apendix').append(resultString);

                //delete when deleted
                
                $('#grocerylist').on('change', function () {
                    $('#submit-glist-button').trigger('click');
                });

                $('#grocerylist').on('click', '.delete-grocery', function () {
                    $('#submit-glist-button').trigger('click');
                });

                //insert display into grocerylist

                $(".grocery").remove();

                $("#search-type-button").val("Bulk");
                $("#hidden-search-type-button").val("Bulk");
                $("#single-submit-button").attr('disabled', true);
                flipflop = 1;

                let ProductList = $('#search-for-these').val().split(',');
                let NumbersList = $('#the-numbers').val().split(',');

                for (let i = 0; i < ProductList.length; i++) {

                    $("#grocerylist").append('<div class="grocery"><input type="number" value="'+NumbersList[i]+'" min="1" class="amount-of-g"><input class="the-grocery" type="text" value="'+ProductList[i]+'"><div class="display-in-glist-c"><div class="display-info-container"><div class="display-thumbnail"><img src="'+priceLeaderboard[0]["prods"][i][0]["img"]+'"></div><h4 class="bottomdweller">'+theNumbers[i]*priceLeaderboard[0]["prods"][i][0]['price']+' kr '+priceLeaderboard[0]["prods"][i][0]["name"]+'</h4></div><div class="display-info-container">'+priceLeaderboard[0]["prods"][i][0]["avail"]+'</div></div><button class="delete-grocery" type="button">x</button></div>');

                }

                $('#submit-glist').append('<h2 id="total-price">fr: '+priceLeaderboard[0]["totprice"]+'kr</h2></div>');

                //display ads
                
                let adsnum = 0;

                for (let i = 0; i < 6; i++){
                        
                    adsnum++;

                    if (adsnum >= ads.length) 
                    {
                        adsnum = 0;   
                    }
                    $('#add-'+i).replaceWith('<a class="adimage-1" id="add-'+i+'" href="'+ads[adsnum]+'"><img src="'+ads[adsnum]+'"></a>'); 
                }

                function slideRight(){
                    
                    for (let i = 0; i < 3; i++){
                        
                        adsnum++;

                        if (adsnum >= ads.length) 
                        {
                            adsnum = 0;   
                        }
                        $('#add-'+i).replaceWith('<a class="adimage-1" id="add-'+i+'" href="'+ads[adsnum]+'"><img src="'+ads[adsnum]+'"></a>'); 
                    }
                    
                    $('#ads-container-1').css('margin-left','34.333333333%');
                    setTimeout( slideLeft, 4000);
                }

                function slideLeft(){
                    
                    for (let i = 0; i < 3; i++){

                        adsnum++;

                        if (adsnum >= ads.length) 
                        {
                            adsnum = 0;   
                        }
                        $('#add-'+(i+3)).replaceWith('<a class="adimage-1" id="add-'+(i+3)+'" href="'+ads[adsnum]+'"><img src="'+ads[adsnum]+'"></a>'); 
                    }
                    
                    $('#ads-container-1').css('margin-left','0%');
                    setTimeout( slideRight, 4000);
                }

                setTimeout(slideRight, 1000);
                
            } catch (error) {
                alert(error);
            }
        }

        //remember location by cookuie

        if($("#loc-cookie").length)
        {
            document.cookie = 'user_location='+$("#loc-cookie").val()+'; max-age=31622400';
        }

        $('#user-location').keypress(function(event) {
            if(event.keyCode == 13){
                $('#submit-glist-button').trigger('click');
            }
        });

        
    });
        
}(jQuery));



