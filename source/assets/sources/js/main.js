var dragPrice = 0;
var dragWieght = 0;
var dragImg = 0;
var boundRect;
var boundRect2;

jQuery(document).ready( function($) {

  if($('#canvas').length){
    //$('.canvas-earring .basement').height($('.basement img').height()+200);
    //$('.canvas-earring-long .basement').height($('.basement img').height()+200);
    if($('.canvas[data-place]').length){
      initFreeConstructor();
      var place = $('.canvas').attr('data-place').split(',');
      if($('.canvas[data-place-2]').length){
        var place2 = $('.canvas').attr('data-place-2').split(',');
        initFabric(place, place2);
      }else{
        initFabric(place);
      }
    }else{
      initFreeConstructor();
      initFabric();
    }
  }

  $('.jewellery-type input').click(function(){
    var id = $(this).attr('id');
    var type = $(this).attr('data-type');
    $('.btns button:not(.back)').attr('onclick',"window.location='constructor_step_3-"+type+"-"+id+".php'");
  })

  if($('.gallery-wrapper').length){
    initMainSlider();
  }

  if($('.gallery-other-wrapper').length){
    initOtherSlider();
  }

  if($('.gallery-item-wrapper').length){
    initGalleryItemSlider();
  }

  if($('.review-slider-source').length){
    initReviewSlider();
  }

  if($('.scrollbar-outer').length){
    $('.scrollbar-outer').scrollbar();
  }
  

  $('.footer .field input').focus(function(){
    $(this).closest('.field').addClass('focus');
  });
  $('.footer .field input').blur(function(){
    $(this).closest('.field').removeClass('focus');
  });

  $('.login-wrapper .field input, .checkout .field input').focus(function(){
    $(this).closest('.field').addClass('focus');
  });
  $('.login-wrapper .field input, .checkout .field input').blur(function(){
    if(!$(this).val().length){
      $(this).closest('.field').removeClass('focus fast');
    }
  });
  $('.login-wrapper .field input, .checkout .field input').each(function(){
    if($(this).val().length){
      $(this).closest('.field').addClass('focus fast');
    }
  });

  $('.decimal').keypress(function(e){
    e = e || event;
    if (e.ctrlKey || e.altKey || e.metaKey) return;
    var chr = getChar(e);
    if (chr == null) return;
    if ((chr < '0' || chr > '9')) {
      return false;
    }
  });

  $(document).on('click', '.currency-toggler .dropdown a', function(e){
    e.preventDefault();
    var $cont = $('.currency-toggler');
    var $this = $(this);
    var index = $cont.find('.dropdown a').index($this);
    $this.addClass('active').siblings().removeClass('active');
    $cont.find('.current').text($this.text());
    var val = $cont.find('select option:eq('+index+')').val();

    $cont.find('select').val(val).trigger('change');
    
  });


  $(document).on('click', '.constructor-total-wrapper .error-text .close', function(e){
    e.preventDefault();
    $(this).closest('.error-text').remove();
    
  });

  $(document).on('click', '.eye', function(){
    var $input = $(this).closest('.field').find('input');

    if($input.attr('type') == 'text'){
      $input.attr('type', 'password');
    }else{
      $input.attr('type', 'text');
    }
  });

  $(document).on('click', '.edit-toggler', function(){
    $(this).closest('.delivery-form').addClass('editing');
    $('.payment-method button').attr('disabled','disabled');
  });

  $(document).on('click', '.delivery-form button', function(e){
    e.preventDefault();
    $(this).closest('.delivery-form').removeClass('editing');
    $('.payment-method button').removeAttr('disabled');
  });

  $(document).on('change', '.radio input', function(){
    var $this = $(this),
      $field = $this.closest('.radio'),
      name = $this.attr('name');

    $('.radio input[name="'+name+'"]').closest('.radio').removeClass('checked');
    
    if($this.prop('checked')){
      $field.addClass('checked');
    }
  });

  $(document).on('click', '.account-form button', function(e){
    if(!$(this).closest('form').hasClass('editing')){
      e.preventDefault();
      $(this).closest('form').addClass('editing')
    }
  });

  $(document).on('click', '.plus', function(){
    var $input = $(this).closest('.field').find('input'),
      val = $input.val();

    $input.val((val<99)?++val:99);
  });

  $(document).on('click', '.minus', function(){
    var $input = $(this).closest('.field').find('input'),
      val = $input.val();

    $input.val((val>1)?--val:1);   
  });

  $(document).on('click', '[data-popup]', function(e){
    e.preventDefault();

    showPopup($(this).attr('data-popup'));
  });

  $(document).on('click', '.popup .close, .popup', function(e){
    e.preventDefault();

    hidePopup($(this).closest('.popup').attr('id'));
  });

  $(document).on('click', '.popup-body, .popup', function(e){
    e.stopPropagation();
  });

  $(document).on('click', '.order-items-toggler', function(){
    $('.order-items').slideToggle();
  });

  $(document).on('click', '.search-toggler', function(e){
    e.preventDefault();
    $('.search-wrapper').toggleClass('active');
    $(this).toggleClass('active');
  });

  $(document).on('click', '.filters-toggler', function(e){
    e.preventDefault();
    $('.filters-mobile').toggleClass('active');
  });

  $(document).on('click', '.menu-wrapper .search-link', function(e){
    e.preventDefault();
    $('.search-wrapper').addClass('active');
    $('.menu-wrapper, .menu-toggler').removeClass('active');
  });

  $(document).on('click', '.search-wrapper .close', function(e){
    e.preventDefault();
    $('.search-wrapper, .search-toggler').removeClass('active');
  });

  $(document).on('click', '.filters-mobile .close', function(e){
    e.preventDefault();
    $('.filters-mobile, .search-toggler').removeClass('active');
  });

  $(document).on('click', '.constructor-sidebar-toggler', function(e){
    e.preventDefault();
    $('.cart-sidebar').removeClass('active');
    $('.constructor-sidebar').toggleClass('active');
  });

  $(document).on('click', '.user-menu .cart-toggler, .cart-sidebar-toggler', function(e){
    e.preventDefault();
    $('.constructor-sidebar').removeClass('active');
    $('.cart-sidebar').toggleClass('active');
  });

  $(document).on('change', '.jewellery-type .type input', function(e){
    $('.constructor-wrapper button').removeAttr('disabled');
  });

  $(document).on('change', '.step-wrapper .product-item input', function(e){
    $('.constructor-wrapper button').removeAttr('disabled');
  });

  $(document).on('click', '.to-favorites:not(.active)', function(e){
    e.preventDefault();
    $(this).addClass('active');
  });

  $(document).on('click', '.part-list img', function(e){
    e.preventDefault();
    var $this = $(this).closest('.img'),
      src = $this.attr('data-src'),
      name = $this.attr('data-name'),
      size = $this.attr('data-size'),
      weight = $this.attr('data-weight'),
      price = $this.attr('data-price');

    showPartView(src, name, size, weight, price);
  });

  $(document).on('click', '.part-view .close', function(e){
    e.preventDefault();
    hidePartView();
  });

  $(document).on('click', '.parts-toggler', function(e){
    e.preventDefault();
    $(this).toggleClass('active');
    $('.edit-step').not($(this).closest('.edit-step')).toggleClass('hidden');
    $('.parts-wrapper').toggleClass('visible');
  });

  $(document).on('click', '.constructor-complete', function(e){
    e.preventDefault();
    $(this).hide();
    $('.zoom-controls, .constructor-total-wrapper').hide();
    $('.edit-steps .product-info .product-price i').text($('.constructor-total-price i').text())
    $('.parts-toggler').removeClass('active');
    $('.edit-step').not($(this).closest('.edit-step')).removeClass('hidden');
    $('.parts-wrapper').removeClass('visible');
    $('.edit-step.active').removeClass('active');
    $('.edit-step.step-5').addClass('active');
    $('.edit-steps .product-info').addClass('visible');

    if($('.canvas-ring').length){
      fabric.Image.fromURL( $('.basement img').attr('src'), function(image) {
        var bgLeft = canvas.getCenter().left;
        var bgTop = canvas.getCenter().top;
        var bgOriginX = 'center';
        var bgOriginY = 'center';
        image.set({
          left: 0,
          top: 0,
          clipTo: function (ctx) {
            ctx.rect(-280,-280,560,280);
          }
        });
        canvas.backgroundImage = false;
        canvas.setBackgroundImage(image, canvas.renderAll.bind(canvas),{
          width: $('.basement img').width(),
          height: $('.basement img').height(),
          originX: bgOriginX,
          originY: bgOriginY,
          left: bgLeft, 
          top: bgTop
        });
        canvas.renderAll();
        $(".final-img").addClass('visible').children('img').attr( "src", canvas.toDataURL() );
        $('.basement').hide();
      });
    }else{
      $(".final-img").addClass('visible').children('img').attr( "src", canvas.toDataURL() );
      $('.basement').hide();
    }

    //$(".final-img").addClass('visible').children('img').attr( "src", trimCanvas() );

  });

  var oldscroll = $(window).scrollTop();
  var direction = 'down';

  if($('body').hasClass('gallery-page')){
    $(window).scroll(function(e){
      var scrollTop = $(this).scrollTop();
      var offset = $('.filters-wrapper').offset().top;

      direction = (oldscroll<scrollTop)?'down':'up';

      if($(window).innerWidth()<768){
        offset -=40;
      }

      if(direction == 'down'){
        $('.filters-fixed').addClass('hide-filters');
      }else{
        $('.filters-fixed').removeClass('hide-filters');
      }

      if(scrollTop > offset){
        $('.filters-fixed').addClass('fixed');
      }else{
        $('.filters-fixed').removeClass('fixed');
      }
      oldscroll = scrollTop;
    });
  }

  $(document).on('click', '.menu-toggler', function(e){
    e.preventDefault();
    $(this).toggleClass('active');
    $('.menu-wrapper').toggleClass('active');
  });

  $(window).resize(function(){
    setFiltersWidth();
  })

  setFiltersWidth();



  $(document).on('click','.zoom-controls',function(e){
    e.preventDefault();
    showPopup('image-zoom');

    if($('.basement-final').length){
      $("#image-zoom .image-zoom .img img").attr( "src", $(".basement-final img").attr('src') );
      $('#image-zoom .image-zoom').width($(".basement-final").width());
    }else{
      canvas.renderAll();
      zoomIt(2);
      if($('.canvas-necklace').length){
        $("#image-zoom .image-zoom .img img").attr( "src", trimCanvas() );
      }else{
        $("#image-zoom .image-zoom .img img").attr( "src", canvas.toDataURL() );
      }
      zoomIt(0.5);
      $('#image-zoom .image-zoom').width(canvas.width);
    }

    $('#image-zoom input').val(1);
    $('#image-zoom').find('.img').panzoom("reset");
    $('#image-zoom').find('.img').panzoom('zoom',1, { silent: true });
  });

  $('#image-zoom').find('.img').panzoom({
    $zoomRange: $('#image-zoom').find("input"),
    startTransform: 'scale(1)',
    increment: 0.3,
    rangeStep: 0.05,
    maxScale: 2,
    minScale: 1,
    panOnlyWhenZoomed: false,
    contain: 'automatic'
  });

});

