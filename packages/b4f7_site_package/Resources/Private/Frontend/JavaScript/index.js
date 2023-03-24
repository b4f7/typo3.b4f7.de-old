'use strict';

import '../Css/index.scss';

document.addEventListener('DOMContentLoaded', () => {
  if (jQuery) {
    // if cache is false (default), jQuery adds a cache-busting parameter to
    // jsonp requests which breaks ext-solr's autosuggestions
    jQuery.ajaxSetup({
      cache: true,
    });
  }
});
