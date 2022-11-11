/**
 * Code contains all stuffs related to public
 *
 * @package Job_Application_Form
 */

(function ($, data) {
    'use strict';
    $(
        function () {
            $(document).on("submit", ".job-application-form", function (e) {
                e.preventDefault();
                let $form = $(this);
                $form.find("button").attr("disabled", true);
                $.ajax({
                    url: $form.attr("action"),
                    type: $form.attr("method"),
                    dataType: "JSON",
                    data: new FormData(this),
                    processData: false,
                    contentType: false,
                    success: function (response) {
                        if (response.success) {
                            $form.trigger("reset");
                            alert(response.message)
                        } else {
                            alert(response.message)
                        }
                        $form.find("button").attr("disabled", false);
                    },
                    error: function (response) {
                        //Handle error.
                        $form.find("button").attr("disabled", false);
                    }
                });
            })
        }
    );
})(jQuery);
