import {createSelector} from 'reselect'
import size from 'lodash/size'

const modal = state => state.modal
const filters = state => state.search

const countFilters = createSelector(
  [filters],
  (filters) => size(filters)
)

export const select = {
  modal,
  filters,
  countFilters
}