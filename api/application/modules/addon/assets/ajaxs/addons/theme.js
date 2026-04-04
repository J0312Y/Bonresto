"use strict";
 $(".delete_item").on('click', function(e){
    var item_name = $(this).attr('data_id');
    var CSRF_TOKEN = $("#CSRF_TOKEN").val();
    var base_url = $("#base_url").val();

    swal({
         title: "Are you sure?",
         text: "You will not be able to recover this theme!",
         type: "warning",
         confirmButtonText: lang.yes+", delete it!",
        confirmButtonColor: '#3085d6',
        showCancelButton: true,
        confirmButtonClass: "btn-danger",
        cancelButtonText: lang.no+", cancel plx!",
        cancelButtonColor: '#d33'
     }).then((willDelete) => {
         if (willDelete.value) {
             $.ajax({
                type: 'POST',
                url: base_url + 'addon/theme/theme_delete',
                data: {"csrf_test_name": CSRF_TOKEN,"theme":item_name},
                 success: function(data) {
                      $(".theme_"+item_name).remove();
                      swal("Deleted!", "Your theme has been deleted.", "success");
                 },
                 error: function() {
                    swal("Failed!", "Failed Please try again", "error");
                 }
              })
         } else {
             swal("Cancelled", "Your theme file is safe :)", "success");
         }
     });
 });


// Show color code beside the picker
function bindColorPicker(pickerId, codeId) {
    var picker = document.getElementById(pickerId);
    var code = document.getElementById(codeId);
    code.value = picker.value; // set initial value
    picker.addEventListener('input', function() {
        code.value = this.value;
    });
}

// Bind all pickers
bindColorPicker('primaryColor', 'primaryColorCode');
bindColorPicker('topHeaderBackgroundColor', 'topHeaderBackgroundColorCode');
bindColorPicker('headerBackgroundColor', 'headerBackgroundColorCode');
bindColorPicker('headerTextColor', 'headerTextColorCode');
bindColorPicker('footerBackgroundColor', 'footerBackgroundColorCode');
bindColorPicker('footerTextColor', 'footerTextColorCode');

// Default values map
var defaultColors = {
    primaryColor: "#c09342",
    topHeaderBackgroundColor: "#112a2a",
    headerBackgroundColor: "#1f3433",
    headerTextColor: "#ffffff",
    footerBackgroundColor: "#081d1c",
    footerTextColor: "#ffffff"
};

// Reset button handler
document.getElementById('resetColors').addEventListener('click', function () {
    for (var key in defaultColors) {
        var picker = document.getElementById(key);
        var code = document.getElementById(key + "Code");
        if (picker && code) {
            picker.value = defaultColors[key];
            code.value = defaultColors[key];
        }
    }
});
 