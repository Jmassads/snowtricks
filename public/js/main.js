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
        const index = $('#trick_images .form-group').length
        // Je recupere le prototype des entrees
        const tmpl = $('#trick_images').data('prototype').replace(/__name__/g, index);
        console.log(tmpl);
        //j'injecte ce code au sein de la div
        $('#trick_images').append(tmpl);

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
});