function setFiltersWidth(){
  $('.filters-fixed .max-width').width($('.filters-wrapper').width());
};

function showPopup(id){
  $('#'+id).show();
  $('body').addClass('show-popup');
  if($('#'+id).find('.swiper-container').length){
    initPopupSlider();
  }
};

function hidePopup(id){
  $('#'+id).hide();
  $('body').removeClass('show-popup');
  if($('#'+id).find('.swiper-container').length){
    var mySwiper = $('#'+id).find('.swiper-container')[0].swiper;
    mySwiper.destroy(true, true);
  }
};

function initMainSlider(){
  var swiper = new Swiper('.gallery-wrapper .swiper-container', {
    loop: false,
    slidesPerView: 5,
    breakpoints: {
      1279: {
        slidesPerView: 4
      },
      940: {
        slidesPerView: 3
      },
      767: {
        slidesPerView: 'auto'
      }
    }
  });
  var mySwiper = $('.gallery-wrapper .swiper-container')[0].swiper;

  $(document).on('click','.gallery-prev', function(){
    mySwiper.slidePrev();
  });
  $(document).on('click','.gallery-next', function(){
    mySwiper.slideNext();
  });
};

function initPopupSlider(){
  var swiper = new Swiper('.popup-body .swiper-container', {
    loop: true,
    speed: 400,
    slidesPerView: 1,
    simulateTouch: false,
    pagination: '.popup-body .swiper-pagination',
    paginationClickable: true,
    prevButton: '.popup-body .swiper-prev',
    nextButton: '.popup-body .swiper-next'
  });
};

