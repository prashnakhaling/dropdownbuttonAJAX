jQuery(document).ready(function ($) {
    $("#number-form").submit(function (event) {
      event.preventDefault();
      var formData = $(this).serialize();
      $.ajax({
        type: "POST",
        url: post_number_meta_ajax_object.ajax_url,
        data: formData + "&action=save_post_number",
        success: function (response) {
          if (response === "success") {
            alert("Number saved successfully!");
          } else {
            alert("Error saving number.");
          }
        },
        error: function (xhr, status, error) {
          console.log(xhr.responseText);
        },
      });
    });
  });