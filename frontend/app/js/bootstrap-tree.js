jQuery(function () {
      $('.tree li:has(ul)').addClass('parent_li').find(' > span').attr('title', 'Collapse this branch');
      $('.tree li.parent_li > span').on('click', function (e) {
          var children = $(this).parent('li.parent_li').find(' > ul > li');

          var $elemIcon = $(this).find(' > i');
          var elemIconOpen = "", elemIconClose = "";

          if($elemIcon.hasClass('fa-chevron-circle-right') || $elemIcon.hasClass('fa-chevron-circle-down')) {
            elemIconOpen = "fa-chevron-circle-down";
            elemIconClose = "fa-chevron-circle-right";
          } else if($elemIcon.hasClass('fa-folder') || $elemIcon.hasClass('fa-folder-open')) {
            elemIconOpen = "fa-folder-open";
            elemIconClose = "fa-folder";
          }

          if (children.is(":visible")) {
              children.hide('fast');
              $(this).attr('title', 'Expand this branch').find(' > i').addClass(elemIconClose).removeClass(elemIconOpen);
          } else {
              children.show('fast');
              $(this).attr('title', 'Collapse this branch').find(' > i').addClass(elemIconOpen).removeClass(elemIconClose);
          }
          e.stopPropagation();
      });
  });
