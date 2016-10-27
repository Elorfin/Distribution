/**
 * Created by david on 13/10/16.
 */
import $ from 'jquery'
import 'jquery-ui/ui/minified/core.min.js'
import 'jquery-ui/ui/minified/widget.min.js'
import 'jquery-ui/ui/minified/button.min.js'
import 'jquery-ui/ui/minified/spinner.min.js'
import 'confirm-bootstrap/confirm-bootstrap.js'

(function($) {

  $(document).ready(function() {
    $('.delete').confirmModal()


  })
})($)