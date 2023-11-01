jQuery(document).ready(function ($) {
  let fs_field_index = $(".fs-faq-field").length;

  $(".fs-add-faq-field").on("click", function () {
    let fs_faq_fields = $(".fs-faq-fields");

    // Create a new field
    let fs_new_field = $(
      "<div class='fs-faq-field'>" +
        "<label class='fs-faq-label' for='faq_question_" +
        fs_field_index +
        "'>Question:</label>" +
        "<input class='fs-faq-input' type='text' id='faq_question_" +
        fs_field_index +
        "' name='faq_data[" +
        fs_field_index +
        "][question]'>" +
        "<br><br>" +
        "<label class='fs-faq-label' for='faq_answer_" +
        fs_field_index +
        "'>Answer:</label>" +
        "<textarea class='fs-faq-textarea' id='faq_answer_" +
        fs_field_index +
        "' name='faq_data[" +
        fs_field_index +
        "][answer]'></textarea>" +
        "<a class='fs-remove-faq-field' href='#'>Remove</a>" +
        "</div>"
    );

    fs_faq_fields.append(fs_new_field);

    fs_field_index++;

    $(".fs-faq-input, .fs-faq-textarea").attr("required", true);

    return false;
  });

  // Remove field
  $(document).on("click", ".fs-remove-faq-field", function () {
    $(this).parent().remove();
    return false;
  });
});
