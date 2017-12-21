$(document).ready(function() {
  //filter range slider
  var priceSlider = $('#price_range').slider({
    range: true,
    min: 0,
    max: 100000,
    values: [ 0, 100000 ],
    slide: function( event, ui ) {
      $('#from_price').val(ui.values[0]);
      $('#to_price').val(ui.values[1]);
    },
    create: function( event, ui ) {
      $('#from_price').val(0);
      $('#to_price').val(100000);
    },
    change: function( event, ui ) {
      $('#from_width').val(ui.values[0]);
      $('#to_width').val(ui.values[1]);
    }
  });
  $('#from_price').on('change', function() {
    priceSlider.slider( "option", "values", [ $(this).val(), $('#to_price').val() ] );
  });
  $('#to_price').on('change', function() {
    priceSlider.slider( "option", "values", [ $('#from_price').val(), $(this).val() ] );
  });
  var widthSlider = $('#width_range').slider({
    range: true,
    min: 0,
    max: 600,
    values: [ 0, 600 ],
    create: function( event, ui ) {
      $('#from_width').val(0);
      $('#to_width').val(600);
    },
    slide: function( event, ui ) {
      $('#from_width').val(ui.values[0]);
      $('#to_width').val(ui.values[1]);
      $(this).find('.filter-form__range-popup').removeClass('opened');
    },
    stop: function( event, ui ) {
      $(this).find('.filter-form__range-popup').addClass('opened');
    }
  });
  $('#from_width').on('change', function() {
    priceSlider.slider( "option", "values", [ $(this).val(), $('#to_width').val() ] );
  });
  $('#to_width').on('change', function() {
    priceSlider.slider( "option", "values", [ $('#from_width').val(), $(this).val() ] );
  });
  var heightSlider = $('#height_range').slider({
    range: true,
    min: 0,
    max: 600,
    values: [ 0, 600 ],
    create: function( event, ui ) {
      $('#from_height').val(0);
      $('#to_height').val(600);
    },
    slide: function( event, ui ) {
      $('#from_height').val(ui.values[0]);
      $('#to_height').val(ui.values[1]);
    }
  });
  $('#from_height').on('change', function() {
    priceSlider.slider( "option", "values", [ $(this).val(), $('#to_height').val() ] );
  });
  $('#to_height').on('change', function() {
    priceSlider.slider( "option", "values", [ $('#from_height').val(), $(this).val() ] );
  });
});
