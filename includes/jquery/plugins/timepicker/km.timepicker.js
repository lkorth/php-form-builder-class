/*!
 * kmTimepicker
 *
 * Author: Martin Milesich (http://milesich.com/)
 *
 * This is modified ui.datepicker.js script from jQuery UI.
 *
 * $Id: km.timepicker.js 24 2009-08-08 19:39:54Z majlo $
 *
 * Depends:
 *  ui.core.js
 *  ui.slider.js
 */

(function($) { // hide the namespace

var PROP_NAME = 'kmTimepicker';
var VERSION   = '0.1.1';

$.extend($.ui, { kmTimepicker: { version: VERSION } });


/* Time picker manager.
   Use the singleton instance of this class, $.kmTimepicker, to interact with the time picker.
   Settings for (groups of) time pickers are maintained in an instance object,
   allowing multiple different settings on the same page. */

function kmTimepicker()
{
    this.debug = false; // Change this to true to start debugging
    this._curInst = null; // The current instance in use
    this._lastInput = null;
    this._keyEvent = false; // If the last event was a key event
    this._disabledInputs = []; // List of time picker inputs that have been disabled
    this._timepickerShowing = false; // True if the popup picker is showing , false if not
    this._inDialog = false; // True if showing within a "dialog", false if not
    this._mainDivId = 'km-timepicker-div'; // The ID of the main timepicker division
    this._appendClass = 'km-timepicker-append'; // The name of the append marker class
    this._triggerClass = 'km-timepicker-trigger'; // The name of the trigger marker class
    this._dialogClass = 'km-timepicker-dialog'; // The name of the dialog marker class
    this._disableClass = 'km-timepicker-disabled'; // The name of the disabled covering marker class
    this.regional = []; // Available regional settings, indexed by language code
    this.regional[''] = { // Default regional settings
        closeText: 'Done', // Display text for close link
        hourText: 'Hour',
        minuteText: 'Minute',
        timeFormat: 'hh:iia', // See format options on parseTime
        isRTL: false // True if right-to-left language, false if left-to-right
    };
    this._defaults = { // Global defaults for all the time picker instances
        showOn: 'focus', // 'focus' for popup on focus,
            // 'button' for trigger button, or 'both' for either
        showAnim: 'show', // Name of jQuery animation for popup
        showOptions: {}, // Options for enhanced animations
        buttonText: '...', // Text for trigger button
        buttonImage: '', // URL for trigger button image
        buttonImageOnly: false, // True if the image appears alone, false if it appears on a button
        duration: 'normal', // Duration of display/closure
        onClose: null, // Define a callback function when the timepicker is closed
        stepMinutes: 1, // Number of minutes to step up/down
        stepHours: 1, // Number of hours to step up/down
        altField: '', // Selector for an alternate field to store selected times into
        altFormat: '', // The time format to use for the alternate field
        time24h: false // True if 24h time, false if 12h time (for showing only)
    };
    $.extend(this._defaults, this.regional['']);
    this.tpDiv = $('<div id="' + this._mainDivId + '" class="km-timepicker ui-widget ui-widget-content ui-helper-clearfix ui-corner-all ui-helper-hidden-accessible"></div>');
}

$.extend(kmTimepicker.prototype, {
    /* Class name added to elements to indicate already configured with a time picker. */
    markerClassName: 'hasKmTimepicker',

    /* Debug logging (if enabled). */
    log: function ()
    {
        if (this.debug) {
            console.log.apply('', arguments);
        }
    },

    /* Attach the time picker to a jQuery selection.
       @param  target    element - the target input field or division or span
       @param  settings  object - the new settings to use for this time picker instance (anonymous) */
    _attachTimepicker: function(target, settings)
    {
        if (target.nodeName.toLowerCase() != 'input') {
            return;
        }

        if (!target.id) {
            target.id = 'kmtp' + (++this.uuid);
        }

        var $target = $(target);

        if ($target.hasClass(this.markerClassName)) {
            return;
        }

        var inst = {};
        inst.id        = $target[0].id.replace(/([:\[\]\.])/g, '\\\\$1');
        inst.input     = $target;
        inst.time      = 0; // we keep time internally in seconds since midnight
        inst.settings  = $.extend({}, settings || {});
        inst.tpDiv     = this.tpDiv;
        inst.append    = $([]);
        inst.trigger   = $([]);

        var isRTL  = this._get(inst, 'isRTL');
        var showOn = this._get(inst, 'showOn');

        // pop-up time picker when in the marked field
        if (showOn == 'focus' || showOn == 'both') {
            $target.focus(this._showTimepicker);
        }

        // pop-up time picker when button clicked
        if (showOn == 'button' || showOn == 'both') {
            var buttonText  = this._get(inst, 'buttonText');
            var buttonImage = this._get(inst, 'buttonImage');

            if (this._get(inst, 'buttonImageOnly')) {
                inst.trigger = $('<img/>').addClass(this._triggerClass).attr(
                    { src: buttonImage, alt: buttonText, title: buttonText }
                );
            } else {
                inst.trigger =  $('<button type="button"></button>').addClass(this._triggerClass).html(
                    buttonImage == '' ? buttonText : $('<img/>').attr(
                        { src: buttonImage, alt: buttonText, title: buttonText }
                    )
                );
            }

            $target[isRTL ? 'before' : 'after'](inst.trigger);

            inst.trigger.click(function() {
                if ($.kmTimepicker._timepickerShowing && $.kmTimepicker._lastInput == target) {
                    $.kmTimepicker._hideTimepicker();
                } else {
                    $.kmTimepicker._showTimepicker(target);
                }
                return false;
            });
        }

        $target.addClass(this.markerClassName)
            .keydown(this._doKeyDown)
            .keypress(this._doKeyPress)
            .bind("setData.kmTimepicker", function(event, key, value) { inst.settings[key] = value; })
            .bind("getData.kmTimepicker", function(event, key) { return this._get(inst, key); });

        $.data(target, PROP_NAME, inst);
    },

    /* Detach a timepicker from its control.
       @param  target    element - the target input field */
    _destroyTimepicker: function(target)
    {
        var $target = $(target);
        var inst    = $.data(target, PROP_NAME);

        if (!$target.hasClass(this.markerClassName)) {
            return;
        }

        $.removeData(target, PROP_NAME);

        inst.append.remove();
        inst.trigger.remove();

        $target.removeClass(this.markerClassName)
               .unbind('focus', this._showTimepicker)
               .unbind('keydown', this._doKeyDown)
               .unbind('keypress', this._doKeyPress);
    },

    /* Enable the time picker to a jQuery selection.
       @param  target    element - the target input field */
    _enableTimepicker: function(target)
    {
        var $target = $(target);
        var inst    = $.data(target, PROP_NAME);

        if (!$target.hasClass(this.markerClassName)) {
            return;
        }

        target.disabled = false;

        inst.trigger.filter('button').each(function() {
            this.disabled = false;
        }).end().filter('img').css({
            opacity: '1.0', cursor: ''
        });

        this._disabledInputs = $.map(
            this._disabledInputs, function(value) {
                return (value == target ? null : value);
            }
        );
    },

    /* Disable the time picker to a jQuery selection.
       @param  target    element - the target input field  */
    _disableTimepicker: function(target)
    {
        var $target = $(target);
        var inst    = $.data(target, PROP_NAME);

        if (!$target.hasClass(this.markerClassName)) {
            return;
        }

        target.disabled = true;

        inst.trigger.filter('button').each(function() {
            this.disabled = true;
        }).end().filter('img').css({
            opacity: '0.5', cursor: 'default'
        });

        this._disabledInputs = $.map(this._disabledInputs, function(value) {
            return (value == target ? null : value);
        });

        this._disabledInputs[this._disabledInputs.length] = target;
    },

    /* Is the first field in a jQuery collection disabled as a timepicker?
       @param  target    element - the target input field
       @return boolean - true if disabled, false if enabled */
    _isDisabledTimepicker: function(target)
    {
        if (!target) {
            return false;
        }

        for (var i = 0; i < this._disabledInputs.length; i++) {
            if (this._disabledInputs[i] == target) {
                return true;
            }
        }

        return false;
    },

    /* Retrieve the instance data for the target control.
       @param  target  element - the target input field
       @return  object - the associated instance data
       @throws  error if a jQuery problem getting data */
    _getInst: function(target)
    {
        try {
            return $.data(target, PROP_NAME);
        }
        catch (err) {
            throw 'Missing instance data for this timepicker';
        }
    },

    /* Update or retrieve the settings for a time picker attached to an input field
       @param  target  element - the target input field
       @param  name    object - the new settings to update or
                       string - the name of the setting to change or retrieve,
                       when retrieving also 'all' for all instance settings or
                       'defaults' for all global defaults
       @param  value   any - the new value for the setting
                       (omit if above is an object or to retrieve a value) */
    _optionTimepicker: function(target, name, value)
    {
        var inst = this._getInst(target);

        if (arguments.length == 2 && typeof name == 'string') {
            return (name == 'defaults' ? $.extend({}, $.kmTimepicker._defaults) :
                (inst ? (name == 'all' ? $.extend({}, inst.settings) :
                this._get(inst, name)) : null));
        }

        var settings = name || {};

        if (typeof name == 'string') {
            settings = {};
            settings[name] = value;
        }

        if (inst) {
            if (this._curInst == inst) {
                this._hideTimepicker(null);
            }

            var time = this._getTimeTimepicker(target);
            extendRemove(inst.settings, settings);
            this._setTimeTimepicker(target, time);
            this._updateTimepicker(inst);
        }
    },

    /* Update any alternate field to synchronise with the main field. */
    _updateAlternate: function(inst) {
        var altField = this._get(inst, 'altField');
        if (altField) { // update alternate field too
            var altFormat = this._get(inst, 'altFormat') || this._get(inst, 'timeFormat');
            var time = this._getTime(inst);
            timeStr = this.formatTime(altFormat, time);
            $(altField).each(function() { $(this).val(timeStr); });
        }
    },

    /* Set the times for a jQuery selection.
       @param  target   element - the target input field
       @param  time     Time - the new time in seconds since midnight */
    _setTimeTimepicker: function(target, time) {
        var inst = this._getInst(target);

        if (inst) {
            this._setTime(inst, time);
            this._updateTimepicker(inst);
            this._updateAlternate(inst);
        }
    },

    /* Get the time(s) for the first entry in a jQuery selection.
       @param  target  element - the target input field
       @return time - the current time in seconds since midnight */
    _getTimeTimepicker: function(target) {
        var inst = this._getInst(target);

        if (inst) {
            this._setTimeFromField(inst);
        }

        return (inst ? this._getTime(inst) : null);
    },

    /* Pop-up the time picker for a given input field.
       @param  input  element - the input field attached to the time picker or
                      event - if triggered by focus */
    _showTimepicker: function(input)
    {
        input = input.target || input;

        // find from button/image trigger
        if (input.nodeName.toLowerCase() != 'input') {
            input = $('input', input.parentNode)[0];
        }

        // already here
        if ($.kmTimepicker._isDisabledTimepicker(input) || $.kmTimepicker._lastInput == input) {
            return;
        }

        var inst = $.kmTimepicker._getInst(input);

        $.kmTimepicker._hideTimepicker(null, '');
        $.kmTimepicker._lastInput = input;
        $.kmTimepicker._setTimeFromField(inst);

        if ($.kmTimepicker._inDialog){
            input.value = '';
        }

        // position below input
        if (!$.kmTimepicker._pos) {
            $.kmTimepicker._pos     = $.kmTimepicker._findPos(input);
            $.kmTimepicker._pos[1] += input.offsetHeight; // add the height
        }

        var isFixed = false;

        $(input).parents().each(function() {
            isFixed |= $(this).css('position') == 'fixed';
            return !isFixed;
        });

        // correction for Opera when fixed and scrolled
        if (isFixed && $.browser.opera) {
            $.kmTimepicker._pos[0] -= document.documentElement.scrollLeft;
            $.kmTimepicker._pos[1] -= document.documentElement.scrollTop;
        }

        var offset = {left: $.kmTimepicker._pos[0], top: $.kmTimepicker._pos[1]};

        $.kmTimepicker._pos = null;
        inst.rangeStart     = null;

        // determine sizing offscreen
        inst.tpDiv.css({position: 'absolute', display: 'block', top: '-1000px'});

        $.kmTimepicker._updateTimepicker(inst);

        // fix width for dynamic number of time pickers
        // and adjust position before showing
        offset = $.kmTimepicker._checkOffset(inst, offset, isFixed);

        inst.tpDiv.css({
            position: ($.kmTimepicker._inDialog && $.blockUI ? 'static' : (isFixed ? 'fixed' : 'absolute')),
            display:  'none',
            left:     offset.left + 'px',
            top:      offset.top + 'px'
        });

        var showAnim = $.kmTimepicker._get(inst, 'showAnim') || 'show';
        var duration = $.kmTimepicker._get(inst, 'duration');

        var postProcess = function() {
            $.kmTimepicker._timepickerShowing = true;

            // fix IE < 7 select problems
            if ($.browser.msie && parseInt($.browser.version,10) < 7) {
                $('iframe.km-timepicker-cover').css({
                    width:  inst.tpDiv.width()  + 4,
                    height: inst.tpDiv.height() + 4
                });
            }
        };

        if ($.effects && $.effects[showAnim]) {
            inst.tpDiv.show(showAnim, $.kmTimepicker._get(inst, 'showOptions'), duration, postProcess);
        } else {
            inst.tpDiv[showAnim](duration, postProcess);
        }

        if (duration == '') {
            postProcess();
        }

        if (inst.input[0].type != 'hidden') {
            inst.input[0].focus();
        }

        $.kmTimepicker._curInst = inst;
    },

    /* Generate the time picker content. */
    _updateTimepicker: function(inst)
    {
        var dims = {
            width:  inst.tpDiv.width()  + 4,
            height: inst.tpDiv.height() + 4
        };

        var curHour   = this._getHour(inst.time);
        var curMinute = this._getMinute(inst.time);

        var stepMinutes = parseInt(this._get(inst, 'stepMinutes'), 10) || 1;
        var stepHours   = parseInt(this._get(inst, 'stepHours'), 10)   || 1;

        if (60 % stepMinutes != 0) { stepMinutes = 1; }
        if (24 % stepHours != 0)   { stepHours   = 1; }

        var self = this;

        inst.tpDiv.empty().append(this._generateHTML(inst))
            .find('iframe.km-timepicker-cover').
                css({width: dims.width, height: dims.height})
            .end()
            .find('button')
                .bind('mouseout', function(){
                    $(this).removeClass('ui-state-hover');
                })
                .bind('mouseover', function(){
                    if (!self._isDisabledTimepicker(inst.input[0])) {
                        $(this).addClass('ui-state-hover');
                    }
                })
            .end();

        inst.tpDiv[(this._get(inst, 'isRTL') ? 'add' : 'remove') + 'Class']('km-timepicker-rtl');

        $('#'+this._mainDivId+' #kmHourSlider').slider({
            orientation: "vertical",
            range: 'min',
            min: 0,
            max: (24 - stepHours),
            value: curHour,
            step: stepHours,
            slide: function(event, ui) {
                self._writeTime(inst, 'hour', ui.value);
            },
            stop: function(event, ui) {
                $(inst.input[0]).focus();
            }
        });

        $('#'+this._mainDivId+' #kmMinuteSlider').slider({
            orientation: "vertical",
            range: 'min',
            min: 0,
            max: (60 - stepMinutes),
            value: curMinute,
            step: stepMinutes,
            slide: function(event, ui) {
                self._writeTime(inst, 'minute', ui.value);
            },
            stop: function(event, ui) {
                $(inst.input[0]).focus();
            }
        });

        this._writeTime(inst, 'hour',   curHour);
        this._writeTime(inst, 'minute', curMinute);

        if (inst.input && inst.input[0].type != 'hidden' && inst == $.kmTimepicker._curInst) {
            $(inst.input[0]).focus();
        }
    },

    /* Check positioning to remain on screen. */
    _checkOffset: function(inst, offset, isFixed)
    {
        var tpWidth     = inst.tpDiv.outerWidth();
        var tpHeight    = inst.tpDiv.outerHeight();
        var inputWidth  = inst.input ? inst.input.outerWidth()  : 0;
        var inputHeight = inst.input ? inst.input.outerHeight() : 0;
        var viewWidth   = (window.innerWidth  || document.documentElement.clientWidth  || document.body.clientWidth)  + $(document).scrollLeft();
        var viewHeight  = (window.innerHeight || document.documentElement.clientHeight || document.body.clientHeight) + $(document).scrollTop();

        offset.left -= (this._get(inst, 'isRTL') ? (tpWidth - inputWidth) : 0);
        offset.left -= (isFixed && offset.left == inst.input.offset().left) ? $(document).scrollLeft() : 0;
        offset.top  -= (isFixed && offset.top  == (inst.input.offset().top + inputHeight)) ? $(document).scrollTop() : 0;

        // now check if timepicker is showing outside window viewport - move to a better place if so.
        offset.left -= (offset.left + tpWidth  > viewWidth  && viewWidth  > tpWidth)  ? Math.abs(offset.left + tpWidth - viewWidth) : 0;
        offset.top  -= (offset.top  + tpHeight > viewHeight && viewHeight > tpHeight) ? Math.abs(offset.top  + tpHeight + inputHeight*2 - viewHeight) : 0;

        return offset;
    },

    /* Find an object's position on the screen. */
    _findPos: function(obj)
    {
        while (obj && (obj.type == 'hidden' || obj.nodeType != 1)) {
            obj = obj.nextSibling;
        }

        var position = $(obj).offset();

        return [position.left, position.top];
    },

    /* Hide the time picker from view.
       @param  input  element - the input field attached to the time picker
       @param  duration  string - the duration over which to close the time picker */
    _hideTimepicker: function(input, duration)
    {
        var inst = this._curInst;

        if (!inst || (input && inst != $.data(input, PROP_NAME))) {
            return;
        }

        if (!this._timepickerShowing) {
            this._curInst = null;
            return;
        }

        duration     = (duration != null ? duration : this._get(inst, 'duration'));
        var showAnim = this._get(inst, 'showAnim');

        var postProcess = function() {
            $.kmTimepicker._tidyDialog(inst);
        };

        if (duration != '' && $.effects && $.effects[showAnim]) {
            inst.tpDiv.hide(showAnim, $.kmTimepicker._get(inst, 'showOptions'), duration, postProcess);
        } else {
            inst.tpDiv[(duration == '' ? 'hide' : (showAnim == 'slideDown' ? 'slideUp' : (showAnim == 'fadeIn' ? 'fadeOut' : 'hide')))](duration, postProcess);
        }

        if (duration == '') {
            this._tidyDialog(inst);
        }

        var onClose = this._get(inst, 'onClose');

        if (onClose) {
            // trigger custom callback
            onClose.apply((inst.input ? inst.input[0] : null), [(inst.input ? inst.input.val() : ''), inst]);
        }

        this._timepickerShowing = false;
        this._lastInput = null;

        if (this._inDialog) {
            this._dialogInput.css({ position: 'absolute', left: '0', top: '-100px' });
            if ($.blockUI) {
                $.unblockUI();
                $('body').append(this.tpDiv);
            }
        }

        this._inDialog = false;
        this._curInst  = null;
    },

    /* Tidy up after a dialog display. */
    _tidyDialog: function(inst)
    {
        inst.tpDiv.removeClass(this._dialogClass);
    },

    /* Close time picker if clicked elsewhere. */
    _checkExternalClick: function(event)
    {
        if (!$.kmTimepicker._curInst) {
            return;
        }

        var $target = $(event.target);

        if (($target.parents('#' + $.kmTimepicker._mainDivId).length == 0) &&
                !$target.hasClass($.kmTimepicker.markerClassName) &&
                !$target.hasClass($.kmTimepicker._triggerClass) &&
                $.kmTimepicker._timepickerShowing && !($.kmTimepicker._inDialog && $.blockUI)) {

            $.kmTimepicker._hideTimepicker(null, '');
        }
    },

    /* Get a setting value, defaulting if necessary. */
    _get: function(inst, name)
    {
        return inst.settings[name] !== undefined ? inst.settings[name] : this._defaults[name];
    },

    /* Parse existing time and initialise time picker. */
    _setTimeFromField: function(inst) {
        try {
            var time = this._parseTime(inst) || 0;
        } catch (event) {
            this.log(event);
            var time = 0;
        }

        inst.time = time;
    },

    /* Generate the HTML for the current state of the time picker. */
    _generateHTML: function(inst)
    {
        var html     = '';
        var btnClose = '<button type="button" class="km-timepicker-close ui-state-default ui-priority-primary ui-corner-all" onclick="TP_jQuery.kmTimepicker._selectTime(\'#' + inst.id + '\');">' + this._get(inst, 'closeText') + '</button>';

        html = '<div class="km-timepicker-header ui-widget-header ui-helper-clearfix ui-corner-all">'
             + ' <div class="km-timepicker-title" style="margin:0">'
             + '  <span class="km-timepicker-sphours">00</span>:<span class="km-timepicker-spminutes">00</span>'
             + '  <span class="km-timepicker-spampm"></span>'
             + ' </div>'
             + '</div>'
             + '<table>'
             + ' <tr><th>'+this._get(inst, 'hourText')+'</th><th>'+this._get(inst, 'minuteText')+'</th></tr>'
             + ' <tr><td align="center"><div id="kmHourSlider"></div></td><td align="center"><div id="kmMinuteSlider"></div></td></tr>'
             + '</table>';

        var buttonPanel = '<div class="km-timepicker-buttonpane ui-widget-content">' + btnClose + '</div';

        html += buttonPanel;

        if ($.browser.msie && parseInt($.browser.version, 10) < 7) {
            html += '<iframe src="javascript:false;" class="km-timepicker-cover" frameborder="0"></iframe>';
        }

        inst._keyEvent = false;

        return html;
    },

    /**
     * Update timepicker's title
     */
    _writeTime: function (inst, type, value)
    {
        var time24h = this._get(inst, 'time24h');

        if (type == 'hour') {
            if (!time24h) {
                if (value < 12) {
                    $('#' + this._mainDivId + ' span.km-timepicker-spampm').text('am');
                } else {
                    $('#' + this._mainDivId + ' span.km-timepicker-spampm').text('pm');
                    value -= 12;
                }

                if (value == 0) value = 12;
            } else {
                $('#' + this._mainDivId + ' span.km-timepicker-spampm').text('');
            }

            if (value < 10) value = '0' + value;
            $('#' + this._mainDivId + ' span.km-timepicker-sphours').text(value);
        }

        if (type == 'minute') {
            if (value < 10) value = '0' + value;
            $('#' + this._mainDivId + ' span.km-timepicker-spminutes').text(value);
        }
    },

    /* Parse a string value into a time variable.
       See formatTime below for the possible formats.
     */
    _parseTime: function (inst)
    {
        var format = this._get(inst, 'timeFormat');
        var value  = inst.input ? inst.input.val() : null;

        if (format == null || value == null) {
            throw 'Invalid arguments';
        }

        value = (typeof value == 'object' ? value.toString() : value + '');

        if (value == '') {
            this._writeTime(inst, 'hour',   0);
            this._writeTime(inst, 'minute', 0);
            return;
        }

        var hour    = 0;
        var minute  = 0;
        var ampm    = '';
        var literal = false;

        // Check whether a format character is doubled
        var lookAhead = function(match) {
            var matches = (iFormat + 1 < format.length && format.charAt(iFormat + 1) == match);
            if (matches) {
                iFormat++;
            }
            return matches;
        };

        // Extract a number from the string value
        var getNumber = function(match) {
            lookAhead(match);

            var size = origSize = 2;
            var num = 0;

            while (size > 0 && iValue < value.length && value.charAt(iValue) >= '0' && value.charAt(iValue) <= '9') {
                num = num * 10 + parseInt(value.charAt(iValue++),10);
                size--;
            }

            if (size == origSize) {
                throw 'Missing number at position ' + iValue;
            }

            return num;
        };

        // Extract a name from the string value and convert to an index
        var getName = function(match) {
            var size = origSize = 2;
            var name = '';

            while (size > 0 && iValue < value.length) {
                name += value.charAt(iValue++);
                size--;
            }

            return name;
        };

        // Confirm that a literal character matches the string value
        var checkLiteral = function() {
            if (value.charAt(iValue) != format.charAt(iFormat)) {
                throw 'Unexpected literal at position ' + iValue;
            }

            iValue++;
        };

        var iValue = 0;
        for (var iFormat = 0; iFormat < format.length; iFormat++) {
            if (literal) {
                if (format.charAt(iFormat) == "'" && !lookAhead("'")) {
                    literal = false;
                } else {
                    checkLiteral();
                }
            } else {
                switch (format.charAt(iFormat)) {
                    case 'h':
                        hour = getNumber('h');
                        break;
                    case 'H':
                        hour = getNumber('H');
                        break;
                    case 'i':
                        minute = getNumber('i');
                        break;
                    case 'a':
                        ampm = getName('a');
                        break;
                    case "'":
                        if (lookAhead("'")) {
                            checkLiteral();
                        } else {
                            literal = true;
                        }
                        break;
                    default:
                        checkLiteral();
                }
            }
        }

        ampm = ampm.toLowerCase();

        if (ampm != 'am' && ampm != 'pm') {
            ampm = '';
        }

        if (hour   < 0) hour   = 0;
        if (minute < 0) minute = 0;

        if (hour   > 23) hour   = 23;
        if (minute > 59) minute = 59;

        if (ampm == 'pm' && hour < 12)  hour += 12;
        if (ampm == 'am' && hour == 12) hour  = 0;

        return (hour * 60 * 60) + (minute * 60);
    },

    /**
     * Set the time directly
     */
    _setTime: function (inst, time)
    {
        var clear = !(time);

        inst.time = time;

        if (inst.input) {
            inst.input.val(clear ? '' : this._formatTime(inst));
        }
    },

    /**
     * Get the time directly
     */
    _getTime: function (inst)
    {
        return inst.time;
    },

    /* Format a time into a string value.
       The format can be combinations of the following:
       h  - hour, 12-hour format (no leading zero)
       hh - hour, 12-hour format (two digit)
       H  - hour, 24-hour format (no leading zeros)
       HH - hour, 24-hour format (three digit)
       i  - minutes (no leading zero)
       ii - minutes (two digit)
       a  - am or pm
       '...' - literal text
       '' - single quote

       @param  format    string - the desired format of the time
       @param  time      the time value to format
       @return  string - the time in the above format */
    formatTime: function (format, time)
    {
        // Check whether a format character is doubled
        var lookAhead = function(match) {
            var matches = (iFormat + 1 < format.length && format.charAt(iFormat + 1) == match);

            if (matches) {
                iFormat++;
            }

            return matches;
        };

        // Format a number, with leading zero if necessary
        var formatNumber = function(match, value, len) {
            var num = '' + value;

            if (lookAhead(match)) {
                while (num.length < len) {
                    num = '0' + num;
                }
            }

            return num;
        };

        var output  = '';
        var literal = false;
        var hour    = this._getHour(time);
        var hour12  = hour;
        var minute  = this._getMinute(time);

        if (hour12 > 11) hour12 -= 12;
        if (hour12 == 0) hour12  = 12;

        for (var iFormat = 0; iFormat < format.length; iFormat++) {
            if (literal) {
                if (format.charAt(iFormat) == "'" && !lookAhead("'")) {
                    literal = false;
                } else {
                    output += format.charAt(iFormat);
                }
            } else {
                switch (format.charAt(iFormat)) {
                    case 'h':
                        output += formatNumber('h', hour12, 2);
                        break;
                    case 'H':
                        output += formatNumber('H', hour, 2);
                        break;
                    case 'i':
                        output += formatNumber('i', minute, 2);
                        break;
                    case 'a':
                        output += (hour < 12 ? 'am' : 'pm');
                        break;
                    case "'":
                        if (lookAhead("'")) {
                            output += "'";
                        } else {
                            literal = true;
                        }
                        break;
                    default:
                        output += format.charAt(iFormat);
                }
            }
        }

        return output;
    },

    /**
     * Update the input field
     */
    _selectTime: function (id)
    {
        var target = $(id);
        var inst   = this._getInst(target[0]);

        var curHour   = $('#'+this._mainDivId+' #kmHourSlider').slider('value');
        var curMinute = $('#'+this._mainDivId+' #kmMinuteSlider').slider('value');

        inst.time = (curHour * 60 * 60) + (curMinute * 60);

        if (inst.input) {
            inst.input.val(this._formatTime(inst));
            inst.input.trigger('change'); // fire the change event
        }

        this._updateAlternate(inst);

        this._hideTimepicker(null, this._get(inst, 'duration'));
        this._lastInput = inst.input[0];

        if (typeof(inst.input[0]) != 'object') {
            inst.input[0].focus(); // restore focus
        }

        this._lastInput = null;
    },

    /**
     * Get hour number from time
     */
    _getHour: function (time)
    {
        return parseInt(time / 60 / 60, 10);
    },

    /**
     * Get minute number from time
     */
    _getMinute: function (time)
    {
        return parseInt(time / 60 % 60, 10);
    },

    /**
     * Format the time using stored instance
     */
    _formatTime: function (inst)
    {
        return this.formatTime(this._get(inst, 'timeFormat'), inst.time);
    }
});

/* jQuery extend now ignores nulls! */
function extendRemove(target, props)
{
    $.extend(target, props);
    for (var name in props)
        if (props[name] == null || props[name] == undefined)
            target[name] = props[name];
    return target;
};

/* Invoke the timepicker functionality.
@param  options  string - a command, optionally followed by additional parameters or
                 Object - settings for attaching new timepicker functionality
@return  jQuery object */
$.fn.kmTimepicker = function(options)
{
    /* Initialise the time picker. */
    if (!$.kmTimepicker.initialized) {
        $(document).mousedown($.kmTimepicker._checkExternalClick).find('body').append($.kmTimepicker.tpDiv);
        $.kmTimepicker.initialized = true;
    }

    var otherArgs = Array.prototype.slice.call(arguments, 1);

    if (typeof options == 'string' && (options == 'isDisabled' || options == 'getTime')) {
        return $.kmTimepicker['_' + options + 'Timepicker'].apply($.kmTimepicker, [this[0]].concat(otherArgs));
    }

    if (options == 'option' && arguments.length == 2 && typeof arguments[1] == 'string') {
        return $.kmTimepicker['_' + options + 'Timepicker'].apply($.kmTimepicker, [this[0]].concat(otherArgs));
    }

    return this.each(function() {
        typeof options == 'string' ?
            $.kmTimepicker['_' + options + 'Timepicker'].apply($.kmTimepicker, [this].concat(otherArgs)) :
            $.kmTimepicker._attachTimepicker(this, options);
    });
};

$.kmTimepicker = new kmTimepicker(); // singleton instance
$.kmTimepicker.initialized = false;
$.kmTimepicker.uuid        = new Date().getTime();
$.kmTimepicker.version     = VERSION;

//Workaround for #4055
//Add another global to avoid noConflict issues with inline event handlers
window.TP_jQuery = $;

})(jQuery);
