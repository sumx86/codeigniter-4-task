var poruchka = {
    'zelenchuci'  : [],
    'elektronika' : [],
    'total_price' : 0
};

(function($) {
    $(document).ready(function() {
        $('#artikuli-zelenchuci-form, #artikuli-elektronika-form').on('submit', function(e) {
            // add to final price
            e.preventDefault();
            var form = $(e.currentTarget);
            $.ajax({
                url: '/add-order',
                method: 'post',
                data: form.serialize() + '&sklad=' + form.attr('data-name')
            })
            .done(function(jqXHR, status, req) {
                var response = $.parseJSON(jqXHR);
                if(response.hasOwnProperty('order')) {
                    updateOrder(response['order']);
                } else {
                    handleError(response['error']);
                }
            });
        });
        

        function updateOrder(order) {
            var item  = order['ime'];
            var price = order['cena'];
            var count = order['broika'];
            var sklad = order['sklad'];
            var foundIndex = -1;

            $(poruchka[sklad]).each(function(index, element) {
                if(element['ime'] == item) {
                    foundIndex = index;
                }
            });
            if(foundIndex != -1) {
                poruchka[sklad][foundIndex]['cena']   = price;
                poruchka[sklad][foundIndex]['broika'] = count;
            } else {
                poruchka[sklad].push({
                    'ime' : item,
                    'cena' : price,
                    'broika' : count
                });
            }
            poruchka['total_price'] = calcPrice(poruchka).toFixed(2);
            console.log(poruchka);
            $('#final-price > span > span').text(poruchka['total_price'] + 'lv');
        }


        function calcPrice(order) {
            var price = 0.00;
            $(Object.keys(order)).each(function(index, element) {
                if(element != 'total_price') {
                    price += calcOrderPrice(order[element]);
                }
            });
            return price;
        }

        function calcOrderPrice(order) {
            var price = 0.00;
            for(var i = 0 ; i < order.length ; i++) {
                price += parseFloat(order[i]['cena']);
            }
            return price;
        }
        
        function handleError(data) {
            $('#' + data['sklad'] + '-error').find('span:first').text(data['message']);
        }
    });
})(jQuery);
(function($) {
    $(document).ready(function() {
        $('#order-button').click(function(e) {
            $.ajax({
                url: '/make-order',
                method: 'post',
                data: JSON.stringify(poruchka)
            }).done(function(jqXHR, status, req) {
                console.log(jqXHR);
            });
        });
    });
})(jQuery);