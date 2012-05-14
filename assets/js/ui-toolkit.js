// ui initialization
function uiInit(within) {  
  // Initialize ui elements within "within" object
  if(typeof within === 'undefined') {
    within = jQuery('body');
  }
  
  // Define ui elements which are available to load (note, only 
  // elements which require js need be initialized)
  var uiAvailable = [];
  
  // Holder for all instantiated ui elements
  window.c = [];
  
  uiAvailable[0] = {'class': 'uiTextInputPlaceholder', 'function': uiTextInput};
  uiAvailable[1] = {'class': 'uiSelectHTML', 'function': uiSelect};
  uiAvailable[2] = {'class': 'uiLightboxHTML', 'function': uiLightbox};
  
  // Search dom for ui elements to load
  for (var i in uiAvailable) {
    within.find('.'+uiAvailable[i]['class']).each(function() {
      if (typeof this.id != 'undefined') {
        var cInit = new uiAvailable[i]['function'](this);
        window.c.push(cInit);
      }
    });
  }
}

function uiTextInput(el) {

  // Properties
  this.el = el;
  this.defaultText = el.value;            // UDefault text gathered from the initial state of the input element

  // Methods
  this.attachCallbacks = function() {
    var uiTextInput = this;
    jQuery(this.el).bind('focus',function() {return uiTextInput.Focus(this);});
    jQuery(this.el).bind('blur',function() {return uiTextInput.Blur(this);});
    jQuery(this.el).closest('form').bind('submit',function() {return uiTextInput.SanitizeSubmit(this);});    
  };
  
  this.Focus = function(el) {
    // FOCUS EVENT HANDLER
    // Get the uiTextInput instance for this <input>
    if (el.value == this.defaultText) {
      el.value = '';
      jQuery(el).removeClass('uiTextInputPlaceholder');
    }
  };
  
  this.Blur = function(el) {
    // BLUR EVENT HANDLER
    // Get the uiTextbox instance for this <input>
    if (el.value.length == 0) {
      el.value = this.defaultText;
      jQuery(el).addClass('uiTextInputPlaceholder');
    }
  };
  
  this.SanitizeSubmit = function(el) {
    // FORM SUBMIT HANDLER
    if (this.el.value == this.defaultText) {
      this.el.value = '';
    }
  };
  
  // Constructor
  this.attachCallbacks();
  // Attach this uiTextInput instance to the parent div (for event handler access)
  jQuery(this.el).data('uiTextInput', this);
  
}

