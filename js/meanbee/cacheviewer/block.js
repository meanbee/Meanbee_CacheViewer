document.observe("dom:loaded", function() {

    $('cacheviewer-enable').observe('click', function() {
        toggleCacheViewer(this);
    });

    $('cacheviewer-hints').observe('click', function() {
        toggleCacheViewerHints(this);
    });

    if(cacheviewer_cookies.get("cacheviewer_enabled") == "true") {
        $('cacheviewer-enable').checked = "checked";
        toggleCacheViewer($('cacheviewer-enable'));
    }

    if(cacheviewer_cookies.get("cacheviewer_hints_enabled") == "true") {
        $('cacheviewer-hints').checked = "checked";
        toggleCacheViewerHints($('cacheviewer-hints'));
    }

    if (cacheviewer_cookies.get("cacheviewer_dispatch_time")) {
        $('cacheviewer-dispatch-time').update("<span>Dispatch time:</span>" + cacheviewer_cookies.get("cacheviewer_dispatch_time"));
        cacheviewer_cookies.clear("cacheviewer_dispatch_time");
    }

});


function toggleCacheViewer(el) {
    if ($(el).checked) {
        cacheviewer_cookies.set("cacheviewer_enabled", true);
        $$('.cacheviewer-block').each(function(block) {
            $(block).addClassName('enabled');
        });
    } else {
        cacheviewer_cookies.set("cacheviewer_enabled", false);
        $$('.cacheviewer-block').each(function(block) {
            $(block).removeClassName('enabled');
        });
    }
}

function toggleCacheViewerHints(el) {
    if ($(el).checked) {
        cacheviewer_cookies.set("cacheviewer_hints_enabled", true);
        $$('.cacheviewer-hints').each(function(block) {
            $(block).addClassName('enabled');
        });
    } else {
        cacheviewer_cookies.set("cacheviewer_hints_enabled", false);
        $$('.cacheviewer-hints').each(function(block) {
            $(block).removeClassName('enabled');
        });
    }
}