function initGalleryItemSlider(){
  var swiper = new Swiper('.gallery-item-wrapper .swiper-container', {
    loop: true,
    speed: 400,
    slidesPerView: 1,
    pagination: '.gallery-item-wrapper .swiper-pagination',
    paginationClickable: true
  });
};

function initOtherSlider(){
  $('.gallery-other-wrapper').each(function(){
    var $this = $(this);
    var size = parseInt($this.attr('data-size'));
    var size_1 = parseInt($this.attr('data-size-1'));
    var size_2 = parseInt($this.attr('data-size-2'));
    var size_3 = parseInt($this.attr('data-size-3'));

    var swiper = new Swiper($this.find('.swiper-container'), {
      loop: true,
      speed: 400,
      spaceBetween: 10,
      slidesPerView: size,
      breakpoints: {
        1560: {
          slidesPerView: size_1,
          spaceBetween: 6
        },
        1279: {
          slidesPerView: size_2,
          spaceBetween: 6
        },
        767: {
          slidesPerView: size_3,
          spaceBetween: 10
        }
      }
    });
  });

  $(document).on('click','.gallery-other-wrapper .swiper-prev', function(){
    var mySwiper = $(this).closest('.gallery-other-wrapper').find('.swiper-container')[0].swiper;
    mySwiper.slidePrev();
  });
  $(document).on('click','.gallery-other-wrapper .swiper-next', function(){
    var mySwiper = $(this).closest('.gallery-other-wrapper').find('.swiper-container')[0].swiper;
    mySwiper.slideNext();
  });
};