function uiSelect(el) {
  // Properties
  this.options = [];                  // The default selected option is the first <option>
  this.id = 'uiSelect-'+el.id;       // DOM ID of the top level uiSelect div (which is built at runtime)
  this.htmlId = el.id;
  this.selected = null;
  
  // Methods
  this.inspectOptions = function(el) {
    // step through el to find child options. Save value/innerHTML to this.options
    var uiSelect = this;
    jQuery('#'+el.id).find('*').each(function () {
      arr = {'nodeName': this.nodeName, 'value': this.value, 'text': this.text, 'childCount': jQuery(this).children().length};
      uiSelect.options.push(arr);
      if (jQuery(this).attr('selected')) {
        uiSelect.selected = arr;
      }
    });
    
    // set default selected value (as the first option if defaultSelectedValue is still null)
    if (!this.selected) {
      this.selected = this.options[0];
    }
   
  };

  this.buildUiSelect = function() {    
    /* build DOM to this template:
      <div id='uiSelect-uiSelectExample' class='uiSelectContainer'>
        <a id='uiSelect-uiSelectExample-button' href='#' class='uiButton uiButtonSelect'>Choose Options</a>
        <ul class='dropdownContainer'>
          <li class='row selected'>Choose Options</li>
          <li class='divider'></li>
          <li class='row'>Option 1</li>
          <li class='row'>Option 2</li>
          <li class='divider'></li>
          <li class='row'>Option 3</li>
          <li class='row'>Option 4</li>
          <li class='divider'></li>
        </ul>
      </div>
    */

    // First, delete the uiSelectContainer if it already exists
    jQuery('#'+this.id).remove();

    // Now find the place to build the top level div and build it
    // We want to place it directly before the HTML <select> in DOM
    jQuery('#'+this.htmlId).before('<div id='+this.id+' class=\'uiSelectContainer\'></div>');
    
    // Build rest of DOM in the div we just created
    jQuery('#'+this.id).append('<a id=\''+this.id+'-button\' href=\'#\' class=\'uiButton uiButtonSelect\'>'+this.selected['text']+'</a>');
    jQuery('#'+this.id).append('<ul class=\'dropdownContainer\'></ul>');
    var ul = jQuery('#'+this.id).find('ul[class=\'dropdownContainer\']').first();
    for (var i in this.options) {
      if (this.options[i]['nodeName'].toLowerCase() == 'optgroup' && this.options[i]['childCount'] > 0) {
        jQuery(ul).append('<li class=\'divider\'></li>');
      } else if (this.options[i]['nodeName'].toLowerCase() == 'option') {
        if (this.selected['value'] == this.options[i]['value']) {
          jQuery(ul).append('<li class=\'row selected\'>'+this.options[i]['text']+'</li>');
        } else {
          jQuery(ul).append('<li class=\'row\'>'+this.options[i]['text']+'</li>');
        }
      }
    }
    
    // Bind actions to certain dom elements
    // This one handles the open/close nature of the dropdown
    var uiSelect = this;
    jQuery('#'+this.id+'-button').bind('click',function() {return uiSelect.ButtonClick(this);});
    // This sets a specific li as the new selected
    jQuery('#'+this.id).find('li[class*=\'row\']').bind('click',function() {return uiSelect.MenuItemClick(this);});

    // Bind a click action to close lightbox if user click outside of it
    jQuery('html').click(function() {
        // hide uiSelect menu
        uiSelect.toggleDropdown('hide');
        uiSelect.toggleButton('off');
    });

    jQuery('#'+this.id).click(function(e) {
      e.stopPropagation();
    });
      
    // Finally attach this uiSelect instance to the parent div (for event handler access)
    jQuery('#'+this.id).data('uiSelect', this);
  };

  this.toggleDropdown = function(force) {
    var dropdown = jQuery('#'+this.id).find('.dropdownContainer');
    if (force) {
      if (force == 'hide') {
        dropdown.removeClass('uiVisible');
        return;
      }
      if (force == 'show') {
        dropdown.addClass('uiVisible');
        return;
      }
    }
    dropdown.toggleClass('uiVisible');
  };
  
  this.toggleButton = function(force) {
    var button = jQuery('#'+this.id).find('a[idjQuery=\'-button\']');
    if (force) {
      if (force == 'off') {
        button.removeClass('uiButtonSelectPressed');
        return;
      }
      if (force == 'on') {
        button.addClass('uiButtonSelectPressed');
        return;
      }
    }
    button.toggleClass('uiButtonSelectPressed');
  };

  this.setHTMLSelected = function(val) {
    // Remove current selected
    jQuery('#'+this.htmlId).find('option:selected').prop('selected', false);
    
    // Set the selected of the hidden form element given form value 
    jQuery('#'+this.htmlId).find('option[value=\''+val+'\']').prop('selected', true);
  };
  
  this.setUiSelected = function(val, clicked) {
    // Set and unset relevant classes
    jQuery('#'+this.id).find('li:contains('+this.selected['text']+')').first().removeClass('selected');
    jQuery(clicked).addClass('selected');
    
    // Set the interal property given a clicked el
    var setValue = val;
    var setText = jQuery(clicked).text();
    this.selected = {'value': setValue, 'text': setText};
    
    // Set the text value of the visibl uiButton
    jQuery('#'+this.id).find('a[idjQuery=\'-button\']').text(setText);
  };

  this.findValueFromText = function(array, text) {
    for (i in array) {
      if (array[i]['text'] == text) {
        return array[i]['value'];
      }
    }
    return null;
  };

  // Event Handlers
  this.ButtonClick = function(el) {
    // BUTTON CLICK EVENT HANDLER

    this.toggleButton();
    this.toggleDropdown();

    // Change the internal state for logic next click
    if (!this.state) {
      this.state = true;
    } else {
      this.state = false;
    }
    
    // Prevent click from propogating
    return false;
  };

  this.MenuItemClick = function(el) {
    // MENU ITEM CLICK EVENT HANDLER
    var val = this.findValueFromText(this.options, el.innerHTML);
    var change = false;
    // Check to see if there is actally a change to the select
    if (this.selected['value'] != val) {
       change = true;
    }
    
    if (change) {
      this.setHTMLSelected(val);
      this.setUiSelected(val, el);
    }
    
    // Always close the form
    this.toggleDropdown('hide');
    this.toggleButton('off');

    // Check to see if there is actally a change to the select
    if (change) {
      // Make an onchange callback if one was specified
      // Note the logic above to make sure the value actually changed (for parity with browser onchange)
      // The dropdown is also closed before this callback to attain browser partiy
      jQuery('#'+this.htmlId).trigger('change');
    }
    
    return false;
  };
  
  // Constructor
  // For select, we need to inspect the given html <options> and then build a
  // new select widget to interface with the html <select>
  this.inspectOptions(el);
  this.buildUiSelect();
  
}

