import React from 'react'
import ReactDOM from 'react-dom'
import App from './RealtorsDir'

const realtorDir = document.getElementById('realtor-dir')

if(realtorDir) {
    ReactDOM.render(<App />, realtorDir)
}
