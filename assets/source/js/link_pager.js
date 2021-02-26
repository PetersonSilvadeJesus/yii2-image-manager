
var demoPagerWidget = {
    init: function (options) {
        if (options.pageSizeParam == "undefined" || !(options.pageSizeParam)) {
            return;
        }
        if (options.url == "undefined" || !(options.url)) {
            return;
        }

        this.bindEvent(options.pageSizeParam, options.url);
    },
    bindEvent: function (pageSizeParam, url) {
        // $('select[name="per-page"]')
        $('select[name="' + pageSizeParam + '"]').on('change', function () {
            var selectedPageSize = $(this).val();
            console.log(selectedPageSize)
            console.log($(this))

            // new RegExp("\(&per-page=\)\\d+", "gi")
            // var pattern = new RegExp("\(&" + pageSizeParam + "=\)\\d+", "gi");
            // var newUrl = url.replace(pattern, "$1"+selectedPageSize);
            var newUrl = url+"&per-page="+selectedPageSize;
            console.log(newUrl)
            window.location.href = newUrl;
        });
    }
};