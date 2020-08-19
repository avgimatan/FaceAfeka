import React from 'react' 
import { Link } from 'react-router-dom'

//If some error occures and a page is not found

const NotFound = ({ location }) => (
  <div>
    <p>404! Not Found - <Link to="/">Go Home</Link></p>
  </div>
)

export default NotFound
