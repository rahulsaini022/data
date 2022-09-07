


$(document).ready(function () {
    $("input[type='text']").attr("maxlength", "100");

    $('button[type="submit"]').css("float", "left");
    $(":checkbox").removeClass("form-control");
    $(".pagination").addClass("flex-wrap");
    var is_admin = $("#admin_main");
    if (is_admin.length) {
        // console.log(window.location.protocol + "//" + window.location.host + "/" + window.location.pathname.split('/')[1]);
        $(
            '#admin_main #sidebar a[href="' +
                window.location.protocol +
                "//" +
                window.location.host +
                "/" +
                window.location.pathname.split("/")[1] +
                '"]'
        ).addClass("active");
        var test = $(
            '#admin_main #sidebar a[href="' +
                window.location.protocol +
                "//" +
                window.location.host +
                "/" +
                window.location.pathname.split("/")[1] +
                '"]'
        )
            .closest(".submenu_outerbox")
            .addClass("show");
        $(
            '#admin_main #sidebar a[href="' +
                window.location.protocol +
                "//" +
                window.location.host +
                "/" +
                window.location.pathname.split("/")[1] +
                '"]'
        )
            .closest(" ul .nav li a.nav-link")
            .removeClass("collapsed")
            .attr("aria-expended", "true");
        $(
            '#admin_main #sidebar a[href="' + window.location.href + '"]'
        ).addClass("active");
    }
    /* Role create and edit validation*/
    $("#role_form").validate({
        errorPlacement: function (error, element) {
            if (element.attr("name") === "permission[]") {
                error.appendTo(".permission_error");
            } else {
                error.insertAfter(element);
            }
        },
    });
    /* admin forms validation*/
    $("#testimonial_form ,#pdfcredit_form ,#page_form ,#clerk_form ,#court_form ,#division_form ,#stripeplans_form").validate();
  
    $("#case_package_form").validate({
        errorPlacement: function (error, element) {
            if (element.attr("name") === "case_type_ids[]") {
                error.appendTo(".case_type_error");
            } else {
                error.insertAfter(element);
            }
        },
    });
});
/** */
function onlyNumber(e) {
    var x = e.which || e.keycode;
    if (x >= 48 && x <= 57) {
        return true;
    } else {
        return false;
    }
}
/**confirmation  on form submission */
function ConfirmDelete(e) {
    var form = e.path[1];
      var text = $(e.target).val().toLowerCase();
    
    event.preventDefault();
    Swal.fire({
        text: "Are you sure you want to " + text + " ?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonText: "No",
        width:"24em",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, " + text + " it!",
    }).then((result) => {
        if (result.isConfirmed) {
            // Swal.fire("Deleted!", "success");
            form.submit();
        }
    });
}
// case hide/show confirmation
function ConfirmHide(e) {
    var form = e.path[1];
    var text = $(e.target).data('text');
    
    event.preventDefault();
    Swal.fire({
        text: text,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonText: "No",
        width:"40em",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, hide it!",
    }).then((result) => {
        if (result.isConfirmed) {
            // Swal.fire("Deleted!", "success");
            form.submit();
        }
    });
}
/** confirmation on status change and confirmation on anchor tag before hit url   */
function ConfirmStatus(e) {
    var form = e.path[0];
    var text = $(e.target).html().toLowerCase();
   
    var url = $(form).attr("href");
    event.preventDefault();
    Swal.fire({
        text: "Are you sure you want to " + text + " ?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        width: "24em",
        cancelButtonColor: "#d33",
        cancelButtonText: "No",
        confirmButtonText: "Yes, " + text + " it!",
    }).then((result) => {
        if (result.isConfirmed) {
            window.location = url;
            return true;
        } else {
            return false;
        }
    });
}

