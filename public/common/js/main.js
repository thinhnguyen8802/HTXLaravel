jQuery(document).ready(function ($) {
    $("#delete_image").hide();
    $("#edit_image").hide();
    $('[name="image"]').hide();
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $("#preview_image").show();
                $("#preview_image").attr("src", e.target.result);
                $("#add_image").hide();
                $("#edit_image").show();
                $("#delete_image").show();
            };
            reader.readAsDataURL(input.files[0]);
        }
    }

    $('[name="image"]').change(function () {
        readURL(this);
    });

    $("#add_image,#edit_image").click(function (event) {
        $('[name="image"]').trigger("click");
    });

    $("#delete_image").click(function (event) {
        $('[name="image"]').val("");
        $("#preview_image").attr("src", "");
        $("#preview_image").hide();
        $("#delete_image").hide();
        $("#edit_image").hide();
        $("#add_image").show();
    });


    activeMenu();
    function activeMenu() {
        const dataMenu = $("#menu-active").attr("data-active-menu");
        const menu = $(`.nav-link[data-menu="${dataMenu}"]`);
        $(".nav-link").removeClass("active");
        menu.addClass("active");

    }
});

$("form input, form select").on("blur", function () {
    var $input = $(this);
    var $labelForm = $input.siblings("label");
    var $textError = $labelForm.find(".error");
    var inputTextLength = $input.val().length;

    if ($textError.length && inputTextLength > 0) {
        $input.removeClass("is-invalid");
        $textError.html("").removeClass("text_error");
    }
});



function closeToast() {
    const toast = document.querySelector(".toastms");
    var closeIcon = document.querySelector(".close-toast");
    let timer1, timer2;

    if (closeIcon != undefined) {
        closeIcon.addEventListener("click", () => {
            toast.classList.remove("active");

            setTimeout(() => {
                toast.classList.remove("active");
            }, 300);

            clearTimeout(timer1);
            clearTimeout(timer2);
        });
    }
    if (toast != undefined) {
        timer1 = setTimeout(() => {
            toast.classList.remove("active");
        }, 5000); //1s = 1000 milliseconds

        timer2 = setTimeout(() => {
            toast.classList.remove("active");
        }, 5300);
    }
};
closeToast();