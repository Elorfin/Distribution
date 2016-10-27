/**
 * Created by david on 13/10/16.
 */
import 'jquery-tagcanvas'
import jQuery from 'jquery'

(function($) {
  $(function() {
    $('#tagCloudCanvas').tagcanvas({
      textColour : '#428BCA',
      outlineThickness : 1,
      maxSpeed : 0.05,
      textHeight: 18,
      depth : 0.5,
      weight : true,
      outlineColour : '#2A6496',
      outlineMethod : 'colour',
      reverse : true
    }, 'tagList')
  })
})(jQuery)