/**
 * File customize-preview.js.
 *
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 */

(function (api, $) {

    api.bind('preview-ready', function () {

        // Site title and description.
        api('blogname', function (value) {
            value.bind(function (to) {
                $('.site-title a').text(to);
            });
        });
        api('blogdescription', function (value) {
            value.bind(function (to) {
                $('.site-description').text(to);
            });
        });

        /**
         * Default Header Background Image.
         * @see private explanations, too long to be displayed here.
         */
        api('default_header_background_image', function (setting) {
            function tcbKeppDefaultBgImg() {
                if ($('body').is('.home, .blog')) {
                    if (setting._value == 0) {
                        $('#masthead').css('background-image', 'url(' + tcb_cp.tcb_default_header_background_image + ')');
                    } else {
                        $('#masthead').removeAttr('style');
                    }
                }
            }
            setInterval(tcbKeppDefaultBgImg, 500);

            function tcbChangeSliderDefaultBgImg() {
                if (tcb_cp.tcb_activate_slider == true) {
                    if (setting._value == 0) {
                        $('#masthead.no-post-thumbnail').css('background-image', 'url(' + tcb_cp.tcb_default_header_background_image + ')');
                    } else {
                        $('#masthead.no-post-thumbnail').removeAttr('style');
                    }
                }
            }
            setInterval(tcbChangeSliderDefaultBgImg, 500);
        });


        /**
         * Following MutationObserver is to display the default search placeholder text (search...),
         * if the user choose to display another placeholder text, then remove completely his chosen text.
         * This will happen when the user erase all charachters of his text in the Search Form Text option.
         */

        // MutationObserver for Dropdown Search Placeholder Text.
        var targetNodePhT = $("#header-search");
        var observerPhT = new MutationObserver(callbackPhT);
        var obsConfigPht = { attributes: true };
        targetNodePhT.each(function () {
            observerPhT.observe(this, obsConfigPht);
        });
        function callbackPhT(mutations) {
            mutations.forEach(function (mutation) {
                var entry = {
                    mutation: mutation,
                    el: mutation.target,
                    value: mutation.target.placeholder.length,
                };
                if (entry.value == 0) {
                    targetNodePhT.attr('placeholder', tcb_cp.tcb_placeholder_text);
                }
            });
        }

        /**
         * Following MutationObserver are to display default texts,
         * if the user choose to display another text, then remove completely his chosen text.
         * This will happen when the user erase all charachters of his text.
         */

        // MutationObserver for Site Title.
        var targetNode = $("#responsive_headline a");
        var observer = new MutationObserver(callback);
        var obsConfig = { attributes: true };
        targetNode.each(function () {
            observer.observe(this, obsConfig);
        });
        function callback(mutations) {
            mutations.forEach(function (mutation) {
                var entry = {
                    mutation: mutation,
                    el: mutation.target,
                    value: mutation.target.innerText,
                };
                if (entry.value == 0) {
                    targetNode.append(tcb_cp.tcb_site_title);
                }
            });
        }

        // MutationObserver for Search Page Title Text.
        var targetNodeSPTT = $("body.search .intro-header .site-heading h1");
        var observerSPTT = new MutationObserver(callbackSPTT);
        var obsConfigSPTT = { attributes: true };
        targetNodeSPTT.each(function () {
            observerSPTT.observe(this, obsConfigSPTT);
        });
        function callbackSPTT(mutations) {
            mutations.forEach(function (mutation) {
                var entry = {
                    mutation: mutation,
                    el: mutation.target,
                    value: mutation.target.innerText,
                };
                if (entry.value == 0) {
                    targetNodeSPTT.append(tcb_cp.tcb_search_page_title_text);
                }
            });
        }

        // MutationObserver for Search Page Subtitle Text.
        var targetNodeSPST = $("body.search .intro-header .site-heading h2");
        var observerSPST = new MutationObserver(callbackSPST);
        var obsConfigSPST = { attributes: true };
        targetNodeSPST.each(function () {
            observerSPST.observe(this, obsConfigSPST);
        });
        function callbackSPST(mutations) {
            mutations.forEach(function (mutation) {
                var entry = {
                    mutation: mutation,
                    el: mutation.target,
                    value: mutation.target.innerText,
                };
                if (entry.value == 0) {
                    targetNodeSPST.append(tcb_cp.tcb_search_page_subtitle_title_text);
                }
            });
        }

        // MutationObserver for Search Results Page Title Text.
        var targetNodeSRPTT = $("body.search .page-header h1.page-title #srft");
        var observerSRPTT = new MutationObserver(callbackSRPTT);
        var obsConfigSRPTT = { childList: true };
        targetNodeSRPTT.each(function () {
            observerSRPTT.observe(this, obsConfigSRPTT);
        });
        function callbackSRPTT(mutations) {
            mutations.forEach(function (mutation) {
                var entry = {
                    mutation: mutation,
                    el: mutation.target,
                    value: mutation.target.innerText,
                };
                if (entry.value == 0) {
                    targetNodeSRPTT.append(tcb_cp.tcb_search_results_page_text);
                }
            });
        }

        // MutationObserver for Search No Results Page Title Text.
        var targetNodeSNRPTT = $("body.search-no-results .page-header h1.page-title");
        var observerSNRPTT = new MutationObserver(callbackSNRPTT);
        var obsConfigSNRPTT = { childList: true };
        targetNodeSNRPTT.each(function () {
            observerSNRPTT.observe(this, obsConfigSNRPTT);
        });
        function callbackSNRPTT(mutations) {
            mutations.forEach(function (mutation) {
                var entry = {
                    mutation: mutation,
                    el: mutation.target,
                    value: mutation.target.innerText,
                };
                if (entry.value == 0) {
                    targetNodeSNRPTT.append(tcb_cp.tcb_search_no_results_page_title_text);
                }
            });
        }

        // MutationObserver for Search No Results Page Paragraph Text.
        var targetNodeSNRPPT = $("body.search-no-results .page-content p");
        var observerSNRPPT = new MutationObserver(callbackSNRPPT);
        var obsConfigSNRPPT = { childList: true };
        targetNodeSNRPPT.each(function () {
            observerSNRPPT.observe(this, obsConfigSNRPPT);
        });
        function callbackSNRPPT(mutations) {
            mutations.forEach(function (mutation) {
                var entry = {
                    mutation: mutation,
                    el: mutation.target,
                    value: mutation.target.innerText,
                };
                if (entry.value == 0) {
                    targetNodeSNRPPT.append(tcb_cp.tcb_search_no_results_page_paragraph_text);
                }
            });
        }

        // MutationObserver for Error404 Page Title Text.
        var targetNodeEPTT = $("body.error404 .intro-header .site-heading h1");
        var observerEPTT = new MutationObserver(callbackEPTT);
        var obsConfigEPTT = { childList: true };
        targetNodeEPTT.each(function () {
            observerEPTT.observe(this, obsConfigEPTT);
        });
        function callbackEPTT(mutations) {
            mutations.forEach(function (mutation) {
                var entry = {
                    mutation: mutation,
                    el: mutation.target,
                    value: mutation.target.innerText,
                };
                if (entry.value == 0) {
                    targetNodeEPTT.append(tcb_cp.tcb_error404_page_title_text);
                }
            });
        }

        // MutationObserver for Error404 Page Subtitle Text.
        var targetNodeEPST = $("body.error404 .intro-header .site-heading h2");
        var observerEPST = new MutationObserver(callbackEPST);
        var obsConfigEPST = { childList: true };
        targetNodeEPST.each(function () {
            observerEPST.observe(this, obsConfigEPST);
        });
        function callbackEPST(mutations) {
            mutations.forEach(function (mutation) {
                var entry = {
                    mutation: mutation,
                    el: mutation.target,
                    value: mutation.target.innerText,
                };
                if (entry.value == 0) {
                    targetNodeEPST.append(tcb_cp.tcb_error404_page_subtitle_text);
                }
            });
        }

        // MutationObserver for Search 404 Page Title Text.
        var targetNodeSEPTT = $("body.error404 .page-header h1.page-title");
        var observerSEPTT = new MutationObserver(callbackSEPTT);
        var obsConfigSEPTT = { childList: true };
        targetNodeSEPTT.each(function () {
            observerSEPTT.observe(this, obsConfigSEPTT);
        });
        function callbackSEPTT(mutations) {
            mutations.forEach(function (mutation) {
                var entry = {
                    mutation: mutation,
                    el: mutation.target,
                    value: mutation.target.innerText,
                };
                if (entry.value == 0) {
                    targetNodeSEPTT.append(tcb_cp.tcb_search_404_page_title_text);
                }
            });
        }

        // MutationObserver for Search 404 Page Paragraph Text.
        var targetNodeSEPPT = $("body.error404 .page-content > p");
        var observerSEPPT = new MutationObserver(callbackSEPPT);
        var obsConfigSEPPT = { childList: true };
        targetNodeSEPPT.each(function () {
            observerSEPPT.observe(this, obsConfigSEPPT);
        });
        function callbackSEPPT(mutations) {
            mutations.forEach(function (mutation) {
                var entry = {
                    mutation: mutation,
                    el: mutation.target,
                    value: mutation.target.innerText,
                };
                if (entry.value == 0) {
                    targetNodeSEPPT.append(tcb_cp.tcb_search_404_page_paragraph_text);
                }
            });
        }

    });

})(wp.customize, jQuery);