function initReviewSlider(){
  $('.review-slider-source .review-slide').each(function(i){
    $('.review-slider-imgs .img:eq(0)').append($(this).find('img:eq(0)'));
    $('.review-slider-imgs .img:eq(1)').append($(this).find('img:eq(0)'));
  });

  $('.review-slider-text .text p').each(function(){
    var $this = $(this);
    var text = $this.text().split(' ');
    var $parent = ($this.children().length)?$this.children():$this;
    $parent.empty();
    for (var i = 0; i < text.length; i++) {
      $parent.append('<span><i>'+text[i]+' </i></span>')
    };
  })

};

function showPartView(src, name, size, weight, price){
  $('.part-view .img img').attr('src', src);
  $('.part-name span').text(name);
  $('.part-size span').text(size);
  $('.part-weight i').text(weight);
  $('.part-price i').text(price);
  $('.part-view').addClass('visible');
}

function hidePartView(){
  $('.part-view').removeClass('visible');
};

var canvas;
function initFabric(){
  canvas = new fabric.Canvas('canvas');
  var w = $('.basement').width();
  var h = $('.basement').height();
  canvas.setWidth(w);
  canvas.setHeight(h);
  var bgLeft = canvas.getCenter().left;
  var bgTop = canvas.getCenter().top;
  var bgOriginX = 'center';
  var bgOriginY = 'center';

  if($('.canvas-necklace').length){
    bgTop = 20;
    bgOriginY = 'top';
  }

  canvas.setBackgroundImage($('.basement img').attr('src'), canvas.renderAll.bind(canvas),{
    width: $('.basement img').width(),
    height: $('.basement img').height(),
    originX: bgOriginX,
    originY: bgOriginY,
    left: bgLeft, 
    top: bgTop
  });
  canvas.renderAll();


  if(arguments.length){
    boundRect = new fabric.Rect({ left: arguments[0][0]-50, top: arguments[0][1]-50, width: 100, height: 100, /*strokeDashArray: [4,4], stroke: '#ffdcf4',*/ fill: 'rgba(0,0,0,0)', hasControls: false, selectable: false, hoverCursor: 'default'})
    canvas.add(boundRect)
    canvas.fixedFilled = false;
    if(arguments.length == 2){
      boundRect2 = new fabric.Rect({ left: arguments[1][0]-50, top: arguments[1][1]-50, width: 100, height: 100, /*strokeDashArray: [4,4], stroke: '#ffdcf4',*/ fill: 'rgba(0,0,0,0)', hasControls: false, selectable: false, hoverCursor: 'default'})
      canvas.add(boundRect2)
    }
  }

  canvas.on("object:moving", function(e){
    checkBounds(e.target);
  });
  canvas.on("object:rotating", function(e){
    checkBounds(e.target);
  });
  canvas.on("object:added", function(e){
    e.target.price = dragPrice;
    e.target.weight = dragWeight;
    updateProductOptions(1);
    checkPartsNumber();
  });
  canvas.on("object:removed", function(e){
    dragPrice = e.target.price;
    dragWeight = e.target.weight;
    if(e.target.fixed){
      canvas.fixedFilled = false;
      $('.canvas-container').removeClass('fixedFilled');
      boundRect.opacity = 1;
    }
    updateProductOptions(-1);
    checkPartsNumber();
  });
  canvas.on("selection:created", function(e){
    var activeGroup = canvas.getActiveGroup();

    var fixedPoints = canvas.getObjects().filter(function(i){
      return (i.fixed)
    });
    for (var i = 0; i < fixedPoints.length; i++) {
      activeGroup.removeWithUpdate(fixedPoints[i]);
    };
    canvas.renderAll(); 
  });

  $('body').on('click',function(){
    canvas.deactivateAll().renderAll();
  })
  $('.canvas-container').on('click',function(e){
    e.stopPropagation();
  })
  
  customizeControls();
}

