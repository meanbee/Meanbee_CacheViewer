;
/**
 *
 * @param fetch_url
 * @param delete_url
 * @param chart_el
 * @param chart_data
 * @constructor
 */
Meanbee_CacheViewer_Admin_Report = function (fetch_url, delete_url, chart_el, chart_data) {
    $$('.action-delete').each(function (el) {
        var cache_id = el.readAttribute('data-cache-id');

        el.observe('click', function (e) {
            Event.stop(e);

            if (confirm('Are you sure you want to delete this cache item?')) {
                new Ajax.Request(delete_url + '?cache_id='+cache_id, {
                    method: 'post',
                    onSuccess: function () {
                        window.location.reload()
                    }
                });
            }
        });
    });

    $$('.action-fetch').each(function (el) {
        var cache_id = el.readAttribute('data-cache-id');
        var target_id = el.readAttribute('data-output-target');

        var target_el = $(target_id).firstDescendant();
        var placeholder_text = target_el.readAttribute('data-placeholder');

        el.observe('click', function (e) {
            Event.stop(e);

            target_el.toggle();

            if (target_el.style.display != 'none') {
                target_el.innerHTML = placeholder_text;

                new Ajax.Request(fetch_url + '?cache_id='+cache_id, {
                    method: 'post',
                    onSuccess: function (response) {
                        target_el.innerHTML = response.responseText;
                    }
                });
            }
        });
    });

    google.load("visualization", "1", {packages:["corechart"]});
    google.setOnLoadCallback(function () {
        var chart = new google.visualization.PieChart(chart_el);
        var data = google.visualization.arrayToDataTable(chart_data);
        var options = {
            title: 'Reported Cache Usage',
            legend: 'none',
            is3D: true
        };

        chart.draw(data, options);
    });
}
