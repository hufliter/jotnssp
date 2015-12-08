if (typeof JTS == "undefined") {
    var JTS = {
        csrf: {
            name: "csrf_token",
            value: "",
            loadForm: function (formSelector) {
                var $form = $(formSelector),
                    $token;
                if ($form.length > 0) {
                    $token = $form.find("[name^=csrf_]");

                    if ($token.length > 0) {
                        JTS.csrf.name = $token.attr("name");
                        JTS.csrf.value = $token.val();
                    }
                }
            },
            fillPostData: function (postData) {
                postData[JTS.csrf.name] = JTS.csrf.value;

                return postData;
            }
        },

        /**
         * Initial namespace
         */
        init: function () {
            $(function () {
                // load default csrf token
                JTS.csrf.loadForm("#_global_form");
            });
        }
    };

    JTS.init();
}