function customizeControls(){
  fabric.Canvas.prototype.customiseControls({
    tl: {
        action: 'remove',
        cursor: 'pointer',
    },
    tr: {
        action: 'rotate',
        cursor: 'crosshair'
    }
  }, function() {
      canvas.renderAll();
  });

  fabric.Object.prototype.customiseCornerIcons({
    settings: {
        borderColor: '#ffdcf4',
        cornerSize: 40,
        cornerBackgroundColor: '#d13ca3',
        cornerShape: 'circle',
        cornerPadding: 15,
    },
    tr: {
      icon: 'assets/build/svg/rotate.svg',
    },
    tl: {
      icon: 'assets/build/svg/remove.svg',
    }
  }, function() {
      canvas.renderAll();
  });

  fabric.Group.prototype._controlsVisibility = {
    mt: false, 
    mb: false, 
    ml: false, 
    mr: false, 
    bl: false,
    br: false,
    mtr: false,
    tr: true,
    tl: true
  };
}


function checkBounds(obj){
  obj.setCoords();
  if(obj.getBoundingRect().top < 20 || obj.getBoundingRect().left < 20){
      obj.top = Math.max(obj.top, obj.top-obj.getBoundingRect().top+20);
      obj.left = Math.max(obj.left, obj.left-obj.getBoundingRect().left+20);
  }
  if(obj.getBoundingRect().top+obj.getBoundingRect().height  > obj.canvas.height -20|| obj.getBoundingRect().left+obj.getBoundingRect().width  > obj.canvas.width-20){
      obj.top = Math.min(obj.top, obj.canvas.height-obj.getBoundingRect().height+obj.top-obj.getBoundingRect().top-20);
      obj.left = Math.min(obj.left, obj.canvas.width-obj.getBoundingRect().width+obj.left-obj.getBoundingRect().left-20);
  }
}

