import React from 'react'
import ReactDOM from 'react-dom'
import {Provider} from 'react-redux'

import {createStore} from './store'
import {registerDefaultItemTypes} from './../items/item-types'
import {registerModalType} from './../modal'
import {MODAL_ADD_ITEM, AddItemModal} from './../quiz/editor/components/add-item-modal.jsx'
import {MODAL_SEARCH, SearchModal} from './components/modal/search.jsx'
import {Bank} from './components/bank.jsx'

// Load question types
registerDefaultItemTypes()

// Register needed modals
registerModalType(MODAL_SEARCH, SearchModal)
registerModalType(MODAL_ADD_ITEM, AddItemModal)

// Get initial data
const container = document.getElementById('questions-bank')
const initialData = JSON.parse(container.dataset['initial'])

const store = createStore(initialData)

ReactDOM.render(
  React.createElement(
    Provider,
    {store},
    React.createElement(Bank)
  ),
  document.getElementById('questions-bank')
)
