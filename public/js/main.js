$(document).ready(function() {
    $("#lightSlider").lightSlider({
        item:4,
        loop:false,
        slideMove:2,
        easing: 'cubic-bezier(0.25, 0, 0.25, 1)',
        speed:600,
        responsive : [
            {
                breakpoint:800,
                settings: {
                    item:3,
                    slideMove:1,
                    slideMargin:6,
                }
            },
            {
                breakpoint:480,
                settings: {
                    item:2,
                    slideMove:1
                }
            }
        ]
    });

    $('#add-image').click(function () {
        //Je recupere le numero des futurs champs que je vais creer
        const index = +$('#widgets-counter').val();

        // Je recupere le prototype des entrees
        const tmpl = $('#trick_images').data('prototype').replace(/__name__/g, index);

        //j'injecte ce code au sein de la div
        $('#trick_images').append(tmpl);
        $('#widgets-counter').val(index + 1);
        //Je gere le bouton supprimer
        handleDeleteButtons();
    });

    $('#add-video').click(function () {
        //Je recupere le numero des futurs champs que je vais creer
        const index = +$('#videos-counter').val();

        console.log(index);
        // Je recupere le prototype des entrees
        const tmpl = $('#trick_videos').data('prototype').replace(/__name__/g, index);
        // console.log(tmpl);

        //j'injecte ce code au sein de la div
        $('#trick_videos').append(tmpl);
        $('#videos-counter').val(index + 1);
        //Je gere le bouton supprimer
        handleDeleteButtons();
    });

    function handleDeleteButtons(){
        $('button[data-action="delete"]').click(function(){
            const target = this.dataset.target;
            console.log(target);
            $(target).remove();
        })
    }

    handleDeleteButtons();

    function updateImagesCounter(){
        const count = +$('#trick_images .form-group').length;

        console.log(count);

        $('#widgets-counter').val(count);
    }

    updateImagesCounter();

    function updateVideosCounter(){
        const count = +$('#trick_videos .form-group').length;

        console.log(count);

        $('#videos-counter').val(count);
    }

    updateVideosCounter();

    $(".trick").slice(0, 6).show();
    $("#loadMoreTrick").on("click", function (e) {
        e.preventDefault();
        $("div.trick:hidden").slice(0, 6).slideDown();
        if ($("div.trick:hidden").length === 0) {
            $("#loadMoreTrick").hide("slow");
            $("#loadLessTrick").show("slow");
        }
    });
    $("#loadLessTrick").on("click", function (e) {
        e.preventDefault();
        $("div.trick").slice(6, $("div.trick").length).hide();
        $("#loadLessTrick").hide("slow");
        $("#loadMoreTrick").show("slow");

    });
});

