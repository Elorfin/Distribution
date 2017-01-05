import React, {PropTypes as T} from 'react'
import {connect} from 'react-redux'
import Panel from 'react-bootstrap/lib/Panel'
import {tex} from './../../../utils/translate'
import {getDefinition} from './../../../items/item-types'
import {selectors} from './../selectors'

let Paper = props =>
  <div>
    <h3>
      {tex('correction')}&nbsp;{props.paper.number}
    </h3>
    <hr/>
    {props.paper.steps.map((step, idx) =>
      <div key={idx} className="item-paper">
        <h4>{tex('step')}&nbsp;{idx + 1}</h4>
        {step.items.map(item =>
          <Panel key={item.id}>
            <header className="item-content">
              <strong dangerouslySetInnerHTML={{__html: item.content}}/>
            </header>
            {React.createElement(
              getDefinition(item.type).paper,
              {item, answer: getAnswer(item.id, props.paper.answers)}
            )}
          </Panel>
        )}
      </div>
    )}
  </div>

Paper.propTypes = {
  paper: T.shape({
    id: T.string.isRequired,
    number: T.number.isRequired,
    steps: T.arrayOf(T.shape({
      items: T.arrayOf(T.shape({
        id: T.string.isRequired,
        content: T.string.isRequired,
        type: T.string.isRequired
      })).isRequired
    })).isRequired
  }).isRequired
}

function getAnswer(itemId, answers) {
  return answers.find(answer => answer.questionId === itemId) || {}
}

function mapStateToProps(state) {
  return {
    paper: selectors.currentPaper(state)
  }
}

const ConnectedPaper = connect(mapStateToProps)(Paper)

export {ConnectedPaper as Paper}