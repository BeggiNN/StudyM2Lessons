define(
    [
        'jquery',
        'Magento_Ui/js/modal/modal',
        'jquery/ui'
    ],
    function(
        $,
        modal
    ) {
        var opt = {
            type: 'popup',
            responsive: true,
            innerScroll: true,
            modalClass: 'citymodal',
            buttons: [{
                text: $.mage.__('Ні, обрати іншe'),
                class: 'action location_decline',
                click: function () {
                    $('#city').modal(options).modal('openModal');
                    this.closeModal();
                }
            },
                {
                    text: $.mage.__('Так'),
                    class: 'action primary location_accept',
                    click: function () {
                        this.closeModal();
                    }
                }
            ]
        };

        var options = {
            type: 'popup',
            responsive: true,
            innerScroll: true,
            modalClass: 'popuup',
            buttons: [{
                text: $.mage.__('Обрати'),
                class: 'action primary location_accept_city',
                click: function () {
                    var city = $('#city-input').val();
                    $('#my-city').text(city);
                    $.cookie('ip', city, {expires: 7});
                    this.closeModal();
                }
            },
        ]
        };
        $("#city-input").on('keyup', function () {
            var cities = $(this).val();
            if (cities.length >= 3) {
                $.ajax({
                    type: 'POST',
                    dataType: 'json',
                    url: 'https://api.novaposhta.ua/v2.0/json/',
                    data: JSON.stringify({
                        modelName: 'Address',
                        calledMethod: 'getCities',
                        methodProperties: {
                            FindByString: cities,
                        },
                        apiKey: '8eea9a9a8cddeb6a5dde83bc47069e79'
                    }),
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    success: function (data) {
                        document.getElementById("livesearch").style.display = 'block';
                        var html = '';
                        for(let i=0; i<data.data.length; i++) {
                            html += '<div id="result" class="autocomplete results'+ i +'" value='+ data.data[i].Description +'>' + data.data[i].Description + '</div>';
                        }
                        $('#livesearch').html(html);
                        $(".autocomplete").click(function () {
                            var city = $('#result').text();
                            $('#city-input').val(city);
                            $('.autocomplete').hide();
                            $('#livesearch').hide();
                        });
                    }
                })
            }
            else {
                $('#livesearch').hide();
            }
            })
            $("#button-location").click(function () {
                $('#city').modal(options).modal('openModal');
            });
            if (!$.cookie('ip')) {
                $(document).ready(function () {
                    $.getJSON("https://ipfind.co/me?&auth=bf5db918-12f2-4a85-9c47-1b9ec1cdb86c&lang=uk", function (result) {
                        $("#my-city").html(result.city);
                        $(".location-city").html("<b>" + result.city + " це ваше місто?</b>");
                        $('#what').modal(opt).modal('openModal');
                        $('#cityy').html(city);
                        $.cookie('ip', result.city, {expires: 7});
                    });
                });
            } else {
                $('#my-city').html($.cookie('ip'));
            }
    })