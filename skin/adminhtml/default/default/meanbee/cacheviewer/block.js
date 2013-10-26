document.observe("dom:loaded", function() {

    $('cacheviewer-enable').observe('click', function() {
        toggleCacheViewer(this);
    });

    $('cacheviewer-hints').observe('click', function() {
        toggleCacheViewerHints(this);
    });

});


function toggleCacheViewer(el) {
    if ($(el).checked) {
        $$('.cacheviewer-block').each(function(block) {
            $(block).addClassName('enabled');
        });
    } else {
        $$('.cacheviewer-block').each(function(block) {
            $(block).removeClassName('enabled');
        });
    }
}

function toggleCacheViewerHints(el) {
    if ($(el).checked) {
        $$('.cacheviewer-hints').each(function(block) {
            $(block).addClassName('enabled');
        });
    } else {
        $$('.cacheviewer-hints').each(function(block) {
            $(block).removeClassName('enabled');
        });
    }
}