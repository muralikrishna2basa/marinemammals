/*

 Plugin search, used to search in the database,

 A particular Html structure is attached to this script.
 perform_search : call the php file via ajax, and perform the search
 filter_search : used to search the database for the appropriate domain values of a filter if applicable.( ajax loaded)

 search object is the particular object for which the search is performed


 */
(function ($) {
    $.fn.search = function (options) {


        options = $.extend({
            perform_search: 'functions/perform_search.php',
            filter_search: 'functions/filter_search.php',
            search_object: 'Search_Samples',
            search_results: 'search_results',
            that: $(this),
            callback_results: function () {
            }, // callback after the search has been performed
            callback_search: function (test) {
                return test;
            },  // calback prior to the search
            datenames: ['date', 'other date']
        }, options || {}); // replace default values by user defined


        return this.each(function () {
            var changefunction = function (event) {
                // Retrieve the searcher class (oo)
                var searcher_class = options.search_object;
                var searchbox = $(event.target).parents('div.Search_Box');
                var selected = $(event.target).val(); // selected item

                data_to_send = {filter: selected, searcher: searcher_class};

                $.ajax({
                    url: options.filter_search,
                    type: 'POST',
                    datatype: 'json',
                    data: data_to_send,
                    success: function (data) {

                        if (data != undefined) {
                            var filters = $.evalJSON(data).filters;
                            var tokens = $.evalJSON(data).tokens;
                            var domain = $.evalJSON(data).domain;
                            // init state
                            searchbox.find('div.tokens select').empty();
                            searchbox.find('div.fields select').empty();
                            searchbox.find('div.fields select').parent().show();
                            searchbox.find('div.fields input').parent().hide();
                            // at load time
                            if (filters) {

                                searchbox.find('div.filters select').empty();
                                searchbox.find('div.filters select').append('<option></option>');
                                $.each(filters, function (ind, val) {
                                    searchbox.find('div.filters select').append('<option>' + val + '</option>');
                                });
                            }
                            // when the filters are solicitated
                            if (tokens) {


                                $.each(tokens, function (ind, val) {
                                    searchbox.find('div.tokens select').append('<option>' + val + '</option>');
                                });

                                if (domain.length == 0) {
                                    searchbox.find('div.fields select').parent().hide();
                                    searchbox.find('div.fields input').parent().show();
                                }
                                else {
                                    searchbox.find('div.fields select').parent().show();
                                    searchbox.find('div.fields input').parent().hide();
                                    $.each(domain, function (ind, val) {
                                        searchbox.find('div.fields select').append('<option>' + val + '</option>');
                                    });
                                }
                            }

                            // together with the plugin datepicker
                            for (i = 0; i < options.datenames.length; i++) {
                                if (searchbox.find('div.filters select').val() == options.datenames[i]) {
                                    searchbox.find('div.fields input').datepick({dateFormat: 'dd-M-y'});
                                    break;
                                }
                                else {
                                    searchbox.find('div.fields input').datepick('destroy');
                                }
                            }


                        }
                    }
                });
            }

            var deletefunction = function () {
                $(this).parents('div.Search_Box:first').remove();
                return false;
            }

            var triggersfunction = function () {

                if (typeof options.callback_results == 'function') {
                    options.callback_results();
                }

                options.that.find('div.' + options.search_results + ' tr').click(function () {

                    if (this.parentNode.tagName == 'TBODY') {
                        $(this).addClass('isclicked').siblings().removeClass('isclicked');
                    }
                });


                options.that.find('div.' + options.search_results + ' .sort').click(function (event) {
                    // how to get the page number

                    current_page = options.that.find('div.' + options.search_results + ' div.navigation_bar').
                        find('select option:selected').val();

                    item_pp = options.that.find('div.' + options.search_results + ' select.rpp').val();
                    if ($(this).attr('sorted') == 'ASC') {
                        sortype = 'DESC';
                    } else {
                        sortype = 'ASC';
                    }

                    // searchfor($(this).text(),sortype,parseInt(current_page),item_pp);
                    searchfor($(this).text(), sortype, 1, item_pp);  // on sort come back to page 1, jdw 01/04
                    return false;
                });


                options.that.find('div.board select.rpp').change(function () {

                    current_page = options.that.find('div.' + options.search_results + ' div.navigation_bar').
                        find('select option:selected').val();

                    item_pp = $(this).val();


                    item_sorted = options.that.find('div.' + options.search_results + ' .sort[sorted]');
                    if (item_sorted.length != 0) {
                        pagesort = item_sorted.text();
                    }
                    else {
                        pagesort = null;
                    }

                    if (options.that.find('a.sort[sorted]').length == 1) {
                        sortype = options.that.find('a.sort[sorted]').attr('sorted');
                    }
                    else {
                        sortype = null;
                    }


                    searchfor(pagesort, sortype, parseInt(current_page), item_pp);
                    return false;
                });

                options.that.find('div.navigation_bar select').change(function () {

                    current_page = options.that.find('div.' + options.search_results + ' div.navigation_bar').
                        find('select option:selected').val();

                    item_pp = options.that.find('div.' + options.search_results + ' select.rpp').val();


                    item_sorted = options.that.find('div.' + options.search_results + ' .sort[sorted]');
                    if (item_sorted.length != 0) {
                        pagesort = item_sorted.text();
                    }
                    else {
                        pagesort = null;
                    }

                    if (options.that.find('a.sort[sorted]').length == 1) {
                        sortype = options.that.find('a.sort[sorted]').attr('sorted');
                    }
                    else {
                        sortype = null;
                    }

                    searchfor(pagesort, sortype, parseInt(current_page), item_pp);
                    return false;
                });

                options.that.find('div.' + options.search_results + ' .previous_page,div.' + options.search_results + ' .next_page').click(function (event) {

                    page = $(this).attr('class');
                    current_page = $(this).parents('div:first').find('select option:selected').val();

                    item_pp = options.that.find('div.' + options.search_results + ' select.rpp').val();


                    switch (page) {
                        case 'previous_page':
                            pagenumber = parseInt(current_page) - 1;
                            break;
                        case 'next_page':
                            pagenumber = parseInt(current_page) + 1;
                            break;

                    }
                    item_sorted = options.that.find('div.' + options.search_results + ' .sort[sorted]');
                    if (item_sorted.length != 0) {
                        pagesort = item_sorted.text();
                    }
                    else {
                        pagesort = null;
                    }

                    if (options.that.find('a.sort[sorted]').length == 1) {
                        sortype = options.that.find('a.sort[sorted]').attr('sorted');
                    }
                    else {
                        sortype = null;
                    }

                    searchfor(pagesort, sortype, pagenumber, item_pp);
                    return false;
                });


                options.that.find('input.searchornot').click(function () {

                    if (options.that.find('div.Search_search_tool:visible').length == 0) {
                        $(this).val('Hide Filter(s)');
                    }
                    else {
                        $(this).val('Show Filter(s)');
                    }

                    options.that.find('div.Search_search_tool').toggle();

                });

            }


            var searchfor = function (sort, sortype, pagenumber, item_pp) {

                data = '{"filter1":{"filter":"filtername","operator":"operatorname","field":"fieldname"},';

                data = "{";

                options.that.find('div.Search div.Search_Box').each(function (index) {

                    filtername = $(this).find('div.filters select').val();
                    operatorname = $(this).find('div.tokens select').val();

                    fieldname_select = $(this).find('div.fields select').val();
                    fieldname_input = $(this).find('div.fields input').val();

                    // surely not optimal but it works
                    if (fieldname_select != null && fieldname_input.length != 0) {
                        if ($(this).find('div.fields select:visible') == null) {
                            fieldname = fieldname_input;
                        }
                        else {
                            fieldname = fieldname_select;
                        }
                    }
                    else if (fieldname_select != null) {
                        fieldname = fieldname_select;
                    }

                    else if (fieldname_input.length != 0) {
                        fieldname = fieldname_input;
                    }

                    else if (fieldname_select == null && fieldname_input.length == 0) {
                        fieldname = fieldname_input;
                    }

                    // a valid filtering contains the triplet filtername, operatorname,fieldname

                    if (filtername && operatorname && fieldname) {

                        data += '"filter' + index + '":{"filter":"' + filtername + '","operator":"' + operatorname + '","field":"' + fieldname + '"},';


                    }
                    ;
                    // create json data's containing all the object to be passed to the search tool, but only if the input fields or
                    // select fields are filled with something.

                })
                if (typeof item_pp == 'undefined') {
                    item_pp = options.that.find('div.' + options.search_results + ' select.rpp').val();
                }

                data += '"dum":"dum"}';


//	if(typeof sort == 'string' && options.that.find('a.sort[sorted]').length == 1)
//	{
//	 		sorttype = options.that.find('a.sort[sorted]').attr('sorted');
//	 		if(sorttype =='ASC') { sorttype = 'DESC';} else { sorttype = 'ASC';}
//	 		
//	}
//	else
//	{
//	 	   sorttype = 'ASC';
//	}

                if (typeof sort == 'string' && typeof pagenumber == "number") {
                    data_search = {
                        sort_type: sortype,
                        search_json: data,
                        search_page: pagenumber,
                        search_sort: sort,
                        search_ppr: item_pp
                    };
                }
                if (typeof sort == 'string' && typeof pagenumber != "number") {
                    data_search = {sort_type: sortype, search_json: data, search_sort: sort, search_ppr: item_pp};
                }
                if (typeof sort != 'string' && typeof pagenumber != "number") {
                    data_search = {search_json: data, search_ppr: item_pp};
                }
                if (typeof sort != 'string' && typeof pagenumber == "number") {
                    data_search = {search_json: data, search_page: pagenumber, search_ppr: item_pp};
                }
                if (typeof options.callback_search == 'function') {
                    data_search = options.callback_search(data_search);
                }


                $.ajax({
                    url: options.perform_search,
                    type: 'GET',
                    datatype: 'json',
                    data: data_search,
                    success: function (data) {

                        options.that.find('div.' + options.search_results).html(data);

                        triggersfunction();

                    }
                });
                return false;
            };

            $('div.Search div.delSearch_Box').click(deletefunction);

            options.that.find('div.Search div.filters select').change(changefunction).change();

            options.that.find('div.search_tool a.Search_for').click(searchfor);

            triggersfunction();

            options.that.find('div.search_tool .addSearch_Box').click(function () {


                options.that.find('div.Search div.Search_Box').parents('span:first').
                    append('<div class="Search_Box first">' + options.that.find('div.Search div.Search_Box:hidden').html() + '</div>');
                $('div.first').find('div.delSearch_Box').click(deletefunction);
                $('div.first').removeClass('first').find('div.filters select').change(changefunction);
                return false; // prevent submission
            });

        });

    };

})(jQuery);
       