function uiLightbox(el) {
  // Properties
  this.elemContent = "#lightbox_"+jQuery(el).attr('id');
  this.url = jQuery(el).attr('src');     // URL to ajax load into the lightbox
  this.anchor = el;                 // Anchor tag which is tied to the lightbox
  this.id = null;                  // Id of the lightbox (uniquely generated for each lightbox instance)
  this.contentLoaded = false;      // Boolean whether the ajax content has been loaded yet
  this.fbauth = jQuery(el).attr('data-fbauth');         // Facebook auth required to load the url
  this.fbscope = jQuery(el).attr('data-fbscope');        // Permissions required (scope DOM property) to load the ajax script
  this.stayOpen = jQuery(el).attr('data-stayopen');   // Defines whether the user can close the lightbox by clicking outside of it
  this.autoOpen = jQuery(el).attr('data-autoopen');   // Defines whether the ligthbox should be automatically opened when initiated
  this.narrow = jQuery(el).attr('data-narrow');   // Defines whether the lightbox is narrow (Page) or not
  this.backdrop = jQuery(el).attr('data-backdrop');   // Defines whether to create and show a dark backdrop when open
    
  // Methods
  this.toggleLightbox = function(force) {
    if (force) {
      if (force == 'hide') {
        jQuery('#'+this.id).removeClass('uiVisible');
        jQuery('#'+this.id).fadeOut();
        if (this.backdrop == 'true') {
          //jQuery('#uiLightboxBackdrop-'+this.id).removeClass('uiVisible');
          jQuery('#uiLightboxBackdrop-'+this.id).fadeOut();
        }
        return;
      }
      if (force == 'show') {
        //jQuery('#'+this.id).addClass('uiVisible');
        jQuery('#'+this.id).fadeIn();


        if (this.backdrop == 'true') {
          //jQuery('#uiLightboxBackdrop-'+this.id).addClass('uiVisible');
          jQuery('#uiLightboxBackdrop-'+this.id).fadeIn();
        }
        return;
      }
    }
    //jQuery('#'+this.id).toggleClass('uiVisible');
    jQuery('#'+this.id).fadeIn();

    if (this.backdrop == 'true') {
      //jQuery('#uiLightboxBackdrop-'+this.id).toggleClass('uiVisible');
      jQuery('#uiLightboxBackdrop-'+this.id).fadeIn();

    }
  };
  
  this.buildUiLightbox = function() {
    /* Build lightbox to this template:
      <div id='uiLightboxExample' class='uiLightbox'>
        <div class='contentContainer'>
          <div class='loading'>
            Loading...
          </div>
        </div>
      </div>
    */
    
    // First, delete the lightbox if it already exists
    jQuery('#'+this.id).remove();
    var narrow = '';
    if (this.narrow == 'true') {
      narrow = ' narrow';
    }
    
    // Append the lightbox backdrop to the end of body
    jQuery('body').append('<div id="uiLightboxBackdrop-'+this.id+'" class="uiLightboxBackdrop"></div>');
    
    // Append the lightbox to the end of body
    jQuery('body').append('<div id=\''+this.id+'\' class=\'uiLightbox'+narrow+'\'></div>');
    
    // Build rest of template
    jQuery('#'+this.id).append('<div class=\'contentContainer'+narrow+'\'><div class=\'contentLoading\'>Loading...<img class="uiLightboxLoading" src="/wp-content/plugins/facebook-awd/assets/css/images/loading.gif" /></div></div>');
        
    // Bind a click action to the calling anchor to toggle the lightbox when clicked
    var uiLightbox = this;
    jQuery(this.anchor).bind('click',function() {return uiLightbox.AnchorClick(this);});
    
    // Bind a click action to close lightbox if user click outside of it
    var uiLightboxInstance = this;
    jQuery('html').click(function() {
      if (uiLightboxInstance.stayOpen != 'true') {
        uiLightboxInstance.toggleLightbox('hide');
      }
    });

    // Stop the propogation of the 'close lightbox' action if user clicks the lightbox or anchor tag
    jQuery('#'+this.id).click(function(e) {
      e.stopPropagation();
    });
    jQuery(this.anchor).click(function(e) {
      e.stopPropagation();
    });
    
    // Now attach this uiLightbox instance to the anchor (for event handler access) and container
    jQuery(this.anchor).data('uiLightbox', this);
    jQuery('#'+this.id).data('uiLightbox', this);
  };
  var strippedUrl='';
  this.generateId = function() {
    // Generate a 'unique' Id for this lightbox instance based on url
    if(typeof this.url != "undefined")
    	strippedUrl = this.url.replace(/[^A-Za-z0-9]/g, '');
    else
        strippedUrl = this.elemContent.replace(/[^A-Za-z0-9]/g, '');
    var timestamp = new Date().getTime();
    return strippedUrl+timestamp;
  };
  
  this.loadContent = function() {
    // Load content from AJAX souce into lightbox content (thus replacing the 'loading' div)
    //var params = {'send_to_list': selected_ids};, //data: params,
    var uiLightbox = this;
    
    if (typeof uiLightbox.fbauth != 'undefined' && uiLightbox.fbauth == 'true' && !fbConnected) {
      // Desired URL requires facebook auth and permissions
      if (uiLightbox.fbscope === 'undefined') {
        uiLightbox.fbscope = '';
      }
      
      fbLogin(uiLightbox.fbscope, function(session) {
        if (session) {
          // user logged in succesfully
          uiLightbox.loadAjax();
        } else {
          // auth not granted, close the lightbox and do not continue request
          uiLightbox.toggleLightbox('hide');
          return;
        }
      });
    } else if(typeof uiLightbox.elemContent != 'undefined' && uiLightbox.elemContent != ''){
      	uiLightbox.loadContentFromElement();
    }
  };
  this.loadContentFromElement = function() {
      var uiLightbox = this;
  	  var uiLightboxContentContainer = jQuery('#'+uiLightbox.id).find('div[class~=\'contentContainer\']');
      uiLightboxContentContainer.html(jQuery('#header_AWD_lightbox').html()+jQuery(uiLightbox.elemContent).html());
      window.uiInit(uiLightboxContentContainer);     // Initialize any ui elements that were just loaded via ajax
      uiLightbox.contentLoaded = true;
  };
  this.loadAjax = function(timeout) {
    //var params = {'send_to_list': selected_ids};, //data: params,
    var uiLightbox = this;
    if (typeof timeout === 'undefined') {
      timeoutLength = 0;
    }
    jQuery.ajax({
      url: uiLightbox.url,
      cache: false,
      type: 'GET',
      success: function(html) {
        var uiLightboxContentContainer = jQuery('#'+uiLightbox.id).find('div[class~=\'contentContainer\']');
        uiLightboxContentContainer.html(html);
        window.uiInit(uiLightboxContentContainer);     // Initialize any ui elements that were just loaded via ajax
        uiLightbox.contentLoaded = true;
      },
      error: function(request,status,errorThrown) {
        if (request.status == 401) {
          // Script required Facebook authentication. Close the lightbox so when it is re-opened
          // a new auth dialog is shown
          uiLightbox.toggleLightbox('hide');
        } else {
        timeoutLength = timeoutLength + 2000;
        setTimeout(function() {uiLightbox.loadAjax(timeoutLength);},timeoutLength);
        }
      }
    });
  };
  
  // Event Handlers
  this.AnchorClick = function(el) {
    // ANCHOR BUTTON EVENT
    this.toggleLightbox();
    if (!this.contentLoaded) {
      this.loadContent();
    }
    return false;
  };
    
  // Contsructor
  this.id = this.generateId();
  this.buildUiLightbox();
  if (this.autoOpen == 'true') {
    this.loadContent();
    this.toggleLightbox('show');
  }
  
}



// Register ui initialization
jQuery(document).ready(function() { uiInit(); });

//on change for select admin
function onchange_uiSelect(id){
	jQuery('#uiSelect-'+id+'-button').html(jQuery('#'+id+' option:selected').text());
}
