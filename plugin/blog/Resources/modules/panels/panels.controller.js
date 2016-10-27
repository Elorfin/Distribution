/**
 * Created by david on 17/10/16.
 */
let _blogData = new WeakMap()
let _transFilter = new WeakMap()

export default class BlogPanelController {

  constructor(blogData, transFilter) {
    // Private variables
    _blogData.set(this, blogData)
    _transFilter.set(this, transFilter)

    // Variables exposed in view
    this.uiCalendarConfig = {
      editable: false,
      buttonText: {
        today: this._t('today')
      },
      monthNames: [
        this._t('month.january'),
        this._t('month.february'),
        this._t('month.march'),
        this._t('month.april'),
        this._t('month.may'),
        this._t('month.june'),
        this._t('month.july'),
        this._t('month.august'),
        this._t('month.september'),
        this._t('month.october'),
        this._t('month.november'),
        this._t('month.december')
      ],
      monthNamesShort: [
        this._t('month.jan'),
        this._t('month.feb'),
        this._t('month.mar'),
        this._t('month.apr'),
        this._t('month.may'),
        this._t('month.ju'),
        this._t('month.jul'),
        this._t('month.aug'),
        this._t('month.sept'),
        this._t('month.nov'),
        this._t('month.dec')],
      dayNames: [
        this._t('day.sunday'),
        this._t('day.monday'),
        this._t('day.tuesday'),
        this._t('day.wednesday'),
        this._t('day.thursday'),
        this._t('day.friday'),
        this._t('day.saturday')
      ],
      dayNamesShort: [
        this._t('day.sun'),
        this._t('day.mon'),
        this._t('day.tue'),
        this._t('day.wed'),
        this._t('day.thu'),
        this._t('day.fri'),
        this._t('day.sat')
      ],
      today: this._t('today'),
      locale: window.Claroline.Home.locale,
    }
  }

  get panels() { return _blogData.get(this).panels }
  get archives() { return _blogData.get(this).archives }
  get info() { return _blogData.get(this).info }
  get isGranted() { return _blogData.get(this).isGranted }
  get authors() { return _blogData.get(this).authors }
  get rssUrl() { return _blogData.get(this).rssUrl }
  get options() { return _blogData.get(this).options }
  get tags() { return _blogData.get(this).tags }
  get eventsPath() { return _blogData.get(this).eventsPath }

  getPanelUrl(nameTemplate) {
    return `${nameTemplate}.panel.html`
  }

  _t(msg) {
    return _transFilter.get(this)(msg, {}, 'agenda')
  }

}

BlogPanelController.$inject = [
  'blog.data',
  'transFilter'
]