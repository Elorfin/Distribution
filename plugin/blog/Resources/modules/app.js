/**
 * Created by david on 17/10/16.
 */
import angular from 'angular/index'
import 'angular-ui-translation/angular-translation'
import 'angular-bootstrap'
import 'angular-ui-calendar'
import 'angular-ui-translation/angular-translation'
import '#/main/core/fos-js-router/module'
import '#/main/core/modal/module'
import '#/main/core/html-truster/module'
import 'fullcalendar/dist/fullcalendar'
import 'fullcalendar/dist/lang/fr'
import 'fullcalendar/dist/lang/en-gb'
import './panels/panels.module'

angular
  .module('BlogModule', [
    'ui.bootstrap',
    'blog.panels',
    'ui.translation',
    'ui.calendar',
    'ui.translation',
    'ui.html-truster'
  ])
  .value('blog.data', window.blogConfiguration)

angular.element(document).ready(function () {
  angular.bootstrap(angular.element(document).find('body')[0], ['BlogModule'], {
    strictDi: true
  })
})