function addImage( data, top, left) {
  canvas.deactivateAll().renderAll();
  fabric.Image.fromURL( data, function(image) {

    image.perPixelTargetFind = true;
    image.targetFindTolerance = 4;
    image.set({
      left: left,
      top: top,
      scaleX: 0.2988,
      scaleY: 0.2988
    })
    .setControlsVisibility({
      mt: false, 
      mb: false, 
      ml: false, 
      mr: false, 
      bl: false,
      br: false,
      mtr: false
    }) 
    .setCoords();
    canvas.add(image);

    if(typeof canvas.fixedFilled != 'undefined'){
      if(!canvas.fixedFilled){
        var rect;

        //if(image.intersectsWithObject(boundRect)){
          canvas.fixedFilled = true;

          if($('.canvas[data-place-2]').length){
            if(top >= canvas.height / 2){
              rect = boundRect2;
            }else{
              rect = boundRect;
            }
          }else{
            rect = boundRect;
          }

          var x = rect.left + (rect.width - image.width*image.scaleX)/2;
          var y = rect.top + (rect.height - image.height*image.scaleY)/2;

          $('.canvas-container').addClass('fixedFilled');
          image.set({
            left: x,
            top: y,
            lockMovementX: true,
            lockMovementY: true,
            fixed: true
          })
          .setCoords();
          //boundRect.opacity = 0;
          canvas.renderAll();
        /*}else{
          canvas.remove(image);
        }*/
      }
    }
  });
};

function checkPartsNumber(){
  if(canvas.fixedFilled){
    var fixedPoints = canvas.getObjects().filter(function(i){
      return (i.fixed)
    });
    var addedParts = canvas.getObjects().filter(function(i){
      return (i.type == 'image' && !i.fixed)
    });
    if(addedParts.length){
      for (var i = 0; i < fixedPoints.length; i++) {
        fixedPoints[i].setControlsVisibility({
          tl: false
        }) 
      };
    }else{
      for (var i = 0; i < fixedPoints.length; i++) {
        fixedPoints[i].setControlsVisibility({
          tl: true
        }) 
      };
    }
  }
}


function initFreeConstructor(){
  $(".part-img").draggable({ 
    containment: "document",
    appendTo: "body",
    scroll: false,
    cursor: '-webkit-grabbing',
    revert: function (obj) {
      $('.canvas-container').removeClass('hover');
      if(!obj){
        return true;
      }else{
        return false;
      }
      dragPrice = 0;
      dragWeight = 0;
    },
    revertDuration: 200,
    helper: 'clone',
    start: function(){
      dragPrice = $(this).parent().attr('data-price');
      dragWeight = $(this).parent().attr('data-weight');
      dragImg = $(this).parent().attr('data-src');
      $('.canvas-container').addClass('hover');
    }
  });

  initFreeDroppable(canvas);

};


