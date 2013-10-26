document.observe("dom:loaded", function() {

    $('cacheviewer-enable').observe('click', function() {
        toggleCacheViewer(this);
    });

    $('cacheviewer-hints').observe('click', function() {
        toggleCacheViewerHints(this);
    });

    if(Mage.Cookies.get("cacheviewer_enabled") == "true") {
        $('cacheviewer-enable').checked = "checked";
        toggleCacheViewer($('cacheviewer-enable'));
    }

    if(Mage.Cookies.get("cacheviewer_hints_enabled") == "true") {
        $('cacheviewer-hints').checked = "checked";
        toggleCacheViewerHints($('cacheviewer-hints'));
    }

    if (Mage.Cookies.get("cacheviewer_dispatch_time")) {
        $('cacheviewer-dispatch-time').update("<span>Dispatch time:</span>" + Mage.Cookies.get("cacheviewer_dispatch_time"));
        Mage.Cookies.clear("cacheviewer_dispatch_time");
    }

});


function toggleCacheViewer(el) {
    if ($(el).checked) {
        Mage.Cookies.set("cacheviewer_enabled", true);
        $$('.cacheviewer-block').each(function(block) {
            $(block).addClassName('enabled');
        });
    } else {
        Mage.Cookies.set("cacheviewer_enabled", false);
        $$('.cacheviewer-block').each(function(block) {
            $(block).removeClassName('enabled');
        });
    }
}

function toggleCacheViewerHints(el) {
    if ($(el).checked) {
        Mage.Cookies.set("cacheviewer_hints_enabled", true);
        $$('.cacheviewer-hints').each(function(block) {
            $(block).addClassName('enabled');
        });
    } else {
        Mage.Cookies.set("cacheviewer_hints_enabled", false);
        $$('.cacheviewer-hints').each(function(block) {
            $(block).removeClassName('enabled');
        });
    }
}
