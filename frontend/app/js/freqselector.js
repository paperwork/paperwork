/* ========================================================================
 * freqselector
 * http://twostairs.com
 * ========================================================================
 * Copyright 2011-2014 Marius M. <marius@twostairs.com>
 * Licensed under MIT (http://opensource.org/licenses/MIT)
 * ======================================================================== */


(function ($) {
  'use strict';

  var Freqselector = function (element, options) {
    this.options        = options;
    this.$body          = $(element).parent();
    this.$element       = $(element);
    this.$background  = $(element).find('.freqselector-background');
    this.$arrow     = $(element).find('.freqselector-arrow-top');
    this.$content     = $(element).find('.freqselector-content');

    this.arrowLeft    = 0;
    this.arrowCenterOffset = 11;
    this.isShown        = false;
    this.isSelected   = "";

    this.initializeFreqselector();
  };

  Freqselector.VERSION  = '1.0.2';

  Freqselector.DEFAULTS = {
    show: false
  };

  Freqselector.prototype.toggle = function (_relatedTarget) {
    return this.isShown ? this.hide() : this.show(_relatedTarget);
  };

  Freqselector.prototype.show = function (_relatedTarget) {
    var e    = $.Event('show.freqselector', { relatedTarget: _relatedTarget });

    this.$element.trigger(e);

    if (this.isShown || e.isDefaultPrevented()) { return; }

    this.isShown = true;

    if($.support.transition) {
    this.$element.css("display", "block");
    this.$element.animate({
      opacity: 1.0,
      height: "80px"
    }, "fast", function() {
      // Move it?
    });
    } else {
      this.showFreqselector();
    }
  };

  Freqselector.prototype.hide = function (e) {
    if (e) { e.preventDefault(); }

    e = $.Event('hide.freqselector');

    this.$element.trigger(e);

    if (!this.isShown || e.isDefaultPrevented()) {
      return;
    }
    this.isShown = false;

    this.$element
      .attr('aria-hidden', true)
      .off('click.dismiss.freqselector');

    if($.support.transition) {
      this.$element.css("display", "none");
      this.$element.animate({
      opacity: 0.0,
      height: "0px"
    }, "fast", function() {
      // Move it?
    });
    } else {
      this.hideFreqselector();
    }
  };

  Freqselector.prototype.showFreqselector = function () {
    this.isShown = true;
    this.$element.css("display", "block").css("height", "80px").css("opacity", "1");
  };

  Freqselector.prototype.hideFreqselector = function () {
    this.isShown = false;
    this.$element.css("display", "none").css("height", "0px").css("opacity", "0");
  };

  Freqselector.prototype.initializeFreqselector = function () {
    jQuery(window).resize((function(_this) {
      return function() {
        _this.resizeFreqselector();
      };
    })(this));
    jQuery(window).resize();

    this.$background.overscroll({
      showThumbs: false,
      direction: 'horizontal',
      wheelDirection: 'horizontal',
      openedCursor: '',
      closedCursor: '',
      captureWheel: false
    });
    this.initializeOverscroll();
    this.initializeItemClick();
    this.show();
  };

  Freqselector.prototype.initializeOverscroll = function () {
    this.$background.off('overscroll:dragend').on('overscroll:dragend', (function(_this) {
      return function() {
        var resultsArray = [];

        _this.$element.find('.freqselector-item-snap').each(function() {
          var itemDistance = jQuery(this).offset().left;
          var itemId = jQuery(this).attr('id').replace(/freqselector-item-/, "");
          resultsArray.push({ 'id': itemId, 'distance': itemDistance });
        });

        var closest = null;
        var prev = Math.abs(resultsArray[0].distance - _this.arrowLeft - _this.arrowCenterOffset);
        for (var i = 1; i < resultsArray.length; i++) {
            var diff = Math.abs(resultsArray[i].distance - _this.arrowLeft - _this.arrowCenterOffset);
            if (diff < prev) {
                prev = diff;
                closest = resultsArray[i];
            }
        }

        if(closest !== null)
        {
          _this.pick('#freqselector-item-'+closest.id);
      }
      };
    })(this)).trigger('overscroll:dragend');
  };

  Freqselector.prototype.initializeItemClick = function() {
    var _this = this;
    this.$content.off('mouseup').on('mouseup', '.freqselector-item-not-dummy', function(_ev) {
      if(!_this.$background.data('overscroll').dragging) {
        var clickedItem = this;

        // That's one lousy hack. If _this.pick is being called right away,
        // it looks like the mouseup event still intervents and makes the freqselector
        // jump back to its old value.
        setTimeout(function() {
          _this.pick('#' + jQuery(clickedItem).find('.freqselector-item-snap').attr('id'));
        }, 10);
        _ev.stopPropagation();
        return false;
      }
    });
  };

  Freqselector.prototype.pick = function (item) {
    if(typeof item !== "undefined") {
      this.$background.scrollTo(item, 500, { offset: (0 - this.arrowLeft - this.arrowCenterOffset + this.$element.offset().left), axis: 'x' });
      var e = $.Event('picked.freqselector', { 'item': item });
      this.$element.trigger(e);
      this.isSelected = item;
    }
  };

  Freqselector.prototype.resizeFreqselector = function () {
  var newWidth = 0;
  var documentWidth = Math.round(this.$body.width() / 2);

  this.$element.find('.freqselector-item-dummy').width(documentWidth);

  this.$element.find('.freqselector-item').each(function() {
    newWidth += $(this).width() + 4;
  });

  this.$content.width(newWidth);
  this.arrowLeft = Math.abs(this.$arrow.offset().left);
  };

  function Plugin(option, _relatedTarget) {
    return this.each(function () {
      var $this   = $(this);
      var data    = $this.data('freqselector');
      var options = $.extend({}, Freqselector.DEFAULTS, $this.data(), typeof option === 'object' && option);

      if (!data) {
        $this.data('freqselector', (data = new Freqselector(this, options)));
        if(options.show) {
          data.showFreqselector();
        }
      }
      if (typeof option === 'string') { data[option](_relatedTarget); }
    });
  }

  var old = $.fn.freqselector;

  $.fn.freqselector             = Plugin;
  $.fn.freqselector.Constructor = Freqselector;


  $.fn.freqselector.noConflict = function () {
    $.fn.freqselector = old;
    return this;
  };


  $(document).on('click.freqselector.data-api', '[data-toggle="freqselector"]', function (e) {
    var $this   = $(this);
    var href    = $this.attr('href');
    var $target = $($this.attr('data-target') || (href && href.replace(/.*(?=#[^\s]+$)/, ''))); // strip for ie7
    var option  = $target.data('freqselector') ? 'toggle' : $.extend({ remote: !/#/.test(href) && href }, $target.data(), $this.data());
    if ($this.is('a')) { e.preventDefault(); }

    $target.one('show.freqselector', function (showEvent) {
      if (showEvent.isDefaultPrevented()) { return; }
      $target.one('hidden.freqselector', function () {
        // if($this.is(':visible')) { $this.trigger('focus'); }
      });
    });
    Plugin.call($target, option, this);
  });

})(jQuery);