function initFreeDroppable(o){
  var obj;
  if(typeof o == 'undefined'){
    obj = $(".basement .part-place");
  }else{
    obj = o;
  }

  obj.droppable({ 
    accept: '.part-img',
    tolerance: 'fit',
    drop: function(event, ui) {
      var helper = $(ui.helper);
      var newElem = helper.clone();
      var helperPos = helper[0].getBoundingClientRect();
      var placePos = $('.part-place')[0].getBoundingClientRect();
      var leftPos = helperPos.left-placePos.left;
      var topPos = helperPos.top-placePos.top;
      //addImage(newElem.attr('src'), topPos, leftPos);
      addImage(dragImg, topPos, leftPos);

      $('.canvas-container').removeClass('hover');
    }
  });
}

function updateProductOptions(remove){
  var $price = $('.constructor-total-price i'),
    oldPrice = $price.text(),
    newPrice = parseFloat(oldPrice) + remove*parseFloat(dragPrice);

    $price.text(newPrice);

 var $weight = $('.constructor-total-weight i'),
    oldWeight = $weight.text(),
    newWeight = parseFloat(oldWeight) + remove*parseFloat(dragWeight);

    $weight.text(newWeight);

  $('.edit-steps .product-info .product-price i').text($('.constructor-total-price i').text())
};

function zoomIt(factor) {
  canvas.setHeight(canvas.getHeight() * factor);
  canvas.setWidth(canvas.getWidth() * factor);

  var bi = canvas.backgroundImage;
  bi.width = bi.width * factor; bi.height = bi.height * factor;
  var bgLeft = canvas.getCenter().left;
  var bgTop = canvas.getCenter().top;
  var bgOriginX = 'center';
  var bgOriginY = 'center';

  if($('.canvas-necklace').length){
    bgTop = 20;
    bgOriginY = 'top';
  }

  bi.left = bgLeft;
  bi.top = bgTop;
  bi.originY = bgOriginY;
  bi.originX = bgOriginX;

  var objects = canvas.getObjects();
  for (var i in objects) {
      var scaleX = objects[i].scaleX;
      var scaleY = objects[i].scaleY;
      var left = objects[i].left;
      var top = objects[i].top;

      var tempScaleX = scaleX * factor;
      var tempScaleY = scaleY * factor;
      var tempLeft = left * factor;
      var tempTop = top * factor;

      objects[i].scaleX = tempScaleX;
      objects[i].scaleY = tempScaleY;
      objects[i].left = tempLeft;
      objects[i].top = tempTop;

      objects[i].setCoords();
  }
  canvas.renderAll();
  canvas.calcOffset();
}

function trimCanvas(){
  var ctx = canvas.getContext("2d");
  var width = canvas.width;
  var imageData = ctx.getImageData(0, 0, canvas.width, canvas.height);
  var top = 0, bottom = imageData.height, left = 0, right = imageData.width;
  while (top < bottom && rowBlank(imageData, width, top)) ++top;
  while (bottom - 1 > top && rowBlank(imageData, width, bottom - 1)) --bottom;
  while (left < right && columnBlank(imageData, width, left, top, bottom)) ++left;
  while (right - 1 > left && columnBlank(imageData, width, right - 1, top, bottom)) --right;

  
  var trimmed = ctx.getImageData(left, top, right - left, bottom - top);
  var copy = document.createElement("canvas");
  var copyCtx = copy.getContext("2d");
  copy.width = trimmed.width;
  copy.height = trimmed.height;
  copyCtx.putImageData(trimmed, 0, 0);

  return copy.toDataURL(); 
}

function rowBlank(imageData, width, y) {
  for (var x = 0; x < width; ++x) {
      if (imageData.data[y * width * 4 + x * 4 + 3] !== 0) return false;
  }
  return true;
}

function columnBlank(imageData, width, x, top, bottom) {
  for (var y = top; y < bottom; ++y) {
      if (imageData.data[y * width * 4 + x * 4 + 3] !== 0) return false;
  }
  return true;
}