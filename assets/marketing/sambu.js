var loading_anim = '<div class="modal-body"><div class="spinner text-center"><i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>&nbsp;&nbsp;<span>Loading...</span></div></div>';
var sambu = function () {

  return {
    //		init : function(){
    //			$('.autonumber').autoNumeric('init');
    //		},

    startPageLoading: function (options) {
      if (options && options.animate) {
        $('.page-spinner-bar').remove();
        $('body').append('<div class="page-spinner-bar"><div class="bounce1"></div><div class="bounce2"></div><div class="bounce3"></div></div>');
      } else {
        $('.page-loading').remove();
        $('body').append('<div class="page-loading"><i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>&nbsp;&nbsp;<span>' + (options && options.message ? options.message : 'Loading...') + '</span></div>');
        //				$('body').append('<div class="page-loading"><img src="' + this.getGlobalImgPath() + 'loading-spinner-grey.gif"/>&nbsp;&nbsp;<span>' + (options && options.message ? options.message : 'Loading...') + '</span></div>');
      }
    },


    stopPageLoading: function () {
      $('.page-loading, .page-spinner-bar').remove();
    },

    startPageLoading2: function (options) {
      if (options && options.animate) {
        $('.page-spinner-bar').remove();
        $('body').append('<div class="page-spinner-bar"><div class="bounce1"></div><div class="bounce2"></div><div class="bounce3"></div></div>');
      } else {
        $('.page-loading').remove();
        $('body').append('<div class="page-loading"><i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>&nbsp;&nbsp;<span>' + (options && options.message ? options.message : 'Loading...') + '</span></div>');
        //				$('body').append('<div class="page-loading"><img src="' + this.getGlobalImgPath() + 'loading-spinner-grey.gif"/>&nbsp;&nbsp;<span>' + (options && options.message ? options.message : 'Loading...') + '</span></div>');
      }
    },

  };
}();